<?php
session_start();
$conexion = new mysqli("localhost", "root", "", "formulario");

// Obtener imágenes
$consulta = "SELECT imagenes.*, usuarios.nombre FROM imagenes 
             JOIN usuarios ON imagenes.usuario_id = usuarios.id 
             ORDER BY fecha_subida DESC";
$resultado = $conexion->query($consulta);
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Galería</title>
  <style>
    .galeria img { width: 200px; margin: 10px; border-radius: 8px; }
    form { margin-top: 20px; }
  </style>
</head>
<body>
  <h1>Galería de Imágenes</h1>

  <?php if (isset($_SESSION['usuario'])): ?>
    <p>Hola, <?php echo $_SESSION['nombre']; ?> | <a href="logout.php">Cerrar sesión</a></p>

    <!-- Formulario para subir imagen -->
    <form action="subir.php" method="POST" enctype="multipart/form-data">
      <input type="text" name="titulo" placeholder="Título de la imagen" required><br>
      <input type="file" name="imagen" accept="image/*" required><br>
      <button type="submit">Subir imagen</button>
    </form>
  <?php else: ?>
    <p><a href="login.html">Iniciar sesión</a> para subir imágenes.</p>
  <?php endif; ?>

  <div class="galeria">
    <?php while ($img = $resultado->fetch_assoc()): ?>
      <div>
        <p><strong><?php echo htmlspecialchars($img['titulo']); ?></strong> por <?php echo htmlspecialchars($img['nombre']); ?></p>
        <img src="<?php echo htmlspecialchars($img['ruta']); ?>" alt="Imagen">
        
        <?php if (isset($_SESSION['id']) && $_SESSION['id'] == $img['usuario_id']): ?>
          <form action="editar.php" method="POST">
            <input type="hidden" name="imagen_id" value="<?php echo $img['id']; ?>">
            <input type="text" name="nuevo_titulo" value="<?php echo htmlspecialchars($img['titulo']); ?>" required>
            <button type="submit">Editar</button>
          </form>
        <?php endif; ?>
      </div>
    <?php endwhile; ?>
  </div>
</body>
</html>
