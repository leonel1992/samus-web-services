<?php
require_once __DIR__ . "/../abstract/dbModelAbstract.php";

class GalleryModel extends DBModelAbstract {
    
    public string $table = 'gallery';
    public string $query = "SELECT * FROM gallery ORDER BY name ASC";

    public function __construct(?PDO $conn) {
        parent::__construct($conn);
    }

    //-----------------------------------------

    public function setParseData(?array $data): array|null {
        if($data){
            $now = new Date();
            $data['date_at'] = $now->formatCompleteMySQL();
            $data['name'] = trimstrval($data['name'] ?? '');
            $data['image'] = $this->processFile('gallery', $data['image']);
            $data['id'] = $this->generateUnikKey($data['name']);
        } return $data;
    }

    public function validate(?array $data): bool {
        return $this->runValidation($data, [
            'name' => !empty($data['name']) && strlen($data['name']) > 2,
            'image' => !empty($data['image']),
        ]);
    }

    //------------------------------------------

    protected function generateUnikKey($name): string|null {
        try {
            $key = normalizetext($name, true, '-');
            $finalKey = $key;
            $i = 0;
    
            do {
                $checkKey = $i === 0 ? $key : "$key-$i";
                $query = "SELECT COUNT(*) as total FROM {$this->table} WHERE `id` = :id";
                $stmt = $this->conn->prepare($query);
                $stmt->execute(['id' => $checkKey]);
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
                if ($result['total'] == 0) {
                    $finalKey = $checkKey;
                    break;
                }
                $i++;
            } while (true);
    
            return $finalKey;
        } catch (PDOException $exception) {
            $this->error = new ResultErrorException($exception);
        } catch (Exception $exception) {
            $this->error = new ResultErrorException($exception);
        } 
        return null;
    }
    
}