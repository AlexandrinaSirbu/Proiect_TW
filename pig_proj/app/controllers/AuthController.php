<?php

class AuthController extends Controller {

    public function showLogin() {
        $this->view('auth/login');
    }

public function login() {
    $email    = $_POST['email']    ?? '';
    $password = $_POST['password'] ?? '';
    $userModel = $this->model('User');

    if ($userModel->authenticate($email, $password)) {
        $_SESSION['user'] = $email;
        header('Location: /pig_proj/app/views/pig');
        exit;
    }

    $this->view('auth/login', [
        'error' => 'Email sau parolă incorectă.'
    ]);
}



    public function showRegister() {
        $this->view('auth/register');
    }

    public function register() {
        $username         = $_POST['username']         ?? '';
        $email            = $_POST['email']            ?? '';
        $password         = $_POST['password']         ?? '';
        $password_confirm = $_POST['password_confirm'] ?? '';

        if ($password !== $password_confirm) {
            $this->view('auth/register', [
                'error' => 'Parolele nu coincid.'
            ]);
            return;
        }

        $userModel = $this->model('User');

        if ($userModel->findByEmail($email)) {
            $this->view('auth/register', [
                'error' => 'Email deja înregistrat.'
            ]);
            return;
        }

        if ($userModel->create($username, $email, $password)) {
            $this->view('auth/register', [
                'success' => 'Cont creat cu succes! Poți să te autentifici acum.'
            ]);
        } else {
            $this->view('auth/register', [
                'error' => 'A apărut o eroare la crearea contului.'
            ]);
        }
    }


    public function logout() {
        session_destroy();
        header('Content-Type: application/json');
        echo json_encode(['success' => true]);
    }


    public function verify() {
        header('Content-Type: application/json');
        if (!empty($_SESSION['user'])) {
            echo json_encode([
                'loggedIn' => true,
                'email'    => $_SESSION['user']
            ]);
        } else {
            echo json_encode(['loggedIn' => false]);
        }
    }
}
