<?php

function loadEnv() {
    $envFiles = glob('.env*');

    if (empty($envFiles)) {
        return false;
    }

    $envFile = $envFiles[0];

    $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    if ($lines === false) {
        return false;
    }

    foreach ($lines as $line) {
        list($key, $value) = explode('=', $line, 2);
        $_ENV[trim($key)] = trim($value);
        $_SERVER[trim($key)] = trim($value);
    }

    return true;
}

// $loaded = loadEnv();

// if ($loaded) {
//     echo "Environment variables loaded successfully from $envFile.\n";
// } else {
//     echo "No .env file found or failed to load environment variables.\n";
// }

// // Access environment variables
// $dbHost = $_ENV['DB_HOST'];
// $dbUser = $_ENV['DB_USER'];
// $dbPass = $_ENV['DB_PASS'];
// $dbName = $_ENV['DB_NAME'];

// echo "DB Host: $dbHost\n";
// echo "DB User: $dbUser\n";
// echo "DB Pass: $dbPass\n";
// echo "DB Name: $dbName\n";
