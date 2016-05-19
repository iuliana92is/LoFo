<?php
require_once "config.php";
error_reporting(0);


switch($_POST["actiune"]) {
	case "inregistare":
		inregistrare();
		break;
	case "autentificare":
		autentificare();
		break;
	case "adaugareAnunt":
		adaugareAnunt();
		break;
	default:
		die("Nu exista aceasta actiune!");
}

// functia de inregistrare, pentru a salva datele utilizatorului 

function inregistrare() {
	$conexiune = $GLOBALS['conexiune'];
	if(!$_POST["nume"] || !$_POST["email"] || !$_POST["utilizator"] || !$_POST["parola"]) {
		echo json_encode(array(
			'succes' => false,
			'mesaj' => 'Nu sunt completate toate informatiile!'
		));
		die();
	}

	$sql = "select * from utilizatori where utilizator = '" . mysql_real_escape_string($_POST['utilizator']) . "'";
	$rezultat = $conexiune->query($sql);

	if($rezultat->num_rows > 0) {
		echo json_encode(array(
			'succes' => false,
			'mesaj' => 'Utilizatorul exista deja!'
		));
		die();
	}

	$sql = "insert into utilizatori (utilizator, parola, nume, email, telefon) values ('" . mysql_real_escape_string($_POST['utilizator']) . "', '" . md5(mysql_real_escape_string($_POST['parola'])) . "', '" . mysql_real_escape_string($_POST['nume']) . "', '" . mysql_real_escape_string($_POST['email']) . "', '" . mysql_real_escape_string($_POST['telefon']) . "')";
	
	if ($conexiune->query($sql) === TRUE) {
		echo json_encode(array(
			'succes' => true,
			'mesaj' => 'Utilizatorul a fost adaugat cu succes!'
		));
	} else {
		echo json_encode(array(
			'succes' => false,
			'mesaj' => 'Eroare adaugare utilizator!'
		));
	}
} 

// functia de autentificare, pentru ca utilizatorul sa poata fi recunoscut, doar daca a fost inregistrat inainte 

function autentificare() {
	$conexiune = $GLOBALS['conexiune'];

	if(!$_POST["utilizator"] || !$_POST["parola"]) {
		echo json_encode(array(
			'succes' => false,
			'mesaj' => 'Nu sunt completate toate informatiile!'
		));
		die();
	}

	$sql = "select * from utilizatori where utilizator = '" . mysql_real_escape_string($_POST['utilizator']) . "' and parola = '" . md5($_POST['parola']) . "'";
	$rezultat = $conexiune->query($sql);

	if($rezultat->num_rows != 1) {
		echo json_encode(array(
			'succes' => false,
			'mesaj' => 'Eroare autentificare!'
		));
		die();
	}

	$utilizator = $rezultat->fetch_assoc();
	$_SESSION['logat'] = true;
	$_SESSION['idUtilizator'] = $utilizator['id'];
	$_SESSION['utilizator'] = $utilizator['utilizator'];
	$_SESSION['email'] = $utilizator['email'];
	$_SESSION['telefon'] = $utilizator['telefon'];
	
	echo json_encode(array(
		'succes' => true,
		'mesaj' => 'ok'
	));
}

function adaugareAnunt() {
	$conexiune = $GLOBALS['conexiune'];
	$caleImagine = "";
	if (isset($_FILES["file"]) && move_uploaded_file($_FILES["file"]["tmp_name"], "uploads/" . $_FILES["file"]["name"])) {
	    $caleImagine = "uploads/" . $_FILES["file"]["name"];
	}

	if(!$_POST['tip'] || !$_POST['categorie'] || !$_POST['zona'] || !$_POST['nume'] || !$_POST['culoare'] || !$_POST['stare']) {
		echo json_encode(array(
			'succes' => false,
			'mesaj' => 'Nu sunt completate toate informatiile!'
		));
		die();
	}

	$sql = "insert into anunturi (tip, utilizator, categorie, zona, nume, culoare, stare, imagine, descriere, data_adaugarii) values ('" . mysql_real_escape_string($_POST['tip']) . "', '" . mysql_real_escape_string($_SESSION['idUtilizator']) . "', '" . mysql_real_escape_string($_POST['categorie']) . "', '" . mysql_real_escape_string($_POST['zona']) . "', '" . mysql_real_escape_string($_POST['nume']) . "', '" . mysql_real_escape_string($_POST['culoare']) . "', '" . mysql_real_escape_string($_POST['stare']) . "', '" . $caleImagine . "', '" . mysql_real_escape_string($_POST['descriere']) . "', '" . date('Y-m-d') . "')";

	if ($conexiune->query($sql) === TRUE) {
		echo json_encode(array(
			'succes' => true,
			'mesaj' => 'Anuntul a fost adaugat!'
		));
	} else {
		echo json_encode(array(
			'succes' => false,
			'mesaj' => 'Eroare adaugare anunt!'
		));
	}
}

?>


