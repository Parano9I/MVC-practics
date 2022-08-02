<?php
error_reporting(E_ALL);

use Dotenv\Dotenv;

use Shop\Routes\Route;

require_once dirname(__FILE__, 2) . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

$dotenv = Dotenv::createImmutable(dirname(__FILE__, 2));
$dotenv->load();

session_start();

Route::add([
    'url' => '/',
    'controller' => 'Products',
    'action' => 'index',
    'is_auth' => 1
]);

Route::add([
    'url' => 'user/logout',
    'controller' => 'User',
    'action' => 'logout',
    'is_auth' => 1
]);

Route::add([
    'url' => 'user/register',
    'controller' => 'User',
    'action' => 'register',
    'is_auth' => 0
]);

Route::add([
    'url' => 'user/login',
    'controller' => 'User',
    'action' => 'login',
    'is_auth' => 0
]);

Route::run();