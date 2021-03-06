<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// include database and object files
include_once '../config/DB.php';
include_once '../objects/transactionLog.php';
include_once '../objects/user.php';

// instantiate database and transactionLog object
$database = new DB();
$db = $database->DBConnection();

// initialize object
$transactionLog = new TransactionLog($db);

// instatiate user
$user = new User($db);
// set ID property of record to read
// $user->UserId = isset($_GET['user']) ? $_GET['user'] : die();

$data = file_get_contents("php://input");
$data = json_decode($data, true);



$user->UserId  = $data['user'];
// query transactionLogs


$info = $user->read_user();   
$transactionLog->AccountNumber = $info['info']['AccountNumber'];


$stmt = $transactionLog->read_transactionLog();
$num = $stmt->rowCount();

// check if more than 0 record found
if($num>0){

    // accounts array
    $transactionLogs_arr=array();
    $transactionLogs_arr["records"]=array();

    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);

        $transactionLog_item=array(
            "recipient_name" => $recipient_name,
            "RecipientNo" => $RecipientNo,
            "created" => $created,
            "narrative" => $narrative,
            "total_charge" => $total_charge,
            "recipient_amount" => $recipient_amount
        );

        array_push($transactionLogs_arr["records"], $transactionLog_item);
    }

    // set response code - 200 OK
    http_response_code(200);

    // show users data in json format
    echo json_encode($transactionLogs_arr);
}
// no products found
else{

    // set response code - 404 Not found
    http_response_code(404);

    // tell the user no users found
    echo json_encode(
        array("message" => "No transaction Logs found.")
    );
}

?>
