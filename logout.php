<?php 
require_once "config.php";

$_SESSION['logat'] = false;
$_SESSION['idUtilizator'] = '';
$_SESSION['utilizator'] = '';
$_SESSION['email'] = '';
$_SESSION['telefon'] = '';

header('Location: index.php');
?>