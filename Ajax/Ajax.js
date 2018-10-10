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
	
	alert(json['text']);
	
	if (json["token"] !== undefined) {
		let input = document.getElementById("csrf");
		input.value = json['token'];
	}
	
	if (json["text"] === "Connexion réussie") {
		document.location.href = "index.php";
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
	
	alert(json['text']);
	
	if (json["token"] !== undefined) {
		let input = document.getElementById("csrf");
		input.value = json['token'];
	}
	
	if (json["text"] === "Compte Créé") {
		requestFormUser(readDataFormUser,"Login");
		modal("page");
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
	
	alert(json["text"]);
	
	if (json["text"] === "Vous êtes déconnecté") {
		location.reload();
	}
}