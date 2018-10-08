let xhr = getXMLHttpRequest();

/*
Apparition du formulaire de Création de compte
 */

function requestFormCreate(callback) {

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && (xhr.status === 200 || xhr.status === 0)) {
            callback(xhr.responseText);
        }
    };

    xhr.open("GET", "Ajax/PHP/CreateAccount.php", true);
    xhr.send(null);
}

function readDataFormCreate(oData) {
    document.getElementById("output").innerHTML = oData;
}

/*
Apparition du formulaire d'ajout de résultats
 */

function requestFormEvent(callback) {

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && (xhr.status === 200 || xhr.status === 0)) {
            callback(xhr.responseText);
        }
    };

    modal("modify");

    xhr.open("GET", "Ajax/PHP/CreateResult.php", true);
    xhr.send(null);
}

function readDataFormEvent(oData) {
    document.getElementById("modal").innerHTML = oData;
}

/*
Apparition du formulaire de modification d'évent
 */

function requestFormModifyEvent(callback, id) {

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && (xhr.status === 200 || xhr.status === 0)) {
            callback(xhr.responseText);
        }
    };

    modal("modify");

    xhr.open("GET", "Ajax/PHP/ModifyEvent.php?id=" + id, true);
    xhr.send(null);
}

function readDataFormModifyEvent(oData) {
    document.getElementById("modal").innerHTML = oData;
}

/*
Apparition du formulaire d'ajout de game
 */

function requestFormGame(callback, id) {

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && (xhr.status === 200 || xhr.status === 0)) {
            callback(xhr.responseText);
        }
    };

    modal("modify");

    xhr.open("GET", "Ajax/PHP/CreateGame.php?id=" + id, true);
    xhr.send(null);
}

function readDataFormGame(oData) {
    document.getElementById("modal").innerHTML = oData;
}

/*
Apparition du formulaire de modification de game
 */

function requestFormModifyGame(callback, id) {

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && (xhr.status === 200 || xhr.status === 0)) {
            callback(xhr.responseText);
        }
    };

    modal("modify");

    xhr.open("GET", "Ajax/PHP/ModifyGame.php?id=" + id, true);
    xhr.send(null);
}

function readDataFormModifyGame(oData) {
    document.getElementById("modal").innerHTML = oData;
}

/*
Apparition des résultats
*/

function requestAllEvents(callback) {
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && (xhr.status === 200 || xhr.status === 0)) {
            console.log(xhr);
            callback(xhr.responseText);
        }
    };

    xhr.open("GET", "Ajax/PHP/ShowResults.php", true);
    xhr.send(null);
}

function readAllEvents(oData) {
    document.getElementById("output").innerHTML = oData;
}

/*
Apparition de la game selectionné
 */

function requestSelectGame(callback, idevent, number) {
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && (xhr.status === 200 || xhr.status === 0)) {
            console.log(xhr);
            callback(xhr.responseText, idevent);
        }
    };

    xhr.open("GET", "Ajax/PHP/ShowResultsGame.php?idevent=" + idevent + "&number=" + number, true);
    xhr.send(null);
}

function readSelectGame(oData, id) {
    document.getElementById("gameInfo-" + id).innerHTML = oData;
}

/*
Envoi des données du nouveau compte créé
 */

function requestSendFormCreate(callback) {

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && (xhr.status === 200 || xhr.status === 0)) {
            callback(xhr.responseText);
        }
    };

    var Statut = encodeURIComponent(document.getElementById("statut").value);
    var Pseudo = encodeURIComponent(document.getElementById("pseudo").value);
    var Password = encodeURIComponent(document.getElementById("password").value);
    var csrf = encodeURIComponent(document.getElementById("csrf").value);

    xhr.open("POST", "Ajax/PHP/SendDataCreate.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send("Statut=" + Statut + "&Pseudo=" + Pseudo + "&Password=" + Password + "&csrf=" + csrf);
}

function readDataSendUser(oData) {
    alert(oData);
    document.location.href = "Accueil.php";
}

/*
Envoi des données de resultat
 */

function requestSendFormEvent(callback) {
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && (xhr.status === 200 || xhr.status === 0)) {
            callback(xhr.responseText);
        }
    };

    let Name = encodeURIComponent(document.getElementById("name").value);
    let Organizer = encodeURIComponent(document.getElementById("organizer").value);
    let Type = encodeURIComponent(document.getElementById("type").value);
    let Date = encodeURIComponent(document.getElementById("date").value);
    let Top = encodeURIComponent(document.getElementById("top").value);
    let Captain = encodeURIComponent(document.getElementById("captain").value);
    let Player1 = encodeURIComponent(document.getElementById("player1").value);
    let Player2 = encodeURIComponent(document.getElementById("player2").value);
    let Player3 = encodeURIComponent(document.getElementById("player3").value);
    let Sub1 = encodeURIComponent(document.getElementById("sub1").value);
    let Sub2 = encodeURIComponent(document.getElementById("sub2").value);
    let csrf = encodeURIComponent(document.getElementById("csrf").value);

    xhr.open("POST", "Ajax/PHP/SendDataEvent.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send("Name=" + Name + "&Organizer=" + Organizer + "&Type=" + Type + "&Date=" + Date + "&Top=" + Top + "&Captain=" + Captain + "&Player1=" + Player1 + "&Player2=" + Player2 + "&Player3=" + Player3 + "&Sub1=" + Sub1 + "&Sub2=" + Sub2 + "&csrf=" + csrf);
}

