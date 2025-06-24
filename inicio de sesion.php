<?php
session_start();

// Conexión a la base de datos
$conexion = new mysqli("localhost", "root", "", "formulario");

if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

// Procesar formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = trim($_POST['usuario']);
    $clave = $_POST['clave'];

    // Buscar usuario
    $query = "SELECT * FROM usuarios WHERE usuario = ?";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows === 1) {
        $row = $resultado->fetch_assoc();

        // Validar clave
        if (password_verify($clave, $row['clave'])) {
            $_SESSION['usuario'] = $row['usuario'];
            $_SESSION['id'] = $row['id'];
            $_SESSION['nombre'] = $row['nombre'];
            header("Location: galeria.php"); // Página privada
            exit();
        } else {
            echo "⚠️ Contraseña incorrecta.";
        }
    } else {
        echo "⚠️ Usuario no encontrado.";
    }

    $stmt->close();
}

$conexion->close();
?>
