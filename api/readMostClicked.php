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
    http_response_code(403);
    echo json_encode(
        value: array('message' => 'Error missing authorization header')
    );
    return;
}
$token = str_replace('Bearer ', '', $headers['Authorization']);

include_once '../db/Database.php';
include_once '../models/Bookmark.php';

// Instantiate a Database object and connect
$database = new Database();
$dbConnection = $database->connect();
// Instantiate a Bookmark object
$bookmark = new Bookmark($dbConnection);

// Read the 10 most clicked bookmarks
$bookmark->setUserId($token);
$result = $bookmark->readMostClicked();
if(!empty($result)){
    echo json_encode($result);
}
else {
    echo json_encode(
        array('message' => 'No bookmarks where found')
    );
}