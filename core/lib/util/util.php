<?php 

namespace Scarpa\lib\util;
use Exception;

include '../env_loader/env_loader.php';

class Util{

    private $characters;
    private $pattern;
    

    public function __construct(){
        $loaded = loadEnv();
        if ($loaded) {
            echo "Environment variables loaded successfully from envFile.\n";
        } else {
            echo "No .env file found or failed to load environment variables.\n";
        }

        $this->characters   = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!@#%^&*()_+=-1234567890[]{};"",./<>?';
        $this->pattern      = '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/';
    }
    
    public function __destruct(){
        $this->characters   = null;
        $this->pattern      = null;
        
    }

    function generateRandomString($length) {
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $this->characters[rand(0, strlen($this->characters) - 1)];
        }
    
        return $randomString;
    }

    public function toString($input) {
        return strval($input);
    }
    
    public function toInt($input) {
        return intval($input);
    }
    
    public function toFloat($input) {
        return floatval($input);
    }
    
    public function toArray($input) {
        if (is_array($input)) {
            return $input; // Already an array
        } else {
            return array($input); // Convert to a one-element array
        }
    }
    
    public function toJson($input) {
        // Attempt to decode the input string
        $decoded = json_decode($input);
    
        // Check if the decoding was successful
        if ($decoded !== null && json_last_error() === JSON_ERROR_NONE) {
            return $input; // Already valid JSON
        } else {
            return json_encode($input); // Convert to JSON
        }
    }

    public function getParamTypeString($inputArray) {
        $typeString = '';
        
        foreach ($inputArray as $value) {
            if (is_int($value)) {
                $typeString .= 'i'; // Integer
            } elseif (is_float($value)) {
                $typeString .= 'd'; // Double (floating-point)
            } elseif (is_string($value)) {
                $typeString .= 's'; // String
            } else {
                $typeString .= 's'; // Default to string if the type is unknown
            }
        }
        
        return $typeString;
    }
    
    public function getOperatingSystem() { //* dev
        if($_ENV['debug'] === true){
            $uname = php_uname('s'); // Get the OS name
            $lowercaseUname = strtolower($uname);
            
            if (strpos($lowercaseUname, 'linux') !== false) {
                return 'Linux';
            } elseif (strpos($lowercaseUname, 'darwin') !== false) {
                return 'macOS';
            } elseif (strpos($lowercaseUname, 'win') !== false) {
                return 'Windows';
            } else {
                return 'Unknown';
            }
        }

        return false;
    }

    public function getCurrentDateTime() {
        // Get current timestamp
        $timestamp = time();
    
        // Format the time as "HH:MM AM/PM"
        $time = date("h:i A", $timestamp);
    
        // Format the date as "DD:MM:YYYY"
        $date = date("d:m:Y", $timestamp);
    
        return $this->jsonify([ 'time' => $time, 'date' => $date ]);
    }

    public function jsonify($data) {
        // Use json_encode to convert the data to JSON
        $json = json_encode($data);
    
        if ($json === false) {
            // Handle the error if the conversion fails
            throw new Exception('JSON encoding failed');
        }
    
        // Return the JSON string
        return $json;
    }

    public function validateEmail($email) {
        // Use the preg_match function to check if the email matches the pattern
        if (preg_match($this->pattern, $email)) {
            return true; // Valid email
        } else {
            return false; // Invalid email
        }
    }
    
}