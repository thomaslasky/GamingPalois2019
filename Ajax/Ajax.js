let xhr = getXMLHttpRequest();

/*
Affichage Formulaire Login
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