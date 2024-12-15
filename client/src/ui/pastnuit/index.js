import { genericRenderer } from "../../lib/utils.js"; 

const templateFile = await fetch("src/ui/pastnuit/template.html");
const template = await templateFile.text();


let Pastnuitview = {};

Pastnuitview.render = function(){
    return template;
}

  



export {Pastnuitview};