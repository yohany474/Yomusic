<?php

session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once '../config/Conexion.php';

    // Obtener los datos del formulario
    $id = mysqli_real_escape_string($conexion, $_POST['id']);
    $nombre = mysqli_real_escape_string($conexion, $_POST['nombre']);
    $apellido = mysqli_real_escape_string($conexion, $_POST['apellido']);
    $email = mysqli_real_escape_string($conexion, $_POST['email']);
    $password = mysqli_real_escape_string($conexion, $_POST['password']);
    $imagenActual = mysqli_real_escape_string($conexion, $_POST['imagenActual']);
    // Verificar si se subió una nueva imagen
    if ($_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
        $nombreArchivoImagen = $_FILES['imagen']['name'];
        $ubicacionArchivoImagen = $_FILES['imagen']['tmp_name'];
        $extension = pathinfo($nombreArchivoImagen, PATHINFO_EXTENSION);
        $extensionesPermitidas = array("jpg", "jpeg", "png", "gif");

        if (in_array(strtolower($extension), $extensionesPermitidas)) {
            $rutaBDI = 'Uploads/' . $nombreArchivoImagen;
            $rutaPredefinida = '../Uploads/';
            $ruta = $rutaPredefinida . $nombreArchivoImagen;

            if (move_uploaded_file($ubicacionArchivoImagen, $ruta)) {
                // Actualizar los datos, incluida la imagen
                if (!$imagenActual = 'img/defecto.png') {
                    unlink("../" . $imagenActual . "");
                }
                $actualizar = $conexion->query("UPDATE usuarios SET 
                nombre = '$nombre', 
                apellido = '$apellido', 
                email = '$email', 
                passworduser = '$password', 
                imguser = '$rutaBDI' 
                WHERE idusuarios = '$id'");

                $_SESSION['nombreUsuario'] = $nombre;
                $_SESSION['img'] = $rutaBDI;

            } else {
                echo "Error al mover la imagen";
                exit();
            }
        } else {
            echo "Formato de imagen no válido";
            exit();
        }
    } else {
        // Actualizar los datos excepto la imagen
        $actualizar = $conexion->query("UPDATE usuarios SET 
        nombre = '$nombre', 
        apellido = '$apellido', 
        email = '$email', 
        passworduser = '$password' 
        WHERE idusuarios = '$id'");

        $_SESSION['nombreUsuario'] = $nombre;
    }

    if ($actualizar) {
        echo '<script>
       window.location.href = "../index.php";
     </script>';
    } else {
        echo "Error al actualizar el usuario";
    }
}
?>