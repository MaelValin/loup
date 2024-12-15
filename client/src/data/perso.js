import {getRequest} from '../lib/api-request.js';

let Perso = {};

Perso.fetch= async function(id){
    let data = await getRequest('perso/'+id);
    return data;

}

Perso.fetchAll = async function(){
    let data = await getRequest('perso');
    return data;
}

Perso.list = async function(){
    let data = await getRequest('perso?stat=list');
    return data;
}



export {Perso};
