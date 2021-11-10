import apiRequest from "./api_request.js";

function includeComponent() {
    // Trouver le "head" pour y insérer les link css
    let head = document.querySelector("head");
    // Trouver tout les components et boucler à travers
    let components = document.querySelectorAll("component");
    for (let component of components) {
        // Trouver le nom des components
        let componentName = component.getAttribute("name");
        if (componentName) {
            // Nom des fichiers à importer
            fileHTML = "../components/" + componentName + "/" + componentName + ".html";
            fileCss = "../stylesheets/" +componentName + "/" + componentName + ".css";
            // Créer et insère le lien pour le fichier css
            let link = document.createElement('link');
            link.rel = 'stylesheet';
            link.type = 'text/css';
            link.href = fileCss;
            head.appendChild(link);
                // Fait une requete HTTP pour importer le fichier HTML
            xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4) {
                    if (this.status == 200) {
                        component.innerHTML = this.responseText;
                    }
                    if (this.status == 404) {
                        component.innerHTML = "Page not found.";
                    }
                    /*remove the attribute, and call this function once more:*/
                    component.removeAttribute("w3-include-html");
                    // Loop
                    // includeComponent();
                }
            }
            xhttp.open("GET", fileHTML, true);
            xhttp.send();
        }
    }
};

includeComponent();

function showSymptomes(chevron) {
    chevron.classList.toggle('up');
    chevron.classList.toggle('down');
    sympthomesContainer = chevron.parentNode.parentNode.lastElementChild;
    if (chevron.classList.contains('up')) sympthomesContainer.style.display = "block";
    else sympthomesContainer.style.display = "none";
}

async function loadPatho() {
    // Trouver le conteneur des pathologies pour y insérer les pathologies
    let pathologiesContainer = document.querySelector(".pathologies_container");
    // console.log(pathologiesContainer);
    let url = apiRequest.baseApiUrl + "/meridiens/all";
    let response = await apiRequest.sendRequest(url);
    console.log(response);
};
// loadPatho()


// autocomplete keywords
async function loadKeywords() {
    let url = apiRequest.baseApiUrl + "/keywords/all";
    let response = await apiRequest.sendRequest(url);
    return response;
};
var keywords = loadKeywords();

function autocompleteMatch(input) {
    if (input == '') {
      return [];
    }
    var reg = new RegExp(input)
    return keywords.filter(function(term) {
        if (term.match(reg)) {
          return term;
        }
    });
  }
   
  function showResults(val) {
    res = document.getElementById("result");
    res.innerHTML = '';
    let list = '';
    let terms = autocompleteMatch(val);
    for (i=0; i<terms.length; i++) {
      list += '<li>' + terms[i] + '</li>';
    }
    res.innerHTML = '<ul>' + list + '</ul>';
  }
