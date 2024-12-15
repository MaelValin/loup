import {getRequest, postRequest, deleteRequest} from '../lib/api-request.js';

let Joueur = {};

Joueur.save = async function(id_perso, nom, ville) {
    let data = JSON.stringify({
        id_perso: id_perso, // Vérifiez que cette variable est définie
        nom: nom,           // Vérifiez que cette variable est définie
        ville: ville         // Vérifiez que cette variable est définie
    });
    
    
    let response = await postRequest('joueur', data);
    return response;
    
}

Joueur.deleteAll = async function() {
    let response = await deleteRequest('joueur');
    return response;
}

Joueur.deleteByVille = async function(ville) {
    let data = JSON.stringify({ ville: ville });
    let response = await deleteRequest('joueur/deleteByVille', data);
    return response;
}

Joueur.fetch= async function(id){
    let data = await getRequest('joueur/'+id);
    return data;

}

Joueur.fetchAll = async function(){
    let data = await getRequest('joueur');
    return data;
}

Joueur.listall = async function(){
    let data = await getRequest('joueur?stat=listall');
    return data;
}

Joueur.list = async function(){
    let data = await getRequest('joueur?stat=list');
    return data;
}

Joueur.listimpair = async function(){
    let data = await getRequest('joueur?stat=listimpair');
    return data;
}
Joueur.listpair = async function(){
    let data = await getRequest('joueur?stat=listpair');
    return data;
}


// Exemple de méthode saveSession
 Joueur.saveSession=  async function (villes) {
    const data = {
        ville: villes
    }; // Vous envoyez la ville en tant que données JSON
    let datajson= JSON.stringify(data);
    let response = await postRequest('saveville', datajson);  // 'saveville' correspond à la route de l'API
    if (response) {
        console.log('Ville enregistrée', response);
    } else {
        console.error('Erreur lors de l\'enregistrement de la ville');
    }
}


Joueur.getVille = async function() {
    let data = await getRequest('getville');
    if (data) {
        if (data.success) {
            console.log('Ville sauvegardée :', data.ville);
        } else {
            console.log(data.message);
        }
    }
    return data;
}

Joueur.deleteVille = async function() {
    let response = await deleteRequest('deleteville');
    console.log(response);
    return response;
}


export {Joueur};
