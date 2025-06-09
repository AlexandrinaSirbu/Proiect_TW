<?php

class GeneratedInput
{
    public static function save($userId, $type, $content)
    {
        $db = Database::getConnection();
        $stmt = $db->prepare("INSERT INTO generated_inputs (user_id, type, content) VALUES (?, ?, ?)");
        $stmt->execute([$userId, $type, json_encode($content)]);
    }

    public static function getAllByUser($userId)
    {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT * FROM generated_inputs WHERE user_id = ? ORDER BY created_at DESC");
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public static function getById($id)
    {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT * FROM generated_inputs WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

}
