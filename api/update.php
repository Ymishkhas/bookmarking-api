<?php
// check HTTP request method
if($_SERVER['REQUEST_METHOD']!== 'PUT'){
    header('Allow: PUT');
    http_response_code(405);
    echo json_encode(
        array('message' => 'Method not allowed')
    );
    return;
}
// set HTTP response headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: Application/json');
header('Access-Control-Allow-Methods: PUT');

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

// Get the HTTP PUT request JSON body
$data = json_decode(file_get_contents('php://input'));

if(!$data || !$data->id || !$data->title || !$data->url){
    http_response_code(422);
    echo json_encode(
        value: array('message' => 'Error missing requried parameters id, title, and url in the JSON body')
    );
    return;
}

// Update the bookmark
$bookmark->setId($data->id);
$bookmark->setUserId($token);
$bookmark->setTitle($data->title);
$bookmark->setUrl($data->url);
if($bookmark->update()){
    echo json_encode(
        array('message' => 'The bookmark was updated')
    );
}
else {
    echo json_encode(
        array('message'=> 'The bookmark was not updated')
    );
}
