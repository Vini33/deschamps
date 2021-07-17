<?php

include_once "conect.php";
session_start();

$banco = new Banco();
$dataBanco = (int) $banco->data(session_id());

?>