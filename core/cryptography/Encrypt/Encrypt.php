<?php 

namespace Oracle\Cryptography\Encrypt;

include "../../lib/env_loader/env_loader.php";

class Encrypt {
    private $cipher = 'aes-256-cbc';  // Cipher method
    private $key;                    // Encryption key
    private $iv;                     // Initialization vector (IV)

    public function __construct() {
        $loaded = loadEnv();
        if ($loaded) {
            echo "Environment variables loaded successfully from envFile.\n";
        } else {
            echo "No .env file found or failed to load environment variables.\n";
        }

        $this->key = $_ENV['secret_key'];
        $this->iv = random_bytes(16);  // Generate a random IV
    }

    public function encrypt($data) {
        $encrypted = openssl_encrypt($data, $this->cipher, $this->key, 0, $this->iv);
        return base64_encode($this->iv . $encrypted);
    }

    public function decrypt($data) {
        $data = base64_decode($data);
        $iv = substr($data, 0, 16);
        $data = substr($data, 16);
        return openssl_decrypt($data, $this->cipher, $this->key, 0, $iv);
    }
}