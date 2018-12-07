<?php
  subtract_sender_acc_bal($acount->sender_acc,$account->amount){
    $account->new_sender_acc_bal = $account->sender_acc_bal - $account->amount;

    //From Account Update
    UpdateAccount($acount->sender_acc, $account->new_sender_acc_bal );

    //From Account Update
    UpdateTransactionLog($acount->recepient_telno, $acount->sender_acc, $account->new_sender_acc_bal, $TransactionType,$Status, $TransactionStatus,$TransactionRef, $TransactionStatusCode ,$Created);
  }

  //add money to mal
  add_mal_acc_bal($acount->mal_acc,$account->amount){
    //Get account balance
    $account->mal_acc_balance = $account->get_acc_balance();
    //get commission

    $account->mal_new_acc_bal = $account->mal_acc_balance + $account->mal_commission;

    //From Account Update
    UpdateAccount($acount->mal_acc, $account->mal_new_acc_bal);

    //From TransactionLog Update
    UpdateTransactionLog($acount->mal_acc, $account->mal_new_acc_bal, $TransactionType,$Status, $TransactionStatus,$TransactionRef, $TransactionStatusCode ,$Created);
  }

  //add money to pixel
  add_pixel_acc_bal($acount->pixel_acc,$account->amount){
    //Get account balance
    $account->pixel_acc_balance = $account->get_acc_balance();
    $account->pixel_new_acc_bal = $account->pixel_acc_balance +  $account->pixel_commission;
;

    //From Account Update
    UpdateAccount($acount->pixel_acc, $account->pixel_new_acc_bal);

    //From TransactionLog Update
    UpdateTransactionLog($acount->pixel_acc, $account->pixel_new_acc_bal, $TransactionType,$Status, $TransactionStatus,$TransactionRef, $TransactionStatusCode ,$Created);
  }

?>
