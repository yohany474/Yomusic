<?php

session_start();
$idUser = $_SESSION['idUsuario'];
require_once '../config/Conexion.php';
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $consulta = $conexion->query("SELECT * FROM musica WHERE idmusica = '$id' and idUsuarios = '$idUser' ");

    if ($consulta->num_rows > 0) {
        $con = '../';
        while ($musica = $consulta->fetch_assoc()) {
            $imagen = $con . $musica['imagen'];
            $music = $con . $musica['ruta'];
        }

        if (unlink($imagen)) {
            unlink($music);

        }
    } else {
        $_SESSION['notifi'] = 'Esta canción solo la puede eliminar el que la guardo';
                echo '<script>
       window.location.href = "../index.php";
     </script>';
        exit();
    }



    $eliminar = $conexion->query("DELETE FROM musica WHERE idmusica = '$id' and idUsuarios = '$idUser'");
    if ($eliminar) {

        $_SESSION['notifi'] = 'Se elimino la canción correctamente';
                echo '<script>
       window.location.href = "../index.php";
     </script>';
    }
}

?>