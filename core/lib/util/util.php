<?php 

namespace Oracle\lib\util;

class Util{

    private $characters;

    public function __construct(){
        $this->characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!@#%^&*()_+=-1234567890[]{};"",./<>?';
    }
    
    public function __destruct(){
        $this->characters = null;

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
    
}