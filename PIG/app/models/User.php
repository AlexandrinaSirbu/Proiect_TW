<?php

class User
{
    public static function findByUsername($username)
    {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function exists($username)
    {
        return self::findByUsername($username) !== false;
    }

    public static function create($username, $password)
    {
        $db = Database::getConnection();
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $db->prepare("INSERT INTO users (username, password_hash) VALUES (?, ?)");
        $stmt->execute([$username, $hash]);
    }
}
