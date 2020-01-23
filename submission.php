<?php 

//FILTER_VALIDATE_EMAIL
//FILTER_VALIDATE_INT Min Max
//FILTER_VALIDATE_URL

use PHPMailer\PHPMailer\PHPMailer;
require 'vendor/autoload.php';
require_once("base.php");



if (isset($_POST['title'])){
    try {
        $bd = get_bd();
        $sth = $bd->prepare('INSERT INTO proposals (pres_title, speaker_first_name, speaker_last_name, speaker_email, pres_format, pres_summary, pres_bio, pres_add_speaker, project_website, reimburse, amount, comments) VALUES (:title, :first_name, :last_name, :email, :pres_format, :pres_summary, :pres_bio, :pres_add_speaker, :website, :reimburse, :amount, :comments)');
        $b = checks($_POST['title'], 0, 50);
        $sth->bindParam(":title", $b);
        $c = checks($_POST['first_name'], 0, 50);
        $sth->bindParam(":first_name", $c);
        $d = checks($_POST['last_name'], 0, 50);
        $sth->bindParam(":last_name", $d);
        $e = filter_var(checks($_POST['email'], 2), FILTER_VALIDATE_EMAIL);
        $sth->bindParam(":email", $e);
        $f = checks($_POST['pres_format'], 0, 20);
        $sth->bindParam(":pres_format", $f);
        $g = checks($_POST['pres_summary'], 0, 256);
        $sth->bindParam(":pres_summary", $g);
        $h = checks($_POST['pres_bio'], 0, 256);
        $sth->bindParam(":pres_bio", $h);
        if (!empty($_POST['pres_add_speaker'])){
            $i = checks($_POST['pres_add_speaker'], 0, 200);
        } else {
            $i = "";
        }
        $sth->bindParam(":pres_add_speaker", $i);
        if (!empty($_POST['website'])){
            $j = filter_var(checks($_POST['website'], 3, 200), FILTER_VALIDATE_URL);
        } else {
            $j = "";
        }
        $sth->bindParam(":website", $j);
        $l = "";
        if (isset($_POST['cost_box'])){
            if ($_POST['cost_box']=="fund" or $_POST['cost_box']=="reimburse"){
                $l = $_POST['cost_box'];
            }
        }
        $sth->bindParam(":reimburse", $l);
        if (isset($_POST['costs']) and !empty($_POST['costs'])){
            $k = checks($_POST['costs'], 1);
        } 
        $sth->bindParam(":amount", $k);
        if (!empty($_POST['comments'])){
            $m = checks($_POST['comments'], 0, 256);
        } else {
            $m = "";
        }
        $sth->bindParam(":comments", $m);
        $sth->execute();
        $csv = [d($b), "","", "", d($f), d($g), d($h), "", d($j), d($l), d($m)];
        //$csv = [$b, $c, $d, $e, $f, $g, $h, $i, $j, $k, $l, $m];
        save_as_csv($csv);
        $csv = [d($b), d($c), d($d), d($e), d($f), d($g), d($h), d($i), d($j), d($k), d($l), d($m)];
        //header('Location: en/program.html');

        if (array_key_exists('first_name', $_POST) and !empty($_POST['email'])) {
            $mail = new PHPMailer(true);
            $mail->isHTML(false);
            $mail->addAddress('lgm@afgral.org', 'Afgral LGM');
            $mail->setFrom($_POST['email'], $_POST['first_name']);
            $mail->addReplyTo($_POST['email'], $_POST['first_name']);
            $mail->addCC($_POST['email'], $_POST['first_name']);
            $mail->Subject = "[CONF] ".$_POST['first_name'];
            $mail->Body = implode(";", $csv);
            if (!$mail->send()) {
                header('Location:en/submission_fail.html');
                #echo 'Mailer Error: ' . $mail->ErrorInfo;
            } else {
                header('Location:en/submission_sent.html');
            }
        } else {
                header('Location:en/submission_fail.html');
        }
    } catch( PDOException $Exception ) {
        echo $Exception->getMessage( );
        echo $Exception->getCode( );
    }
}

/*function d($s){
    return html_entity_decode($s);
}*/

?>