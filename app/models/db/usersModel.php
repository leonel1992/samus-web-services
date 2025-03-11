<?php
// require_once __DIR__ . "/rolesModel.php";
// require_once __DIR__ . "/userStatusModel.php";
require_once __DIR__ . "/../../helpers/encrypt.php";
require_once __DIR__ . "/../../helpers/validate.php";
require_once __DIR__ . "/../../lang/{$GLOBALS['lang']}/controllers/databaseLang.php";
require_once __DIR__ . "/../../lang/{$GLOBALS['lang']}/controllers/generalLang.php";

class UsersModel extends ORM {

	protected ?PDO $conn;
	public ?ResultError $error = null;
	public string $query = "SELECT * FROM users ORDER BY full_name ASC";

	public function __construct(?PDO $conn) {
		$this->conn = $conn;
		parent::__construct($conn, 'users');
	}

//     // DATA -------------------------------------------------------------

//     public function parseID($id) {
//         return intval($id);
//     }

//     public function parseData($data) {
//         // if($data){
//         //     $data['rol']     = !array_key_exists('rol',     $data) ? null : idxval($data['rol']);
//         //     $data['status']  = !array_key_exists('status',  $data) ? null : idxval($data['status']);
//         //     $data['account'] = !array_key_exists('account', $data) ? null : idxval($data['account']);
//         //     $data['country'] = !array_key_exists('country', $data) ? null : intval($data['country']);

//         //     $data['date_create'] = !array_key_exists('date_create', $data) ? null : trimstrval($data['date_create']);
//         //     $data['date_login']  = !array_key_exists('date_login',  $data) ? null : trimstrval($data['date_login']);

//         //     $data['name']      = !array_key_exists('name',      $data) ? null : trimstrval($data['name']);
//         //     $data['last_name'] = !array_key_exists('last_name', $data) ? null : trimstrval($data['last_name']);
//         //     $data['email']     = !array_key_exists('email',     $data) ? null : trimstrval($data['email']);
//         //     $data['birthdate'] = !array_key_exists('birthdate', $data) ? null : dateval($data['birthdate']);
//         //     $data['city']      = !array_key_exists('city',      $data) ? null : trimstrval($data['city']);
//         //     $data['district']  = !array_key_exists('district',  $data) ? null : trimstrval($data['district']);
//         //     $data['address']   = !array_key_exists('address',   $data) ? null : trimstrval($data['address']);
//         //     $data['phone']     = !array_key_exists('phone',     $data) ? null : trimstrval($data['phone']);
//         //     $data['password']  = !array_key_exists('password',  $data) ? null : strval($data['password']);
            
//         //     $data['balance']     = !array_key_exists('balance',     $data) ? null : trimstrval($data['balance']);
//         //     $data['social']      = !array_key_exists('social',      $data) ? null : trimstrval($data['social']);
//         //     $data['social_type'] = !array_key_exists('social_type', $data) ? null : trimstrval($data['social_type']);
//         // } return $data;
//     }

    public function parseDataPassword(?array $data): array|null {
        if($data){
            $data['password']         = isset($data['password']) ? strval($data['password']) : null;
            $data['password_confirm'] = isset($data['password_confirm']) ? strval($data['password_confirm']) : null;
        } return $data;
    }

