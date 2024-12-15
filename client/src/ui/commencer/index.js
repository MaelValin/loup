import { genericRenderer } from "../../lib/utils.js"; 

const templateFile = await fetch("src/ui/commencer/template.html");
const template = await templateFile.text();


let Commencerview = {};

Commencerview.render = function(){
    return template;
}

  



export {Commencerview};