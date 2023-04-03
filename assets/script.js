// CHANGER L'AFFICHAGE DES PRIX DU PLAN
function changeSortPlan(sel) {
    priceBurInd = document.getElementById('priceBurInd');
    priceBurCol = document.getElementById('priceBurCol');
    priceSalReu = document.getElementById('priceSalReu');

    if (sel.value == 'day') {
        priceBurInd.innerHTML = 'à partir de 15€/jour';
        priceBurCol.innerHTML = 'à partir de 15€/jour';
        priceSalReu.innerHTML = 'à partir de 25€/jour';
    } else if (sel.value == 'week') {
        priceBurInd.innerHTML = 'à partir de 100€/semaine';
        priceBurCol.innerHTML = 'à partir de 100€/semaine';
        priceSalReu.innerHTML = 'à partir de 175€/semaine';
    } else {
        priceBurInd.innerHTML = 'à partir de 400€/mois';
        priceBurCol.innerHTML = 'à partir de 400€/mois';
        priceSalReu.innerHTML = 'à partir de 700€/mois';
    }
}


// ACHAT D'UN PLAN
function buyPlan(ress) {
    sortBy = document.getElementById('sortBy');
    ress = ress.toUpperCase();
    if (ress == "BI") {
        nbPlace = document.getElementById('nbPlaceBurInd');
        errorNbPlace = document.getElementById('errorNbPlaceBurInd');
    }

    if (nbPlace.value <= 10 && nbPlace.value >= 1) {
        window.location.href='dash/purchase.php?r='+ress+'&sb='+sortBy.value+'&nbp='+nbPlace.value;
    } else {
        nbPlace.value = 1;
        if (ress == "BI") {
            errorNbPlace.setAttribute('style', 'visibility: visible;');
        }
    }
}


// CHECK QUE LE NOMBRE DE PLACE EST ENTRE 1 ET 10
function checkNbPlaceCorrect(word, plan) {
    if (word.value > 10) {
        word.value = 10;
        if (plan == "BI") {
            document.getElementById('errorNbPlaceBurInd').setAttribute('style', 'visibility: visible;');
        }
    }
}


// CHANGER LES EXTRAS
function editExtras2(type, act) {
    nbExtrasPc = document.getElementById('nbExtrasPc');
    inpExtrasPc = document.getElementById('inpExtrasPc');
    nbExtrasPlPark = document.getElementById('nbExtrasPlPark');
    inpExtrasPlPark = document.getElementById('inpExtrasPlPark');

    // Si c'est un PC
    if (type == "pc") {
        // Si "ajouter" sinon "retirer"
        if (act == "add") {
            // Ne pas choisir plus de ressource que disponible
            if (inpExtrasPc.value < inpExtrasPc.max) {
                nbExtrasPc.innerHTML = Number(inpExtrasPc.value) + 1;
                inpExtrasPc.value = Number(inpExtrasPc.value) + 1;
            }
        } else {
            // Ne pas descendre en dessous de 0
            if (inpExtrasPc.value > 0) {
                nbExtrasPc.innerHTML = Number(inpExtrasPc.value) - 1;
                inpExtrasPc.value = Number(inpExtrasPc.value) - 1;
            }
        }
    // Sinon (Place de parking)
    } else {
        // Si "ajouter" sinon "retirer"
        if (act == "add") {
            // Ne pas choisir plus de ressource que disponible
            if (inpExtrasPlPark.value < inpExtrasPlPark.max) {
                nbExtrasPlPark.innerHTML = Number(inpExtrasPlPark.value) + 1;
                inpExtrasPlPark.value = Number(inpExtrasPlPark.value) + 1;
            }
        } else {
            // Ne pas descendre en dessous de 0
            if (inpExtrasPlPark.value > 0) {
                nbExtrasPlPark.innerHTML = Number(inpExtrasPlPark.value) - 1;
                inpExtrasPlPark.value = Number(inpExtrasPlPark.value) - 1;
            }
        }
    }
}


// CHANGEMENT DU TYPE D'ABONNEMENT (S'ABONNER)
function changeTypeSub(sel) {
    if (sel.value == "day") {
        typeSub = "Journalier";
    } else if (sel.value == "week") {
        typeSub = "Hebdomadaire";
    } else {
        typeSub = "Mensuel";
    }

    confirmSub = document.getElementById('confirmSub');

    // Balise P : Message de confirmation
    msgConfirm = document.createElement('p');
    msgConfirm.innerText = "Vous êtes sur le point de vous abonnez de manière " + typeSub + ", êtes vous sûr ?";
    confirmSub.appendChild(msgConfirm);

    // Balise DIV : Container des buttons
    containerBtn = document.createElement('div');
    confirmSub.appendChild(containerBtn);

    // Balise BUTTON : Button YES
    btnYes = document.createElement('button');
    btnYes.classList.add("btn");
    btnYes.type = "submit";
    btnYes.innerText = "Oui";
    containerBtn.appendChild(btnYes);

    // Balise BUTTON : Button NO
    btnNo = document.createElement('button');
    btnNo.classList.add("btn");
    btnNo.type = "button";
    btnNo.innerText = "Non";
    btnNo.onclick = function() {
        window.location.href='../index.php#plan-sect';
    }
    containerBtn.appendChild(btnNo);
}