import {Perso} from "./data/perso.js";
import {Joueur} from "./data/joueur.js";
import {CardpersoView} from "./ui/cardperso/index.js";
import {Listview} from "./ui/liste/index.js";
import {Optionview} from "./ui/option/index.js";
import {Nuitview} from "./ui/nuit/index.js";
import {Zonelisteview} from "./ui/zoneliste/index.js";
import {Pastnuitview} from "./ui/pastnuit/index.js";
import { Terminerview } from "./ui/terminer/index.js";
import { Commencerview } from "./ui/commencer/index.js";

let C = {};

C.init = async function() {
    V.init();
}

let V = {
    container: document.querySelector("#container"),
    liste: document.querySelector("#liste"),
    optionselected: document.querySelector("#selectoption"),
    container_partihaut: document.querySelector("#container_partihaut"),
};

V.init = function() {
    // V.renderHeader();  // Uncomment if needed
    if (window.location.pathname.endsWith('index.html')) {
        V.renderCards();
    }

    if (window.location.pathname.endsWith('parti.html')) {
        V.rendercommencer();
        if (document.querySelector('#dynamic-form')) {
            V.addjoueur();
            V.renderoption();
        }
        
    }

    V.data();
}

V.data = async function () {
    // Placeholder for any data loading logic
}




V.renderCards = async function () {
    let person = await Perso.fetchAll();
    V.container.innerHTML = '';  // Clear container

    person.forEach(perso => {
        let cardElement = document.createElement('div');
        cardElement.innerHTML = CardpersoView.render(perso);
        V.container.appendChild(cardElement);
    });
};

V.rendercommencer = function() {
    V.container_partihaut.innerHTML = Commencerview.render();
}


let nuitCounter = 1;  // Initialiser le compteur global pour la nuit

V.rendernuit = async function(nuitCounter) {
    // Mettre à jour le contenu de la partie haute
    V.container_partihaut.innerHTML = Nuitview.render(nuitCounter);

    // Rendre la liste des zones
    V.renderzoneliste(nuitCounter);

    // Rendre les éléments du passé de la nuit
    V.renderPastnuit();

    V.renderterminer();
    // Une fois le rendu effectué, ajouter l'écouteur à #pastnuit si il existe
    const pastNuitButton = document.getElementById('pastnuit');
    if (pastNuitButton) {
        pastNuitButton.addEventListener('click', function() {
            nuitCounter++;  // Incrémenter le compteur à chaque clic
            V.rendernuit(nuitCounter);  // Appeler rendernuit avec le compteur mis à jour
        });
    }
    const terminerButton = document.getElementById('terminer');
    if (terminerButton) {
        terminerButton.addEventListener('click', async function() {
              
            
            Joueur.deleteAll();

            Joueur.deleteVille();

            V.rendercommencer();
            V.renderoption();
            V.addjoueur();






        });
    }
};

V.renderzoneliste = function(nuitCounter) {
    let zonelisteElement = document.createElement('div');
    zonelisteElement.innerHTML = Zonelisteview.render();
    V.container_partihaut.appendChild(zonelisteElement);
    
    if (document.querySelector('#liste')) {
        V.renderList(nuitCounter);
    }
}

V.renderPastnuit = function() {
    let pastnuitelement = document.createElement('div');
    pastnuitelement.innerHTML = Pastnuitview.render();
    V.container_partihaut.appendChild(pastnuitelement);
}

V.renderterminer= function() {
    let terminerelement = document.createElement('div');
    terminerelement.innerHTML = Terminerview.render();
    V.container_partihaut.appendChild(terminerelement);
}


