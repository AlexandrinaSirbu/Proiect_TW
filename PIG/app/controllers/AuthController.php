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
                $_SESSION['username'] = $user['username']; 
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
    session_start();
    $_SESSION = [];
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }
    session_destroy();

    header('Location: /PIG/public/login');
    exit;
}

}
