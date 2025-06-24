<?php
session_start();
if (!isset($_SESSION['id'])) {
  header("Location: login.html");
  exit();
}

$conexion = new mysqli("localhost", "root", "", "formulario");

$titulo = $_POST['titulo'];
$usuario_id = $_SESSION['id'];
$carpeta = "uploads/";

if (!is_dir($carpeta)) {
  mkdir($carpeta);
}

$nombre_archivo = basename($_FILES["imagen"]["name"]);
$destino = $carpeta . time() . "_" . $nombre_archivo;

if (move_uploaded_file($_FILES["imagen"]["tmp_name"], $destino)) {
  $stmt = $conexion->prepare("INSERT INTO imagenes (usuario_id, titulo, ruta) VALUES (?, ?, ?)");
  $stmt->bind_param("iss", $usuario_id, $titulo, $destino);
  $stmt->execute();
}

header("Location: galeria.php");
