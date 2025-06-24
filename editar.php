<?php
session_start();
if (!isset($_SESSION['id'])) {
  header("Location: login.html");
  exit();
}

$conexion = new mysqli("localhost", "root", "", "formulario");

$imagen_id = $_POST['imagen_id'];
$nuevo_titulo = $_POST['nuevo_titulo'];
$usuario_id = $_SESSION['id'];

// Verificar que la imagen le pertenece al usuario
$verifica = $conexion->prepare("SELECT * FROM imagenes WHERE id = ? AND usuario_id = ?");
$verifica->bind_param("ii", $imagen_id, $usuario_id);
$verifica->execute();
$resultado = $verifica->get_result();

if ($resultado->num_rows === 1) {
  $actualiza = $conexion->prepare("UPDATE imagenes SET titulo = ? WHERE id = ?");
  $actualiza->bind_param("si", $nuevo_titulo, $imagen_id);
  $actualiza->execute();
}

header("Location: galeria.php");
