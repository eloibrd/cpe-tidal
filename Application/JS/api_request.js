async function sendRequest(req) {
    let res = await fetch(req)
        .then((response) => response.json())
        .then((data) => {
            return data;
        });
    return res;
}

let currentUrl = window.location.href.replace('Application/pages/home.php', '')
var baseApiUrl = currentUrl + 'API/api.php';

console.log(baseApiUrl)
