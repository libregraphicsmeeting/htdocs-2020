<?php
use PHPMailer\PHPMailer\PHPMailer;
require 'vendor/autoload.php';

$host = "ssl0.ovh.net";
$port = 465;
$user = "lgm@afgral.org";
$pass = "pasMailSurTuxFamily2019";

if (array_key_exists('first_name', $_POST)) {
    $mail = new PHPMailer;
    // only if using non local smtp
    $mail->IsSMTP();
    $mail->SMTPDebug = 2;
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = 'ssl';
    $mail->Host = $host;
    $mail->Port = $port;

    $mail->Username = $user;
    $mail->Password = $pass;

    $mail->setFrom($_POST['email'], $_POST['first_name']);
    $mail->addReplyTo($_POST['email'], $_POST['first_name']);
    $mail->addAddress('lgm@afgral.org', 'Afgral LGM'); // adds new recipients
    $mail->Subject = 'LGM Website';
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