    public function parseDataRegister(?array $data, string $email): array|null {
        if($data){
            $now = new Date();
            $data['rol'] = null;
            $data['status'] = 'active';
            $data['date_create'] = $now->formatCompleteMySQL();
            
            $data['country']  = idxval($data['country']);
            $data['email'] = mb_strtolower(trimstrval($email));
            $data['name']  = ucwords(strtolower(trimstrval($data['name'])));
            $data['last_name'] = ucwords(strtolower(trimstrval($data['last_name'])));
            $data['phone'] = bigintval($data['phone']);
            $data['password'] = Encrypt::generateHash($data['password']);
            unset($data['password_confirm']);
        } return $data;
    }

//     public function parseTable($data) {
//         if ( isset($data['data']) && count($data['data'])>0 ) {
//             foreach ($data['data'] as $key => $item) {
//                 $data['data'] = $this->parseTableItem($item);
//             }
//         } return $data;
//     }

//     public function parseTableItem($item) {
//         $item['id']        = intval($item['id']);
//         return $item;
//     }

//     // VALIDATE -------------------------------------------------------------

//     public function validate($data) {
//         // $this->error = null;
//         // if (!$data) {
//         //     $this->error = $GLOBALS['lang-controllers']['general']['missing-data'];
//         //     return false;
//         // } if (!isset($data['country']) || !is_numeric($data['country']) || $data['country'] <= 0) {
//         //     $this->error = $GLOBALS['lang-controllers']['db'][$this->table]['invalid-country'];
//         //     return false;
//         // } if (!isset($data['name']) || !validateName($data['name']) ) {
//         //     $this->error = $GLOBALS['lang-controllers']['db'][$this->table]['invalid-name'];
//         //     return false;
//         // } if (!isset($data['name']) || !validateName($data['last_name'])) {
//         //     $this->error = $GLOBALS['lang-controllers']['db'][$this->table]['invalid-last-name'];
//         //     return false;
//         // } if (!isset($data['name']) || !validateEmail($data['email'])) {
//         //     $this->error = $GLOBALS['lang-controllers']['db'][$this->table]['invalid-email'];
//         //     return false;
//         // } if (!isset($data['name']) || !validatePhone($data['phone'])) {
//         //     $this->error = $GLOBALS['lang-controllers']['db'][$this->table]['invalid-phone'];
//         //     return false;
//         // } return true;
//     }

    public function validateRegister(?array $data): bool {
        $this->error = null;
        if (!$data) {
            $this->error = new ResultError($GLOBALS['lang-controllers']['general']['missing-data']);
            return false;
        } if (!isset($data['country']) || !$data['country']) {
            $this->error = new ResultError($GLOBALS['lang-controllers']['db'][$this->table]['invalid-country']);
            return false;
        } if (!isset($data['email']) || !validateEmail($data['email'])) {
            $this->error = new ResultError($GLOBALS['lang-controllers']['db'][$this->table]['invalid-email']);
            return false;
        } if (!isset($data['name']) || !validateName($data['name']) ) {
            $this->error = new ResultError($GLOBALS['lang-controllers']['db'][$this->table]['invalid-name']);
            return false;
        } if (!isset($data['last_name']) || !validateName($data['last_name'])) {
            $this->error = new ResultError($GLOBALS['lang-controllers']['db'][$this->table]['invalid-last-name']);
            return false;
        } if (!isset($data['phone']) || !validatePhone($data['phone'])) {
            $this->error = new ResultError($GLOBALS['lang-controllers']['db'][$this->table]['invalid-phone']);
            return false;
        } return true;
    }

    public function validatePassword(?array $data): bool {
        $this->error = null;
        if (!$data) {
            $this->error = new ResultError($GLOBALS['lang-controllers']['general']['missing-data']);
            return false;
        } if (!isset($data['password']) || !validatePassword($data['password'])) {
            $this->error = new ResultError($GLOBALS['lang-controllers']['db'][$this->table]['invalid-password']);
            return false;
        } if (!isset($data['password_confirm']) || $data['password'] !== $data['password_confirm']) {
            $this->error = new ResultError($GLOBALS['lang-controllers']['db'][$this->table]['invalid-password-equal']);
            return false;
        } return true;
    }

    // METHODS --------------------------------------

	public function register(array $data): ResultError|ResultSuccess {
        if ($this->conn) {
            try {
                $insertUser = $this->insert($data);
				if ($insertUser->success) {
					return new ResultSuccess($GLOBALS['lang-controllers']['db'][$this->table]['register-succes']);
				} return new ResultError($GLOBALS['lang-controllers']['db'][$this->table]['register-error']);
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