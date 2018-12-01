<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// include database and object files
include_once '../config/DB.php';
include_once '../objects/account.php';

// get database connection
$database = new DB();
$db = $database->DBConnection();

// prepare product object
$account = new Account($db);

// get AccountNumber of product to be edited
$data = json_decode(file_get_contents("php://input"));

// set ID property of account to be edited
$account->AccountNumber = $data->AccountNumber;


// set deposit property values
$dep= $data->deposit;

$account->readOne();
$account->AccountBalance = $account->AccountBalance  +   $account->deposit;

// update the product
if($account->credit()){

    // set response code - 200 ok
    http_response_code(200);

    // tell the user
    echo json_encode(array("message" => "Account was updated."));
}

// if unable to update the account, tell the user
else{

    // set response code - 503 service unavailable
    http_response_code(503);

    // tell the user
    echo json_encode(array("message" => "Unable to update Account."));
}
?>
