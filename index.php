<?php
session_start();
require 'model/musica.php';
require 'model/playlist.php';
require 'model/genero.php';


?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="css/principal.css" />
  <link rel="shortcut icon" href="img/logoo.png" type="image/x-icon" />
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://kit.fontawesome.com/0015840e45.js" crossorigin="anonymous"></script>
  <title>Home</title>
</head>

<body>
  <?php
  if (isset($_SESSION['notifi'])) {
    $data = $_SESSION['notifi'];
    echo "<script>alert('" . $data . "')</script>";
    unset($_SESSION['notifi']);
  } ?>
  <section id="ventanaEdit" class="">

  </section>

  <!--Ventana modal agregar canción-->
  <section id="ventanaCrearCancion" class="">

    <form action="" method="post" enctype="multipart/form-data" id="form-agregar" class="form">
      <div class="close" id="cerrarCrearCancion">Cerrar</div>
      <h3>Agregar canción</h3>
      <img src="" alt="" id="imagenPreview" width="50px" height="50px" style="opacity: 0;">

      <label for="Nombre">Título de la canción</label>
      <input required type="text" name="nombre_cancion" id="Nombre">
      <label for="Autor">Nombre del autor o artista</label>
      <input required type="text" name="artista" id="Autor">
      <label for="genero">Selecciona el género de la canción</label>
      <select name="genero" required>
        <option value="">Selecciona un género</option>
        <?php
        if (!empty($genero)) {
          foreach ($genero as $gene) {
            echo '<option value="' . $gene['idgenero'] . '"> ' . $gene['nombre_genero'] . '</option>';
          }
        }
        ?>
      </select>
      <label for="Musica">Selecciona el archivo de la canción (formato MP3)</label>
      <input required type="file" name="cancion" id="Musica" accept=".mp3">
      <label for="Imagen">Selecciona la imagen relacionada (formato de imagen)</label>
      <input required type="file" name="imagen" id="Imagen" accept="image/*">
      <button type="submit" value="" name="guardar">Guardar canción</button>
    </form>
    <script>
      document.getElementById("form-agregar").addEventListener("submit", async function (event) {
        event.preventDefault();

        const form = event.target;
        const formData = new FormData(form);
        const submitButton = form.querySelector('button[type="submit"]');

        // Mostrar animación de carga
        submitButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Cargando...';

        try {
          const response = await fetch("controllers/procesarMusica.php", {
            method: "POST",
            body: formData
          });

          const data = await response.json();
          if (data.error) {
            // Mostrar mensaje de error
            alert(data.error);
          } else if (data.success) {
            // Mostrar mensaje de éxito
            alert(data.success);
            // Aquí puedes realizar alguna acción adicional después de un registro exitoso
            if (data.success == 'Se registró correctamente') {
              window.location.reload();
            }
          }
        } catch (error) {
          console.error("Error en la solicitud:", error);
        } finally {
          // Restaurar el contenido del botón después de la respuesta
          submitButton.innerHTML = 'Enviar';
        }
      });

    </script>
  </section>

  <!--Ventana modal crear playlist-->

  <form action="controllers/procesarPlaylist.php" method="post" enctype="multipart/form-data" id="ventanaCrearPLaylist"
    class="">

    <section class="form-playlist">
      <section class="form">
        <h3>Crear playlist</h3>
        <div class="close" id="cerrarPlaylist">Cerrar</div>
        <label for="NombreP">Nombre playlist</label>
        <input required type="text" id="NombreP" name="nombrePLaylist" required>
        <label for="publica_privada">Seleccione el tipo de playlist</label>
        <select name="tipo" id="publica_privada" required>
          <option value="" selected>Selecciona</option>
          <option value="Publica">Pública</option>
          <option value="Privada">Privada</option>
        </select>
        <label id="informaciontipo" style="font-size: 14px"></label>
        <label for="imagenP">Imagen</label>
        <input required type="file" id="imagenP" name="imagenPlaylist" required accept="image/*">
        <input required type="submit" value="Crear playlist" name="guardar">
      </section>
    </section>

    <section id="list-music">
      <h3>Elige las canciones para crear tu propia lista de reproducción.</h3>

      <?php
      if (!empty($data)) {
        $var = 0;

        foreach ($data as $cancion) {
          if (isset($_SESSION['idUsuario'])) {
            $enlace = ' <a href="controllers/eliminarCancion.php?id=' . $cancion['idmusica'] . '" onclick="return confirm(\'¿Estás seguro de que deseas eliminar esta canción?\')">Eliminar canción <i class="fa-solid fa-trash"></i></a>  ';
          } else {
            $enlace = '';
          }
          $var = $var + 1;

          echo '
                  <div class="listaCancion">
                  <img src="' . $cancion['imagen'] . '" alt="" />
                  <span class="informacion">
                    <p>' . $cancion['nombre'] . '</p>
                    <sub>' . $cancion['artista'] . '</sub>
                    <sub>' . $cancion['nombre_genero'] . '</sub>
                  </span>
                  <input  name="idMusica[]" type="checkbox" value="' . $cancion['idmusica'] . '">
                </div>
          
                ';
        }
      }
      ?>

    </section>



  </form>
  <!-- Menú lateral izquierda-->
  <aside class="menu">
    <div class="profile item">
      <img src="img/logoo.png" alt="" width="70px">
    </div>
    <div class="contenido-menu">
      <div class="item">
        <i class="fa-solid fa-house"></i>
        <p class="invisible">Inicio</p>
      </div>
      <?php
      if (isset($_SESSION['nombreUsuario']) && isset($_SESSION['idUsuario'])) {
        echo '
      <div class="item" onclick="abrirModal(\'ventanaCrearCancion\', \'cerrarCrearCancion\')">
          <i class="fa-solid fa-plus"></i>
          <p class="invisible">Agregar canción</p>
      </div>
      <div class="item" id="crearPlaylist" onclick="abrirModal(\'ventanaCrearPLaylist\', \'cerrarPlaylist\')">
        <i class="fa-solid fa-list"></i>
        <p class="invisible">Crear playlist</p>
      </div>
      ';
      } else {
        echo ' 
      <div class="item" id="" onclick="alert(\'Debes iniciar sesión para agregar canciones\')">
          <i class="fa-solid fa-plus"></i>
          <p class="invisible">Agregar canción</p>
      </div>
      <div class="item" id="" onclick="alert(\'Debes iniciar sesión para crear playlists\')">
      <i class="fa-solid fa-list"></i>
      <p class="invisible">Crear playlist</p>
    </div>
      ';
      }
      ?>

      <!-- <div class="item" id="changeThem">
        <i id="icono" class="fas fa-lightbulb"></i>
      </div> -->
    </div>
  </aside>
  <!-- Contenedor principal -->
  <main class="principal">

    <header id="header">
      <span></span>
      <form method="post" id="searchForm" autocomplete="off">
        <input type="search" placeholder="Buscar canciones" name="search" id="searchInput">
        <button type="submit" value="" name="buscar"><i class="fas fa-search"></i></button>

        <?php if (isset($_SESSION['idUsuario'])) {
          echo '<img src="' . $_SESSION['img'] . '" id="viewProfile">';
        } else {
          echo '<img src="img/defecto.png" alt="" id="viewProfile">';
        }

        ?>
      </form>

      <article id="profile" class="">
        <div class="close" id="closeProfile">X</div>
        <?php if (isset($_SESSION['nombreUsuario']) and isset($_SESSION['idUsuario'])) {
          echo '
        <h3>' . $_SESSION['nombreUsuario'] . '</h3>
        <form id="edit">
        <input type="hidden" value="' . $_SESSION['idUsuario'] . '" name="id">
        <button type="submit">Editar perfil</button>
        </form>
       
        <a class="" href="controllers/close.php">Cerrar sesión</a>
        ';
        } else {
          echo ' <a href="views/login.html" class="">Iniciar sesión</a>
               <a href="views/registro.html" class="">Registrarse</a>';
        }
        ?>
        <div id="responseContainer"></div>
        <script>
          const editForm = document.getElementById('edit');
          const responseContainer = document.getElementById('ventanaEdit');

          editForm.addEventListener('submit', function (e) {
            e.preventDefault();

            const formData = new FormData(editForm);

            fetch('controllers/editPerfil.php', {
              method: 'POST',
              body: formData
            })
              .then(response => response.text())
              .then(data => {
                document.getElementById('ventanaEdit').classList.add('modalActive');
                responseContainer.innerHTML = data;
              })
              .catch(error => {
                console.error(error);
              });
          });
        </script>

      </article>
    </header>



    <!--Playlist-->

    <section id="sliderPlaylist">


      <?php
      if (!empty($dato)) {
        foreach ($dato as $cancion) {
          $enlace = '';

          if (isset($_SESSION['idUsuario']) && $cancion['iduser'] === $_SESSION['idUsuario']) {
            $enlace = '<a href="controllers/eliminarplaylist.php?id=' . $cancion['categoria'] . '" onclick="return confirm(\'¿Estás seguro de que deseas eliminar la playlist ' . $cancion['categoria'] . '?\')"><i class="fa-solid fa-trash"></i></a>';
          }

          $type = ($cancion['type'] === 'Privada') ? 'fa-lock' : 'fa-globe';

          echo '
            <article class="playlist">
                <h3>' . $cancion['categoria'] . ' </h3>
                ' . $enlace . '
                <b>' . $cancion['cantidadCanciones'] . '<i class="fas fa-music"></i></b>
                <p id="tipoPlaylist"><i class="fa-solid ' . $type . '" id=""></i></p>
                <h4><i class="fas fa-feather-alt"></i> ' . $cancion['usuarionombre'] . '</h4>
                <a href="playlist.php?id=' . $cancion["categoria"] . '&iduser=' . $cancion['iduser'] . '&tipo='.$cancion['type'].'" class="play-list"><i class="fa-solid fa-play"></i></a>
                <img src="' . $cancion["imagenPlaylist"] . '" alt="">
            </article>
        ';
        }
      } else {
        echo '<p style="color: var(--color-principal);">No hay playlist</p>';
      }
      ?>



    </section>

    <section id="listaCanciones">

      <section id="list-music" class="ContenedorMusica">


        <?php

        if (!empty($data)) {
          $var = 0;

          foreach ($data as $cancion) {
            $id = $cancion['idUsuarios'];
            $var = $var + 1;
            if (isset($_SESSION['idUsuario']) && isset($_SESSION['idUsuario']) && $_SESSION['idUsuario'] === $id) {
              $enlace = '<a href="controllers/eliminarCancion.php?id=' . $cancion['idmusica'] . '" onclick="return confirm(\'¿Estás seguro de que deseas eliminar ' . $cancion['nombre'] . '?\')"><i class="fa-solid fa-trash"></i></a>';
            } else {
              $enlace = '';
            }
            echo '
                  <div class="listaCancion cancion' . $var . '">
                  <img src="' . $cancion['imagen'] . '" alt="" />
                  <span class="informacion">
                    <p>' . $cancion['nombre'] . '</p>
                    <sub>' . $cancion['artista'] . '</sub>
                    <sub>' . $cancion['nombre_genero'] . '</sub>
                  </span>
                  <div class="playCancion cancion" data-nombre="' . $cancion['nombre'] . '"  data-ruta="' . $cancion['ruta'] . '"><i class="fa-solid fa-play"></i></div>
                  ' . $enlace . '
                  <a href="' . $cancion['ruta'] . '" download class=""><i class="fa-solid fa-download"></i></a>
                </div>
          
                ';
          }
        }
        ?>

      </section>

      <aside class="about">
        <h1>Disfruta de tus playlists favoritas </h1>
        <h3>Sumérgete en la música y deja que te envuelva con su magia, creando memorias en cada nota. </h3>
      </aside>


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
  </main>
  <script src="js/reproductorMusica.js"></script>
  <script src="js/editarCancion.js"></script>
  <script src="js/buscarCancion.js"></script>
  <script src="js/ventanasModales.js"></script>
  <script src="js/validarFormulario.js"></script>

</body>

</html>