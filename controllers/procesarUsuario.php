<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once '../config/Conexion.php';

    $nombre = mysqli_real_escape_string($conexion, $_POST['nombre']);
    $apellido = mysqli_real_escape_string($conexion, $_POST['apellido']);
    $email = mysqli_real_escape_string($conexion, $_POST['email']);
    $password = mysqli_real_escape_string($conexion, $_POST['password']);
    $imgDefault = 'img/defecto.png';

    // Validar nombre
    if (empty($nombre)) {
        echo json_encode('El nombre es obligatorio');
        exit;
    } elseif (!preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/', $nombre)) {
        echo json_encode('El nombre no debe contener números ni caracteres especiales');
        exit;
    }

    // Validar apellido
    if (empty($apellido)) {
        echo json_encode('El apellido es obligatorio');
        exit;
    } elseif (!preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/', $apellido)) {
        echo json_encode('El apellido no debe contener números ni caracteres especiales');
        exit;
    }
// Validar email
if (empty($email)) {
    echo json_encode('El Correo es obligatorio');
    exit;
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode('El correo electrónico no es válido');
    exit;
}

// Verificar si el correo ya existe en la base de datos
$correoExistente = $conexion->query("SELECT COUNT(*) as total FROM usuarios WHERE email = '$email'");
$resultado = $correoExistente->fetch_assoc();
if ($resultado['total'] > 0) {
    echo json_encode('El correo electrónico ya está registrado');
    exit;
}

// Validar contraseña
if (empty($password)) {
    echo json_encode('La contraseña es obligatoria');
    exit;
} elseif (strlen($password) < 6) {
    echo json_encode('La contraseña debe tener al menos 6 caracteres');
    exit;
}

// Resto del código de inserción

$insertar = $conexion->query("INSERT INTO usuarios 
    (nombre, apellido, email, passworduser, imguser) VALUES
    ('$nombre', '$apellido', '$email', '$password', '$imgDefault')");

if ($insertar) {
    $data = array(
        'state' => true,
        'php' =>'',
    );
    echo json_encode($data);

} else {
    echo json_encode('Error al insertar el usuario');
}

$correoDestinatario  = $email;

require_once 'enviarCorreo.php';

    
}
?>
