import { genericRenderer } from "../../lib/utils.js"; 

const templateFile = await fetch("src/ui/liste/template.html");
const template = await templateFile.text();


let Listview = {
    render: function(data) {
        let html = "";
      
        let rend = genericRenderer(template, data);
        rend = rend.replace("{{nom}}", data.perso_nom);
        rend = rend.replace("{{joueur}}", data.joueur_nom);
        html = rend;
      
      return html;
    }
  };
  



export {Listview};