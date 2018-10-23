let xhr = getXMLHttpRequest();

/*
Global
*/

function readData(oData, id) {
	document.getElementById(id).innerHTML = oData;
}

function reload(docTitle) {
	return new Promise((resolve) => {
		switch (docTitle) {
			case "Evenements":
				requestEvenements((oData, id) => {
					readData(oData, id);
					resolve();
				});
				break;
			case "Presentation":
				requestPresentation((oData, id) => {
					readData(oData, id);
					resolve();
				});
				break;
			case "Partenaires":
				requestPartenaires((oData, id) => {
					readData(oData, id);
					resolve();
				});
				break;
			case "Web TV":
				resolve();
				break;
			case "Contact":
				requestContact((oData, id) => {
					readData(oData, id);
					resolve();
				});
				break;
			case "Profil":
				requestProfil((oData, id) => {
					readData(oData, id);
					resolve();
				});
				break;
		}
	})
	
}

/*
Affichage Formulaire Log User
 */

function requestForm(callback, type) {
	
	xhr.onreadystatechange = function () {
		if (xhr.readyState === 4 && (xhr.status === 200 || xhr.status === 0)) {
			callback(xhr.responseText);
		}
	};
	
	xhr.open("GET", "Ajax/PHP/Formulaire.php?type=" + type, true);
	xhr.send(null);
}

function readDataForm(oData) {
	modal("page");
	document.getElementById("modal").innerHTML = oData;
}

/*
Affichage formulaire vide grenier
*/

function requestFormVideGrenier(callback, type, id) {
	
	xhr.onreadystatechange = function () {
		if (xhr.readyState === 4 && (xhr.status === 200 || xhr.status === 0)) {
			callback(xhr.responseText);
		}
	};
	
	xhr.open("GET", "Ajax/PHP/Formulaire.php?type=" + type + "&idevent=" + id, true);
	xhr.send(null);
}

/*
Affichage de la barre de navigation post connexion
*/

function requestNewNav(callback) {
	return new Promise((resolve) => {
		xhr.onreadystatechange = function () {
			if (xhr.readyState === 4 && (xhr.status === 200 || xhr.status === 0)) {
				callback(xhr.responseText, "is_connect");
				resolve();
			}
		};
		
		xhr.open("GET", "Ajax/PHP/VerificationConnexion.php", true);
		xhr.send(null);
	});
}

/*
Affichage WebTV
 */

function requestWebTV(callback) {
	xhr.onreadystatechange = function () {
		if (xhr.readyState === 4 && (xhr.status === 200 || xhr.status === 0)) {
			callback(xhr.responseText, "output");
		}
	};
	
	document.title = "Web TV";
	
	xhr.open("GET", "Ajax/HTML/webtv.html", true);
	xhr.send(null);
}

/*
Affichage Evenements
 */

function requestEvenements(callback) {
	xhr.onreadystatechange = function () {
		if (xhr.readyState === 4 && (xhr.status === 200 || xhr.status === 0)) {
			callback(xhr.responseText, "output");
		}
	};
	
	document.title = "Evenements";
	
	xhr.open("GET", "Ajax/PHP/Evenements.php", true);
	xhr.send(null);
}

/*
Affichage Contact
 */

function requestContact(callback) {
	xhr.onreadystatechange = function () {
		if (xhr.readyState === 4 && (xhr.status === 200 || xhr.status === 0)) {
			callback(xhr.responseText, "output");
		}
	};
	
	document.title = "Contact";
	
	xhr.open("GET", "Ajax/PHP/Contact.php", true);
	xhr.send(null);
}

/*
Affichage Presentation
 */

function requestPresentation(callback) {
	xhr.onreadystatechange = function () {
		if (xhr.readyState === 4 && (xhr.status === 200 || xhr.status === 0)) {
			callback(xhr.responseText, "output");
		}
	};
	
	document.title = "Presentation";
	
	xhr.open("GET", "Ajax/HTML/presentation.html", true);
	xhr.send(null);
}

/*
Affichage des partenaires
 */

function requestPartenaires(callback) {
	xhr.onreadystatechange = function () {
		if (xhr.readyState === 4 && (xhr.status === 200 || xhr.status === 0)) {
			callback(xhr.responseText, "output");
		}
	};
	
	document.title = "Partenaires";
	
	xhr.open("GET", "Ajax/PHP/Partenaires.php", true);
	xhr.send(null);
}

/*
Affichage choix events
*/

function requestChoice(callback, idevent) {
	xhr.onreadystatechange = function () {
		if (xhr.readyState === 4 && (xhr.status === 200 || xhr.status === 0)) {
			callback(xhr.responseText, "choice_action-" + idevent);
		}
	};
	
	xhr.open("GET", "Ajax/PHP/VerificationInscription.php?IDevent=" + idevent, true);
	xhr.send(null);
}

