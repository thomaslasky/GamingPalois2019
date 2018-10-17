let xhr = getXMLHttpRequest();

/*
Global readData
*/

function readData(oData, id) {
	document.getElementById(id).innerHTML = oData;
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
	
	if (type === "BecomeMember") {
		document.title = "Devenir Membre"
	} else {
		document.title = type;
	}
	
	xhr.open("GET", "Ajax/PHP/Formulaire.php?type=" + type, true);
	xhr.send(null);
}

function readDataForm(oData) {
	modal("page");
	document.getElementById("modal").innerHTML = oData;
}

/*
Affichage de la barre de navigation post connexion
*/

function requestNewNav(callback) {
	xhr.onreadystatechange = function () {
		if (xhr.readyState === 4 && (xhr.status === 200 || xhr.status === 0)) {
			callback(xhr.responseText, "is_connect");
		}
	};
	
	xhr.open("GET", "Ajax/PHP/VerificationConnexion.php", true);
	xhr.send(null);
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
	
	document.title = "Evenements";
	
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
	
	document.title = "Evenements";
	
	xhr.open("GET", "Ajax/PHP/VerificationInscription.php?IDevent=" + idevent, true);
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
		M.toast({html: 'Vous êtes connecté'});
		requestNewNav(readData);
		closeModal("page")
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
		M.toast({html: 'Compte créé'});
		requestForm(readDataForm, "Login");
		modal("page");
	} else {
		M.toast({html: json["text"]});
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
		M.toast({html: 'Vous êtes déconnecté'});
		requestNewNav(readData);
		closeModal("page")
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
		M.toast({html: json["text"]});
	} else {
		M.toast({html: json["text"]});
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
		M.toast({html: json["text"]});
		closeModal("page")
	} else {
		M.toast({html: json["text"]});
		let input = document.getElementById("csrf");
		input.value = json['token'];
	}
}

/*
Send Actions Event Event
*/

function requestSendActionsEvent(callback, action, idevent) {
	xhr.onreadystatechange = function () {
		if (xhr.readyState === 4 && (xhr.status === 200 || xhr.status === 0)) {
			callback(xhr.responseText, idevent);
		}
	};
	
	let formDataInscirption = new FormData();
	formDataInscirption.append('Action', action);
	formDataInscirption.append('IDevent', idevent);
	
	xhr.open("POST", "Ajax/PHP/SendActionsEvents.php", true);
	xhr.send(formDataInscirption);
}

function readDataSendActionsEvent(oData, idevent) {
	
	let json = JSON.parse(oData);
	
	requestChoice(readData, idevent);
	M.toast({html: json["text"]});
	
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
		M.toast({html: json["text"]});
		requestProfil(readData);
	} else {
		M.toast({html: json["text"]});
		let input = document.getElementById("csrf");
		input.value = json['token'];
	}
}