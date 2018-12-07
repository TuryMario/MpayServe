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

//yoAPI return proprties
$account->status;
$account->transaction_status;
$account->transaction_reference;
$account->status_code;
$account->$status_code_message;


//get acc bal
$account->sender_acc_bal = $account->get_acc_bal();


$message_arr = array();

//getCharge on Account
$account_charge = account->getCharge($account->sender_acc);
$Total_charge = $account_charge + $Yopay_charge;

//Calculate commission
$account->mal_commission = $account->account_charge * 0.6;
$account->pixel_commission = $account->account_charge * 0.4;

///actual balance
$account_actual_bal = $account->sender_acc_bal - $Total_charge ;

if($account_actual_bal > $account->amount){

    //yoAPI method
    $account->status = $account->yoAPI_pay($account->recepient_telno, $account->amount, $account->$narrative);
  // yoAPI returns status ;

    if($account->status == 'OK'){

        $account->subtract_sender_acc_bal($acount->sender_acc,$account->amount);

        //add money to mal
        $account->add_mal_acc_bal($acount->mal_acc,$account->amount);

        //add money to pixel
        $account->add_pixel_acc_bal($acount->pixel_acc,$account->amount);

        $transactionLog->transac_log($account, $TransactionType,$Status, $TransactionStatus,$TransactionRef, $TransactionStatusCode ,$Created);

    }else{


        $message_arr['message'] = $account->$status_code_message;

    }





}else{

    $message_arr['message']="You account balance is insufficient to make this payment";
}




?>
