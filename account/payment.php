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

// instantiate user object
include_once '../objects/user.php';

// instantiate transactionLog object
include_once '../objects/transactionLog.php';

$database = new DB();
$db = $database->DBConnection();

$account = new Account($db);

// initialise transaction log
$transactionLog = new TransactionLog($db);

$server_response = array();

// instatiate user
$user = new User($db);
// get posted data
$data = file_get_contents("php://input");
$data = json_decode($data, true);



$contact_data = $data['data'];
$userId = $data['user'];
//   var_dump($contact_data);


//loop through the contact array
for ($i=0; $i < count($contact_data); $i++) { 
    # code...
    //  $recipient_no;
    //  $recipient_name;
    //  $narrative;
    $recipient_no = $contact_data[$i]['phoneNo'];
    $recipient_name = $contact_data[$i]['name'];
    $amount =$contact_data[$i]['amount'];
    $narrative =$contact_data[$i]['narrative'];

//server response
$server_response = array();
    
// make sure data is not empty
if(
    !empty($userId) &&
    !empty($recipient_no) &&
    !empty($recipient_name)&&
    !empty($amount)&&
    !empty($narrative)
){

   $user->UserId = $userId;
    $info = $user->read_user();
    
    $account->AccountNumber = $info['info']['AccountNumber'];
    $accountName = $info['info']['FirstName'].' '.$info['info']['LastName'];
    
    // set product property values
    
    // $account->AccountName = $data->AccountName;
    $account->recipient_no = $recipient_no;
    $account->recipient_name = $recipient_name;
    $account->amount = $amount;
    $account->narrative = $narrative;
    $transactionLog->recepient_telno = $recipient_no;
   

    // create the product
    //get acc bal and account charge
    $result = $account->get_Account_Balance();
    $account->sender_acc_bal = $result['AccountBalance'];
    $account->account_charge =  $result['AccountCharge'];

    //get total charge on transaction
    $Total_charge = $account->account_charge + $account->Yopay_charge;

    //Calculate commission
    $account->mal_commission = $account->account_charge * 0.6;
    $account->pixel_commission = $account->account_charge * 0.4;

    ///actual balance
    $account_actual_bal = $account->sender_acc_bal - $Total_charge ;

    if($account_actual_bal > $account->amount){

        //getting the actual balance to be inserted in the database
        $account_actual_bal = $account_actual_bal - $account->amount; 
        //yoAPI
         include_once '../../mpay_api/yopay.php';
        
      // yoAPI returns status ;
      $account->status = $response['Status'];
        if($account->status == 'OK'){
            
    
            $account->subtract_sender_acc_bal($sender_acc =$account->AccountNumber, $actual_bal =$account_actual_bal);
    
            
            /*   update malcom  account
             *   get mal account balance
             *   add commission 
             *    then update the account 
             */
    
             //get mal account balance
            $mal_account_balance = $account->get_mal_acc_balance();
    
            //add commission to account balance
            $mal_new_account_balance = $mal_account_balance + $account->mal_commission;
            //then update the account 
            $account->update_mal_acc_bal($mal_new_account_balance);
    
            /*   update pixel  account
             *   get pixel account balance
             *   add commission 
             *   then update the account 
             */
            
            // get pixel account balance
            $pixel_account_balance = $account->get_pixel_acc_balance();
    
            // add commission 
            $pix_new_account_balance = $pixel_account_balance + $account->pixel_commission;
    
            //then update  pixel account
            $account->update_pixel_acc_bal($pix_new_account_balance);
    
            $transactionLog->create_transactionLog($accountNo =$account->AccountNumber, $accountName ,$Status,$TransactionStatus,$TransactionRef,$TransactionStatusCode,$TransactionStatusMessage,$TransactionType,$recipient_name,$amount,$Total_charge,$narrative);


             // set response code - 201 created
        http_response_code(201);

        // tell the user
        echo json_encode($server_response[$i]['Transaction Message']= "Transaction was successfully.");
    
        }else{

            $transactionLog->create_transactionLog($accountNo =$account->AccountNumber, $accountName ,$Status,$TransactionStatus,$TransactionRef,$TransactionStatusCode,$TransactionStatusMessage,$TransactionType,$recipient_name,$amount,$Total_charge,$narrative);
    
            echo json_encode($server_response[$i]['Transaction Message']= "Something Went Wrong. Transaction failed");
           
    
        }
    
    
    
    
    
          }else{
    
        // tell the user
        echo json_encode($server_response[$i]['Account Message'] = "You account balance is insufficient to make this payment.");
          }
    

    
    
    }
    // tell the user data is incomplete
else{

    // set response code - 400 bad request
    http_response_code(400);

    // tell the user
    echo json_encode(array($server_response[$i]['Validation Error'] ="Unable to make payment. Data is incomplete."));
}


}
?>
