import { genericRenderer } from "../../lib/utils.js"; 

const templateFile = await fetch("src/ui/zoneliste/template.html");
const template = await templateFile.text();


let Zonelisteview = {};

Zonelisteview.render = function(){
    return template;
}

  



export {Zonelisteview};