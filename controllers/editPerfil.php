<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  require_once '../config/Conexion.php';
  
  // Escapar la entrada del usuario
  $iduser = mysqli_real_escape_string($conexion, $_POST['id']);
  
  $consulta = $conexion->query("SELECT * FROM usuarios WHERE idusuarios = '$iduser'");
  
  if ($consulta->num_rows > 0) {
    $persona = $consulta->fetch_assoc();
?>

  <section class="contenedor-form" style="height: 32em; width: 360px; position: absolute;">
  <h2>Editar perfil</h2>
  <div onclick="cerrarVentanaEditar()" class="close">Cerrar</div>
  <form id="savechangeUser" action="controllers/actualizarCambios.php" method="post" enctype="multipart/form-data">
    <label for="Nombre">Nombre </label>
    <input required type="text" name="nombre" value="<?php echo $persona['nombre']; ?>" id="Nombre" />
    <label for="imagenP">Imagen</label>
    <img width="45px" height="45px" src="<?php echo $persona['imguser']; ?>" />
    <input  type="file" id="imagenP" name="imagen" accept="image/*">
    <input type="hidden" name="imagenActual" value="<?php echo $persona['imguser']?>">
    <label for="Apellido">Apellido</label>
    <input required type="text" name="apellido" value="<?php echo $persona['apellido']; ?>" id="Apellido" />
    <label for="Email">Correo electrónico</label>
    <input required type="email" name="email" value="<?php echo $persona['email']; ?>" id="Email" />

    <label for="password">Contraseña</label>
    <input type="hidden" value="<?php echo $iduser; ?>" name="id" id="contraseña">

    <input required type="password" name="password" value="<?php echo $persona['passworduser']; ?>" id="password" />
    <input type="submit" value="Guardar cambios" name="" />
  </form>
</section>

<?php
  }
}
?>
