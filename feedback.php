<?php 

//FILTER_VALIDATE_EMAIL
//FILTER_VALIDATE_INT Min Max
//FILTER_VALIDATE_URL

use PHPMailer\PHPMailer\PHPMailer;
require 'vendor/autoload.php';
require_once("base.php");


if (isset($_POST['cons'])){
    try {
        $c = checks($_POST['attendLGM'], 0, 300);
        $d = checks($_POST['cons'], 0, 500);
        $f = checks($_POST['favlgm'], 0, 500);
        $g = checks($_POST['favreason'], 0, 500);
        $h = checks($_POST['propaganda'], 0, 1000);
        $i = checks($_POST['name'], 0, 100);
        $csv = [d($c), d($d), d($f), d($g), d($h), d($i)];

        $mail = new PHPMailer();
        
        $mail->setFrom('lgm@afgral.org', 'Afgral LGM');
        $mail->addReplyTo('lgm@afgral.org', 'Afgral LGM');
        $mail->addAddress("lgm@afgral.org", 'Afgral LGM'); // adds new recipients
        $mail->Subject = '[WITNESS] LGM';
        $mail->isHTML(false);
        $mail->Body = implode("\n", $csv);
        if (!$mail->send()) {
                # Message not sent !
            header('Location:en/feedback_fail.html');
                #echo 'Mailer Error: ' . $mail->ErrorInfo;
        } else {
                # Message sent!
            header('Location:en/feedback_sent.html');
        }
        //header('Location: en/program.html');
    } catch( PDOException $Exception ) {
        echo $Exception->getMessage( );
        echo $Exception->getCode( );
    }
}



?>