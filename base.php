<?php


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

?>