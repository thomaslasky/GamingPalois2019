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
	
	xhr.open("GET", "Ajax/PHP/Formulaire.php?type=" + type, true);
	xhr.send(null);
}

function readDataFormUser(oData) {
	document.getElementById("index_form").innerHTML = oData;
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
	
	xhr.open("POST", "Ajax/PHP/Login.php", true);
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
		document.location.href = "Accueil.php";
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
	
	xhr.open("POST", "Ajax/PHP/Inscription.php", true);
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
		document.location.href = "index.php";
	}
}