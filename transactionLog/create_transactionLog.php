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
include_once '../objects/transactionLog.php';

$database = new DB();
$db = $database->DBConnection();

$transactionLog = new TransactionLog($db);

// get posted data
$data = json_decode(file_get_contents("php://input"));

// make sure data is not empty
if(
    !empty($data->TransactionId) &&
    !empty($data->TransactionType)&&
    !empty($data->TransactionStatus)&&
    !empty($data->TransactionCode)
){

    // set product property values
    $transactionLog->TransactionId = $data->TransactionId;
    $transactionLog->TransactionType = $data->TransactionType;
    $transactionLog->TransactionStatus = $data->TransactionStatus;
    $transactionLog->TransactionCode = $data->TransactionCode;
    $transactionLog->Created = date('Y-m-d H:i:s');
    // $product->description = $data->description;
    // $product->category_id = $data->category_id;
    //$account->created = date('Y-m-d H:i:s');

    // create the product
    if($transactionLog->create_transactionLog()){

        // set response code - 201 created
        http_response_code(201);

        // tell the user
        echo json_encode(array("message" => "TransactionLog was created."));
    }

    // if unable to create the product, tell the user
    else{

        // set response code - 503 service unavailable
        http_response_code(503);

        // tell the user
        echo json_encode(array("message" => "Unable to create transactionLog."));
    }
}

// tell the user data is incomplete
else{

    // set response code - 400 bad request
    http_response_code(400);

    // tell the user
    echo json_encode(array("message" => "Unable to create transactionLog. Data is incomplete."));
}
?>
