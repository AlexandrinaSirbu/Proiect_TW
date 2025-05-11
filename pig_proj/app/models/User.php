<?php
class User extends Model {
    public function findByEmail(string $email){
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function authenticate(string $email, string $password){
        $user = $this->findByEmail($email);
        return $user && password_verify($password, $user['password']);
    }

    public function create(string $username, string $email, string $password){
        $hash = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $this->db->prepare(
          "INSERT INTO users (username,email,password) VALUES (?,?,?)"
        );
        return $stmt->execute([$username, $email, $hash]);
    }
}
