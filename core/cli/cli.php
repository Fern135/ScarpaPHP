#!/usr/bin/env php

<?php

use Oracle\lib\util\Util;

$ut = new Util();
$os = $ut->getOperatingSystem();
$DT = $ut->getCurrentDateTime();

// Check if getopt is available
if (!function_exists('getopt')) {
    die('The getopt function is not available. Please make sure you are running the script from the command line.');
}

// Define options and arguments
$shortOptions = "hvosdt"; // Define short options (-h, -v)
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