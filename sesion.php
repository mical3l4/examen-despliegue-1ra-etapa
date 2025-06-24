<?php
// Conexión a la base de datos
$conexion = new mysqli("localhost", "root", "", "formulario");

if ($conexion->connect_error) {
    die("Error en la conexión: " . $conexion->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recibir y limpiar datos
    $nombre = trim($_POST['nombre']);
    $email = trim($_POST['email']);
    $usuario = trim($_POST['usuario']);
    $clave = $_POST['clave'];

    // Validar campos (puedes agregar más validaciones)
    if (empty($nombre) || empty($email) || empty($usuario) || empty($clave)) {
        die("Por favor complete todos los campos.");
    }

    // Verificar si el usuario o correo ya existe
    $sql = "SELECT id FROM usuarios WHERE usuario = ? OR email = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("ss", $usuario, $email);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        die("El usuario o correo ya está registrado.");
    }
    $stmt->close();

    // Encriptar contraseña
    $clave_hash = password_hash($clave, PASSWORD_DEFAULT);

    // Insertar nuevo usuario
    $sql = "INSERT INTO usuarios (nombre, email, usuario, clave) VALUES (?, ?, ?, ?)";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("ssss", $nombre, $email, $usuario, $clave_hash);
    if ($stmt->execute()) {
        echo "Registro exitoso. <a href='Sesion.html'>Inicia sesión aquí</a>.";
    } else {
        echo "Error al registrar usuario.";
    }
    $stmt->close();
}

$conexion->close();
?>
