import { genericRenderer } from "../../lib/utils.js"; 

const templateFile = await fetch("src/ui/nuit/template.html");
const template = await templateFile.text();


let Nuitview = {
    render: function(data) {
        let html = "";
      
        let rend = genericRenderer(template, data);
        rend = rend.replace("{{nuit}}", data);
        html = rend;
      
      return html;
    }
  };

  



export {Nuitview};