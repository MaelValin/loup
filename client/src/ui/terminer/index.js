import { genericRenderer } from "../../lib/utils.js"; 

const templateFile = await fetch("src/ui/terminer/template.html");
const template = await templateFile.text();


let Terminerview = {};

Terminerview.render = function(){
    return template;
}

  



export {Terminerview};