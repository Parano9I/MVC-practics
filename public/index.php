<?php
error_reporting(E_ALL);

use Dotenv\Dotenv;

use Shop\Routes\Route;
use Shop\Models\User;

require_once dirname(__FILE__, 2) . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

$dotenv = Dotenv::createImmutable(dirname(__FILE__, 2));
$dotenv->load();

session_start();

Route::add([
    'url' => '/',
    'controller' => 'Products',
    'action' => 'index',
    'isAuth' => 1
]);

Route::add([
    'url' => 'user/register',
    'controller' => 'User',
    'action' => 'register',
    'isAuth' => 0
]);

Route::add([
    'url' => 'user/login',
    'controller' => 'User',
    'action' => 'login',
    'isAuth' => 0
]);

Route::add([
    'url' => 'user/logout',
    'controller' => 'User',
    'action' => 'logout',
    'isAuth' => 1
]);

Route::add([
    'url' => 'user/post-login',
    'controller' => 'User',
    'action' => 'postLogin',
    'isAuth' => 0
]);

Route::add([
    'url' => 'user/post-register',
    'controller' => 'User',
    'action' => 'postRegister',
    'isAuth' => 0
]);

Route::add([
    'url' => 'cart',
    'controller' => 'Cart',
    'action' => 'index',
    'isAuth' => 1
]);

Route::add([
    'url' => 'cart/add-product',
    'controller' => 'Cart',
    'action' => 'addProduct',
    'isAuth' => 1
]);

Route::add([
    'url' => 'cart/remove-product',
    'controller' => 'Cart',
    'action' => 'removeProduct',
    'isAuth' => 1
]);


Route::setMiddleware(function () {
    if (!User::isAuth() && !empty($_COOKIE['userId'])) {
        $_SESSION['userId'] = $_COOKIE['userId'];
    }
});

Route::setMiddleware(function ($isAuth) {
    if (!User::isAuth() && $isAuth) {
        header('Location: /user/login');
    }
}, 'isAuth');

Route::run();