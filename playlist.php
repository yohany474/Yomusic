<?php
session_start();
if (isset($_SESSION['notifi'])) {
  $data = $_SESSION['notifi'];
  echo "<script>alert('" . $data . "')</script>";
  unset($_SESSION['notifi']);
  session_destroy();
}
require 'model/consultaPlaylist.php';
require 'model/modelPlaylistAdd.php';
require 'model/musica.php';

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="css/playlistPrincipal.css" />
  <link rel="stylesheet" href="css/principal.css" />
  <script src="https://kit.fontawesome.com/0015840e45.js" crossorigin="anonymous"></script>
  <title>PLaylist</title>
</head>

<body>



  <!-- Verificacion de playlist -->
  <?php if (isset($_GET['id'])) {

    if (!empty($_GET['iduser'])) {


      $idusuario = $_GET['iduser'];
      if (isset($_GET['tipo'])) {
        $tipo = $_GET['tipo'];
      } else {
        $tipo = '';
      }

      if (isset($_SESSION['idUsuario']) && $_SESSION['idUsuario'] === $idusuario) {
        $add = '
        <a class="" id="crearPlaylist" onclick="abrirModal(\'ventanaCrearPLaylist\', \'cerrarPlaylist\')">
          <i class="fa-solid fa-list"></i>
          <p class="">Agregar mas canciones</p>
        </a>
        ';
      } else {
        $add = '';
      }
    }


    $playlist = $_GET['id'];
    echo '
        <!-- Banner de la playlist -->
        <section id="banner">
          ' . $add . '
          <a href="index.php"><i class="fas fa-home"></i> Volver al inicio </a>
          <section>
            <h3>' . $playlist . '</h3>
            <h5>Creada por yohany <i class="fas fa-music"></i></h5>
          </section>
        </section>

        <!-- Lista de canciones -->
        <section id="list-music" class="ContenedorMusica">
        '
    ;
    $resultado = obtenerCancionesPorPlaylist($playlist);

    if (!empty($resultado)) {
      $var = 0;

      foreach ($resultado as $cancion) {

        $var = $var + 1;
        echo '<style>
            #banner{
             background-image: url("' . $cancion['imagenP'] . '");
            }
             </style>';
        $playlistImagen = $cancion['imagenP'];
        $var = 0;

        if (isset($_SESSION['idUsuario']) && $cancion['idUsuarios'] === $_SESSION['idUsuario']) {
          $enlace = '<a href="controllers/eliminarCancionPlaylist.php?id=' . $cancion['idmusica'] . '&ruta=' . $playlist . '&iduser=' . $idusuario . '" onclick="return confirm(\'¿Estás seguro de que deseas eliminar ' . $cancion['nombre'] . '?\')"><i class="fa-solid fa-trash"></i></a>';
        }else{
          $enlace = '';
        }
        $var = $var + 1;

        echo '
       
          <div class="listaCancion">
            <img src="' . $cancion['imagen'] . '" alt="" />
            <span class="informacion">
              <p>' . $cancion['nombre'] . '</p>
              <sub>' . $cancion['artista'] . '</sub>
            </span>
            <div class="playCancion cancion" data-nombre="' . $cancion['nombre'] . '"  data-ruta="' . $cancion['ruta'] . '"><i class="fa-solid fa-play"></i></div>
            <a href="' . $cancion['ruta'] . '" download class=""><i class="fa-solid fa-download"></i></a>
            ' . $enlace . '
          </div>
        ';
      }
      echo ' </section>  ';
    } else {
      header("location: index.php");
    }
  }
  ?>
  <!-- Agregar mas items a la playlist -->
  <section id="ventanaCrearPLaylist">

    <?php require_once 'controllers/actualizarPlaylist.php'; ?>
    <form action="" method="post" class="form" enctype="multipart/form-data" id="addMusic">
      <div class="close" id="cerrarPlaylist">Cerrar</div>
      <label for="">Selecciona las canciones que deseas añadir a tu lista de playlist <p
          style="color: var(--color-principal);">
          <?php echo $playlist; ?>
        </p></label>
      <div id="list-music">
        <input type="hidden" name="nombrePLaylist" value="<?php echo $playlist ?>">
        <input type="hidden" name="imagenP" value="<?php echo $playlistImagen ?>">
        <input type="hidden" name="ruta" value="<?php echo $playlist ?>">
        <input type="hidden" name="iduser" value="<?php echo $idusuario ?>">
        <input type="hidden" name="tipo" value="<?php echo $tipo ?>">
        <?php
        $cancionesLista = getCanciones($playlist);

        if (!empty($cancionesLista)) {
          foreach ($cancionesLista as $cancion) {
            echo '<label><input  name="idMusica[]" type="checkbox" value="' . $cancion['idmusica'] . '"> ' . $cancion['nombre'] . '</label>';
          }
        }
        ?>
      </div>
      <input required type="submit" value="Añadir a la playlist" name="Actualizar">
    </form>
  </section>





  <!--Control de canciones-->
  <section class="reproductor" id="reproductorPrincipal">
    <p id="nombreCancion">Selecciona una canción</p>


    <!--Acciones del reproductor-->
    <section class="controles">

      <button class="play botones" id="cancionAnterior">
        <i class="fa-solid fa-backward"></i>
      </button>

      <button class="botones" id="pausarCancion">
        <i class="fa-solid fa-play"></i>
      </button>

      <button class="play botones" id="siguienteCancion">
        <i class="fa-solid fa-forward"></i>
      </button>

      <button class="botones" id="mute">
        <i class="fas fa-volume-up"></i>
      </button>

      <audio src="" id="rutaCancion"></audio>
    </section>

    <div class="tiempo">
      <span id="tiempoTranscurrido"></span>
      <span id="tiempoTotal"></span>
    </div>
    <input type="range" id="controlTiempo" min="0" value="0" />
  </section>
  <script>
    function abrirModal(ventana, botonCerrar) {
      const ventanaModal = document.getElementById(ventana);
      const cerrarBoton = document.getElementById(botonCerrar);

      ventanaModal.classList.add('modalActive');

      cerrarBoton.addEventListener('click', () => {
        ventanaModal.classList.remove('modalActive');
      });
    }
  </script>
  <script src="js/reproductorMusica.js"></script>
</body>

</html>