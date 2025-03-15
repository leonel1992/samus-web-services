<?php
require_once __DIR__ . '/../helpers/encrypt.php';
require_once __DIR__ . '/../models/db/sessionsModel.php';
require_once __DIR__ . '/../models/db/devicesModel.php';
require_once __DIR__ . '/../models/db/usersModel.php';
require_once __DIR__ . '/../models/db/permissionsRolesModel.php';

class LoginService {

	public const SESSION_PATH = __DIR__ ."/../../sessions/";
	public const EXPIRE_DEVICE = 90; // 90 días
	public const EXPIRE_SESSION_SHORT = 30; // 30 minutos
	public const EXPIRE_SESSION_LONG  = 30 * 24 * 60; // 30 días en minutos

	protected ?PDO $conn = null;
	protected ?ResultError $error = null;
	
	protected ?array $data = null;
	protected ?array $permissions = null;

	protected ?string $email = null;
	protected ?string $password = null;
	protected ?string $session = null;
	protected ?string $device = null;
	protected int $expireTime = 0;
	protected int $expireMinutes = 0;

	protected ?string $code = null;
	protected ?string $codeID = null;
	protected ?string $codeCookie = null;
	protected ?string $codeEmail = null;

	protected bool $remember = false;
	protected bool $logout = false;
	protected bool $refresh = false;

	public function __construct(string $codeEmail=null, bool $refresh=false) {
		require_once __DIR__ . "/../lang/{$GLOBALS['lang']}/controllers/sessionLang.php";
		
		if(isset($_COOKIE['DEVICE']) && $_COOKIE['DEVICE']){ 
			$this->device = $_COOKIE['DEVICE'];
		}

		$this->refresh = $refresh;
		$this->codeEmail = $codeEmail;
		$this->logout = VarsData::boolean('logout');
		$this->remember = VarsData::boolean('remember');

		$this->loadSession();
		$this->email = VarsData::string('email');
		if ($this->email) {
			$this->email = mb_strtolower($this->email);
			$this->password = VarsData::string('password');
		} elseif (!$this->session) {
			$this->session = VarsData::string('session');
		}

		if ($this->logout || $this->session || $this->codeEmail || $this->email) {
			$this->conn = DatabaseService::init();
			if ($this->conn) { 
				if ($this->logout) {
					$this->logout();
				} elseif ($this->codeEmail){
					$this->loginCode();
				} elseif ($this->session) {
					$this->loginSession();
				} else {
					$this->login();
				}
			} else {
				$this->error = new ResultError($GLOBALS['lang-controllers']['session']['error-conection']);
			}
		}
	}
		
	// DB ---------------------------------------------------------- 

	private function queryUserDB($key, $value): ResultError|ResultData {
		$model = new UsersModel($this->conn);
		return $model->getByKey($key, $value);
	}

	private function queryDeviceDB(): ResultError|ResultData {
		$model = new DevicesModel($this->conn);
		return $model->getByKeys([
			'user' => $this->data['id'],
			'device' => $this->device
		]);
	}

	private function querySessionDB(): ResultData|ResultError {
        $model = new SessionsModel($this->conn); 
        return $model->getByKeys([
            'device' => $this->device,
            'session' => $this->session
        ]);
    }

	private function queryPermissionsDB(): ResultData|ResultError {
		$model = new PermissionsRolesModel($this->conn);
		$permissions = $model->getAllPermissionsByRol($this->data['rol']);
		return $model->parseTable($permissions);
	}

	//----------------------------------------

	private function updateDeviceDB(): ResultError|ResultSuccess {
		if ($this->refresh) {
			return new ResultSuccess();
		}

		if(!$this->device) {
			$this->device = strtoupper(uniqid($this->data['id']));
			$this->updateSessionServer();
		}

		$model = new DevicesModel($this->conn);
		return $model->updateDevice([
			'user' => $this->data['id'],
			'device' => $this->device
		]);
	}

	private function updateSessionDB(): ResultError|ResultSuccess {
		if ($this->refresh) {
			return new ResultSuccess();
		}

		if (!$this->session) {
			$this->session = strtoupper(uniqid($this->data['id']));
			$this->updateSessionServer();
		}
		
		$model = new SessionsModel($this->conn);
		return $model->updateSession([
			'user' => $this->data['id'],
			'device' => $this->device,
			'session' => $this->session,
			'expire' => $this->expireMinutes,
		]);
	}

	//----------------------------------------

	private function deleteSessionDB(): ResultError|ResultSuccess {
        $this->deleteSessionServer();
        $model = new SessionsModel($this->conn);
        return $model->deleteByKey('session', $this->session);
    }

  // SESSIONS ---------------------------------------------------------- 
  
	private function loadSession(): void {

		$this->expireMinutes = LoginService::EXPIRE_SESSION_SHORT;
		$this->expireTime = time() + 60 * LoginService::EXPIRE_SESSION_SHORT;

		if ($this->device) {
		$url = LoginService::SESSION_PATH . $this->device .'.json';
		$session = JSON::open($url);
		if ($session && is_array($session)) {
			if(time() > $session['expire']){
			$session['session'] = null;
			$session['expire'] = time();
			$session['long'] = false;
			}

			if (!$this->refresh) {
			if ($session['long'] || $this->remember) {
				$session['long'] = true;
				$session['expire'] = time() + 60 * LoginService::EXPIRE_SESSION_LONG;
				$this->expireTime = time() + 60 * LoginService::EXPIRE_SESSION_LONG;
				$this->expireMinutes = LoginService::EXPIRE_SESSION_LONG;
			} else {
				$session['long'] = false;
				$session['expire'] = time() + 60 * LoginService::EXPIRE_SESSION_SHORT;
			} JSON::save($url, $session);
			}

			$this->session = $session['session'];
			$this->expireTime = $session['expire'];
		}
		}
		
		if (!$this->session) $this->deleteSession();
		if (!$this->refresh && $this->remember) {
			$this->expireMinutes = LoginService::EXPIRE_SESSION_LONG;
			$this->expireTime = time() + 60 * LoginService::EXPIRE_SESSION_LONG;
		}
	}

