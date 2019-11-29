<?php
use PHPMailer\PHPMailer\PHPMailer;
require 'vendor/autoload.php';

#$host = "ssl0.ovh.net";
#$port = 465;
#$user = "lgm@afgral.org";
#$pass = "pasMailSurTuxFamily2019";

if (array_key_exists('first_name', $_POST)) {
    $mail = new PHPMailer;
    // only if using non local smtp
#    $mail->IsSMTP();
#    $mail->SMTPDebug = 2;
#    $mail->SMTPAuth = true;
#    $mail->SMTPSecure = 'ssl';
#    $mail->Host = $host;
#    $mail->Port = $port;

#    $mail->Username = $user;
#    $mail->Password = $pass;

    $mail->setFrom($_POST['email'], $_POST['first_name']);
    $mail->addReplyTo($_POST['email'], $_POST['first_name']);
    $mail->addAddress('lgm@afgral.org', 'Afgral LGM'); // adds new recipients
    $mail->Subject = 'LGM Website';
    $mail->isHTML(false);
    $mail->Body = "sample text";
    $mail->Body = $_POST['message'];
    if (!$mail->send()) {
        # Message not sent !
        header('Location:en/contact_fail.html');
        #echo 'Mailer Error: ' . $mail->ErrorInfo;
    } else {
        # Message sent!
        header('Location:en/contact_sent.html');
    }
}
