<?php

// require 'SimpleEncryption.php'; // Assuming your SimpleEncryption class is in a separate file.
use \Oracle\Cryptography\Encrypt\Encrypt;

$encryption = new Encrypt();

// Test the encrypt method
$originalData = 'This is a secret message';
$encryptedData = $encryption->encrypt($originalData);

assert(is_string($encryptedData), 'encrypt should return a string');
assert($encryptedData !== $originalData, 'encrypt should produce different output from the original data');

// Test the decrypt method
$decryptedData = $encryption->decrypt($encryptedData);

assert(is_string($decryptedData), 'decrypt should return a string');
assert($decryptedData === $originalData, 'decrypted data should match the original data');

echo "All tests passed!\n";
