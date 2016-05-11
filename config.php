<?php
error_reporting(E_ALL);
session_start();

$db_server = "localhost";
$db_utilizator = "root";
$db_parola = "";
$db_nume_db = "lofo";

$conexiune = new mysqli($db_server, $db_utilizator, $db_parola, $db_nume_db);

if($conexiune->connect_error) {
	die("Eroare conexiune baza de date");
}

$GLOBALS['conexiune'] = $conexiune;
$GLOBALS['categorii'] = array(
    'Animale',
    'Obiecte'
);

$GLOBALS['zone'] = array(
    'Pacurari',
    'Dacia',
    'Alexandru',
    'Dacia',
    'Canta',
    'Nicolina',
    'Galata',
    'Podul Ros',
    'Centru',
    'Copou',
    'Bucium',
    'Bularga',
    'Tatarasi',
    'Targu cucu',
    'Aeroport',
    'Ciric',
    'Frumoasa',
    'Valea lupului'
);

$GLOBALS['culori'] = array(
    'Rosu',
    'Galben',
    'Albastru',
    'Mov',
    'Verde',
    'Portocaliu',
    'Maro',
    'Roz',
    'Gri',
    'Alb',
    'Negru'
);

$GLOBALS['stari'] = array(
    'Buna',
    'Deteriorat'
);
?>
