<?php 
require_once "config.php";
require_once "html2pdf/html2fpdf.php";

//functia de export se realizeaza daca se selecteaza un tip de format valid
if(!isset($_GET['formatExport']) || !isset($_GET['tip']) || !$_GET['formatExport'] || !$_GET['tip']) {
	echo 'Request invalid!';
	die;
}

$conexiune = $GLOBALS['conexiune'];

//selectam toate anunturile de tipul primit ca parametru
$sql = "select an.*, ut.utilizator from anunturi an join utilizatori ut on ut.id = an.utilizator  where tip = ?";
$query = $conexiune->prepare($sql);
$query->bind_param('s', $_GET['tip']);
$query->execute();

$rezultat = $query->get_result();

$arrAnunturi = array();
while($rand = $rezultat->fetch_assoc()) {
    $arrAnunturi[] = $rand;
}

//stabilim tipul exportului si facem handle corespunzator
switch ($_GET['formatExport']) {
	case 'html':
		exportHtml($arrAnunturi);
		break;
	case 'csv':
		exportCsv($arrAnunturi);
		break;
	case 'json':
		exportJson($arrAnunturi);
		break;
	case 'pdf':
		exportPdf($arrAnunturi);
		break;
	default:
		echo 'Format export invalid!';
		die;
		break;
}

//schema exportului in format HTML creaza o structura HTML care va fi populata cu datele fiecarui anunt adaugat in baza de date
function continutHtml($arrAnunturi) {
	$export = '
		
		<html lang="ro">
		    <head>
		        <title>Export</title>
		        <meta charset="UTF-8">
		        <meta name="author" content="Iuliana Ciobanu">
		        <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport" /> 
		        <link rel="stylesheet" href="assets/css/style.css" /> 
		        <link rel="icon" href="assets/images/favicon.ico" type="image/x-icon" />
		    </head>
		    <body>
				<table class="tabelHtml">
				<thead>
					<tr>
						<td>#</td>
						<td>Tip</td>
						<td>Utilizator</td>
						<td>Categorie</td>
						<td>Zona</td>
						<td>Nume</td>
						<td>Culoare</td>
						<td>Stare</td>
						<td>Imagine</td>
						<td>Descriere</td>
						<td>Data adaugarii</td>
					</tr>
				</thead>
				<tbody>
	';

	//datele anuntului vor fi preluate din baza de date
	$i = 0;
	foreach($arrAnunturi as $anunt) {
		$i++;
		$export .= '
			<tr>
				<td>' . $i . '</td> 
				<td>' . $anunt['tip'] . '</td>
				<td>' . $anunt['utilizator'] . '</td>
				<td>' . $anunt['categorie'] . '</td>
				<td>' . $anunt['zona'] . '</td>
				<td>' . $anunt['nume'] . '</td>
				<td>' . $anunt['culoare'] . '</td>
				<td>' . $anunt['stare'] . '</td>
				<td><img src="' . $anunt['imagine'] . '" style="max-width: 150px;"/></td>
				<td>' . $anunt['descriere'] . '</td>
				<td>' . $anunt['data_adaugarii'] . '</td>
			</tr>
		';
	}

	$export .= '
					</tbody>
				</table>
			</body>
		</html>
	';

	return $export;
}

//exportul in format HTML va contine datele care au fost populate in funtia de "continutHtml"
function exportHtml($arrAnunturi) {
	$html = continutHtml($arrAnunturi);

	echo $html;
}

// exportul in format JSON
function exportJson($arrAnunturi) {
	echo json_encode($arrAnunturi);
}

// exportul in format CSV creaza un document extern ce este descarcat local
// fisierul CSV contine toate campurile unui anunt, acestea fiind populate cu continutul lor din baza de date
function exportCsv($arrAnunturi) {
	//setam headerele pentru a forta un fisier sa se descarce
	header('Content-Type: text/csv; charset=utf-8');
	header('Content-Disposition: attachment; filename=export.csv');
	$output = fopen('php://output', 'w');
	fputcsv($output, array('Tip', 'Utilizator', 'Categorie', 'Zona', 'Nume', 'Culoare', 'Stare', 'Descriere', 'Data adaugarii'));

	foreach($arrAnunturi as $anunt) {
		fputcsv($output, array($anunt['tip'], $anunt['utilizator'], $anunt['categorie'], $anunt['zona'], $anunt['nume'], $anunt['culoare'], $anunt['stare'], $anunt['descriere'], $anunt['data_adaugarii']));
	}
}

// exportul in format PDF (folosit cu librarie)
function exportPdf($arrAnunturi) {
	error_reporting(0);
	header('Content-type: application/pdf');

	$html = continutHtml($arrAnunturi);
	//landscape
	$pdf = new HTML2FPDF('L');
	$pdf->AddPage();
	$pdf->WriteHtml($html);
	$pdf->Output();
}
?>