//pentru vizualizarea detaliilor unui anunt se va apasa pe sageata verde ce va face vizibila zona de detalii
function vizualizareDetalii(e) {
    var event = event || window.event;
    var detalii = event.srcElement;
    while ((detalii = detalii.parentElement) && !detalii.classList.contains("rand"));

    for(var i = 0; i < detalii.childNodes.length; i++) {
        if(detalii.childNodes[i].classList && detalii.childNodes[i].classList.contains("infoText")) {
            detalii = detalii.childNodes[i];
            break;
        }
    }

    detalii.classList.add("active");
    detalii.classList.remove("hidden");
}

//pentru ascunderea detaliilor unui anunt se va apasa pe sageata roz ce va face ascunsa zona de detalii
function inchidereDetalii(e) {
    var event = event || window.event;
    var detalii = event.srcElement;
    while ((detalii = detalii.parentElement) && !detalii.classList.contains("infoText"));
    detalii.classList.add("hidden");
    detalii.classList.remove("active");
}

// pentru a ne inregistra trebuie sa completam capurile definite cu valori
function inregistrare() {
	var nume = document.getElementsByName("nume")[0].value;
	var email = document.getElementsByName("email")[0].value;
	var utilizator = document.getElementsByName("utilizator")[0].value;
	var parola = document.getElementsByName("parola")[0].value;
	var telefon = document.getElementsByName("telefon")[0].value;

	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		//daca primim raspuns valid de la server
		if (xhttp.readyState == 4 && xhttp.status == 200) {
			var raspuns = JSON.parse(xhttp.responseText);
			if(raspuns.succes) {
				window.location = 'autentificare.php';
			} else {
				alert(raspuns.mesaj);
			}
		}
	};

	//se realizeaza actiunea de inregistrare si se vor atasa valorile campurilor completate
	xhttp.open("POST", "controller.php", true);
	var data = new FormData();
	data.append("actiune", "inregistare");
	data.append("nume", nume);
	data.append("email", email);
	data.append("utilizator", utilizator);
	data.append("parola", parola);
	data.append("telefon", telefon);
	xhttp.send(data);
	return false;
}

//autentificarea se realizeaza prin completarea celor doua campuri
//datele trebuie sa concida cu cele de lainregistrare
function autentificare() {
	var utilizator = document.getElementsByName("utilizator")[0].value;
	var parola = document.getElementsByName("parola")[0].value;

	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		//daca primim raspuns valid de la server
		if (xhttp.readyState == 4 && xhttp.status == 200) {
			var raspuns = JSON.parse(xhttp.responseText);
			if(raspuns.succes) {
				window.location = 'index.php';
			} else {
				alert(raspuns.mesaj);
			}
		}
	};

	//se realizeaza actiunea de autentificare si se vor atasa valorile campurilor completate
	xhttp.open("POST", "controller.php", true);
	var data = new FormData();
	data.append("actiune", "autentificare");
	data.append("utilizator", utilizator);
	data.append("parola", parola);
	xhttp.send(data);
	return false;
}

//adaugarea unui anunt nou
function adaugareAnunt(tip) {
	var files = document.getElementById('addUpload').files;
	var categorie = document.getElementById("addCategorie").value;
	var zona = document.getElementById("addZona").value;
	var nume = document.getElementById("addNume").value;
	var culoare = document.getElementById("addCuloare").value;
	var stare = document.getElementById("addStare").value;
	var descriere = document.getElementById("addDescriere").value;

	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		//daca primim raspuns valid de la server
		if (xhttp.readyState == 4 && xhttp.status == 200) {
			var raspuns = JSON.parse(xhttp.responseText);
			if(raspuns.succes) {
				window.location.reload();
			} else {
				alert(raspuns.mesaj);
			}
		}
	};

	xhttp.open("POST", "controller.php", true);
	var data = new FormData();
	if(files.length > 0) {
		data.append("file", files[0], files[0].name);
	}
	//noile date din campuri vor fi salvare
	data.append("actiune", "adaugareAnunt");
	data.append("tip", tip);
	data.append("categorie", categorie);
	data.append("zona", zona);
	data.append("nume", nume);
	data.append("culoare", culoare);
	data.append("stare", stare);
	data.append("descriere", descriere);
	xhttp.send(data);

	return false;
}

function exportAnunturi(tip) {
	var formatExport = document.getElementById("formatExport").value;
	//vom fi redirectionati catre o pagina noua pentru export
	window.open("export.php?tip=" + tip + "&formatExport=" + formatExport, "_blank");
}

// functia de deschidere a modalului pentru stergerea unui anunt
function deschideModalStergere(idAnunt, utilizatorAnunt) {
	document.getElementById("idAnuntStergere").value = idAnunt;
	document.getElementById("utilizatorAnuntStergere").value = utilizatorAnunt;
	document.getElementById("modalSterge").classList.remove("hidden");
}

// functia de inchidere a modalului pentru stergerea unui anunt
function inchidereModalStergere() {
	document.getElementById("idAnuntStergere").value = "";
	document.getElementById("utilizatorAnuntStergere").value = "";
	document.getElementById("modalSterge").classList.add("hidden");
}

// functia de deschidere a modalului pentru raportearea unei fraude
function deschideModalFrauda(idAnunt) {
	document.getElementById("idAnuntFrauda").value = idAnunt;
	document.getElementById("modalFrauda").classList.remove("hidden");
}

