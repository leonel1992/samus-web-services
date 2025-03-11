<?php
class SessionsModel extends ORM {

	public function __construct(?PDO $conn) {
	    parent::__construct($conn, 'sessions');
	}

    public function updateSession(array $data, ?string $msg=null): ResultError|ResultSuccess {
        if ($this->conn){
            try {
                $dateCreate = new Date();
                $dateCreateFormat = $dateCreate->formatCompleteMySQL();

                $dateExpire = new Date();
                $dateExpire->addMinutes($data['expire']);
                $dateExpireFormat = $dateExpire->formatCompleteMySQL();

                $edit = "date_expire = :date_expire";
                $fields = "(user, device, session, date_create, date_expire)";
                $values = "(:user, :device, :session, :date_create, :date_expire)";
                $sql = "INSERT INTO sessions $fields VALUES $values ON DUPLICATE KEY UPDATE $edit";

                $stmt = $this->conn->prepare($sql);
                $stmt->bindValue(":user", $data['user']);
                $stmt->bindValue(":device", $data['device']);
                $stmt->bindValue(":session", $data['session']);
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