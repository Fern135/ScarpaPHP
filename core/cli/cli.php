#!/usr/bin/env php

<?php
require "../lib/util/util.php";
use Oracle\lib\util\Util;

$ut = new Util();
$os = $ut->getOperatingSystem();
$DT = $ut->getCurrentDateTime();

function writeEnvFile($directoryPath, $data) {
    // Define the .env file template with placeholders
    $template = "db_host=%s
        db_username=%s
        db_password=%s
        db_database=%s

        secret_key=%s

        email_user=%s
        email_pass=%s
        email_host=%s";

    // Create the full path to the .env file
    $envFilePath = $directoryPath . '/.env';

    // Check if the .env file exists
    if (!file_exists($envFilePath)) {
        // .env file doesn't exist, so create it
        $envContent = sprintf($template, ...$data);
        file_put_contents($envFilePath, $envContent);
        echo "Created $envFilePath and added data";
    } else {
        // .env file exists, so write the data to it
        $envContent = sprintf($template, ...$data);
        file_put_contents($envFilePath, $envContent);
        echo "Data written to $envFilePath";
    }
}


// Check if getopt is available
if (!function_exists('getopt')) {
    die('The getopt function is not available. Please make sure you are running the script from the command line.');
}

// Define options and arguments
$shortOptions = "hvosdtset"; // Define short options (-h, -v)
$longOptions = ["help", "version"]; // Define long options (--help, --version) 

$options = getopt($shortOptions, $longOptions);

// Handle options and arguments
if (isset($options['h']) || isset($options['help'])) {
    // Display help
    echo "Usage: php mycli.php [options] [arguments]\n";
    echo "Options:\n";
    echo "  -h, --help          Display this help message\n";
    echo "  -v, --version       Display the application version\n";
    echo "  -os                 Displaye the operating system being used\n";
    echo "  -dt                 Displays the time and date";
    exit;
}

if (isset($options['v']) || isset($options['version'])) {
    // Display version
    echo "Oracle Version 1.0\n";
    exit;
}

if (isset($options["os"])){
    echo "Oracle Server : $os\n";
}

if (isset($options["-dt"])){
    echo "Time: {$dateTime['time']}\n";
    echo "Date: {$dateTime['date']}\n";
}

if(isset($options["set"])){
    // setting up the .env file 
    $data = [
        'localhost',
        'admin',
        $ut->generateRandomString(300),
        'db_database_value',
        $ut->generateRandomString(256),
        'webdesignbusiness11@gmail.com',
        '',
        'email_host_value' // may delete this 
    ];

    writeEnvFile("../../.env", $data);
}