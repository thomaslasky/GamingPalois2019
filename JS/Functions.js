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

function colorTop(id) {
    let $topResult = document.getElementById('topBR-' + id);
    let topResult = $topResult.innerHTML;

    if (topResult <= 5) {
        $topResult.style.color = "green";
    } else if (topResult > 5 && topResult <= 10) {
        $topResult.style.color = "orange";
    } else if (topResult > 10) {
        $topResult.style.color = "red";
    }
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

function selectedGame(idEvent, idGame) {
    let background = document.getElementById("game-" + idEvent + "-" + idGame);

    background.style.backgroundColor = "grey";
    background.style.border = "1px solid black";
    background.style.borderBottom = "none";

    let otherBody = document.querySelectorAll(".game_number");

    otherBody.forEach(function (background) {
        if (background.id !== "game-" + idEvent + "-" + idGame) {
            background.style.backgroundColor = "";
            background.style.border = "";
        }
    });

    return true;
}