/*
Affichage Administration
 */

function requestAdministration(callback) {
	xhr.onreadystatechange = function () {
		if (xhr.readyState === 4 && (xhr.status === 200 || xhr.status === 0)) {
			callback(xhr.responseText, "output");
		}
	};
	
	document.title = "Partenaires";
	
	xhr.open("GET", "Ajax/HTML/administration.html", true);
	xhr.send(null);
}

/*
Affichage place disponible
 */

/*function requestPlaceDispo(callback,idevent) {
	xhr.onreadystatechange = function () {
		if (xhr.readyState === 4 && (xhr.status === 200 || xhr.status === 0)) {
			callback(xhr.responseText, "choice_action-place-" + idevent);
		}
	};
	
	xhr.open("GET", "Ajax/PHP/VerificationNumberIn.php?idevent=" + idevent, true);
	xhr.send(null);
}*/

/*
Affichage du profil
 */

function requestProfil(callback) {
	xhr.onreadystatechange = function () {
		if (xhr.readyState === 4 && (xhr.status === 200 || xhr.status === 0)) {
			callback(xhr.responseText, "output");
		}
	};
	
	document.title = "Profil";
	
	xhr.open("GET", "Ajax/PHP/Profil.php", true);
	xhr.send(null);
}

/*
Send Data Log User
 */

function requestLogin(callback) {
	xhr.onreadystatechange = function () {
		if (xhr.readyState === 4 && (xhr.status === 200 || xhr.status === 0)) {
			callback(xhr.responseText);
		}
	};
	
	let formData = new FormData(document.getElementById("login_form"));
	
	xhr.open("POST", "Ajax/PHP/SendLogin.php", true);
	xhr.send(formData);
}

function readDataLogin(oData) {
	
	let json = JSON.parse(oData);
	
	if (json["token"] !== undefined) {
		let input = document.getElementById("csrf");
		input.value = json['token'];
	}
	
	if (json["text"] === "Connexion réussie") {
		Materialize.toast("Vous êtes connecté", 3000);
		reload(document.title)
			.then(() => requestNewNav(readData))
			.then(() => closeModal("page"))
			.catch((err) => console.error(err));
	} else {
		Materialize.toast(json["text"], 2500);
	}
}

/*
Send Data new User
 */

function requestRegister(callback) {
	xhr.onreadystatechange = function () {
		if (xhr.readyState === 4 && (xhr.status === 200 || xhr.status === 0)) {
			callback(xhr.responseText);
		}
	};
	
	let formData = new FormData(document.getElementById("register_form"));
	
	xhr.open("POST", "Ajax/PHP/SendInscription.php", true);
	xhr.send(formData);
}

function readDataRegister(oData) {
	
	let json = JSON.parse(oData);
	
	if (json["token"] !== undefined) {
		let input = document.getElementById("csrf");
		input.value = json['token'];
	}
	
	if (json["text"] === "Compte Créé") {
		Materialize.toast("Compte Créé", 2000);
		requestForm(readDataForm, "Login");
		modal("page");
	} else {
		Materialize.toast(json["text"], 2000);
		let input = document.getElementById("csrf");
		input.value = json['token'];
	}
}

/*
Send Deconnexion
*/

function requestDeconnexion(callback) {
	xhr.onreadystatechange = function () {
		if (xhr.readyState === 4 && (xhr.status === 200 || xhr.status === 0)) {
			callback(xhr.responseText);
		}
	};
	
	xhr.open("GET", "Ajax/PHP/SendDeconnexion.php", true);
	xhr.send(null);
}

function readDataDeconnexion(oData) {
	
	let json = JSON.parse(oData);
	
	if (json["text"] === "Vous êtes déconnecté") {
		Materialize.toast("Vous êtes deconnecté", 2000);
		reload(document.title)
			.then(() => requestNewNav(readData))
			.catch((err) => console.error(err));
	}
}

/*
Send Email contact
 */

function requestSendContact(callback) {
	xhr.onreadystatechange = function () {
		if (xhr.readyState === 4 && (xhr.status === 200 || xhr.status === 0)) {
			callback(xhr.responseText);
		}
	};
	
	let formData = new FormData(document.getElementById("form_contact"));
	
	xhr.open("POST", "Ajax/PHP/SendContact.php", true);
	xhr.send(formData);
}

function readDataSendContact(oData) {
	
	let json = JSON.parse(oData);
	
	if (json["token"] !== undefined) {
		let input = document.getElementById("csrf");
		input.value = json['token'];
	}
	
	if (json["text"] === "Email envoyé !") {
		Materialize.toast("Email envoyé !");
	} else {
		Materialize.toast(json["text"], 2000);
		let input = document.getElementById("csrf");
		input.value = json['token'];
	}
}

