<?php
require_once __DIR__ . "/usersBusinessModel.php";
require_once __DIR__ . "/../abstract/dbModelAbstract.php";
require_once __DIR__ . "/../../helpers/encrypt.php";
require_once __DIR__ . "/../../helpers/validate.php";
require_once __DIR__ . "/../../lang/{$GLOBALS['lang']}/controllers/generalLang.php";
require_once __DIR__ . "/../../lang/{$GLOBALS['lang']}/controllers/databaseLang.php";

class UsersModel extends DBModelAbstract {

    public UsersBusinessModel $businesModel;

    public string $table = 'users';
	public string $query = "SELECT * FROM `users` ORDER BY `name` ASC";

	public function __construct(?PDO $conn) {
        $this->businesModel = new UsersBusinessModel($conn);
		parent::__construct($conn);
	}

    // DATA -------------------------------------------------------------

    public function getParseItem(?array $item): array|null {
        if ($item) {
            $item['id'] = bigintval($item['id']);
        } return $item;
    }

    public function setParseKey(mixed $key): mixed {
        return bigintval($key);
    }

    public function setParseData(?array $data): array|null {
        return $this->setParseDataAll($data, false);
    }

    public function setParseDataRegister(?array $data, string $email): array|null {
        $data['user']['email'] = $email;
        return $this->setParseDataAll($data, true);
    }

    public function setParseDataPassword(?array $data): array|null {
        if($data){
            $data['password_1'] = isset($data['password_1']) ? strval($data['password_1']) : null;
            $data['password_2'] = isset($data['password_2']) ? strval($data['password_2']) : null;
        } return $data;
    }

    public function setParseDataAll(?array $data, bool $reg): array|null {
        if($data){
            $newData = [];

            if ($reg) {
                $now = new Date();
                $newData['user']['status'] = 'active';
                $newData['user']['rol'] = $_SESSION['data-giros']['rol'] ?? null;
                $newData['user']['code'] = $_SESSION['data-giros']['code'] ?? null;
                $newData['user']['id_sup'] = $this->setParseIdSup($data['user']['id_sup']);
                $newData['user']['date_create'] = $now->formatCompleteMySQL();
            } else {
                $newData['user']['rol'] = idxval($data['user']['rol'] ?? null, true);
                $newData['user']['code'] = $data['user']['code'] ?? intval($data['user']['code']) ?? null;
                $newData['user']['id_sup'] = $data['user']['id_sup'] ?? bigintval($data['user']['id_sup']) ?? null;
                $newData['user']['status'] = idxval($data['user']['status'] ?? '');
            }

            $newData['user']['account'] = idxval($data['user']['account'] ?? '');
            $newData['user']['gender'] = idxval($data['user']['gender'] ?? '');
            $newData['user']['name'] = ucwords(strtolower(trimstrval($data['user']['name'] ?? '')));
            $newData['user']['last_name'] = ucwords(strtolower(trimstrval($data['user']['last_name'] ?? '')));
            $newData['user']['birthdate'] = dateval($data['user']['birthdate'] ?? '');
            $newData['user']['document_type'] = idxval($data['user']['document_type'] ?? '');
            $newData['user']['document_number'] = trimstrval($data['user']['document_number'] ?? '');
            $newData['user']['country'] = idxval($data['user']['country'] ?? '');
            $newData['user']['state'] = idxval($data['user']['state'] ?? '');
            $newData['user']['city'] = trimstrval($data['user']['city'] ?? '');
            $newData['user']['address'] = trimstrval($data['user']['address'] ?? '');
            $newData['user']['phone'] = bigintval($data['user']['phone'] ?? 0);
            $newData['user']['email'] = mb_strtolower(trimstrval($data['user']['email'] ?? ''));
            $newData['user']['password_1'] = isset($data['user']['password_1']) ? strval($data['user']['password_1']) : null;
            $newData['user']['password_2'] = isset($data['user']['password_2']) ? strval($data['user']['password_2']) : null;

            if ($newData['user']['account'] === 'business') {
                $newData['business'] = $this->businesModel->setParseData($data['business'] ?? null);
            }

            return $newData;
        } return $data;
    }

    protected function setParseIdSup($idSup) {
        $idSup = bigintval($data['user']['id_sup'] ?? null, true);
        if ($idSup) {
            $sql = "SELECT id from {$this->table} WHERE id=:id OR code=:code";
            $data = $this->getByKeys([
                'id' => $idSup,
                'id_sup' => $idSup,
            ], $sql);
            return $data->data['id'] ?? null;
        } return null;
    }

    // VALIDATE -------------------------------------------------------------

