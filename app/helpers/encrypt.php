<?php
class Encrypt {

    protected static ?string $encryptionKey = null;
    protected static string $method = 'AES-256-CBC';

    protected static function getEncryptionKey(): ?string {
        if (self::$encryptionKey === null) {
            $filePath = __DIR__ . "/../../.private/secret-key.txt";
            if (file_exists($filePath)) {
                self::$encryptionKey = trim(file_get_contents($filePath));
            }
        } return self::$encryptionKey;
    }

    public static function generateKey(string $data): ?string {
        $key = self::getEncryptionKey();
        if ($key) {
            $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length(self::$method));
            $encryptedData = openssl_encrypt($data, self::$method, $key, 0, $iv);
            return base64_encode("$encryptedData::$iv");
        } return null;
    }


    public static function decryptKey(string $data): ?string {
        $key = self::getEncryptionKey();
        if ($key) {
            [$encrypted_data, $iv] = explode('::', base64_decode($data), 2);
            return openssl_decrypt($encrypted_data, self::$method, $key, 0, $iv);
        } return null;
    }
    
    public static function validateKey(string $key, string $hash): bool {
        $decryptedApiKey = self::decryptKey($hash);
        return $decryptedApiKey === $key;
    }

    // -------------------------------------------------------------------
    
    public static function generateHash(string $data): string {
        return password_hash($data, PASSWORD_DEFAULT);
    } 

    public static function validateHash(string $data, string $hash): bool {
        return password_verify($data, $hash);
    } 
}
