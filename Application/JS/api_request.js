async function sendRequest(req) {
    let res = await fetch(req)
        .then((response) => response.json())
        .then((data) => {
            return data;
        });
    return res;
}

var baseApiUrl = 'http://192.168.25.20/API/api.php';

export default {
    sendRequest,
    baseApiUrl,
};
