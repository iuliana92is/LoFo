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
			if(raspuns.success) {
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
			if(raspuns.success) {
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

function exportAnunturi(tip) {
	var formatExport = document.getElementById("formatExport").value;
	
	window.open("export.php?tip=" + tip + "&formatExport=" + formatExport, "_blank");
}