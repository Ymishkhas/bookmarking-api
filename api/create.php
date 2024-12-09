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
if($_SERVER['REQUEST_METHOD']!== 'POST'){
    header('Allow: POST');
    http_response_code(405);
    echo json_encode(
        array('message' => 'Method not allowed')
    );
    return;
}
// set HTTP response headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: Application/json');
header('Access-Control-Allow-Methods: POST');

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
// Get the HTTP POST request JSON body
$data = json_decode(file_get_contents('php://input'), true);
// if no title and url is included in the JSON body, return an error
if(!$data || !isset($data['user_id']) || !isset($data['title']) || !isset($data['url'])){
    http_response_code(422);
    echo json_encode(
        array('message' => 'Error missing requried parameters user_id, title and url in the JSON body')
    );
    return;
}

// Create a bookmark
$bookmark->setTitle($data['title']);
$bookmark->setUrl($data['url']);
$bookmark->setUserId($data['user_id']);
if($bookmark->create()){
    echo json_encode(
        array('message' => 'A bookmark was created')
    );
}
else{
    echo json_encode(
        array('message' => 'Error: No bookmark was created')
    );
}
