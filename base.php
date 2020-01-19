<?php
use PHPMailer\PHPMailer\PHPMailer;
require 'vendor/autoload.php';

function get_bd(){
    try {
        return new PDO('sqlite:db/proposals.sqlite');
    } catch( PDOException $Exception ) {
        echo $Exception->getMessage( );
        echo $Exception->getCode( );
    }
}

function get_all_data($table){
    $bd = get_bd();
    $query = $bd->prepare("SELECT * FROM $table");
    $query->execute();
    return $query->fetchAll(PDO::FETCH_ASSOC);
}

function get_data_as_csv(){
    $s = "";
    foreach (get_all_data("proposals") as $r){
        $s .= implode(";", $r)."\n";
    }
    return $s;
}

function get_data_as_csv_in_html(){
    $s = "";
    foreach (get_all_data("proposals") as $r){
        $s .= implode(";", $r)."<br />";
    }
    return $s;
}

function reset_db(){
    $bd = get_bd();
    $query = $bd->prepare("UPDATE main.sqlite_sequence SET seq=0");
    $query->execute();
    $query = $bd->prepare("DELETE FROM proposals");
    $query->execute();
    $query = $bd->prepare("VACUUM");
    $query->execute();
    return "db emptied";
}


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

function d($s){
    return html_entity_decode($s);
}


?>