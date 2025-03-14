<?php
require_once __DIR__ . "/userBusinessModel.php";
require_once __DIR__ . "/../abstract/dbModelAbstract.php";
require_once __DIR__ . "/../../helpers/encrypt.php";
require_once __DIR__ . "/../../helpers/validate.php";
require_once __DIR__ . "/../../lang/{$GLOBALS['lang']}/controllers/generalLang.php";
require_once __DIR__ . "/../../lang/{$GLOBALS['lang']}/controllers/databaseLang.php";

class UsersModel extends DBModelAbstract {

    public UserBusinessModel $businesModel;

    public string $table = 'users';
	public string $query = "SELECT * FROM `users` ORDER BY `name` ASC";

	public function __construct(?PDO $conn) {
        $this->businesModel = new UserBusinessModel($conn);
		parent::__construct($conn);
	}

    // DATA -------------------------------------------------------------

    public function parseKey(mixed $key): mixed {
        return bigintval($key);
    }

    public function parseData(?array $data): array|null {
        return $this->parseDataAll($data, false);
    }

    public function parseDataRegister(?array $data, string $email): array|null {
        $data['user']['email'] = $email;
        return $this->parseDataAll($data, true);
    }

    public function parseDataAll(?array $data, bool $reg): array|null {
        if($data){
            $newData = [];

            if ($reg) {
                $now = new Date();
                $newData['user']['rol'] = null;
                $newData['user']['status'] = 'active';
                $newData['user']['date_create'] = $now->formatCompleteMySQL();
            } else {
                $newData['user']['id_sup'] = bigintval($data['user']['id_sup'] ?? null, true);
                $newData['user']['rol'] = idxval($data['user']['rol'] ?? null, true);
                $newData['user']['status'] = idxval($data['user']['status'] ?? '');
            }

            $newData['user']['code'] = intval($data['user']['code'] ?? null, true);
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
            $newData['user']['password'] = Encrypt::generateHash($data['user']['password_1']);

            if ($newData['user']['account'] === 'business') {
                $newData['business'] = $this->businesModel->parseData($data['business'] ?? null);
            }

            return $newData;
        } return $data;
    }

    public function parseDataPassword(?array $data): array|null {
        if($data){
            $data['password_1'] = isset($data['password_1']) ? strval($data['password_1']) : null;
            $data['password_2'] = isset($data['password_2']) ? strval($data['password_2']) : null;
        } return $data;
    }

    public function parseTable(ResultData|ResultError|ResultPaginate $data): ResultData|ResultError|ResultPaginate {
        if ($data->success && is_array($data->data)) {
            foreach ($data->data as $key => $item) {
                $data->data[$key] = $this->parseTableItem($item);
            }
        } return $data;
    }

    public function parseTableItem(?array $item): array|null {
        if ($item) {
            $item['id'] = bigintval($item['id']);
        } return $item;
    }

    // VALIDATE -------------------------------------------------------------

    public function validate(?array $data): bool {
        return $this->validateAll($data, false);
    }

    public function validateRegister(?array $data): bool {
        return $this->validateAll($data, true);
    }

    public function validateAll(?array $data, bool $reg): bool {
        $this->error = null;

        if (!$data || !$data['user']) {
            return $this->setError();
        } 

        if (!$reg) {
            if (!isset($data['user']['status']) || !$data['user']['status']) {
                return $this->setError('invalid-status');
            }  
        }

        if (!isset($data['user']['account']) || !$data['user']['account']) {
            return $this->setError('invalid-account');
        } if (!isset($data['user']['gender']) || !$data['user']['gender']) {
            return $this->setError('invalid-gender');
        } if (!isset($data['user']['name']) || !validateName($data['user']['name'])) {
            return $this->setError('invalid-name');
        } if (!isset($data['user']['last_name']) || !validateName($data['user']['last_name'])) {
            return $this->setError('invalid-last-name');
        } if (!isset($data['user']['birthdate']) || !validateAge($data['user']['birthdate'], 18)) {
            return $this->setError('invalid-birthdate');
        } if (!isset($data['user']['document_type']) || !$data['user']['document_type']) {
            return $this->setError('invalid-document-type');
        } if (!isset($data['user']['document_number']) || !$data['user']['document_number']) {
            return $this->setError('invalid-document-number');
        } if (!isset($data['user']['country']) || !$data['user']['country']) {
            return $this->setError('invalid-country');
        } if (!isset($data['user']['state']) || !$data['user']['state']) {
            return $this->setError('invalid-state');
        } if (!isset($data['user']['city']) || !$data['user']['city']) {
            return $this->setError('invalid-city');
        } if (!isset($data['user']['address']) || !$data['user']['address']) {
            return $this->setError('invalid-address');
        } if (!isset($data['user']['phone']) || !validatePhone($data['user']['phone'])) {
            return $this->setError('invalid-phone');
        } if (!isset($data['user']['email']) || !validateEmail($data['user']['email'])) {
            return $this->setError('invalid-email');
        }

        if ($data['user']['account'] === 'business') {
            $valid = $this->businesModel->validate($data['business']);
            $this->error = $this->businesModel->error;
            return $valid;
        } return true;
    }

    public function validatePassword(?array $data): bool {
        $this->error = null;
        if (!$data || !$data['user']) {
            return $this->setError();
        } if (!isset($data['user']['password_1']) || !validatePassword($data['user']['password_1'])) {
            return $this->setError('invalid-password-1');
        } if (!isset($data['user']['password_2']) || $data['user']['password_1'] !== $data['user']['password_2']) {
            return $this->setError('invalid-password-2');
        } return true;
    }

    // METHODS --------------------------------------

	public function register(array $data): ResultError|ResultSuccess {
        if ($this->conn) {
            try {
                $this->conn->beginTransaction();
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
                    'password' => Encrypt::generateHash($data['password'])
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