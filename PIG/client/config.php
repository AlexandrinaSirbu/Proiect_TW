<?php
$host = 'localhost';
$dbname = 'pig_app';
$user = 'root'; 
$pass = '';     

try {
  $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $user, $pass);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
  die("Eroare conexiune: " . $e->getMessage());
}
?>
