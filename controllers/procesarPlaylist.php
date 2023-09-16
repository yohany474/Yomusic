<?php

require_once '../config/Conexion.php'; // Asegúrate de incluir la conexión a la base de datos
session_start();
require_once '../config/Conexion.php';
if (!isset($_SESSION['idUsuario'])) {
    session_start();
    $_SESSION['notifi'] = 'Debes iniciar sesión para crear tu playlist';
    echo '<script>
       window.location.href = "../index.php";
     </script>';
    exit();
}
if (isset($_POST['guardar'])) {
    $idMusica = $_POST['idMusica'];
    $nombrePLaylist = $_POST['nombrePLaylist'];
    $tipo = $_POST['tipo'];



    // Validación de datos
    if (empty($idMusica)) {
        session_start();
        $_SESSION['notifi'] = 'Seleccione al menos una canción para crear la playlist';
        echo '<script>
       window.location.href = "../index.php";
     </script>';
        exit();
    }

    if (empty($nombrePLaylist)) {
        session_start();
        $_SESSION['notifi'] = 'El nombre de la playlist no puede estar vacío';
        echo '<script>
       window.location.href = "../index.php";
     </script>';
        exit();
    }


    // Validar y mover archivo de imagen
    $nombreArchivoMusica = $_FILES['imagenPlaylist']['name'];
    $ubicacionArchivoMusica = $_FILES['imagenPlaylist']['tmp_name'];
    $rutaBDM = 'Uploads/' . $nombreArchivoMusica;

    if (empty($nombreArchivoMusica) || empty($ubicacionArchivoMusica)) {
        session_start();
        $_SESSION['notifi'] = 'Debe seleccionar una imagen para la playlist';
        echo '<script>
       window.location.href = "../index.php";
     </script>';
        exit();
    }

    if (!moverArchivo($ubicacionArchivoMusica, $nombreArchivoMusica)) {
        session_start();
        $_SESSION['notifi'] = 'Error al subir la imagen';
        echo '<script>
       window.location.href = "../index.php";
     </script>';
        exit();
    }
    $idClientes = $_SESSION['idUsuario'];

    foreach ($idMusica as $id) {
        $creaPLaylist = $conexion->query("INSERT INTO playlist (nombre_playlist, idMusica, idUsuarios, imagenP, tipoP)
            VALUES('$nombrePLaylist', '$id', '$idClientes', '$rutaBDM', '$tipo') ");

        if (!$creaPLaylist) {
            echo 'Error al crear la playlist';
            exit(); // Asegurarse de salir del script en caso de error
        }
    }

    echo '<script>
       window.location.href = "../index.php";
     </script>';
    exit();
}

function moverArchivo($ubicacionActual, $nombreArchivo)
{
    $rutaPredefinida = '../Uploads/';
    $ruta = $rutaPredefinida . $nombreArchivo;

    if (move_uploaded_file($ubicacionActual, $ruta)) {
        return true;
    } else {
        return false;
    }
}
?>