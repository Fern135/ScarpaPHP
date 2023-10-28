<?php 

// should fix the having to use require for every class i use namespace with
require "../vendor/autoload.php"; 
require '../core/Main/App.php';

$app = new App();
$app->run();        // running Oracle