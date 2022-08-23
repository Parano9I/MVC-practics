<?php

namespace Shop\Models;

use \Exception;
use \PDO;

class User
{
    private int $id;
    private string $login;
    private string $email;
    private string $password;
    private PDO $db;

    private function __construct(string $login, string $password, string $email)
    {
        $this->login = $login;
        $this->email = $email;
        $this->password = $password;
        $this->db = Db::getInstance()->getConnection();
    }

    public static function setUser(string $login, string $password, string $email = ''): User
    {
        return new User($login, $password, $email);
    }

    private function hashPassword(string $pass): string
    {
        return password_hash($pass, PASSWORD_DEFAULT);
    }

    private function verifyPass(string $pass, string $hashedPass): bool
    {
        return password_verify($pass, $hashedPass);
    }

    private function checkFieldExistence(array $field): void
    {
        $stmt = $this->db->prepare('SELECT id FROM users WHERE `' . key($field) . '` = :' . key($field));
        $stmt->execute($field);

        if (!empty($stmt->fetchColumn())) {
            throw new Exception(json_encode(['error' => ucfirst(key($field)) . ' is already used']));
        }
    }

    public static function isAuth(): bool
    {
        return !empty($_SESSION['userId']);
    }

    public function signUp(): void
    {
        $this->checkFieldExistence(['email' => $this->email]);
        $this->checkFieldExistence(['login' => $this->login]);

        $stmt = $this->db->prepare(
            "INSERT INTO users 
            (login, email, password) VALUES 
            (:login, :email, :password)"
        );
        $stmt->execute([
            "login" => $this->login,
            "email" => $this->email,
            "password" => $this->hashPassword($this->password)
        ]);
        $this->id = $this->db->lastInsertId();
    }

    public function login(bool $isRemember = false): void
    {
        if (empty($this->id)) {
            $stmt = $this->db->prepare("SELECT id, password FROM users WHERE `login` = :login");
            $stmt->execute(["login" => $this->login]);
            $user = $stmt->fetch();
            $isVerifyPass = false;

            if (!empty($user)) {
                $this->id = $user['id'];
                $password = $user['password'];
                $isVerifyPass = $this->verifyPass($this->password, $password);
            }

            if (empty($user) || !$isVerifyPass) {
                throw new Exception(json_encode(['error' => 'Wrong login or password']));
            }
        }

        $_SESSION['userId'] = $this->id;

        if ($isRemember) {
            setcookie("userId", $this->id, time() + 3600);
        }
    }

    public static function logout(): void
    {
        unset($_SESSION['userId']);
        unset($_COOKIE['userId']);
    }

    public static function getId(): int
    {
        return $_SESSION['userId'];
    }

    public static function checkEmailExistence(string $email)
    {
        $stmt = Db::getInstance()->getConnection()->prepare('SELECT id FROM users WHERE email = :email');
        $stmt->execute(['email' => $email]);

        if (!empty($stmt->fetchColumn())) {
            throw new Exception(json_encode(['error' => $email . ' is already used']));
        }
    }
}