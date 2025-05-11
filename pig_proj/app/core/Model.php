<?php
class Model {
    protected $db;
    public function __construct(){
        $this->db = new PDO(
            DB_DSN, DB_USER, DB_PASS,
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
        );
    }
}
