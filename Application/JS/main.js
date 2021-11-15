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
            let fileHTML = "../components/" + componentName + "/" + componentName + ".html";
            let fileCss = "../stylesheets/" + componentName + "/" + componentName + ".css";
            // Créer et insère le lien pour le fichier css
            let link = document.createElement('link');
            link.rel = 'stylesheet';
            link.type = 'text/css';
            link.href = fileCss;
            head.appendChild(link);
            // Fait une requete HTTP pour importer le fichier HTML
            let xhttp = new XMLHttpRequest();
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
    let url = baseApiUrl + "/pathologies/all";
    let response = await sendRequest(url);
    response.forEach(patho => {
        let pathoCard = document.createElement('div')
        pathoCard.className = 'pathologie_card'
        // Titre
        let pathoTitle = document.createElement('h3')
        pathoTitle.innerText = patho.desc.charAt(0).toUpperCase() + patho.desc.slice(1)
        pathoCard.appendChild(pathoTitle)
        // Méridien
        let pathoMer = document.createElement('p')
        pathoMer.className = 'meridien'
        pathoMer.innerText = 'Méridien : ' + patho.mer.nom
        pathoCard.appendChild(pathoMer)

        // Titre "symptôme"avec le chevron
        let pathoSympTitle = document.createElement('p')
        pathoSympTitle.className = 'symptomes_title'
        pathoSympTitle.innerText = 'Symptômes'
        let pathoSympChevron = document.createElement('span')
        pathoSympChevron.className = 'chevron down'
        pathoSympChevron.addEventListener('click', (e) => showSymptomes(e.target))
        pathoSympTitle.appendChild(pathoSympChevron)
        pathoCard.appendChild(pathoSympTitle)

        // Symptômes
        let pathoSymps = document.createElement('ul')
        pathoSymps.className = 'sympthomes_container'
        patho.symptomes.forEach((symp, index) => {
            let li = document.createElement('li')
            li.innerText = symp.desc
            pathoSymps.appendChild(li)
            if (index < patho.symptomes.length - 1) pathoSymps.appendChild(document.createElement('hr'))
        });
        pathoCard.appendChild(pathoSymps)

        pathologiesContainer.appendChild(pathoCard)
    });
};
loadPatho()

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
        }).slice(0,10);
    });
}

let res = document.getElementById("autocompletion");

function showAutocomplete(val) {
    res.innerHTML = ''

    autocompleteMatch(val).then((terms) => {
        for (i = 0; i < terms.length; i++) {
            let li = document.createElement('li')
            li.className = 'autocompleteItem'
            li.addEventListener('click', (e) => appendSearchAutocomplete(e.target.id))
            li.id = terms[i]
            li.innerText = terms[i].charAt(0).toUpperCase() + terms[i].slice(1)
            res.appendChild(li)
        }
        if(terms.length > 0) res.style.display = 'initial'
        else res.style.display = 'none'
    });

}

async function getPathoByKeywords() {
    var keyword = document.getElementById("keywordSearch").value;
    const data = await sendRequest(baseApiUrl + '/pathologies/byKeyword/' + keyword);  // fetch('http://localhost:80/API/api.php/pathologies/byKeyword/' + keyword)
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

keywordSearch.addEventListener("keyup", function (e) {
    showAutocomplete(keywordSearch.value);
    if (e.keyCode == 13) {
        getPathoByKeywords()
    }
});

function appendSearchAutocomplete(suggestion) {
    var keywordSearch = document.getElementById('keywordSearch');
    keywordSearch.value = suggestion;
}

// document.querySelector('.form_input').addEventListener('focusout', (e) => {
//     res.style.display = 'none'
// })
// document.querySelector('.form_input').addEventListener('focusin', (e) => {
//     res.style.display = 'initial'
// })