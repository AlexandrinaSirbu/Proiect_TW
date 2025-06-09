<?php


class DashboardController
{
    public function index()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: PIG/public/login');
            exit;
        }

        include VIEW . '/dashboard/index.php';
    }

    public function history()
    {
        require_once MODEL . '/GeneratedInput.php';
        $items = GeneratedInput::getAllByUser($_SESSION['user_id']);
        include VIEW . '/dashboard/history.php';
    }
}