V.renderList = async function(nuitCounter) {

    let listdata = document.querySelector('#liste');
    if(document.querySelector('#liste')){
     // Nettoyer la liste
     let datajoueur= await Joueur.list();
     let datajoueur1= await Joueur.listimpair();
        let datajoueur2= await Joueur.listpair();
    console.log(datajoueur);
    console.log(datajoueur1);
    console.log(datajoueur2);
    let joueurs;

    if (nuitCounter === 1) {
        // Charger tous les joueurs sauf ceux avec tour === -1
        joueurs = datajoueur; 
    } else if (nuitCounter % 2 !== 0) {
        joueurs = datajoueur1;  // Nuit impaire
    } else {
        joueurs = datajoueur2;  // Nuit paire
    }

    // Afficher chaque joueur
    joueurs.forEach(joueur => {
        let listElement = document.createElement('div');
        listElement.innerHTML = Listview.render(joueur);
        listdata.appendChild(listElement);

        // Gestion spéciale pour Cupidon
        if (nuitCounter === 1 && joueur.perso_nom.toLowerCase() === 'cupidon') {
            let amoureuxElement = document.createElement('div');
            amoureuxElement.innerHTML = Listview.render({ nom: 'les amoureux', joueur: '' });
            listdata.appendChild(amoureuxElement);
        }
    });}
};




V.renderoption = async function () {
    let options = await Perso.fetchAll();
    const selectOption = document.getElementById('selectoption');
    options.forEach(option => {
        let optionElement = document.createElement('option');
        optionElement.value = option.id_perso;
        optionElement.textContent = option.nom;
        selectOption.appendChild(optionElement);
    });

    document.getElementById('add-select').addEventListener('click', async function() {
        const form = document.getElementById('dynamic-form');
        const newInput = document.createElement('input');
        newInput.type = 'text';
        newInput.placeholder = 'Nom du joueur';
        newInput.className = 'p-2 border border-gray-300 rounded w-full md:w-fit';

        const newSelect = document.createElement('select');
        newSelect.className = 'p-2 border border-gray-300 rounded';

        let options = await Perso.fetchAll();
        options.forEach(option => {
            let optionElement = document.createElement('option');
            optionElement.value = option.id_perso;
            optionElement.textContent = option.nom;
            newSelect.appendChild(optionElement);
        });

        const newDiv = document.createElement('div');
        newDiv.className = 'flex gap-4 md:flex-row flex-col items-center';
        newDiv.id = 'form-joueur';
        newDiv.appendChild(newInput);
        newDiv.appendChild(newSelect);
        form.appendChild(newDiv);
    });

    document.getElementById('sup-select').addEventListener('click', function() {
        const form = document.getElementById('dynamic-form');
        if (form.lastChild) {
            form.removeChild(form.lastChild);
        }
    });
}

V.initSearch = function() {
    if (window.location.pathname.endsWith('index.html')) {
        let searchInput = document.querySelector('input[type="text"]');
        searchInput.addEventListener('input', V.handleSearch);
    }
};

V.handleSearch = async function(event) {
    let query = event.target.value.toLowerCase();
    let person = await Perso.fetchAll();
    V.container.innerHTML = '';

    person.filter(perso => {
        return perso.nom.toLowerCase().includes(query);
    }).forEach(perso => {
        let cardElement = document.createElement('div');
        cardElement.innerHTML = CardpersoView.render(perso);
        V.container.appendChild(cardElement);
    });
};

V.initSearch();


V.addjoueur = function() {
    document.getElementById('add-joueur').addEventListener('click', async function() {

        const villeInputvalue = document.getElementById('villeinput').value;
        Joueur.saveSession(villeInputvalue);




        console.log('Add joueur clicked');
        const villeInput = document.getElementById('villeinput');
        const dynamicForm = document.getElementById('dynamic-form');

        let promises = []; // Collecte des promesses
        dynamicForm.querySelectorAll('div#form-joueur').forEach(div => {
            const joueurInput = div.querySelector('input[type="text"]');
            const optionSelect = div.querySelector('select');

            // Ajouter chaque sauvegarde comme une promesse
            promises.push(Joueur.save(optionSelect.value, joueurInput.value, villeInput.value));
        });

        // Attendre que toutes les promesses soient terminées
        await Promise.all(promises);

        // Une fois les joueurs ajoutés, re-rendre la liste et réinitialiser la nuit
        await V.renderList(1);
        await V.rendernuit(1);




    });
};



// La première initialisation pour le bouton pastnuit
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM loaded');
    V.rendernuit(nuitCounter);  // Appeler la première fois rendernuit pour initialiser
});

C.init();
