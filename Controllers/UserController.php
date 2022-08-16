<?php

namespace Shop\Controllers;

use Dotenv\Validator;
use Shop\Views\View;
use Shop\Models\User;
use Shop\Helpers\Validation;

class UserController
{
    public function __construct()
    {
        if (User::isAuth()) {
            header('Location: /');
        }
    }

    public function login()
    {
        View::render('login', ['pageTitle' => 'Login']);
    }

    public function logout()
    {
        User::logout();
    }

    public function register()
    {
        View::render('register', ['pageTitle' => 'Register']);
    }

    public function postRegister()
    {
        $errorsMsg = [];
        $notEmpty = ['login', 'email', 'password', 'confirm_password'];

        if (!empty($_POST)) {
            if (Validation::isEqualFields($_POST['password'], $_POST['confirm_password'])) {
                $errorsMsg['password'] = 'Password was not confirmed';
            }

            if (empty($errorsMsg)) {
                try {
                    Validation::validate($_POST, [
                        'login' => [
                            'require' => true,
                            'minLength' => 5
                        ],
                        'password' => [
                            'require' => true,
                            'minLength' => 5
                        ],
                        'email' => [
                            'require' => true,
                            'minLength' => 5,
                            'maxLength' => 30,
                        ]
                    ]);
                    $user = User::setUser(
                        $_POST['login'],
                        $_POST['password'],
                        $_POST['email'],
                    );
                    $user->signUp();
                    $user->login();
                    header('Location: /');
                } catch (\Exception $err) {
                    $errorsMsg = json_decode($err->getMessage(), true);
                    View::render('register', [
                        'errorsMsg' => [...$errorsMsg],
                        'pageTitle' => 'Register'
                    ]);
                }
            }
        }
    }

    public function postLogin()
    {
        $errorsMsg = [];

        if (!empty($_POST)) {
            $isRemember = empty($_POST['remember']) ? false : true;
            try {
                Validation::validate($_POST, [
                    'login' => [
                        'require' => true,
                        'minLength' => 5
                    ],
                    'password' => [
                        'require' => true,
                        'minLength' => 5
                    ]
                ]);
                $user = User::setUser(
                    $_POST['login'],
                    $_POST['password']
                );
                $user->login($isRemember);
                header('Location: /');
            } catch (\Exception $err) {
                $errorsMsg = json_decode($err->getMessage(), true);

                View::render('login', [
                    'errorsMsg' => [...$errorsMsg],
                    'pageTitle' => 'Login'
                ]);
            }
        }
    }
}
