<?php

require_once 'config/Conexion.php';

function obtenerCancionesPorPlaylist($playlist) {
    global $conexion;

    $consulta = $conexion->query("SELECT * FROM musica INNER JOIN playlist ON musica.idmusica = playlist.idMusica WHERE playlist.nombre_playlist  = '$playlist'  ");

    $datos = array();

    if ($consulta->num_rows > 0) {
        while ($fila = $consulta->fetch_assoc()) {
            $datos[] = $fila;
        }
    }
    return $datos;
}


 ?>




