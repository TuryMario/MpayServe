<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// get database connection
include_once '../config/DB.php';

// instantiate product object
include_once '../objects/account.php';

$database = new DB();
$db = $database->DBConnection();

$account = new Account($db);

// get posted data
$data = json_decode(file_get_contents("php://input"));

// make sure data is not empty
if(
    !empty($data->AccountNumber) &&
    !empty($data->AccountName)&&
    !empty($data->AccountType)&&
    !empty($data->AccountBalance)
){

    // set product property values
    $account->AccountNumber = $data->AccountNumber;
    $account->AccountName = $data->AccountName;
    $account->AccountType = $data->AccountType;
    $account->AccountBalance = $data->AccountBalance;
   
    // $account->created = date('Y-m-d H:i:s');

    // create the product
    if($account->create()){

        // set response code - 201 created
        http_response_code(201);

        // tell the user
        echo json_encode(array("message" => "Account was created."));
    }

    // if unable to create the product, tell the user
    else{

        // set response code - 503 service unavailable
        http_response_code(503);

        // tell the user
        echo json_encode(array("message" => "Unable to create Account."));
    }
}

// tell the user data is incomplete
else{

    // set response code - 400 bad request
    http_response_code(400);

    // tell the user
    echo json_encode(array("message" => "Unable to create Account. Data is incomplete."));
}
?>
