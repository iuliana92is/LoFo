<?php 
require_once "config.php";

//pentru delogare se vor sterge/decompleta/goli datele de autentificare din sesiune
$_SESSION['logat'] = false;
$_SESSION['idUtilizator'] = '';
$_SESSION['utilizator'] = '';
$_SESSION['email'] = '';
$_SESSION['telefon'] = '';

//redirectionarea catre pagina principala "index"
header('Location: index.php');
?>