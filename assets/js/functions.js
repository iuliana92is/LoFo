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

function inchidereDetalii(e) {
    var event = event || window.event;
    var detalii = event.srcElement;
    while ((detalii = detalii.parentElement) && !detalii.classList.contains("infoText"));
    detalii.classList.add("hidden");
    detalii.classList.remove("active");
}

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
				alert(raspuns.mesaj);
			} else {
				alert(raspuns.mesaj);
			}
		}
	};

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

	xhttp.open("POST", "controller.php", true);
	var data = new FormData();
	data.append("actiune", "autentificare");
	data.append("utilizator", utilizator);
	data.append("parola", parola);
	xhttp.send(data);
	return false;
}

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
				windows.location.reload();
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
	
	window.open("export.php?tip=" + tip + "&formatExport=" + formatExport, "_blank");
}

function deschideModalStergere(idAnunt) {
	document.getElementById("idAnuntStergere").value = idAnunt;
	document.getElementById("modalSterge").classList.remove("hidden");
}

function inchidereModalStergere() {
	document.getElementById("idAnuntStergere").value = "";
	document.getElementById("modalSterge").classList.add("hidden");
}

function deschideModalFrauda(idAnunt) {
	document.getElementById("idAnuntFrauda").value = idAnunt;
	document.getElementById("modalFrauda").classList.remove("hidden");
}

function inchidereModalFrauda() {
	document.getElementById("idAnuntFrauda").value = "";
	document.getElementById("numeFrauda").value = "";
	document.getElementById("emailFrauda").value = "";
	document.getElementById("descriereFrauda").value = "";
	document.getElementById("modalFrauda").classList.add("hidden");
}

function confirmareStegere() {
	var idAnunt = document.getElementById("idAnuntStergere").value;

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
	data.append("actiune", "stergereAnunt");
	data.append("idAnunt", idAnunt);
	xhttp.send(data);
	return false;
}

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