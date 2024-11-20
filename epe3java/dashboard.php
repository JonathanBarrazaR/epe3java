<?php
session_start();

// Verificar si el usuario está logueado
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php"); // Redirigir al login si no está logueado
    exit();
}

// Conectar a la base de datos
$conexion = new mysqli("localhost", "jonathan", "Holashushe12345!", "registro_usuarios");

// Verificar conexión
if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

// Consulta para obtener los usuarios
$sql = "SELECT nombre_completo, email, telefono, fecha_nacimiento, fecha_registro FROM usuarios";
$result = $conexion->query($sql);

// Manejo de errores en la consulta
if (!$result) {
    die("Error en la consulta: " . $conexion->error);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="stylo.css">
    <title>Dashboard</title>
</head>
<body>
    <h2>Bienvenido al Dashboard</h2>
    <p>Has iniciado sesión correctamente.</p>
    <a href="logout.php">Cerrar sesión</a> <!-- Enlace para cerrar sesión -->

    <h3>Lista de Usuarios</h3>
<?php if ($result->num_rows > 0): ?>
    <table>
        <tr>
            <th>Nombre Completo</th>
            <th>Email</th>
            <th>Teléfono</th>
            <th>Fecha de Nacimiento</th>
            <th>Fecha de Registro</th> <!-- Nueva columna -->
        </tr>
        <?php while($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo htmlspecialchars($row["nombre_completo"]); ?></td>
                <td><?php echo htmlspecialchars($row["email"]); ?></td>
                <td><?php echo htmlspecialchars($row["telefono"]); ?></td>
                <td><?php echo htmlspecialchars($row["fecha_nacimiento"]); ?></td>
                <td><?php echo htmlspecialchars($row["fecha_registro"]); ?></td> <!-- Mostrar fecha de registro -->
            </tr>
        <?php endwhile; ?>
    </table>
<?php else: ?>
    <p>No hay usuarios registrados.</p>
<?php endif; ?>

    <?php
    // Cerrar conexión
    $conexion->close();
    ?>
</body>
</html>