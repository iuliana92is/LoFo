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
	case "modificareAnunt":
		modificareAnunt();
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
	$sql = "select * from utilizatori where utilizator = ?";
	$query = $conexiune->prepare($sql);
    $query->bind_param('s', $_POST['utilizator']);
    $query->execute();

	$rezultat = $query->get_result();
	
	if($rezultat->num_rows > 0) {
		echo json_encode(array(
			'succes' => false,
			'mesaj' => 'Utilizatorul exista deja!'
		));
		die();
	}

	// adaugarea utilizatorului nou in baza de date
	$parola =  md5($_POST['parola']);
	$sql = "insert into utilizatori (utilizator, parola, nume, email, telefon) values (?, ?, ?, ?, ?)";
	$query = $conexiune->prepare($sql);
    $query->bind_param('sssss', $_POST['utilizator'], $parola, $_POST['nume'], $_POST['email'], $_POST['telefon']);	
	
	if ($query->execute() === TRUE) {
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
	$parola =  md5($_POST['parola']);
	$sql = "select * from utilizatori where utilizator = ? and parola = ?";
	$query = $conexiune->prepare($sql);
    $query->bind_param('ss', $_POST['utilizator'], $parola);
    $query->execute();

	$rezultat = $query->get_result();

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
	$dataAdaugarii = date('Y-m-d');
	$sql = "insert into anunturi (tip, utilizator, categorie, zona, nume, culoare, stare, imagine, descriere, data_adaugarii) values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
	$query = $conexiune->prepare($sql);
    $query->bind_param('ssssssssss', $_POST['tip'], $_SESSION['idUtilizator'], $_POST['categorie'], $_POST['zona'], $_POST['nume'], $_POST['culoare'], $_POST['stare'], $caleImagine, $_POST['descriere'], $dataAdaugarii);

	if ($query->execute() === TRUE) {
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

function modificareAnunt() {
	$conexiune = $GLOBALS['conexiune'];

	//functia de incarcare a imaginii la adaugarea unui nou anunt
	//imaginea se adauga intr-un director numit "upload"
	$caleImagine = "";
	if (isset($_FILES["file"]) && move_uploaded_file($_FILES["file"]["tmp_name"], "uploads/" . $_FILES["file"]["name"])) {
	    $caleImagine = "uploads/" . $_FILES["file"]["name"];
	}

	//se verifica completarea tuturor campurilor obligatorii pentru adaugarea unui anunt
	if(!$_POST['idAnunt'] || !$_POST['categorie'] || !$_POST['zona'] || !$_POST['nume'] || !$_POST['culoare'] || !$_POST['stare']) {
		echo json_encode(array(
			'succes' => false,
			'mesaj' => 'Nu sunt completate toate informatiile!'
		));
		die();
	}

	if($caleImagine) {
		$sql = "update anunturi set imagine = ? where id = ?";
	    $query = $conexiune->prepare($sql);
        $query->bind_param('si', $caleImagine, $_POST['idAnunt']);
        $query->execute();
	}

	//se modifica anuntul in baza de date
	$sql = "update anunturi set categorie = ?, zona = ?, nume = ?, culoare = ?, stare = ?, descriere = ? where id = ?";
	$query = $conexiune->prepare($sql);
    $query->bind_param('ssssssi', $_POST['categorie'], $_POST['zona'], $_POST['nume'], $_POST['culoare'], $_POST['stare'], $_POST['descriere'], $_POST['idAnunt']);

	if ($query->execute() === TRUE) {
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
	if(!$_POST['idAnunt'] || !$_SESSION['logat'] || (!$_SESSION['admin'] && $_POST['utilizatorAnunt'] != $_SESSION['idUtilizator'])) {
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