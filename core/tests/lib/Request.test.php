<?php

// require 'Request.php'; // Assuming your Request class is in a separate file.
use \Oracle\lib\Request\Request;

$request = new Request('https://api.example.com');

// Test setUrl method
$request->setUrl('https://newapi.example.com');
assert($request->url === 'https://newapi.example.com', 'setUrl should update the URL');

// Test setMethod method
$request->setMethod('POST');
assert($request->method === 'POST', 'setMethod should update the HTTP method');

// Test withMethod, withData, and withHeaders methods
$request
    ->withMethod('PUT')
    ->withData(['key' => 'value'])
    ->withHeaders(['Authorization: Bearer YOUR_TOKEN']);

assert($request->method  === 'PUT', 'withMethod should update the HTTP method');
assert($request->data    === ['key' => 'value'], 'withData should update the data');
assert($request->headers === ['Authorization: Bearer YOUR_TOKEN'], 'withHeaders should update the headers');

// Mocking a CURL request and test the send method
// For a full test, you'd need to use a testing framework to mock CURL requests.
// This example just shows a simple way to test the send method.

// Function to mock CURL requests
function mockCurl($url, $options) {
    if ($options[CURLOPT_URL] === 'https://newapi.example.com') {
        return 'Mocked Response Data';
    } else {
        return false;
    }
}

// Mock the curl_init and curl_setopt functions
function curl_init($url) {
    return true;
}

function curl_setopt($ch, $option, $value) {
    return true;
}

// Set the mock function for curl_exec
function curl_exec($ch) {
    global $request;
    return mockCurl($request->url, curl_getinfo($ch));
}

// Mock the curl_close function
function curl_close($ch) {
    return true;
}

// Test the send method
$response = $request->send();
assert($response === 'Mocked Response Data', 'send should return the expected response');

echo "All tests passed!\n";