// functia de inchidere a modalului pentru raportearea unei fraude
function inchidereModalFrauda() {
	document.getElementById("idAnuntFrauda").value = "";
	document.getElementById("numeFrauda").value = "";
	document.getElementById("emailFrauda").value = "";
	document.getElementById("descriereFrauda").value = "";
	document.getElementById("modalFrauda").classList.add("hidden");
}

// apasarea butonului a confirmarii stergerii unui anunt
function confirmareStegere() {
	var idAnunt = document.getElementById("idAnuntStergere").value;
	var utilizatorAnunt = document.getElementById("utilizatorAnuntStergere").value;

	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		//daca primim raspuns valid de la server
		if (xhttp.readyState == 4 && xhttp.status == 200) {
			var raspuns = JSON.parse(xhttp.responseText);
			if(raspuns.succes) {
				window.location.reload();
			} else {
				alert(raspuns.mesaj);
			}
		}
	};

	//se va realiza actiunea de stergere 
	xhttp.open("POST", "controller.php", true);
	var data = new FormData();
	data.append("actiune", "stergereAnunt");
	data.append("idAnunt", idAnunt);
	data.append("utilizatorAnunt", utilizatorAnunt);
	xhttp.send(data);
	return false;
}

//functia de raportarea a ueni fraude
function trimiteRaportFrauda() {
	var idAnunt = document.getElementById("idAnuntFrauda").value;
	var nume = document.getElementById("numeFrauda").value;
	var email = document.getElementById("emailFrauda").value;
	var descriere = document.getElementById("descriereFrauda").value;

	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		//daca primim raspuns valid de la server
		if (xhttp.readyState == 4 && xhttp.status == 200) {
			var raspuns = JSON.parse(xhttp.responseText);
			if(raspuns.succes) {
				inchidereModalFrauda();
			} else {
				alert(raspuns.mesaj);
			}
		}
	};

	//se vor trimite datele completate pentru a raporta frauda
	xhttp.open("POST", "controller.php", true);
	var data = new FormData();
	data.append("actiune", "trimiteRaportFrauda");
	data.append("idAnunt", idAnunt);
	data.append("nume", nume);
	data.append("email", email);
	data.append("descriere", descriere);
	xhttp.send(data);
	return false;
}

//vizualizare anunt de pe pagina de profil al utilizatorului
function deschideModalAnunt(mod, idAnunt, categorie, zona, nume, culoare, stare, descriere) {
	document.getElementById("addIdAnunt").value = idAnunt;
	document.getElementById("addCategorie").value = categorie;
	document.getElementById("addZona").value = zona;
	document.getElementById("addNume").value = nume;
	document.getElementById("addCuloare").value = culoare;
	document.getElementById("addStare").value = stare;
	document.getElementById("addDescriere").value = descriere;

	if(mod == 'vizualizare') {
		document.getElementById("addCategorie").disabled = true;
		document.getElementById("addZona").disabled = true;
		document.getElementById("addNume").disabled = true;
		document.getElementById("addCuloare").disabled = true;
		document.getElementById("addStare").disabled = true;
		document.getElementById("addDescriere").disabled = true;
		document.getElementById("salveazaEditare").classList.add("hidden");
		document.getElementById("anuleazaEditare").classList.add("hidden");
	}

	document.getElementById("modalAnunt").classList.remove("hidden");
}

//inchidere modal anunt de pe pagina de profil al utilizatorului
function inchidereModalAnunt() {
	document.getElementById("addIdAnunt").value = '';
	document.getElementById("addCategorie").value = '';
	document.getElementById("addZona").value = '';
	document.getElementById("addNume").value = '';
	document.getElementById("addCuloare").value = '';
	document.getElementById("addStare").value = '';
	document.getElementById("addDescriere").value = '';

	document.getElementById("addCategorie").disabled = false;
	document.getElementById("addZona").disabled = false;
	document.getElementById("addNume").disabled = false;
	document.getElementById("addCuloare").disabled = false;
	document.getElementById("addStare").disabled = false;
	document.getElementById("addDescriere").disabled = false;

	document.getElementById("salveazaEditare").classList.remove("hidden");
	document.getElementById("anuleazaEditare").classList.remove("hidden");
	document.getElementById("modalAnunt").classList.add("hidden");	
}

//modificare/editare anunt de pe pagina de profil al utilizatorului
function modificareAnunt() {
	var idAnunt = document.getElementById('addIdAnunt').value;
	var files = document.getElementById('addUpload').files;
	var categorie = document.getElementById("addCategorie").value;
	var zona = document.getElementById("addZona").value;
	var nume = document.getElementById("addNume").value;
	var culoare = document.getElementById("addCuloare").value;
	var stare = document.getElementById("addStare").value;
	var descriere = document.getElementById("addDescriere").value;

	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		//daca primim raspuns valid de la server
		if (xhttp.readyState == 4 && xhttp.status == 200) {
			var raspuns = JSON.parse(xhttp.responseText);
			if(raspuns.succes) {
				window.location.reload();
			} else {
				alert(raspuns.mesaj);
			}
		}
	};

	xhttp.open("POST", "controller.php", true);
	var data = new FormData();
	if(files.length > 0) {
		data.append("file", files[0], files[0].name);
	}
	//noile date din campuri vor fi salvare
	data.append("idAnunt", idAnunt);
	data.append("actiune", "modificareAnunt");
	data.append("categorie", categorie);
	data.append("zona", zona);
	data.append("nume", nume);
	data.append("culoare", culoare);
	data.append("stare", stare);
	data.append("descriere", descriere);
	xhttp.send(data);

	return false;
}