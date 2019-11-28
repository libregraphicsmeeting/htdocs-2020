<?php


function get_bd(){
    try {
        return new PDO('sqlite:db/proposals.sqlite');
    } catch( PDOException $Exception ) {
        echo $Exception->getMessage( );
        echo $Exception->getCode( );
    }
}




?>