<?php
require_once("base.php");

if (array_key_exists('first_name', $_POST)) {
    $mail = new PHPMailer()

    $mail->setFrom($_POST['email'], $_POST['first_name']);
    $mail->addReplyTo($_POST['email'], $_POST['first_name']);
    $mail->addAddress('lgm@afgral.org', 'Afgral LGM'); // adds new recipients
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

if (array_key_exists('first_name', $_POST)) {
    $mail = new lgmMailer()
    if (!$mail->send($_POST['email'], $_POST['first_name'], "CONTACT", $_POST['message'])) {
        header('Location:en/contact_fail.html');
        #echo 'Mailer Error: ' . $mail->ErrorInfo;
    } else {
        header('Location:en/contact_sent.html');
    }
}