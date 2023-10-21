<?php 

// require '../../Router/Router.php'; 

use \Oracle\router\Router;

$router = new Router();

// Define some routes using the get and post methods
$router->get('/home', 'HomeController@index');
$router->post('/login', 'AuthController@login');

// Test if the route retrieval works correctly
assert($router->route('/home', 'GET')   === 'HomeController@index', 'Route for /home, GET should be HomeController@index');
assert($router->route('/login', 'POST') === 'AuthController@login', 'Route for /login, POST should be AuthController@login');
assert($router->route('/about', 'GET')  === null, 'Route for /about, GET should be null (not found)');

echo "All tests passed!\n";