/*
Send Email devenir membre
 */

function requestSendBecomeMember(callback) {
	xhr.onreadystatechange = function () {
		if (xhr.readyState === 4 && (xhr.status === 200 || xhr.status === 0)) {
			callback(xhr.responseText);
		}
	};
	
	let formData = new FormData(document.getElementById("form_contact"));
	
	xhr.open("POST", "Ajax/PHP/SendBecomeMember.php", true);
	xhr.send(formData);
}

function readDataSendBecomeMember(oData) {
	
	let json = JSON.parse(oData);
	
	if (json["token"] !== undefined) {
		let input = document.getElementById("csrf");
		input.value = json['token'];
	}
	
	if (json["text"] === "Email envoyé !") {
		Materialize.toast(json["text"], 1500);
		closeModal("page")
	} else {
		Materialize.toast(json["text"], 2500);
		let input = document.getElementById("csrf");
		input.value = json['token'];
	}
}

/*
Send inscription LAN
*/

function requestSendLAN(callback, idevent) {
	xhr.onreadystatechange = function () {
		if (xhr.readyState === 4 && (xhr.status === 200 || xhr.status === 0)) {
			callback(xhr.responseText, idevent);
		}
	};
	
	let formDataInscirption = new FormData();
	formDataInscirption.append('IDevent', idevent);
	
	xhr.open("POST", "Ajax/PHP/SendInscriptionLAN.php", true);
	xhr.send(formDataInscirption);
}

function readDataSendLAN(oData, idevent) {
	
	let json = JSON.parse(oData);
	
	if (json["text"] === "Inscription effectué !") {
		Materialize.toast(json["text"], 1500);
		//requestPlaceDispo(readDataPlace, idevent);
		requestChoice(readData, idevent);
	} else {
		Materialize.toast(json["text"], 2500);
	}
}

/*
Send modification
 */

function requestSendModificationProfil(callback) {
	xhr.onreadystatechange = function () {
		if (xhr.readyState === 4 && (xhr.status === 200 || xhr.status === 0)) {
			callback(xhr.responseText);
		}
	};
	
	let formData = new FormData(document.getElementById("form_modification_profil"));
	
	xhr.open("POST", "Ajax/PHP/SendModificationProfil.php", true);
	xhr.send(formData);
}

function readDataSendModificationProfil(oData) {
	
	let json = JSON.parse(oData);
	
	if (json["text"] === "Modification effectué") {
		Materialize.toast(json["text"], 1500);
		requestProfil(readData);
	} else {
		Materialize.toast(json["text"], 2500);
		let input = document.getElementById("csrf");
		input.value = json['token'];
	}
}

/*
Send Inscription vide grenier
 */

function requestSendVideGrenier(callback, id) {
	xhr.onreadystatechange = function () {
		if (xhr.readyState === 4 && (xhr.status === 200 || xhr.status === 0)) {
			callback(xhr.responseText, id);
		}
	};
	
	let formData = new FormData(document.getElementById("form_contact"));
	formData.append("IDevent", id);
	
	xhr.open("POST", "Ajax/PHP/SendInscriptionVideGrenier.php", true);
	xhr.send(formData);
}

function readDataSendVideGrenier(oData, idevent) {
	
	let json = JSON.parse(oData);
	
	if (json["text"] === "Inscription effectué !") {
		Materialize.toast(json["text"], 1500);
		closeModal("page");
		//requestPlaceDispo(readDataPlace, idevent);
		requestChoice(readData, idevent);
	} else {
		Materialize.toast(json["text"], 2500);
		let input = document.getElementById("csrf");
		input.value = json['token'];
	}
}

/*
Send Desinscription event
 */

function requestSendDesinscription(callback, id) {
	xhr.onreadystatechange = function () {
		if (xhr.readyState === 4 && (xhr.status === 200 || xhr.status === 0)) {
			callback(xhr.responseText, id);
		}
	};
	
	let formData = new FormData();
	formData.append("IDevent", id);
	
	xhr.open("POST", "Ajax/PHP/SendDesinscriptionEvent.php", true);
	xhr.send(formData);
}

function readDataSendDesinscriptionEvent(oData, idevent) {
	
	let json = JSON.parse(oData);
	
	if (json["text"] === "Vous êtes desinscrit !") {
		Materialize.toast(json["text"], 1500);
		//requestPlaceDispo(readData, idevent);
		requestChoice(readData, idevent);
	} else {
		Materialize.toast(json["text"], 2500);
	}
}