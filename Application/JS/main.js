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
            fileCss = "../stylesheets/" + componentName + "/" + componentName + ".css";
            // Créer et insère le lien pour le fichier css
            let link = document.createElement('link');
            link.rel = 'stylesheet';
            link.type = 'text/css';
            link.href = fileCss;
            head.appendChild(link);
            // Fait une requete HTTP pour importer le fichier HTML
            xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function () {
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
    let url = baseApiUrl + "/meridiens/all";
    let response = await sendRequest(url);
    console.log(response);
};
// loadPatho()


// autocomplete keywords
async function loadKeywords() {
    let url = baseApiUrl + "/keywords/all";
    let response = await sendRequest(url);
    return response;
};

function autocompleteMatch(input) {
    return loadKeywords().then((keywords) => {
        if (input == '') {
            return [];
        }
        var reg = new RegExp(input)
        return keywords.filter(function (term) {
            if (term.match(reg)) {
                return term;
            }
        });
    });
}

function showAutocomplete(val) {
    res = document.getElementById("autocompletion");
    res.innerHTML = '';
    let list = '';
    autocompleteMatch(val).then((terms) => {
        console.log(terms);
        for (i = 0; i < terms.length; i++) {
            list += '<li class="autocompleteItem" id="' + terms[i] + '">' + terms[i] + '</li>';
        }
        res.innerHTML = '<ul>' + list + '</ul>';
    });
}

async function getPathoByKeywords() {
    var keyword = document.getElementById("keywordSearch").value;
    const data = await sendRequest(baseApiUrl + '/pathologies/byKeyword/' + keyword);  // fetch('http://localhost:80/API/api.php/pathologies/byKeyword/' + keyword)
    console.log(baseApiUrl + '/pathologies/byKeyword/' + keyword);
    var patho_html = '';
    data.forEach(patho => {
        patho_html += `
                    <div class="pathologie_card">
                    <h3>${patho.desc}</h3>
                    <p class="meridien">Méridien : ${patho.mer.nom}</p>
                    <p class="symptomes_title">Symptômes<span class="chevron down" onclick="showSymptomes(this)"></span></p>
                    <ul class="sympthomes_container">
                    `
        var i = 0
        console.log(patho.symptomes);
        patho.symptomes.forEach(sympt => {
            patho_html += `
                        <li>${sympt.desc}</li>
                        `
            if (i < patho.symptomes.length - 1) {
                patho_html += '<hr>'
            }
            i += 1
        })
        patho_html += `</ul>
                        </div>`
    })
    document.getElementById("pathologies_container").innerHTML = patho_html
}

var keywordSearch = document.getElementById('keywordSearch');
// keywordSearch.onkeydown = function (e) {
//     if (e.keyCode == 13) {
//         getPathoByKeywords()
//     }
// };

keywordSearch.addEventListener("keyup", function (e) {
    console.log(keywordSearch.value);
    showAutocomplete(keywordSearch.value);
    if (e.keyCode == 13) {
        getPathoByKeywords()
    }
});


