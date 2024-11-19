<?php
session_start(); // Iniciar sesión
include 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre_completo = $_POST['nombre_completo'];
    $email = $_POST['email'];
    $telefono = $_POST['telefono'];
    $contrasena = $_POST['contrasena'];
    $confirmacion_contrasena = $_POST['confirmacion_contrasena'];
    $fecha_nacimiento = $_POST['fecha_nacimiento'];

    if ($contrasena === $confirmacion_contrasena) {
        $hashed_password = password_hash($contrasena, PASSWORD_DEFAULT);
        
        $sql = "INSERT INTO usuarios (nombre_completo, email, telefono, contrasena, fecha_nacimiento) VALUES (?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        
        if ($stmt->execute([$nombre_completo, $email, $telefono, $hashed_password, $fecha_nacimiento])) {
            $_SESSION['mensaje'] = 'Registro exitoso. Puedes iniciar sesión ahora.';
            header("Location: index.php");
            exit();
        } else {
            $_SESSION['mensaje'] = 'Error en el registro.';
            header("Location: registro.html");
            exit();
        }
    } else {
        $_SESSION['mensaje'] = 'Las contraseñas no coinciden.';
        header("Location: registro.html");
        exit();
    }
}
?>