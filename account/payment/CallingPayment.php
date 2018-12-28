<?php
$transactionLog = new transactionLog();
$account = new account();

$account->trans_Id;
$account->amount;
$account->time_stamp;
$acount->sender_acc;
$account->recepient_telno;
$account->$narrative;
$account->$pixel_acc;
$account->mal_acc;
$account->acc_charge;
$account->$TransactionType = "withdraw";

//yoAPI return proprties
$account->status;
$account->transaction_status;
$account->transaction_reference;
$account->status_code;
$account->$status_code_message;


//get acc bal and account charge
$result = $account->get_Account_Balance();
 $account->sender_acc_bal = $result->AccountBalance;
$account->account_charge =  $result->AccountCharge;

//return message array
$message_arr = array();


$Total_charge = $account->account_charge + $Yopay_charge;

//Calculate commission
$account->mal_commission = $account->account_charge * 0.6;
$account->pixel_commission = $account->account_charge * 0.4;

///actual balance
$account_actual_bal = $account->sender_acc_bal - $Total_charge ;

if($account_actual_bal > $account->amount){

    //getting the actual balance to be inserted in the database
    $account_actual_bal = $account_actual_bal - $account->amount; 
    //yoAPI
     include_once '../../../mpay_api/yopay.php';
    
  // yoAPI returns status ;
  $account->status = $response['Status'];
    if($account->status == 'OK'){

        $account->subtract_sender_acc_bal($sender_acc =$acount->sender_acc,$actual_bal =$account_actual_bal);

        
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

        $transactionLog->create_transactionLog($accountNo, $accountName );

    }else{


        $message_arr['message'] = "Something Went Wrong";

    }





}else{

    $message_arr['message']="You account balance is insufficient to make this payment";
}




?>
