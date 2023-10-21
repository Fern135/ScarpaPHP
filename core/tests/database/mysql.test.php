<?php

// require 'mysql.php'; // Assuming your mysql class is in a separate file.
use \Oracle\databases\mysql\mysql;

$database = new mysql();

// Test the database connection
assert($database->getConnection() !== null, 'Database connection should not be null');

// Define test data for insertion
$data = [
    'John Doe',
    'john.doe@example.com',
    '123456',
];

// Test data insertion
$database->insert('users', $data);
// Assuming the 'users' table exists in your database

// Perform a query to check if the inserted data is present
$query = "SELECT * FROM users WHERE username = 'John Doe'";
$result = mysqli_query($database->getConnection(), $query);
$row = mysqli_fetch_assoc($result);

// Check if the inserted data is present in the database
assert($row['email']    === 'john.doe@example.com', 'Data insertion should be successful');
assert($row['password'] === '123456', 'Data insertion should be successful');

echo "All tests passed!\n";
