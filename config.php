<?php
error_reporting(E_ALL);
session_start();

if(!isset($_SESSION['logat'])) {
    $_SESSION['logat'] = false;
}

if(!isset($_SESSION['utilizator'])) {
    $_SESSION['utilizator'] = '';
}

// datele de configurare a functionarii aplicatiei
$db_server = "localhost";
$db_utilizator = "root";
$db_parola = "";
$db_nume_db = "lofo";

$conexiune = new mysqli($db_server, $db_utilizator, $db_parola, $db_nume_db);

// eroarea conexiunei la baza de date
if($conexiune->connect_error) {
    die("Eroare conexiune baza de date");
}

$GLOBALS['conexiune'] = $conexiune;

// optiunile campului de selectare a categoriei
$GLOBALS['categorii'] = array(
    'Animale',
    'Obiecte'
);

// optiunile campului de selectare a zonei
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

// optiunile campului de selectare a culorii
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

// optiunile campului de selectare a starii
$GLOBALS['stari'] = array(
    'Buna',
    'Deteriorat'
);
?>
