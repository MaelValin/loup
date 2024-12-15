import { genericRenderer } from "../../lib/utils.js"; 

const templateFile = await fetch("src/ui/cardperso/template.html");
const template = await templateFile.text();


let CardpersoView = {
    render: function(data) {
        let html = "";
      
        let rend = genericRenderer(template, data);
        rend = rend.replace("{{img}}", data.img);
        rend = rend.replace("{{effet}}", data.effet);
        rend = rend.replace("{{nom}}", data.nom);
       
        html = rend;
      
      return html;
    }
  };
  



export {CardpersoView};