    public function validate(?array $data): bool {
        return $this->validateAll($data, false);
    }

    public function validateRegister(?array $data): bool {
        return $this->validateAll($data, true);
    }

    public function validatePassword(?array $data): bool {
        return $this->runValidation($data, [
            'password_1' => !empty($data['password_1']) && validatePassword($data['password_1']),
            'password_2' => !empty($data['password_2']) && $data['password_1'] === $data['password_2'],
        ]);
    }

    public function validateAll(?array $data, bool $reg): bool {

        if (!$data || !$data['user']) {
            return $this->setError();
        } 

        if ($reg) {
            if (!$this->validatePassword($data['user'])) {
                return false;
            } 
        } else {
            if (!isset($data['user']['status']) || !$data['user']['status']) {
                return $this->setError('invalid-status');
            }  
        }

        if (!$this->runValidation($data, [
            'account' => !empty($data['user']['account']),
            'gender' => !empty($data['user']['gender']),
            'name' => !empty($data['user']['name']) && validateName($data['user']['name']),
            'last-name' => !empty($data['user']['last_name']) && validateName($data['user']['last_name']),
            'birthdate' => !empty($data['user']['birthdate']) && validateAge($data['user']['birthdate'], 18),
            'document-type' => !empty($data['user']['document_type']),
            'document-number' => !empty($data['user']['document_number']),
            'country' => !empty($data['user']['country']) && strlen($data['user']['country']) == 3,
            'state' => !empty($data['user']['state']) && strlen($data['user']['state']) > 1,
            'city'  => !empty($data['user']['city']) && strlen($data['user']['city']) > 1,
            'address' => !empty($data['user']['address']) && strlen($data['user']['address']) > 9,
            'phone' => !empty($data['user']['phone']) && validatePhone($data['user']['phone']),
            'email' => !empty($data['user']['email']) && validateEmail($data['user']['email']),
        ])) {
            return false;
        }

        if ($data['user']['account'] === 'business') {
            $valid = $this->businesModel->validate($data['business']);
            $this->error = $this->businesModel->error;
            return $valid;
        } return true;
    }
    
    // METHODS --------------------------------------

	public function register(array $data): ResultError|ResultSuccess {
        if ($this->conn) {
            try {
                $this->conn->beginTransaction();
                
                $data['user']['password'] = Encrypt::generateHash($data['user']['password_1']);
                unset($data['user']['password_1']);
                unset($data['user']['password_2']);

                $insertUser = $this->insert($data['user']);
                $execUser = $insertUser->success && $insertUser->data;

                $execBusiness = true;
                if ($execUser && $data['user']['account'] === 'business') {
                    $data['business']['user'] = $insertUser->data;
                    $insertBusiness = $this->businesModel->insert($data['business']);
                    $execBusiness = $insertBusiness->success;
                }
                
                if ($execUser && $execBusiness && $this->conn->commit()) {
                    return new ResultSuccess($GLOBALS['lang-controllers']['db'][$this->table]['register-succes']);
                }
                
                return new ResultError($GLOBALS['lang-controllers']['db'][$this->table]['register-error']); 
            } catch (PDOException $exception) {
				return new ResultError($GLOBALS['lang-controllers']['db'][$this->table]['register-error']);
			} catch (Exception $exception) {
				return new ResultError($GLOBALS['lang-controllers']['db'][$this->table]['register-error']);
			}
        } return new ResultErrorConn();
    }

    public function updatePassword(array $data, int $user): ResultError|ResultSuccess {
        if ($this->conn) {
            try {
                $this->conn->beginTransaction();
				
				// Update password
                $updateUser = $this->updateByKey('id', $user, [
                    'password' => Encrypt::generateHash($data['password_1'])
                ]);

				// Delete devices
                $devicesModel = new DevicesModel($this->conn);
                $delDevices = $devicesModel->deleteByKey('user', $user);

                // Commit transaction
                if($updateUser->success && $delDevices->success && $this->conn->commit()){
                    return new ResultSuccess($GLOBALS['lang-controllers']['db'][$this->table]['update-pass-success']);
                }
				
				$this->conn->rollBack();
                return new ResultError($GLOBALS['lang-controllers']['db'][$this->table]['update-pass-error']);

            } catch (PDOException $exception) {
                $this->conn->rollBack();
				return new ResultError($GLOBALS['lang-controllers']['db'][$this->table]['update-pass-error']);
			} catch (Exception $exception) {
                $this->conn->rollBack();
				return new ResultError($GLOBALS['lang-controllers']['db'][$this->table]['update-pass-error']);
			}
        } return new ResultErrorConn();
    }

}