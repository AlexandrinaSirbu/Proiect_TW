<?php

class AuthController
{
    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username'] ?? '');
            $password = $_POST['password'] ?? '';

            $user = User::findByUsername($username);

            if ($user && password_verify($password, $user['password_hash'])) {
                $_SESSION['user_id'] = $user['id'];
                header('Location: /PIG/public');
                exit;
            } else {
                $error = "Date invalide";
            }
        }

        include VIEW . '/auth/login.php';
    }

    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username'] ?? '');
            $password = $_POST['password'] ?? '';

            if (User::exists($username)) {
                $error = "Username deja folosit";
            } else {
                User::create($username, $password);
                header('Location: /PIG/public/login');
                exit;
            }
        }

        include VIEW . '/auth/register.php';
    }

    public function logout()
    {
        session_destroy();
        header('Location: /');
        exit;
    }
}
