<?php
require_once "config.php";
error_reporting(0);

if(!isset($_POST["actiune"])) {
	die("Request incorect!");
}

//stabilim tipul actiunii si facem handle corespunzator
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
	case "stergereAnunt":
		stergereAnunt();
		break;
	case "trimiteRaportFrauda":
		trimiteRaportFrauda();
		break;
	default:
		die("Nu exista aceasta actiune!");
}

// functia de inregistrare a unui nou utilizator
function inregistrare() {

	// verificarea validitatii campurilor completate
	$conexiune = $GLOBALS['conexiune'];
	if(!$_POST["nume"] || !$_POST["email"] || !$_POST["utilizator"] || !$_POST["parola"]) {
		echo json_encode(array(
			'succes' => false,
			'mesaj' => 'Nu sunt completate toate informatiile!'
		));
		die();
	}

	// verificarea existentei utilizatorului in baza de date
	$sql = "select * from utilizatori where utilizator = '" . mysql_real_escape_string($_POST['utilizator']) . "'";
	$rezultat = $conexiune->query($sql);

	
	if($rezultat->num_rows > 0) {
		echo json_encode(array(
			'succes' => false,
			'mesaj' => 'Utilizatorul exista deja!'
		));
		die();
	}

	// adaugarea utilizatorului nou in baza de date 
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


// functia de autentificare a unui utilizator
//autentificarea se realizeaza pe baza completarii campului de nume_utilizator si parola acestuia de la inregistrarea lui in baza de date	
function autentificare() {
	$conexiune = $GLOBALS['conexiune'];

	//se verifica validitatea campurilor completate
	if(!$_POST["utilizator"] || !$_POST["parola"]) {
		echo json_encode(array(
			'succes' => false,
			'mesaj' => 'Nu sunt completate toate informatiile!'
		));
		die();
	}

	//verificam daca avem un utilizator cu datele completate, parola este criptata in md5
	$sql = "select * from utilizatori where utilizator = '" . mysql_real_escape_string($_POST['utilizator']) . "' and parola = '" . md5($_POST['parola']) . "'";
	$rezultat = $conexiune->query($sql);

	//daca datele nu concid se trimite mesaj de eroare
	if($rezultat->num_rows != 1) {
		echo json_encode(array(
			'succes' => false,
			'mesaj' => 'Eroare autentificare!'
		));
		die();
	}

	//daca gasim utilizatorul, ii setam sesiunea
	$utilizator = $rezultat->fetch_assoc();
	$_SESSION['logat'] = true;
	$_SESSION['idUtilizator'] = $utilizator['id'];
	$_SESSION['utilizator'] = $utilizator['utilizator'];
	$_SESSION['email'] = $utilizator['email'];
	$_SESSION['telefon'] = $utilizator['telefon'];
	$_SESSION['admin'] = $utilizator['admin'];
	
	echo json_encode(array(
		'succes' => true,
		'mesaj' => 'ok'
	));
}

// functia de adaugare anunt
function adaugareAnunt() {
	$conexiune = $GLOBALS['conexiune'];

	//functia de incarcare a imaginii la adaugarea unui nou anunt
	//imaginea se adauga intr-un director numit "upload"
	$caleImagine = "";
	if (isset($_FILES["file"]) && move_uploaded_file($_FILES["file"]["tmp_name"], "uploads/" . $_FILES["file"]["name"])) {
	    $caleImagine = "uploads/" . $_FILES["file"]["name"];
	}

	//se verifica completarea tuturor campurilor obligatorii pentru adaugarea unui anunt
	if(!$_POST['tip'] || !$_POST['categorie'] || !$_POST['zona'] || !$_POST['nume'] || !$_POST['culoare'] || !$_POST['stare']) {
		echo json_encode(array(
			'succes' => false,
			'mesaj' => 'Nu sunt completate toate informatiile!'
		));
		die();
	}

	//se inregistreaza anuntul nou in baza de date in caz de succes
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


// functia de stergere a unui anunt
function stergereAnunt() {
	$conexiune = $GLOBALS['conexiune'];

	//stergerea anuntului se realizeaza doar daca userul de tip "admin" este autentificat
	if(!$_POST['idAnunt'] || !$_SESSION['logat'] || !$_SESSION['admin']) {
		echo json_encode(array(
			'succes' => false,
			'mesaj' => 'Nu sunt completate toate informatiile sau nu aveti access la aceasta functionalitate!'
		));
		die();
	}

	//anuntul se sterge pe baza identificarii ID-ului acelui anunt
	$sql = "delete from anunturi where id = ?";
	$query = $conexiune->prepare($sql);
    $query->bind_param('i', $_POST['idAnunt']);
    $query->execute();

    echo json_encode(array(
		'succes' => true,
		'mesaj' => 'Anuntul a fost sters cu succes!'
	));
}

// functia de raportare a unei fraude
function trimiteRaportFrauda() {
	$conexiune = $GLOBALS['conexiune'];

	if(!$_POST['idAnunt']) {
		echo json_encode(array(
			'succes' => false,
			'mesaj' => 'Nu a fost identificat anuntul!'
		));
		die();
	}

	// se trimite raportul de frauda prin completarea campurilor modalului respectiv
	// mesajul ajunge la "iuliana92ciobanu@gmail.com"
	// mesajul de raportare a fraudei contine id, nume, email si descriere
	$to = "iuliana92ciobanu@gmail.com";
	$from = $_POST['email'];
	$subject = "Raportare frauda LoFo";
	$body = "Id: " . $_POST['idAnunt'] . "\nNume:" . $_POST['nume'] . "\nEmail" . $_POST['email'] . "\nDescriere:" . $_POST['descriere'];

	mail($to, $subject, $body, $from);

	echo json_encode(array(
		'succes' => true,
		'mesaj' => 'Frauda raportata cu succes!'
	));
	die();
}

?>