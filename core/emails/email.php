<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../libraries/phpMailer/Exception.php';
require '../libraries/phpMailer/PHPMailer.php';
require '../libraries/phpMailer/SMTP.php';

class Email 
{   
    public function verificationCode($userEmail, $code)
    {
        $mail = new PHPMailer(true);
        $subject = '¡URGENTE! Han querido entrar a tu usuario';    
        $body ='Te hemos bloqueado tu cuenta, ya que han querido ingresar a tu usuario mientras estás en línea \n Para recuperar tu cuenta debes ingresar este código: '.$code;
        try {
            //Server settings
            $mail->SMTPDebug = 0;                                       // Enable verbose debug output
            $mail->isSMTP();                                            // Set mailer to use SMTP
            $mail->Host       = 'smtp.gmail.com';                       // Specify main and backup SMTP servers
            $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
            $mail->Username   = 'bestandlab@gmail.com';                 // SMTP username
            $mail->Password   = 'Expo2019';                             // SMTP password
            $mail->SMTPSecure = 'tls';                                  // Enable TLS encryption, `ssl` also accepted
            $mail->Port       = 587;                                    // TCP port to connect to
            //Recipients
            $mail->setFrom('bestandlab@gmail.com', 'BestandLab');
            $mail->addAddress($userEmail);                              // Add a recipient
            // Content
            $mail->isHTML(true);                                        // Set email format to HTML
            $mail->Subject = utf8_decode($subject);
            $mail->Body = $body;
            $mail->send();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
    
    public function updatePass($userEmail, $code)
    {
        $mail = new PHPMailer(true);
        $subject = 'Haz solicitado cambiar tu contraseña';    
        $body ='El código para hacer el cambio de contraseña es: '.$code. '';
        try {
            //Server settings
            $mail->SMTPDebug = 0;                                       // Enable verbose debug output
            $mail->isSMTP();                                            // Set mailer to use SMTP
            $mail->Host       = 'smtp.gmail.com';                       // Specify main and backup SMTP servers
            $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
            $mail->Username   = 'bestandlab@gmail.com';                 // SMTP username
            $mail->Password   = 'Expo2019';                             // SMTP password
            $mail->SMTPSecure = 'tls';                                  // Enable TLS encryption, `ssl` also accepted
            $mail->Port       = 587;                                    // TCP port to connect to
            //Recipients
            $mail->setFrom('bestandlab@gmail.com', 'BestandLab');
            $mail->addAddress($userEmail);                              // Add a recipient
            // Content
            $mail->isHTML(true);                                        // Set email format to HTML
            $mail->Subject = utf8_decode($subject);
            $mail->Body = $body;
            $mail->send();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    
}

?>