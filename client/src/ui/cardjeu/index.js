import { genericRenderer } from "../../lib/utils.js"; 

const templateFile = await fetch("src/ui/cardjeu/template.html");
const template = await templateFile.text();


let CardjeuView = {
    render: function(data) {
        let html = "";
      
        let rend = genericRenderer(template, data);
        rend = rend.replace("{{numero}}", data.numero);
        rend = rend.replace("{{titre}}", data.titre);
        rend = rend.replace("{{nom}}", data.nom);
        rend = rend.replace("{{perso}}", data.perso);
        rend = rend.replace("{{age}}", data.age);
        rend = rend.replace("{{race}}", data.race);
        rend = rend.replace("{{Personalite}}", data.personalite);
        rend= rend.replace("{{quartier}}", data.quartier);
        html = rend;
      
      return html;
    }
  };
  



export {CardjeuView};