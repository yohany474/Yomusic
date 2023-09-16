<?php

require_once 'config/Conexion.php';

function getCanciones($playlistActual)
{
    global $conexion;

    $consultaCan = $conexion->query("SELECT * FROM musica 
                                    LEFT JOIN playlist ON musica.idmusica = playlist.idMusica 
                                    WHERE playlist.nombre_playlist != '$playlistActual' OR playlist.idMusica IS NULL");

    $cancionesAdd = array();

    if ($consultaCan->num_rows > 0) {
        while ($fila = $consultaCan->fetch_assoc()) {
            $cancionesAdd[] = $fila;
        }
    }

    return $cancionesAdd;
}
?>







