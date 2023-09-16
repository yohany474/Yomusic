<?php

require_once 'config/Conexion.php'; 

if (isset($_POST['Actualizar'])) {
    // Validación de datos
    if (empty($_POST['idMusica'])) {
      
        echo"<script>alert('Seleccione al menos una canción para agregar a la playlis')</script>";
        exit(); 
    }
    $idMusica = $_POST['idMusica'];
    $nombrePLaylist = $_POST['nombrePLaylist'];
    $imagenP = $_POST['imagenP'];
    $ruta = $_POST['ruta'];
    $idUsuario = $_POST['iduser'];
    $tipo = $_POST['tipo'];

    

    $idUser  =$_SESSION['idUsuario'];

    foreach ($idMusica as $id) {
        $creaPLaylist = $conexion->query("INSERT INTO playlist (nombre_playlist, idMusica, idUsuarios, imagenP, tipoP)
            VALUES('$nombrePLaylist', '$id', '$idUser', '$imagenP', '$tipo') ");

        if (!$creaPLaylist) {
            echo 'Error al crear la playlist';
            exit();
        }
    }

 
        echo "<script>window.location.href='playlist.php?id=" . $ruta . "&iduser=".$idUsuario."'</script>";

    
    exit();
}

?>