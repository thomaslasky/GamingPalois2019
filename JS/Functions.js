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

function closeModal(name) {
    let modal = document.getElementById('myModal-' + name);

    if (modal.style.display === "block") {
        modal.style.display = "none";
    }
}

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