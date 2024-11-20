<?php
session_start();
include 'conexion.php'; // Asegúrate de que este archivo esté correctamente configurado

if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit();
}

// Mostrar mensaje si existe
$mensaje = '';
if (isset($_SESSION['mensaje'])) {
    $mensaje = $_SESSION['mensaje'];
    unset($_SESSION['mensaje']); // Limpiar mensaje después de mostrarlo
}

// Verificar si se envió el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $contrasena = $_POST['contrasena'];

    // Consulta para verificar el usuario
    $sql = "SELECT id, contrasena FROM usuarios WHERE email = ?";
    $stmt = $conexion->prepare($sql);

    if ($stmt === false) {
        die("Error en la preparación de la consulta: " . $conexion->error);
    }

    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($user_id, $hashed_password);
        $stmt->fetch();

        // Verificar la contraseña
        if (password_verify($contrasena, $hashed_password)) {
            // Iniciar sesión
            $_SESSION['user_id'] = $user_id;
            header("Location: dashboard.php");
            exit();
        } else {
            $mensaje = "Contraseña incorrecta.";
        }
    } else {
        $mensaje = "No existe un usuario con ese email.";
    }

    $stmt->close(); // Cerrar la declaración
}

// Cerrar la conexión a la base de datos
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="stylo.css">
    <title>Login</title>
    <script>
        // Mostrar alerta si hay un mensaje
        window.onload = function() {
            <?php if ($mensaje): ?>
                alert('<?php echo htmlspecialchars($mensaje); ?>');
            <?php endif; ?>
        };
    </script>
</head>
<body>
    <h2>Iniciar Sesión</h2>
    <form action="login.php" method="POST">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>

        <label for="contrasena">Contraseña:</label>
        <input type="password" id="contrasena" name="contrasena" required>

        <button type="submit">Entrar</button>
    </form>

    <p>¿No tienes una cuenta? <a href="registro.html">Regístrate aquí</a></p> <!-- Enlace al registro -->
</body>
</html>