<?php
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

// Get the HTTP GET request query parameter (e.g. ?user_id='gfdsgsgag')
if(!isset($_GET['user_id'])){
    http_response_code(422);
    echo json_encode(
        value: array('message' => 'Error missing requried query parameter user_id.')
    );
    return;
}

// Read all user bookmarks
$bookmark->setUserId($_GET['user_id']);
$result = $bookmark->readAll();
if(!empty($result)){
    echo json_encode($result);
}
else {
    echo json_encode(
        array('message' => 'No bookmarks where found')
    );
}