<?php 

//FILTER_VALIDATE_EMAIL
//FILTER_VALIDATE_INT Min Max
//FILTER_VALIDATE_URL

use PHPMailer\PHPMailer\PHPMailer;
require 'vendor/autoload.php';
require_once("base.php");


if (isset($_POST['first_name']) and isset($_POST['type'])){
    try {
        $c = checks($_POST['first_name'], 0, 50);
        $d = checks($_POST['last_name'], 0, 50);
        $e = filter_var(checks($_POST['email'], 2), FILTER_VALIDATE_EMAIL);
        $f = checks($_POST['organization'], 0, 20);
        $g = $_POST['participant_list'];
        $h = checks($_POST['comments'], 0, 256);
        $csv = [d($c), d($d), d($e), d($f), d($g), d($h)];

        $mail = new PHPMailer();
        
        $mail->setFrom($_POST['email'], $_POST['first_name']);
        $mail->addReplyTo($_POST['email'], $_POST['first_name']);
        $mail->addAddress('lgm@afgral.org', 'Afgral LGM'); // adds new recipients
        $mail->addCC($_POST['email'], $_POST['first_name']);
        $mail->Subject = '[REGISTER] '.$_POST['first_name'];
        $mail->isHTML(false);
        $mail->Body = implode(";", $csv);
        if (!$mail->send()) {
                # Message not sent !
            header('Location:en/register_fail.html');
                #echo 'Mailer Error: ' . $mail->ErrorInfo;
        } else {
                # Message sent!
            header('Location:en/register_sent.html');
        }
        //header('Location: en/program.html');
    } catch( PDOException $Exception ) {
        echo $Exception->getMessage( );
        echo $Exception->getCode( );
    }
}



?>