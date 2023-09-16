<?php
session_start();
require_once '../config/Conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = mysqli_real_escape_string($conexion, $_POST['search']);

    $consulta = $conexion->query("SELECT * FROM musica 
    INNER JOIN genero ON musica.idgenero = genero.idgenero  
    WHERE musica.nombre LIKE '%$data%' 
    ORDER BY musica.idmusica DESC");

    if ($consulta->num_rows > 0) {
        while ($musica = $consulta->fetch_assoc()) {
            $var = 0;
            $id = $musica['idUsuarios'];
            if (isset($_SESSION['idUsuario']) && isset($_SESSION['idUsuario']) && $_SESSION['idUsuario'] === $id) {
                $URL = '<a href="controllers/eliminarCancion.php?id=' . $musica['idmusica'] . '" onclick="return confirm(\'¿Estás seguro de que deseas eliminar ' . $musica['nombre'] . '?\')"><i class="fa-solid fa-trash"></i></a>';
            } else {
                $URL = '';
            }

            echo '
                 
                      <div class="listaCancion cancion' . $var . '">
                      <img src="' . $musica['imagen'] . '" alt="" />
                      <span class="informacion">
                        <p>' . $musica['nombre'] . '</p>
                        <sub>' . $musica['artista'] . '</sub>
                        <sub>' . $musica['nombre_genero'] . '</sub>
                      </span>
                      <div class="playCancion cancion" data-nombre="' . $musica['nombre'] . '"  data-ruta="' . $musica['ruta'] . '"><i class="fa-solid fa-play"></i></div>
                      ' . $URL . '
                      <a href="' . $musica['ruta'] . '" download class=""><i class="fa-solid fa-download"></i></a>
                    </div>
                      ';
        }
    } else {
        echo '<p style="color:var(--color-principal)">No se encontraron resultados</p>';
    }
}

?>