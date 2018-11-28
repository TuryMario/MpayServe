<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// include database and object files
include_once '../config/DB.php';
include_once '../objects/user.php';

// instantiate database and account object
$database = new DB();
$db = $database->DBConnection();

// initialize object
$user = new User($db);

// query accounts
$stmt = $user->read_user();
$num = $stmt->rowCount();

// check if more than 0 record found
if($num>0){

    // accounts array
    $users_arr=array();
    $users_arr["records"]=array();

    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);

        $user_item=array(
            "UserName" => $UserName,
            "FirstName" => $FirstName,
            "LastName" => $LastName
            //"Created" => $created
        );

        array_push($users_arr["records"], $user_item);
    }

    // set response code - 200 OK
    http_response_code(200);

    // show users data in json format
    echo json_encode($users_arr);
}
// no products found
else{

    // set response code - 404 Not found
    http_response_code(404);

    // tell the user no users found
    echo json_encode(
        array("message" => "No users found.")
    );
}

?>
