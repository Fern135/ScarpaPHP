<?php

require '../../lib/env_loader/env_loader.php'; // Assuming your loadEnv function is in a separate file.

// Create a sample .env file
$envFileContent = "DB_HOST=localhost\nDB_USERNAME=myuser\nDB_PASSWORD=mypassword\nDB_DATABASE=mydb";
file_put_contents('.env_test', $envFileContent);

// Test loading environment variables from the sample .env file
$loaded = loadEnv();
unlink('.env_test'); // Clean up by removing the test .env file

assert($loaded === true, 'loadEnv should return true when environment variables are loaded');

// Check if environment variables are set correctly
assert($_ENV['DB_HOST']     === 'localhost', 'DB_HOST should be set to localhost');
assert($_ENV['DB_USERNAME'] === 'myuser', 'DB_USERNAME should be set to myuser');
assert($_ENV['DB_PASSWORD'] === 'mypassword', 'DB_PASSWORD should be set to mypassword');
assert($_ENV['DB_DATABASE'] === 'mydb', 'DB_DATABASE should be set to mydb');

echo "All tests passed!\n";
