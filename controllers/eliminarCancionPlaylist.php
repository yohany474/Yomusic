<?php
require_once '../config/Conexion.php';

session_start();
$id = $_GET['id'];
$idUser  =$_SESSION['idUsuario'];
$idUsuario = $_GET['iduser'];
$ruta = $_GET['ruta'];



$eliminar = $conexion->query("DELETE FROM playlist WHERE idMusica = '$id' and idUsuarios = '$idUser' ");
if ($eliminar) {
    echo "<script>window.location.href='../playlist.php?id=" . $ruta . "&iduser=".$idUsuario."'</script>";
}


?>