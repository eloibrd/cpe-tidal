<?php

// import des middlewares
include 'DatabaseDriver.php';
$dbd = new DatabaseDriver;


function _authentificationError()
{
    // header('WWW-Authenticate: Basic realm="My Realm"');
    header('HTTP/1.0 401 Unauthorized');
    exit;
}

// if (!$_SESSION) {
//     if (isset($_SERVER['PHP_AUTH_USER'])) {
//         // the user is authenticated and handle the rest api call here
//         $db_pass = $dbd->getUserPassword($_SERVER['PHP_AUTH_USER']);
//         if (empty($db_pass)) {
//             echo 'User not found';
//             _authentificationError();
//         } else if (!password_verify($_SERVER['PHP_AUTH_PW'], $db_pass[0]['password'])) {
//             echo 'Wrong password for user ' . $_SERVER['PHP_AUTH_USER'];
//             _authentificationError();
//         }
//     } else {
//         echo 'Please authenticate';
//         _authentificationError();
//     }
// }


// get the HTTP method, path and body of the request
$method = $_SERVER['REQUEST_METHOD'];
$request = explode('/', trim($_SERVER['PATH_INFO'], '/'));
$input = json_decode(file_get_contents('php://input'), true);

// on ne supporte que les requetes GET
if ($method != 'GET') {
    echo ('error : only GET supported');
    http_response_code(405);
    exit();
}

// traiter requête
if (array_key_exists(1, $request)) {
    switch ($request[0]) {
        case 'meridiens':
            // routes : /meridiens/all
            if (array_key_exists(1, $request) && $request[1] == 'all') {
                $data = $dbd->getAllMeridien();
                header('Content-Type: application/json');
                echo json_encode($data);
                break;
            }
            http_response_code(400);
            exit();
        case 'symptomes':
            // routes : /symptomes/all
            if (array_key_exists(1, $request) && $request[1] == 'all') {
                $data = $dbd->getAllSymptomes();
                header('Content-Type: application/json');
                echo json_encode($data);
                break;
            }
            http_response_code(400);
            exit();
        case 'keywords':
            // routes : /keywords/all
            if (array_key_exists(1, $request) && $request[1] == 'all') {
                $data = $dbd->getAllKeywords();
                header('Content-Type: application/json');
                echo json_encode($data);
                break;
            }
            http_response_code(400);
            exit();
        case 'pathologies':
            // routes : /pathologies/all
            //          /pathologies/byKeyword/:keyword
            if (array_key_exists(1, $request)) {
                if ($request[1] == 'all') {
                    $data = $dbd->getAllPatho();
                    header('Content-Type: application/json');
                    echo json_encode($data);
                    break;
                } elseif ($request[1] == 'byKeyword' && array_key_exists(2, $request)) {
                    $data = $dbd->getPathosByKeyWord($request[2]);
                    header('Content-Type: application/json');
                    echo json_encode($data);
                    break;
                }
            }
            http_response_code(400);
            exit();

        default:
            http_response_code(404);
            exit();
    }
} else {
    http_response_code(400);
    exit();
}

http_response_code(200);
