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

function requestFormEvent(callback, type, id) {
	
	xhr.onreadystatechange = function () {
		if (xhr.readyState === 4 && (xhr.status === 200 || xhr.status === 0)) {
			callback(xhr.responseText);
		}
	};
	
	xhr.open("GET", "Ajax/PHP/Formulaire.php?type=" + type + "&idevent=" + id, true);
	xhr.send(null);
}

/*
Affichage formulaire modification partenaire
 */

function requestFormModificationPartenaire(callback, type, id) {
	
	xhr.onreadystatechange = function () {
		if (xhr.readyState === 4 && (xhr.status === 200 || xhr.status === 0)) {
			callback(xhr.responseText);
		}
	};
	
	xhr.open("GET", "Ajax/PHP/Formulaire.php?type=" + type + "&idpartenaire=" + id, true);
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
	
	document.title = "Administration";
	
	xhr.open("GET", "Ajax/HTML/administration.html", true);
	xhr.send(null);
}

/*
Affichage création d'évent
 */

function requestCreateEvent(callback) {
	xhr.onreadystatechange = function () {
		if (xhr.readyState === 4 && (xhr.status === 200 || xhr.status === 0)) {
			callback(xhr.responseText, "administration");
		}
	};
	
	document.title = "Admin-Create Event";
	
	xhr.open("GET", "Ajax/PHP/CreateEvent.php", true);
	xhr.send(null);
}

/*
Affichage de la gestion des partenaires
 */

function requestAdminPartenaires(callback) {
	xhr.onreadystatechange = function () {
		if (xhr.readyState === 4 && (xhr.status === 200 || xhr.status === 0)) {
			callback(xhr.responseText, "administration");
		}
	};
	
	document.title = "Admin-Partenaires";
	
	xhr.open("GET", "Ajax/PHP/GestionPartenaires.php", true);
	xhr.send(null);
}

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
Affichage des evenements à administrer
 */

