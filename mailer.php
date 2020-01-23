<?php

ini_set("log_errors", 1);
ini_set("error_log", getcwd()."/php-error.log");
use PHPMailer\PHPMailer\PHPMailer;
require 'vendor/autoload.php';
require_once("base.php");

if (array_key_exists('first_name', $_POST)) {
    $mail = new PHPMailer();

    $mail->setFrom($_POST['email'], $_POST['first_name']);
    $mail->addReplyTo($_POST['email'], $_POST['first_name']);
    $mail->addAddress('lgm@afgral.org', 'Afgral LGM'); // adds new recipients
    $mail->addCC($_POST['email'], $_POST['first_name']);
    $mail->Subject = '[CONTACT] LGM Website';
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
