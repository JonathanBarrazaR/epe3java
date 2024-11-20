<?php
session_start();
include 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $contrasena = $_POST['contrasena'];

    // Consultar el usuario por el email
    $sql = "SELECT * FROM usuarios WHERE email = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$email]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    // Verificar si el usuario existe y si la contraseña es correcta
    if ($usuario && password_verify($contrasena, $usuario['contrasena'])) {
        $_SESSION['user_id'] = $usuario['id']; // Guardar el ID del usuario en la sesión
        header("Location: dashboard.php"); // Redirigir al dashboard
        exit();
    } else {
        // Establecer un mensaje de error en la sesión
        $_SESSION['mensaje'] = "Email o contraseña incorrectos.";
        header("Location: index.php"); // Redirigir a index.php
        exit();
    }
}
?>