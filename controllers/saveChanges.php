<?php 

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    require_once '../config/Conexion.php';
    $id = mysqli_real_escape_string($conexion, $_POST['id']);
    $newCambio = mysqli_real_escape_string($conexion, $_POST['newCambio']);

    if(is_numeric($newCambio)){
        session_start();
        $_SESSION['notifi'] = 'Solo texto';
                echo '<script>
       window.location.href = "../index.php";
     </script>';
        exit;
    }

    $actualizar  = $conexion->query("UPDATE musica SET nombre = '$newCambio' WHERE idmusica ='$id' ");
    
    if ($actualizar) {
        session_start();
        $_SESSION['notifi'] = 'Se guardaron los cambios correctamente';
                echo '<script>
       window.location.href = "../index.php";
     </script>';
    }
}
?>