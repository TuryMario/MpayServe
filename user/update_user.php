<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// include database and object files
include_once '../config/DB.php';
include_once '../objects/user.php';

// get database connection
$database = new DB();
$db = $database->DBConnection();

// prepare product object
$user = new User($db);

// get AccountNumber of product to be edited
$data = json_decode(file_get_contents("php://input"));

// set ID property of account to be edited
$user->UserName = $data->UserName;

// set account property values
$user->FirstName = $data->FirstName;
$user->LastName = $data->LastName;

// update the user
if($user->update_user()){

    // set response code - 200 ok
    http_response_code(200);

    // tell the user
    echo json_encode(array("message" => "User was updated."));
}

// if unable to update the account, tell the user
else{

    // set response code - 503 service unavailable
    http_response_code(503);

    // tell the user
    echo json_encode(array("message" => "Unable to update User."));
}
?>
