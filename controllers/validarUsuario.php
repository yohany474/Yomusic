<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {


    require_once '../config/Conexion.php';
    $passworduser = mysqli_real_escape_string($conexion, $_POST['contraseña']);
    $email = mysqli_real_escape_string($conexion, $_POST['email']);
    $usuario = $conexion->query("SELECT idusuarios, nombre, imguser FROM usuarios WHERE 
    passworduser = '$passworduser' and email = '$email'
    ");
    if (empty($email)) {
        echo json_encode('El campo email es obligatorio');
        exit;
    } else if (empty($passworduser)) {
        echo json_encode('El campo de contraseña es obligatorio');
        exit;
    } else if (empty($email) and empty($passworduser)) {
        echo 'Todos los campos son obligatorios';
        exit;
    }
    if ($usuario->num_rows > 0) {
        session_start();
        $user = $usuario->fetch_assoc();

        $_SESSION['idUsuario'] = $user['idusuarios'];
        $_SESSION['nombreUsuario'] = $user['nombre'];
        $_SESSION['img'] = $user['imguser'];

        echo json_encode('success');

    } else {
        echo json_encode('El usuario no existe');
    }
}


?>