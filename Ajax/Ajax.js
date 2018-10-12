let xhr = getXMLHttpRequest();

/*
Affichage Formulaire Log User
 */

function requestFormUser(callback, type) {
	
	xhr.onreadystatechange = function () {
		if (xhr.readyState === 4 && (xhr.status === 200 || xhr.status === 0)) {
			callback(xhr.responseText);
		}
	};
	
	document.title = type;
	
	xhr.open("GET", "Ajax/PHP/formulaire.php?type=" + type, true);
	xhr.send(null);
}

function readDataFormUser(oData) {
	modal("page");
	document.getElementById("modal").innerHTML = oData;
}

/*
Affichage de la barre de navigation post connexion
*/

function requestNewNav(callback) {
	xhr.onreadystatechange = function () {
		if (xhr.readyState === 4 && (xhr.status === 200 || xhr.status === 0)) {
			callback(xhr.responseText);
		}
	};
	
	xhr.open("GET", "Ajax/PHP/verificationconnexion.php", true);
	xhr.send(null);
}

function readDataNewNav(oData) {
	document.getElementById("is_connect").innerHTML = oData;
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
	
	xhr.open("POST", "Ajax/PHP/login.php", true);
	xhr.send(formData);
}

function readDataLogin(oData) {
	
	let json = JSON.parse(oData);
	
	//alert(json['text']);
	
	if (json["token"] !== undefined) {
		let input = document.getElementById("csrf");
		input.value = json['token'];
	}
	
	if (json["text"] === "Connexion réussie") {
		M.toast({html: 'Vous êtes connecté'});
		requestNewNav(readDataNewNav);
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
	
	xhr.open("POST", "Ajax/PHP/inscription.php", true);
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
		requestFormUser(readDataFormUser, "Login");
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
	
	xhr.open("GET", "Ajax/PHP/deconnexion.php", true);
	xhr.send(null);
}

function readDataDeconnexion(oData) {
	
	let json = JSON.parse(oData);
	
	if (json["text"] === "Vous êtes déconnecté") {
		M.toast({html: 'Vous êtes déconnecté'});
		requestNewNav(readDataNewNav);
		closeModal("page")
	}
}