<?php
require_once __DIR__ . "/../../lang/{$GLOBALS['lang']}/controllers/generalLang.php";

class DevicesModel extends ORM { 
	
	public function __construct(?PDO $conn) {
		parent::__construct($conn, 'devices');
	}

	public function updateDevice(array $data, ?string $msg=null): ResultError|ResultSuccess {
		if ($this->conn) {
			try {
				$dateCreate = new Date();
				$dateExpire = new Date();
				$dateExpire->addDays(LoginService::EXPIRE_DEVICE);
				$dateCreateFormat = $dateCreate->formatCompleteMySQL();
				$dateExpireFormat = $dateExpire->formatCompleteMySQL();
				
				$edit = "date_expire = :date_expire";
				$fields = "(user, device, date_create, date_expire)";
				$values = "(:user, :device, :date_create, :date_expire)";
				$query = "INSERT INTO devices $fields VALUES $values ON DUPLICATE KEY UPDATE $edit";

				$stmt = $this->conn->prepare($query);
				$stmt->bindValue(":user", $data['user']);
				$stmt->bindValue(":device", $data['device']);
				$stmt->bindValue(":date_create", $dateCreateFormat);
				$stmt->bindValue(":date_expire", $dateExpireFormat);
			
				if($stmt->execute()){
					return new ResultSuccess($msg ?? $GLOBALS['lang-controllers']['general']['update']);
				} return new ResultErrorPDO($stmt);
			} catch (PDOException $exception) {
				return new ResultErrorException($exception);
			} catch (Exception $exception) {
				return new ResultErrorException($exception);
			}
		} return new ResultErrorConn();
	}
}