<?php
use PHPMailer\PHPMailer\PHPMailer;
require 'vendor/autoload.php';

if (array_key_exists('first_name', $_POST)) {
    $mail = new PHPMailer;
    // only if using non local smtp
    /*$mail->IsSMTP();
    $mail->SMTPDebug = 2;
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = 'ssl';
    $mail->Host = $host;
    $mail->Port = $port;

    $mail->Username = $user;
    $mail->Password = $pass;*/

    $mail->setFrom($mail_adr, $mail_name);
    $mail->addReplyTo($mail_adr, $mail_name);
    $mail->addAddress('contact@afgral.org', 'Afgral LGM'); // adds new recipients
    $mail->Subject = 'PHPMailer SMTP message';
    //$mail->msgHTML(file_get_contents('message.html'), __DIR__);
    //$mail->msgHTML("file_get_contents('message.html')", __DIR__);
    $mail->isHTML(false);
    //$mail->AltBody = 'This is a plain text message body';
    $mail->Body = "sample text";
    $mail->Body = $_POST['message'];
    //$mail->addAttachment('test.txt');
    if (!$mail->send()) {
        echo 'Mailer Error: ' . $mail->ErrorInfo;
    } else {
        echo 'Message sent!';
        #header('Location:en/index.html');
    }
}
