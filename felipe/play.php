<?php

session_start();
date_default_timezone_set('America/Sao_Paulo');

include_once "conect.php";

$banco = new Banco();
$banco->Players();

//gerando novas frutinhas
$banco->PosMaca(rand(0,19),rand(0,19));
//$banco->MacaPos();

//colisao ja removendo a frutinha
$banco->colisao();

//remover jogador por esta parado
//$data = date("Hi");
//$banco->remove($data);


?>