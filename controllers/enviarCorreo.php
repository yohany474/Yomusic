<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../src/PHPMailer.php';
require '../src/SMTP.php';
require '../src/Exception.php';

try {
    // Tu código existente aquí

    // Crea una instancia de PHPMailer
    $mail = new PHPMailer(true);

    // Configuración del servidor SMTP y autenticación
    // $mail->SMTPDebug = SMTP::DEBUG_SERVER; // Salida de depuración detallada
    $mail->isSMTP(); // Utiliza SMTP para enviar el correo
    $mail->Host = 'smtp.gmail.com'; // Servidor SMTP de Gmail
    $mail->SMTPAuth = true; // Habilita la autenticación SMTP
    $mail->Username = 'mejiayohany6@gmail.com'; // Tu dirección de correo
    $mail->Password = 'mwfnqrcypvdimyzu'; // Tu contraseña
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; // Encriptación TLS implícita
    $mail->Port = 465; // Puerto TCP

    // Configuración de los destinatarios y el contenido del correo
    $mail->setFrom('mejiayohany6@gmail.com', 'Registro exitoso'); // Remitente
    $mail->addAddress($correoDestinatario, ''); // Destinatario
    $mail->addReplyTo('info@example.com', 'Information'); // Dirección de respuesta
    $mail->isHTML(true); // Habilita el formato HTML
    $mail->Subject = 'Bienvenido '.$nombre.''; // Asunto del correo

    // Contenido del correo en formato HTML
    $mail->Body = '
        <h2 style="text-align:center; color: green;">Registro Exitoso</h2>
        <p>Fecha: ' . date('Y-m-d H:i:s') . '</p>
        <p>Gracias por unirte a nuestro sistema de reproducción de música.</p>
        <p>Puedes visitar mas proyectos en <a href="https://adso24.com">adso24.com</a>.</p>
        <p>Tu contraseña para acceder a tu cuenta es: '.$password.'</p>
        <a href="https://adso24.com" style="text-align:star; color: green;">By: Análisis y Desarrollo de Software</a>
    ';

    // Envía el correo
    $mail->send();

} catch (Exception $e) {
    
}
?>
