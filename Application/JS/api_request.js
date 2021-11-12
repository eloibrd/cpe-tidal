async function sendRequest(req) {
    let res = await fetch(req)
        .then((response) => response.json())
        .then((data) => {
            return data;
        });
    return res;
}

let curruntUrl = window.location.href.replace('Application/pages/home.php','')
var baseApiUrl = curruntUrl + 'API/api.php';

console.log(baseApiUrl)