function readDataSendEvent(oData) {
    let json = JSON.parse(oData);

    alert(json['text']);

    if (json["token"] !== undefined) {
        let input = document.getElementById("csrf");
        input.value = json['token'];
    }

    if (json["text"] === "Résultat Ajouté") {
        closeModal("modify");
        requestAllEvents(readAllEvents);
    }
}

/*
Suppression d'évènement
 */

function requestDeleteEvent(callback, id) {
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && (xhr.status === 200 || xhr.status === 0)) {
            callback(xhr.responseText);
        }
    };

    if (confirm("Voulez-vous vraiment supprimer cet évènement ? (action irrévocable)")) {
        xhr.open("POST", "Ajax/PHP/DeleteEvent.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.send("ID=" + id);
    }
}

function readDataDeleteEvent(oData) {
    let json = JSON.parse(oData);

    if (json["text"] === "Evènement supprimé avec succès") {
        requestAllEvents(readAllEvents);
    } else {
        alert(json['text']);
    }
}

/*
Suppression de game
 */

function requestDeleteGame(callback, id) {
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && (xhr.status === 200 || xhr.status === 0)) {
            callback(xhr.responseText);
        }
    };

    if (confirm("Voulez-vous vraiment supprimer cette game ? (action irrévocable)")) {
        xhr.open("POST", "Ajax/PHP/DeleteGame.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.send("ID=" + id);
    }
}

function readDataDeleteGame(oData) {
    let json = JSON.parse(oData);

    if (json["text"] === "Game supprimé avec succès") {
        requestAllEvents(readAllEvents);
    } else {
        alert(json['text']);
    }
}

/*
UPDATE d'évènement
 */

function requestUpdateEvent(callback) {
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && (xhr.status === 200 || xhr.status === 0)) {
            callback(xhr.responseText);
        }
    };

    let id = encodeURIComponent(document.getElementById("id").value);
    let Name = encodeURIComponent(document.getElementById("name").value);
    //let Organizer = encodeURIComponent(document.getElementById("organizer").value);
    //let Type = encodeURIComponent(document.getElementById("type").value);
    let Date = encodeURIComponent(document.getElementById("date").value);
    let Top = encodeURIComponent(document.getElementById("top").value);
    let Captain = encodeURIComponent(document.getElementById("captain").value);
    let Player1 = encodeURIComponent(document.getElementById("player1").value);
    let Player2 = encodeURIComponent(document.getElementById("player2").value);
    let Player3 = encodeURIComponent(document.getElementById("player3").value);
    let Sub1 = encodeURIComponent(document.getElementById("sub1").value);
    let Sub2 = encodeURIComponent(document.getElementById("sub2").value);
    let csrf = encodeURIComponent(document.getElementById("csrf").value);

    if (confirm("Modifier l'évènement ?")) {
        xhr.open("POST", "Ajax/PHP/SendDataUpdateEvent.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.send("ID=" + id + "&Name=" + Name + "&Date=" + Date + "&Top=" + Top + "&Captain=" + Captain + "&Player1=" + Player1 + "&Player2=" + Player2 + "&Player3=" + Player3 + "&Sub1=" + Sub1 + "&Sub2=" + Sub2 + "&csrf=" + csrf);
    }
}

function readDataUpdateEvent(oData) {
    let json = JSON.parse(oData);
    alert(json['text']);

    if (json["token"] !== undefined) {
        let input = document.getElementById("csrf");
        input.value = json['token'];
    }

    if (json["text"] === "Résultat modifié") {
        //document.location.href = "Accueil.php";
        closeModal("modify");
        requestAllEvents(readAllEvents);
    }

}

/*
UPDATE de game
 */

function requestUpdateGame(callback) {
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && (xhr.status === 200 || xhr.status === 0)) {
            callback(xhr.responseText);
        }
    };

    let formData = new FormData(document.getElementById("modifyGame"));

    xhr.open("POST", "Ajax/PHP/SendDataUpdateGame.php", true);
    xhr.send(formData);
}

function readDataUpdateGame(oData) {

    let json = JSON.parse(oData);

    alert(json['text']);

    if (json["token"] !== undefined) {
        let input = document.getElementById("csrf");
        input.value = json['token'];
    }

    if (json["text"] === "Game modifié") {
        closeModal("modify");
        requestAllEvents(readAllEvents);
    }
}

/*
Envoi de données de game
 */

function requestCreateGame(callback) {
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && (xhr.status === 200 || xhr.status === 0)) {
            callback(xhr.responseText);
        }
    };

    let formData = new FormData(document.getElementById("formGame"));

    xhr.open("POST", "Ajax/PHP/SendDataGame.php", true);
    xhr.send(formData);
}

function readDataCreateGame(oData) {

    let json = JSON.parse(oData);

    alert(json['text']);

    if (json["token"] !== undefined) {
        let input = document.getElementById("csrf");
        input.value = json['token'];
    }

    if (json["text"] === "Game ajouté") {
        closeModal("modify");
        requestAllEvents(readAllEvents);
    }
}