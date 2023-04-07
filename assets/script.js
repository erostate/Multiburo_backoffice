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
    if (ress == "MR") {
        nbPlace = document.getElementById('nbPlaceSalReu');
        errorNbPlace = document.getElementById('errorNbPlaceSalReu');

        if (nbPlace.value <= 30 && nbPlace.value >= 10) {
            window.location.href='dash/purchase.php?r='+ress+'&sb='+sortBy.value+'&nbp='+nbPlace.value;
        } else {
            nbPlace.value = 10;
            errorNbPlace.setAttribute('style', 'visibility: visible;');
        }
    } else {
        if (ress == "BI") {
            nbPlace = document.getElementById('nbPlaceBurInd');
            errorNbPlace = document.getElementById('errorNbPlaceBurInd');
        } else if (ress == "OS") {
            nbPlace = document.getElementById('nbPlaceBurCol');
            errorNbPlace = document.getElementById('errorNbPlaceBurCol');
        }
    
        if (nbPlace.value <= 10 && nbPlace.value >= 1) {
            window.location.href='dash/purchase.php?r='+ress+'&sb='+sortBy.value+'&nbp='+nbPlace.value;
        } else {
            nbPlace.value = 1;
            if (ress == "BI") {
                errorNbPlace.setAttribute('style', 'visibility: visible;');
            } else if (ress == "OS") {
                errorNbPlace.setAttribute('style', 'visibility: visible;');
            }
        }
    }
}


// CHECK QUE LE NOMBRE DE PLACE EST ENTRE 1 ET 10
function checkNbPlaceCorrect(word, plan) {
    if (plan == "MR") {
        if (word.value > 30) {
            word.value = 30;
            document.getElementById('errorNbPlaceSalReu').setAttribute('style', 'visibility: visible;');
        } else if (word.value < 10) {
            document.getElementById('errorNbPlaceSalReu').setAttribute('style', 'visibility: visible;');
        } else {
            document.getElementById('errorNbPlaceSalReu').setAttribute('style', 'visibility: hidden;');
        }
    } else {
        if (word.value > 10) {
            word.value = 10;
            if (plan == "BI") {
                document.getElementById('errorNbPlaceBurInd').setAttribute('style', 'visibility: visible;');
            } else if (plan == "OS") {
                document.getElementById('errorNbPlaceBurCol').setAttribute('style', 'visibility: visible;');
            }
        } else {
            if (plan == "BI") {
                document.getElementById('errorNbPlaceBurInd').setAttribute('style', 'visibility: hidden;');
            } else if (plan == "OS") {
                document.getElementById('errorNbPlaceBurCol').setAttribute('style', 'visibility: hidden;');
            }
        }
    }
}


// CHANGEMENT DU TYPE D'ABONNEMENT (S'ABONNER)
function changeTypeSub(plan, sel) {
    if (sel.value == "day") {
        typeSub = "Journalier";
        txtPeriodAdd = "jour";
        minPeriodAdd = 1;
        maxPeriodAdd = 31;
    } else if (sel.value == "week") {
        typeSub = "Hebdomadaire";
        txtPeriodAdd = "semaine";
        minPeriodAdd = 1;
        maxPeriodAdd = 4;
    } else {
        typeSub = "Mensuel";
        txtPeriodAdd = "mois";
        minPeriodAdd = 1;
        maxPeriodAdd = 12;
    }

    confirmSub = document.getElementById('confirmSub');

    while (confirmSub.firstChild) {
        confirmSub.removeChild(confirmSub.firstChild);
    }

    if (plan == "new") {
        // Balise P : Message de confirmation
        msgConfirm = document.createElement('p');
        msgConfirm.innerText = "Vous êtes sur le point de vous abonnez de manière " + typeSub + ", êtes vous sûr ?";
        confirmSub.appendChild(msgConfirm);
        
        // Balise INPUT : Que faire?
        inpWhatDo = document.createElement('input');
        inpWhatDo.type = "hidden";
        inpWhatDo.name = "whatDo";
        inpWhatDo.value = "new";
        confirmSub.appendChild(inpWhatDo);

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
    } else {
        // Balise LABEL : Période à rajouter
        labelPeriodAdd = document.createElement('label');
        labelPeriodAdd.for = "inpPeriodAdd";
        labelPeriodAdd.innerText = "Nombre de " + txtPeriodAdd + " à augmenter";
        labelPeriodAdd.setAttribute('style', 'margin-right: 10px;');
        confirmSub.appendChild(labelPeriodAdd);
        // Balise INPUT : Période à rajouter
        inpPeriodAdd = document.createElement('input');
        inpPeriodAdd.type = "number";
        inpPeriodAdd.setAttribute('style', 'margin-top: 10px; color: white;');
        inpPeriodAdd.name = "periodAdd";
        inpPeriodAdd.value = 1;
        inpPeriodAdd.id = "inpPeriodAdd";
        inpPeriodAdd.placeholder = "Nombre de " + txtPeriodAdd + " à augmenter";
        inpPeriodAdd.min = minPeriodAdd;
        inpPeriodAdd.max = maxPeriodAdd;
        confirmSub.appendChild(inpPeriodAdd);

        // Balise P : Message de confirmation
        msgConfirm = document.createElement('p');
        msgConfirm.innerText = "Vous êtes sur le point de migrer votre abonnement en " + typeSub + ", êtes vous sûr ?";
        confirmSub.appendChild(msgConfirm);
        
        // Balise INPUT : Que faire?
        inpWhatDo = document.createElement('input');
        inpWhatDo.type = "hidden";
        inpWhatDo.name = "whatDo";
        inpWhatDo.value = "old";
        confirmSub.appendChild(inpWhatDo);

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
}