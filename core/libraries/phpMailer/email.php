<?php 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'Exception.php';
require 'PHPMailer.php';
require 'SMTP.php';

// Instantiation and passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    //Server settings
    $mail->SMTPDebug = 0;                                       // Enable verbose debug output
    $mail->isSMTP();                                            // Set mailer to use SMTP
    $mail->Host       = 'smtp.gmail.com';                       // Specify main and backup SMTP servers
    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
    $mail->Username   = 'bestandlab@gmail.com';                     // SMTP username
    $mail->Password   = 'Expo2019';                               // SMTP password
    $mail->SMTPSecure = 'tls';                                  // Enable TLS encryption, `ssl` also accepted
    $mail->Port       = 587;                                    // TCP port to connect to

    //Recipients
    $mail->setFrom('bestandlab@gmail.com', 'BestandLab');
    $mail->addAddress('kevin.ale24@gmail.com');     // Add a recipient

    // Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = utf8_decode('Código de verificación');
    $mail->Body    = '<b>Hola como estas guapo:</b> Hola de nuevo pero sin negritas';
    $mail->send();
    echo 'Correo enviado';
} catch (Exception $e) {
    echo "Correo no enviado: {$mail->ErrorInfo}";
}
?>