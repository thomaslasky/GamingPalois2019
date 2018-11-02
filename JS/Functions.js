function navigateur() {
	
	let navigateur = document.getElementById("mySidenav");
	
	if (navigateur.style.display !== "") {
		if (navigateur.style.display === "none") {
			navigateur.style.display = "block";
		} else {
			navigateur.style.display = "none";
		}
	} else {
		navigateur.style.display = "block";
	}

// When the user clicks anywhere outside of the navigateur, close it
	window.onclick = function (event) {
		if (event.target === navigateur) {
			navigateur.style.display = "none";
		}
	}
}

function closeNavigateur() {
	let navigateur = document.getElementById('mySidenav');
	
	if (navigateur.style.display === "block") {
		navigateur.style.display = "none";
	}
}

//Fonction permettant de gérer les collapssible

function collapsible(name, id) {
	let body = document.getElementById("collaps-" + name + "-" + id);
	
	if (body.style.display !== "") {
		if (body.style.display === "none") {
			body.style.display = "block";
		} else {
			body.style.display = "none";
		}
	} else {
		body.style.display = "block";
	}
	
	let otherBody = document.querySelectorAll(".collapsible-body-" + name);
	
	otherBody.forEach(function (body) {
		if (body.id !== "collaps-" + name + "-" + id) {
			body.style.display = "none";
		}
	})
}

//Fonction permettant de gérer les modals

function modal(name) {
	// Get the modal
	let modal = document.getElementById('myModal-' + name);

// When the user clicks the button, open the modal
	
	if (modal.style.display !== "") {
		if (modal.style.display === "none") {
			modal.style.display = "block";
		} else {
			modal.style.display = "none";
		}
	} else {
		modal.style.display = "block";
	}

// When the user clicks anywhere outside of the modal, close it
	window.onclick = function (event) {
		if (event.target === modal) {
			modal.style.display = "none";
		}
	}
}

// Fermeture du modal

function closeModal(name) {
	let modal = document.getElementById('myModal-' + name);
	
	if (modal.style.display === "block") {
		modal.style.display = "none";
	}
}

//Fonction permettant de selectionner un élèment d'une liste afin de lui donner une couleur particulière

function selectedCategorie(categorie, id) {
	let background = document.getElementById("categorie-" + categorie + "-" + id);
	
	background.style.backgroundColor = "grey";
	background.style.border = "1px solid black";
	
	let otherBody = document.querySelectorAll(".categorie");
	
	otherBody.forEach(function (background) {
		if (background.id !== "categorie-" + categorie + "-" + id) {
			background.style.backgroundColor = "";
			background.style.border = "";
		}
	});
	
	return true;
}

//Fonction permettant la modification d'un input

function modifyInput(id, idInput1, idInput2) {
	
	document.getElementById("modify_" + idInput1).readOnly = false;
	document.getElementById("modify_" + idInput2).readOnly = false;
	
	let inputValide = "<input class='col s4 bottum_validation_log bottum_validation_inscription cursor-pointer' style='margin: 0;' name='Validation' value=\"Valider\" onclick='requestSendModificationProfil(readDataSendModificationProfil)' type='button'>";
	let inputAnnulation = "<input class='col s4 bottum_validation_log bottum_validation_inscription cursor-pointer' style='margin: 0;' name='Annuler' value=\"Annuler\" onclick='requestProfil(readData)' type='button'>";
	
	document.getElementById("modify_" + id).innerHTML = inputValide + inputAnnulation;
}

//Fonction d'affichage du loader

function initLoader(type, id) {
	let elem = document.getElementById("loader-" + type + "-" + id);
	
	elem.innerHTML = "<img src='Img/Icone/loader.gif' alt='loading' />";
}

//Fonction modifiant la barre de navigation admin

function modifNavAdmin(id, tableau) {
	let nav = document.getElementById(id);
	let newNav = nav.innerHTML + "<span onclick = '" + tableau[0] + "' class = 'breadcrumb cursor-pointer no-select'>" + tableau[1] + "</span>";
	
	nav.innerHTML = newNav;
}

//Remove Toast

function removeToast() {
	Materialize.Toast.removeAll();
}

//Montrer une image avant upload

function showPicture(input) {
	if (input.files && input.files[0]) {
		let reader = new FileReader();
		
		reader.onload = function (e) {
			$('#blah')
				.attr('src', e.target.result)
				.width("50%")
				.height("100%")
		};
		
		reader.readAsDataURL(input.files[0]);
	}
}