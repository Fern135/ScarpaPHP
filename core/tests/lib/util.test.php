<?php

// require 'Util.php'; // Assuming your Util class is in a separate file.
use \Oracle\lib\util\Util;

$util = new Util();

// Test generateRandomString method
$randomString = $util->generateRandomString(10);
assert(strlen($randomString) === 10, 'Generated random string should have a length of 10 characters');

// Test toString method
$toStringResult = $util->toString(123);
assert($toStringResult === '123', 'toString should convert an integer to a string');

// Test toInt method
$toIntResult = $util->toInt('456');
assert($toIntResult === 456, 'toInt should convert a string to an integer');

// Test toFloat method
$toFloatResult = $util->toFloat('3.14');
assert($toFloatResult === 3.14, 'toFloat should convert a string to a float');

// Test toArray method
$toArrayResult = $util->toArray('test');
assert($toArrayResult === ['test'], 'toArray should convert a non-array input to an array');

// Test toJson method
$toJsonResult = $util->toJson(['key' => 'value']);
assert($toJsonResult === '{"key":"value"}', 'toJson should convert an array to a JSON string');

// Test getParamTypeString method
$paramTypeString = $util->getParamTypeString([123, 'test', 3.14]);
assert($paramTypeString === 'ids', 'getParamTypeString should return the correct type string');

echo "All tests passed!\n";
