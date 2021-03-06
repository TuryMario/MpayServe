<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// get database connection
include_once '../config/DB.php';

// instantiate user object
include_once '../objects/user.php';

$database = new DB();
$db = $database->DBConnection();

$user = new User($db);

// get posted data
$data = json_decode(file_get_contents("php://input"));

// make sure data is not empty
if(
    !empty($data->FirstName)&&
    !empty($data->LastName)&&
    !empty($data->Email)&&
    !empty($data->AccountType)&&
    !empty($data->Mobile)&&
    !empty($data->AccountNumber)&&
    !empty($data->UserId)
){

    // set product property values
    
    $user->FirstName = $data->FirstName;
    $user->LastName = $data->LastName;
    $user->Email = $data->Email;
    $user->AccountType = $data->AccountType;
    $user->Mobile = $data->Mobile;
    $user->AccountNumber = $data->AccountNumber;
    $user->UserId = $data->UserId;

    // create the product
    if($user->create_user()){

        // set response code - 201 created
        http_response_code(201);

        // tell the user
        echo json_encode(array("message" => "User was created."));
    }

    // if unable to create the product, tell the user
    else{

        // set response code - 503 service unavailable
        http_response_code(503);

        // tell the user
        echo json_encode(array("message" => "Unable to create User."));
    }
}

// tell the user data is incomplete
else{

    // set response code - 400 bad request
    http_response_code(400);

    // tell the user
    echo json_encode(array("message" => "Unable to create User. Data is incomplete."));
}
?>
