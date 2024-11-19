<?php
$host = 'localhost'; 
$db = 'registro_usuarios';
$user = 'jonathan';
$pass = 'Holashushe12345!';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Error de conexión: " . $e->getMessage();
}
?>