<?php
require_once '../config/Conexion.php';

$id = $_GET['id'];
session_start();
$idUser = $_SESSION['idUsuario'];

$consulta = $conexion->query("SELECT * FROM playlist WHERE nombre_playlist = '$id' and idUsuarios ='$idUser' "); {

    if ($consulta->num_rows > 0) {
        $con = '../';
        while ($musica = $consulta->fetch_assoc()) {
            $imagen = $con . $musica['imagen'];

        }

        if (unlink($imagen)) {
            $eliminar = $conexion->query("DELETE FROM playlist WHERE nombre_playlist = '$id' and idUsuarios ='$idUser' ");
            if ($eliminar) {
                session_start();
                $_SESSION['notifi'] = 'Se elimino la playlist correctamente';
                        echo '<script>
       window.location.href = "../index.php";
     </script>';
            }

        }
    }

}


?>