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




export {Joueur};
