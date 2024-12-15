import { genericRenderer } from "../../lib/utils.js"; 

const templateFile = await fetch("src/ui/option/template.html");
const template = await templateFile.text();


let Optionview = {
    render: function(data) {
        let html = "";
      
        let rend = genericRenderer(template, data);
        rend = rend.replace("{{nom}}", data.nom);
        rend = rend.replace("{{id_perso}}", data.id_perso);
        html = rend;
      
      return html;
    }
  };
  



export {Optionview};