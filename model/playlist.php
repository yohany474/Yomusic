<?php

require_once 'config/Conexion.php';

function obtenerCancionesPorCategoria($idClientes, $condicion)
{
    global $conexion;

    $consulta = $conexion->query("
    SELECT
        idplaylist AS id,
        usuarios.nombre AS usuarionombre,
        playlist.idUsuarios AS iduser,
        playlist.tipoP AS type,
        playlist.nombre_playlist AS categoria,
        imagenP AS imagenPlaylist, count(idMusica) as cantidadCanciones
    FROM
        playlist
    INNER JOIN
        usuarios ON playlist.idUsuarios = usuarios.idusuarios
    WHERE
        " . $condicion . "
    GROUP BY
        nombre_playlist ORDER BY playlist.idplaylist DESC
");

    $datos = array();

    if ($consulta->num_rows > 0) {
        while ($fila = $consulta->fetch_assoc()) {
            $datos[] = $fila;
        }
    }

    return $datos;
}

// Verificar si hay una sesión de usuario activa
if (isset($_SESSION['idUsuario'])) {
    $idClientes = $_SESSION['idUsuario'];
    $condicion = "usuarios.idUsuarios = '$idClientes' OR tipoP = 'Publica'";
    $dato = obtenerCancionesPorCategoria($idClientes, $condicion);
} else {
    // Si no hay una sesión activa, mostrar solo las playlists públicas
    $idClientes = null;
    $condicion = "tipoP = 'Publica'";
    $dato = obtenerCancionesPorCategoria($idClientes, $condicion);
}
?>