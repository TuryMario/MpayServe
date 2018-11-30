<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// include database and object files
include_once '../config/DB.php';
include_once '../objects/account.php';

// instantiate database and account object
$database = new DB();
$db = $database->DBConnection();

// initialize object
$account = new Account($db);

// query accounts
$stmt = $account->read();
$num = $stmt->rowCount();

// check if more than 0 record found
if($num>0){

    // accounts array
    $accounts_arr=array();
    $accounts_arr["records"]=array();

    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);

        $account_item=array(
            "AccountNumber" => $AccountNumber,
            "AccountName" => $AccountName,
            "AccountBalance" => $AccountBalance,
            "AccountType" => $AccountType,
                  "Created" => $Created,
                  "Email" => $Email
            
        );

        array_push($accounts_arr["records"], $account_item);
    }

    // set response code - 200 OK
    http_response_code(200);

    // show products data in json format
    echo json_encode($accounts_arr);
}
// no products found
else{

    // set response code - 404 Not found
    http_response_code(404);

    // tell the user no products found
    echo json_encode(
        array("message" => "No accounts found.")
    );
}

?>
