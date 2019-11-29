<?php 

//FILTER_VALIDATE_EMAIL
//FILTER_VALIDATE_INT Min Max
//FILTER_VALIDATE_URL

require_once("base.php");

function checks_test($var, $filter, $len=256){
    echo "<p>check pour $var : ". html_entity_decode(checks($var, $filter, $len))."</p>";
}

function checks($var, $filter, $len=256){
    $san = [0=>"FILTER_SANITIZE_STRING", 1=>"FILTER_SANITIZE_NUMBER_INT", 2=>"FILTER_SANITIZE_EMAIL", 3=>"FILTER_SANITIZE_URL"];
    $v = null;
    $s = constant($san[$filter]);
    if(!empty($var) and filter_var($var, $s)){
        $v = htmlentities(strip_tags(trim(filter_var($var, $s))), ENT_NOQUOTES);
        //return $v;
        if ($filter=="str" and !strlen($v)>$len){
            return $v;
        } else {
            //echo "<li>chaine trop longue</li>";
            return substr($v, 0, $len);
        }
    } else {
        echo "<li>filter ".$san[$filter]." mal appliqué !</li>";
        return 0;
    }
}

function test(){
    checks_test("Ceci est une chaine avec 1 mot et des car \" echappés", 0, 100);
    checks_test('Select * from "toto"', "str", 100);
    checks_test("Ceci est une chaine avec 1 mot et des car \" echappés", 0, 10);
    checks_test("10", 1);
    checks_test("toto1ettata2",1);
    checks_test("toto@gmail.com", 2, 70);
    checks_test("totoagmail.com", 2);
    checks_test("activdesign.eu", 3, 100);
    checks_test("https://aeiu eiu eia eiu eiua eiu ea ie auiei ei eiu eiua eiu eiu ei ie ii ie ieiue iatenpod ateitne updte tise pdt eit end.com", 3, 30);
}

function save_as_csv($list){
    $fp = fopen('data_proposals.csv', 'a');
    fputcsv($fp, $list, ";" ,'"', "\\");
    fclose($fp);
}


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
        $csv = [d($b), d($c), d($d), d($e), d($f), d($g), d($h), d($i), d($j), d($k), d($l), d($m)];
        //$csv = [$b, $c, $d, $e, $f, $g, $h, $i, $j, $k, $l, $m];
        save_as_csv($csv);
        //header('Location: en/program.html');
    } catch( PDOException $Exception ) {
        echo $Exception->getMessage( );
        echo $Exception->getCode( );
    }
}

function d($s){
    return html_entity_decode($s);
}

?>