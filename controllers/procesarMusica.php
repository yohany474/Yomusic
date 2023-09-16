<?php
session_start();
require_once '../config/Conexion.php';


    if ($_SERVER['REQUEST_METHOD']==='POST') {
        $idUser = $_SESSION['idUsuario'];

        // Validar título de la canción (no números, no vacío)
        $nombreCancion = $_POST['nombre_cancion'];
        $artista = $_POST['artista'];
        $genero = $_POST['genero'];

        if (!preg_match('/^[a-zA-Z\s]+$/', $artista)) {
            echo json_encode(['error' => 'El artista debe contener solo letras y espacios']);
            exit();
        }

        // Verificar duplicados
        $consultaDuplicados = $conexion->query("SELECT * FROM musica WHERE nombre = '$nombreCancion'");
        if ($consultaDuplicados->num_rows > 0) {
            echo json_encode(['error' => 'El título de la canción ya existe. Elige otro título.']);
            exit();
        }

        function moverArchivo($ubicacionActual, $nombreArchivo)
        {
            $rutaPredefinida = '../Uploads/';
            $ruta = $rutaPredefinida . $nombreArchivo;

            if (move_uploaded_file($ubicacionActual, $ruta)) {
                return true;
            } else {
                return false;
            }
        }

        $nombreArchivoMusica = $_FILES['cancion']['name'];
        $ubicacionArchivoMusica = $_FILES['cancion']['tmp_name'];
        $rutaBDM = 'Uploads/' . $nombreArchivoMusica;

        //Imagen
        $nombreArchivoImagen = $_FILES['imagen']['name'];
        $ubicacionArchivoImagen = $_FILES['imagen']['tmp_name'];
        $rutaBDI = 'Uploads/' . $nombreArchivoImagen;

        if (moverArchivo($ubicacionArchivoMusica, $nombreArchivoMusica) && moverArchivo($ubicacionArchivoImagen, $nombreArchivoImagen)) {
            $insertar = $conexion->query("INSERT INTO musica 
            (nombre, ruta, idUsuarios, imagen, artista, idgenero )VALUES
            ('$nombreCancion', '$rutaBDM', '$idUser', '$rutaBDI', '$artista', '$genero')");

            if ($insertar) {
                echo json_encode(['success' => 'Se registró correctamente']);
                exit();
            } else {
                echo json_encode(['error' => 'Error al registrar']);
                exit();
            }
        } else {
            echo json_encode(['error' => 'Error al mover archivos']);
            exit();
        }
    }

?>