function requestAdminEvent(callback) {
	xhr.onreadystatechange = function () {
		if (xhr.readyState === 4 && (xhr.status === 200 || xhr.status === 0)) {
			callback(xhr.responseText, "administration");
		}
	};
	
	document.title = "Admin-Evenement";
	
	xhr.open("GET", "Ajax/PHP/AdministrerEvent.php", true);
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
	
	if (json["text"] === "Compte Créé mail de confirmation envoyé" || json["text"] === "Compte Créé !") {
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
		Materialize.toast("Email envoyé !", 2000);
		requestContact(readData);
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
Send inscription LAN
*/

function requestSendLAN(callback, idevent) {
	xhr.onreadystatechange = function () {
		if (xhr.readyState === 4 && (xhr.status === 200 || xhr.status === 0)) {
			callback(xhr.responseText, idevent);
			document.getElementById("loader").style.display = "none";
		}
	};
	
	let formDataInscirption = new FormData();
	formDataInscirption.append('IDevent', idevent);
	
	xhr.open("POST", "Ajax/PHP/SendInscriptionLAN.php", true);
	xhr.send(formDataInscirption);
}

function readDataSendLAN(oData, idevent) {
	
	let json = JSON.parse(oData);
	
	if (json["text"] === "Inscription effectué !" || json["text"] === "Inscription effectué, vous recevrez un mail sous peu") {
		Materialize.toast(json["text"], 1500);
		//requestPlaceDispo(readDataPlace, idevent);
		requestChoice(readData, idevent);
	} else {
		Materialize.toast(json["text"], 2500);
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
	
	if (json["text"] === "Inscription effectué !" || json["text"] === "Inscription effectué, vous recevrez un mail sous peu") {
		Materialize.toast(json["text"], 1500);
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

/*
Send new event
 */

function requestSendCreateEvent(callback) {
	xhr.onreadystatechange = function () {
		if (xhr.readyState === 4 && (xhr.status === 200 || xhr.status === 0)) {
			callback(xhr.responseText);
		}
	};
	
	let formData = new FormData(document.getElementById("form_create_event"));
	
	xhr.open("POST", "Ajax/PHP/SendCreateEvent.php", true);
	xhr.send(formData);
}

function readDataSendCreateEvent(oData) {
	
	let json = JSON.parse(oData);
	
	if (json["token"] !== undefined) {
		let input = document.getElementById("csrf");
		input.value = json['token'];
	}
	
	if (json["text"] === "Evenement créé avec succès !") {
		Materialize.toast(json["text"], 1500);
		requestEvenements(readData);
	} else {
		Materialize.toast(json["text"], 2500);
		let input = document.getElementById("csrf");
		input.value = json['token'];
	}
}

/*
Send delete partenaires
 */

function requestDeletePartenaireGP(callback, id) {
	xhr.onreadystatechange = function () {
		if (xhr.readyState === 4 && (xhr.status === 200 || xhr.status === 0)) {
			callback(xhr.responseText);
		}
	};
	
	let formData = new FormData();
	formData.append("IDpartenaire", id);
	
	xhr.open("POST", "Ajax/PHP/SendDeletePartenaire.php", true);
	xhr.send(formData);
}

function readDataDeletePartenaireGP(oData) {
	
	let json = JSON.parse(oData);
	
	if (json["text"] === "Partenaire Supprimé") {
		Materialize.toast(json["text"], 3000);
		requestAdminPartenaires(readData);
	} else {
		Materialize.toast(json["text"], 2500);
	}
}

/*
Send add partenaires
 */

function requestSendNewPartenaire(callback) {
	xhr.onreadystatechange = function () {
		if (xhr.readyState === 4 && (xhr.status === 200 || xhr.status === 0)) {
			callback(xhr.responseText);
		}
	};
	
	let formData = new FormData(document.getElementById("form_add_partenaire"));
	
	xhr.open("POST", "Ajax/PHP/SendAddPartenaire.php", true);
	xhr.send(formData);
}

function readDataSendNewPartenaire(oData) {
	
	let json = JSON.parse(oData);
	
	if (json["token"] !== undefined) {
		let input = document.getElementById("csrf");
		input.value = json['token'];
	}
	
	if (json["text"] === "Partenaire Ajouté !") {
		Materialize.toast(json["text"], 1500);
		closeModal("page");
		requestAdminPartenaires(readData);
	} else {
		Materialize.toast(json["text"], 2500);
		let input = document.getElementById("csrf");
		input.value = json['token'];
	}
}

/*
Send modification partenaires
 */

function requestSendModifPartenaire(callback, id) {
	xhr.onreadystatechange = function () {
		if (xhr.readyState === 4 && (xhr.status === 200 || xhr.status === 0)) {
			callback(xhr.responseText);
		}
	};
	
	let formData = new FormData(document.getElementById("form_modif_partenaire"));
	formData.append("idpartenaire", id);
	
	xhr.open("POST", "Ajax/PHP/SendModificationPartenaire.php", true);
	xhr.send(formData);
}

function readDataSendModifPartenaire(oData) {
	
	let json = JSON.parse(oData);
	
	if (json["token"] !== undefined) {
		let input = document.getElementById("csrf");
		input.value = json['token'];
	}
	
	if (json["text"] === "Partenaire Modifié !") {
		Materialize.toast(json["text"], 1500);
		closeModal("page");
		requestAdminPartenaires(readData);
	} else {
		Materialize.toast(json["text"], 2500);
		let input = document.getElementById("csrf");
		input.value = json['token'];
	}
}

/*
Send modification partenaires img
 */

function requestSendModifImgPartenaire(callback, id) {
	xhr.onreadystatechange = function () {
		if (xhr.readyState === 4 && (xhr.status === 200 || xhr.status === 0)) {
			callback(xhr.responseText);
		}
	};
	
	let formData = new FormData(document.getElementById("form_modif_partenaire"));
	formData.append("idpartenaire", id);
	
	xhr.open("POST", "Ajax/PHP/SendModificationImgPartenaire.php", true);
	xhr.send(formData);
}

function readDataSendModifImgPartenaire(oData) {
	
	let json = JSON.parse(oData);
	
	if (json["token"] !== undefined) {
		let input = document.getElementById("csrf");
		input.value = json['token'];
	}
	
	if (json["text"] === "Image Modifié !") {
		Materialize.toast(json["text"], 1500);
		closeModal("page");
		requestAdminPartenaires(readData);
	} else {
		Materialize.toast(json["text"], 2500);
		let input = document.getElementById("csrf");
		input.value = json['token'];
	}
}

/*
Send Modification event
 */

function requestSendModifEvent(callback, id) {
	xhr.onreadystatechange = function () {
		if (xhr.readyState === 4 && (xhr.status === 200 || xhr.status === 0)) {
			callback(xhr.responseText);
		}
	};
	
	let formData = new FormData(document.getElementById("form_modify_event"));
	formData.append("IDevenement", id);
	
	xhr.open("POST", "Ajax/PHP/SendModificationEvent.php", true);
	xhr.send(formData);
}

function readDataSendModifEvent(oData) {
	
	let json = JSON.parse(oData);
	
	if (json["token"] !== undefined) {
		let input = document.getElementById("csrf");
		input.value = json['token'];
	}
	
	if (json["text"] === "Evenement modifié avec succès !") {
		Materialize.toast(json["text"], 1500);
		closeModal("page");
		requestAdminEvent(readData);
	} else {
		Materialize.toast(json["text"], 2500);
		let input = document.getElementById("csrf");
		input.value = json['token'];
	}
}

/*
Send delete evenement
 */

function requestDeleteEvenement(callback, id) {
	xhr.onreadystatechange = function () {
		if (xhr.readyState === 4 && (xhr.status === 200 || xhr.status === 0)) {
			callback(xhr.responseText);
		}
	};
	
	let formData = new FormData();
	formData.append("idevent", id);
	
	xhr.open("POST", "Ajax/PHP/SendDeleteEvent.php", true);
	xhr.send(formData);
}

function readDataDeleteEvenement(oData) {
	
	let json = JSON.parse(oData);
	
	if (json["text"] === "Evenement supprimé !") {
		Materialize.toast(json["text"], 3000);
		requestAdminEvent(readData);
	} else {
		Materialize.toast(json["text"], 2500);
	}
}

/*
Send modification evenements img
 */

function requestSendModifImgEvent(callback, id) {
	xhr.onreadystatechange = function () {
		if (xhr.readyState === 4 && (xhr.status === 200 || xhr.status === 0)) {
			callback(xhr.responseText);
		}
	};
	
	let formData = new FormData(document.getElementById("form_modif_event"));
	formData.append("idevent", id);
	
	xhr.open("POST", "Ajax/PHP/SendModificationImgEvent.php", true);
	xhr.send(formData);
}

function readDataSendModifImgEvent(oData) {
	
	let json = JSON.parse(oData);
	
	if (json["token"] !== undefined) {
		let input = document.getElementById("csrf");
		input.value = json['token'];
	}
	
	if (json["text"] === "Image Modifié !") {
		Materialize.toast(json["text"], 1500);
		closeModal("page");
		requestAdminEvent(readData);
	} else {
		Materialize.toast(json["text"], 2500);
		let input = document.getElementById("csrf");
		input.value = json['token'];
	}
}

/*
Génerate PDF
 */

function requestGeneratePDF(callback, id) {
	xhr.onreadystatechange = function () {
		if (xhr.readyState === 4 && (xhr.status === 200 || xhr.status === 0)) {
			callback(xhr.responseText);
		}
	};
	
	let formData = new FormData();
	formData.append("idevent", id);
	
	xhr.open("POST", "Ajax/PHP/GeneratePDF.php", true);
	xhr.send(formData);
}

function readDataGeneratePDF(oData) {
	let json = JSON.parse(oData);
	
	if (json["text"] === "PDF Généré !") {
		let $toastContent = $("<span style='margin-right: 10px'>" + json['text'] + "</span><span onclick='requestTelechargementListePDF(\"" + json['name'] + "\")' class='btn - flattoast - action'>Telecharger</span>");
		Materialize.toast($toastContent, 5000);
	} else {
		Materialize.toast(json["text"], 2500);
	}
}

/*
Télécharger le fichier PDF de la liste
 */

function requestTelechargementListePDF(name) {
	window.open("Files/ListePDF/" + name, "_blank");
}

/*
Confirmation DELETE
 */

function requestDeleteEventConfirm(id) {
	let idEvent = parseInt(id);
	let $toastContent = $("<span>Souhaitez vous supprimer l'événement ?</span>")
		.add($("<button class='btn-flat toast-action' onclick='requestDeleteEvenement(readDataDeleteEvenement," + idEvent + ") ; removeToast()'>Oui</button>"))
		.add($("<button class='btn-flat toast-action' onclick='removeToast()'>Non</button>"));
	Materialize.toast($toastContent, 7000);
}

/*
Confirmation DELETE Partenaire
 */

function requestDeletePartenaireConfirm(id) {
	let idEvent = parseInt(id);
	let $toastContent = $("<span>Souhaitez vous supprimer le Partenaire ?</span>")
		.add($("<button class='btn-flat toast-action' onclick='requestDeletePartenaireGP(readDataDeletePartenaireGP," + idEvent + ") ; removeToast()'>Oui</button>"))
		.add($("<button class='btn-flat toast-action' onclick='removeToast()'>Non</button>"));
	Materialize.toast($toastContent, 7000);
}

/*
Envois des mail aux participants
 */

function requestSendMailAllParticipants(callback, idEvent) {
	xhr.onreadystatechange = function () {
		if (xhr.readyState === 4 && (xhr.status === 200 || xhr.status === 0)) {
			callback(xhr.responseText);
		}
	};
	
	let formData = new FormData(document.getElementById("form_send_mail_all"));
	formData.append("idevent", idEvent);
	
	xhr.open("POST", "Ajax/PHP/SendMailAllParticipants.php", true);
	xhr.send(formData);
}

function readDataSendMailAllParticipants(oData) {
	
	let json = JSON.parse(oData);
	
	if (json["token"] !== undefined) {
		let input = document.getElementById("csrf");
		input.value = json['token'];
	}
	
	if (json["text"] === "Les Email ont été envoyé !") {
		Materialize.toast(json["text"], 2000);
		closeModal("page");
	} else {
		Materialize.toast(json["text"], 2000);
		let input = document.getElementById("csrf");
		input.value = json['token'];
	}
}