<?php

session_start();
include_once "conect.php";
date_default_timezone_set('America/Sao_Paulo');

$a = new Banco();
define('VER',1);
$dd = date("Hi");

if(isset($_POST['press'])){
    $a->att($_POST['press'],session_id(), $dd);
}


?>