	private function deleteSession(): void {
		$_SESSION['user'] = null;
		$_SESSION['session'] = null;
		$_SESSION['permissions'] = null;
	}

	private function saveSession(): void {
		$_SESSION['user'] = $this->data;
		$_SESSION['session'] = $this->session;
		$_SESSION['permissions'] = $this->permissions;
	}

	private function saveCookies(): void {
		if (!$this->refresh) {
			$this->device
			? setcookie('DEVICE',$this->device, time() + 24*3600*(LoginService::EXPIRE_DEVICE), "/")
			: setcookie('DEVICE', null, time()-1, "/");
		}
	}

	//----------------------------------------

	private function updateSessionServer(): bool {
		$url = LoginService::SESSION_PATH . $this->device .'.json';
		$data = JSON::open($url);
		if ($data) {
			return JSON::save($url, [
				'session' => $data['session'] ?? $this->session,
				'expire' => $data['expire'],
				'long' => $data['long'],
			]);
		} else {
			return JSON::save($url, [
				'session' => $this->session,
				'expire' => $this->expireTime,
				'long' => $this->remember,
			]);
		}
	}

	private function deleteSessionServer(): bool {
		$url = LoginService::SESSION_PATH . $this->device .'.json';
		return JSON::save($url, [
			'session' => null,
			'expire' => time() - 3600,
			'long' => false,
		]);
	}

  	// METHODS ---------------------------------------------------------- 

	private function login(): void {
		$user = $this->queryUserDB('email', $this->email);
		if($user->success && Encrypt::validateHash($this->password, $user->data['password']) ){
			$this->data = $user->data;
			$device = $this->queryDeviceDB();
			if ($device->success) {
				$this->updateDeviceDB();
				$this->updateSessionDB();
				$this->updatePermissions();
				$this->saveCookies();
				$this->saveSession();
				$this->sendMail();
			} else {
				$code = new CodeService($this->conn, CodeService::LOGIN, $this->email, $this->data['id']);
				$this->error = $code->getError();
				$this->codeID = $code->getCodeID();
				$this->codeCookie = $code->getCodeCookie();
				$this->data = null;
				$this->device = null;
				$this->saveCookies();
			}
		} else {
			if ($this->email && $this->password) {
				$this->error = new ResultError($GLOBALS['lang-controllers']['session']['error-login']);
			}
		}
	}

	private function loginCode(): void {
        $user = $this->queryUserDB('email', $this->codeEmail);
        if ($user->success) {
            $this->data = $user->data;
            $this->email = $this->codeEmail;
            $this->updateDeviceDB();
            $this->updateSessionDB();
            $this->updatePermissions();
            $this->saveCookies();
            $this->saveSession();
            $this->sendMail();
        } else {
            $this->error = new ResultError($GLOBALS['lang-controllers']['session']['error-conection']);
        }
    }

	private function loginSession(): void {
        $session = $this->querySessionDB();
        if($session->success){
			
            $today = new Date();
            $expire = null;
            if ($session->data['date_expire']) {
                $expire = new Date($session->data['date_expire']);
            }

            if ($expire && $expire > $today) {
                $user = $this->queryUserDB('id', $session->data['user']);
                if ($user->success) {
                    $this->data = $user->data;
                    $this->email = $this->data['email'];
                    $this->updateDeviceDB();
                    $this->updateSessionDB();
                    $this->updatePermissions();
                    $this->saveCookies();
                    $this->saveSession();
                } else {
					$this->error = new ResultError($GLOBALS['lang-controllers']['session']['error-conection']);
                }
            } else {
                $this->deleteSession();
				$this->error = new ResultError($GLOBALS['lang-controllers']['session']['error-session-expire']);
            }
        } else {
            $this->deleteSession();
            $this->error = new ResultError($GLOBALS['lang-controllers']['session']['error-session-expire']);
        }
    }

    private function logout(): void {
		$this->error = null;
        $delete = $this->deleteSessionDB();
        if ($delete->success) {
            $this->email = null;
            $this->data = null;

			$_SESSION = [];
			if (session_id()) {
				session_unset();
				session_destroy();
			}

			if (isset($_COOKIE['LOGIN_VIEW'])) {
				setcookie('LOGIN_VIEW', '', time() - 3600, '/');
			}
        } else {
            $this->error = new ResultError($GLOBALS['lang-controllers']['session']['error-logout']);
        }
    }

	private function updatePermissions(): void {
		$data = $this->queryPermissionsDB();
		if ($data->success) {
			$this->permissions = $data->data;
		}
	}

	private function sendMail(): void {
        if (!$this->refresh) {
            EmailService::sendLogin($this->email, $_SESSION['user']['name']);
        }
    }

    // DATA ---------------------------------------------------------- 
	
    public function isSuccess(): bool {
        return isset($_SESSION['user']) && $_SESSION['user'];
    }

    public function getData(): array|null {
        return $_SESSION['user'] ?? null;
    }

    public function getExpire(): int {
        return $this->expireTime;
    }

    public function getCodeID(): string|null {
        return $this->codeID;
    }

    public function getCodeCookie(): string|null {
        return $this->codeCookie;
    }

    public function getError(): ResultError|null {
        return $this->error;
    }
}