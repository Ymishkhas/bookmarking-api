<?php
// Handle preflight request (OPTIONS)
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    header('Access-Control-Allow-Origin: *');  // Allow any origin, or specify a domain like 'http://localhost:5173'
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');  // Allow GET, POST, and OPTIONS
    header('Access-Control-Allow-Headers: Authorization, Content-Type');  // Allow specific headers
    http_response_code(200);  // Return OK response for OPTIONS request
    exit;
}

// check HTTP request method
if($_SERVER['REQUEST_METHOD']!== 'GET'){
    header('Allow: GET');
    http_response_code(405);
    echo json_encode(
        array('message' => 'Method not allowed')
    );
    return;
}
// set HTTP response headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: Application/json');
header('Access-Control-Allow-Methods: GET');

// Check the authorizatoin header
$headers = getallheaders();
if(!isset($headers['Authorization'])){
    http_response_code(401);
    echo json_encode(
        array('message' => 'Error missing authorization header')
    );
    return;
}
$api_key = str_replace('Bearer ', '', $headers['Authorization']);

// Validate the api key
$API_SERVER_KEY = getenv('API_SERVER_KEY');
if($api_key !== $API_SERVER_KEY){
    http_response_code(403);
    echo json_encode(
        array('message'=> 'Error invalid API key')
    );
    return;
}

include_once '../db/Database.php';
include_once '../models/Bookmark.php';

// Instantiate a Database object and connect
$database = new Database();
$dbConnection = $database->connect();
// Instantiate a Bookmark object
$bookmark = new Bookmark($dbConnection);

// Get the HTTP GET request query parameter (e.g. ?id=14&&user_id='adfagagda')
if(!isset($_GET['id']) || !isset($_GET['user_id'])){
    http_response_code(422);
    echo json_encode(
        value: array('message' => 'Error missing requried query parameter id and user_id.')
    );
    return;
}

// Read Bookmark details
$bookmark->setId($_GET['id']);
$bookmark->setUserId($_GET['user_id']);
if($bookmark->readOne()){
    $result = array(
        'id' => $bookmark->getId(),
        'user_id' => $bookmark->getUserId(),
        'title' => $bookmark->getTitle(),
        'url' => $bookmark->getUrl(),
        'clicks_count' => $bookmark->getClicksCount(),
        'dateAdded' => $bookmark->getDateAdded(),
    );
    echo json_encode($result);
}
else {
    http_response_code(404);
    echo json_encode(
        array('message' => 'Error: No such bookmark')
    );
}