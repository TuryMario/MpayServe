<?php
class Account{

    // database connection and table name
    private $DBconnect;
    private $table_name = "accounts";
    private $user_table = "users";

    // object properties
    public $AccountNumber;
    public $AccountName;
    public $AccountBalance;
    public $AccountType;
    public $deposit;


    public $trans_Id;
    public $amount;
    public $time_stamp;
    public $sender_acc;
    public $recepient_telno;
    public $narrative;
    public $pixel_acc;
    public $mal_acc;
    public $acc_charge;

    //yoAPI return proprties
    public $status;
    public $transaction_status;
    public $transaction_reference;
    public $status_code;
    public $status_code_message;
    //public $created = null;

    // constructor with $db as database connection
    public function __construct($db){ //,$accNum,$accName,$create
        $this->DBconnect = $db;
        //$this->AccountNumber = $accNum;
        // $this->AccountName = $accName;
        //$this->created = $create;
    }

    function read(){
      // select all query
      $query = "SELECT
                  accounts.AccountNumber,
                  accounts.AccountName,
                  accounts.AccountType,
                  accounts.AccountBalance,
                  accounts.Created,
                  users.Email

              FROM
                  " . $this->table_name . "

INNER JOIN " . $this->user_table . "

ON  accounts.AccountNumber = users.AccountNumber
              ";
              //echo $query;

      // prepare query statement
      $stmt = $this->DBconnect->prepare($query);

      // execute query
      $stmt->execute();

      return $stmt;
      }

      // create product
      function create(){

          // query to insert record
          $query = "INSERT INTO
                      " . $this->table_name . "
                  SET
                      AccountName=:AccountName, AccountNumber=:AccountNumber
                      , AccountType=:AccountType, AccountBalance=:AccountBalance";

          // prepare query
          $stmt = $this->DBconnect->prepare($query);

          // sanitize
          $this->AccountName=htmlspecialchars(strip_tags($this->AccountName));
          $this->AccountNumber=htmlspecialchars(strip_tags($this->AccountNumber));
          $this->AccountType=htmlspecialchars(strip_tags($this->AccountType));
          $this->AccountBalance=htmlspecialchars(strip_tags($this->AccountBalance));

          // bind values
          $stmt->bindParam(":AccountName", $this->AccountName);
          $stmt->bindParam(":AccountNumber", $this->AccountNumber);
          $stmt->bindParam(":AccountType", $this->AccountType);
          $stmt->bindParam(":AccountBalance", $this->AccountBalance);

          // execute query
          if($stmt->execute()){
              return true;
          }

          return false;

      }

      // used when filling up the update account form
      function readOne(){

          // query to read single record
          $query = "SELECT
                      *
                  FROM
                      " . $this->table_name . "
                  WHERE
                      AccountNumber = ?
                  LIMIT
                      0,1";

          // prepare query statement
          $stmt = $this->DBconnect->prepare( $query );

          // bind id of product to be updated
          $stmt->bindParam(1, $this->AccountNumber);

          // execute query
          $stmt->execute();

          // get retrieved row
          $row = $stmt->fetch(PDO::FETCH_ASSOC);

          // set values to object properties
          $this->AccountName = $row['AccountName'];
          $this->AccountBalance = $row['AccountBalance'];
      }

      // update the account
      function update(){

          // update query
          $query = "UPDATE
                      " . $this->table_name . "
                  SET
                      AccountName = :AccountName
                  WHERE
                      AccountNumber = :AccountNumber";

          // prepare query statement
          $stmt = $this->DBconnect->prepare($query);

          // sanitize
          $this->AccountName=htmlspecialchars(strip_tags($this->AccountName));
          // $this->price=htmlspecialchars(strip_tags($this->price));
          // $this->description=htmlspecialchars(strip_tags($this->description));
          // $this->category_id=htmlspecialchars(strip_tags($this->category_id));
          $this->AccountNumber=htmlspecialchars(strip_tags($this->AccountNumber));

          // bind new values
          $stmt->bindParam(':AccountName', $this->AccountName);
          // $stmt->bindParam(':price', $this->price);
          // $stmt->bindParam(':description', $this->description);
          // $stmt->bindParam(':category_id', $this->category_id);
          $stmt->bindParam(':AccountNumber', $this->AccountNumber);

          // execute the query
          if($stmt->execute()){
              return true;
          }

          return false;
      }

      // debit the account
      function debit(){

          // update query
          $query = "UPDATE
                      " . $this->table_name . "
                  SET
                      AccountBalance = :AccountBalance
                  WHERE
                      AccountNumber = :AccountNumber";

          // prepare query statement
          $stmt = $this->DBconnect->prepare($query);

          // sanitize
          $this->AccountName=htmlspecialchars(strip_tags($this->AccountName));
          // $this->price=htmlspecialchars(strip_tags($this->price));
          // $this->description=htmlspecialchars(strip_tags($this->description));
          $this->AccountBalance=htmlspecialchars(strip_tags($this->AccountBalance));
          $this->AccountNumber=htmlspecialchars(strip_tags($this->AccountNumber));

          // bind new values
          $stmt->bindParam(':AccountName', $this->AccountName);
          $stmt->bindParam(':AccountBalance', $this->AccountBalance);
          // $stmt->bindParam(':description', $this->description);
          // $stmt->bindParam(':category_id', $this->category_id);
          $stmt->bindParam(':AccountNumber', $this->AccountNumber);

          // execute the query
          if($stmt->execute()){
              return true;
          }

          return false;
      }

      //credit method
      function credit(){

        // update query
        $query = "UPDATE
                    " . $this->table_name . "
                SET
                    AccountBalance = :AccountBalance
                WHERE
                    AccountNumber = :AccountNumber";

        // prepare query statement
        $stmt = $this->DBconnect->prepare($query);

        // sanitize

        $this->AccountBalance=htmlspecialchars(strip_tags($this->AccountBalance));
        $this->AccountNumber=htmlspecialchars(strip_tags($this->AccountNumber));

        // bind new values

        $stmt->bindParam(':AccountBalance', $this->AccountBalance);
        $stmt->bindParam(':AccountNumber', $this->AccountNumber);

        // execute the query
        if($stmt->execute()){
            return true;
        }

        return false;
    }

      // delete the product
      function delete(){

          // delete query
          $query = "DELETE FROM " . $this->table_name . " WHERE AccountNumber = ?";

          // prepare query
          $stmt = $this->DBconnect->prepare($query);

          // sanitize
          $this->AccountNumber=htmlspecialchars(strip_tags($this->AccountNumber));

          // bind id of record to delete
          $stmt->bindParam(1, $this->AccountNumber);

          // execute query
          if($stmt->execute()){
              return true;
          }

          return false;

      }

      // search products
      function search($keywords){

          // select all query
          $query = "SELECT
                      *
                  FROM
                      " . $this->table_name . "
                  WHERE
                      AccountName LIKE ? OR AccountNumber LIKE ?
                  ORDER BY
                      AccountNumber DESC";

          // prepare query statement
          $stmt = $this->DBconnect->prepare($query);

          // sanitize
          $keywords=htmlspecialchars(strip_tags($keywords));
          $keywords = "%{$keywords}%";

          // bind
          $stmt->bindParam(1, $keywords);
          $stmt->bindParam(2, $keywords);
          //$stmt->bindParam(3, $keywords);

          // execute query
          $stmt->execute();

          return $stmt;
      }

      // Payment methods

    // get account balance
    function get_Account_Balance(){
        
          // query to read single record
          $query = "SELECT AccountBalance FROM  " . $this->table_name . " WHERE AccountNumber = ? LIMIT 0,1";

          // prepare query statement
          $stmt = $this->DBconnect->prepare( $query );

          // bind id of product to be updated
          $stmt->bindParam(1, $this->AccountNumber);

          // execute query
          $stmt->execute();

          // get retrieved row
          $row = $stmt->fetch(PDO::FETCH_ASSOC);

          // set values to object properties

          $this->AccountBalance = $row['AccountBalance'];

          return $this->AccountBalance;
    }


    function  subtract_sender_acc_bal(){
        $this->new_sender_acc_bal = $this->sender_acc_bal - $this->amount;

        //From Account Update
        // UpdateAccount($this->sender_acc, $this->new_sender_acc_bal );

        //From Account Update
        // UpdateTransactionLog($this->recepient_telno, $this->sender_acc, $this->new_sender_acc_bal, $TransactionType,$Status, $TransactionStatus,$TransactionRef, $TransactionStatusCode ,$Created);
      }

      //add money to mal
      function add_mal_acc_bal(){
        //Get account balance
        // $this->mal_acc_balance = $this->get_acc_balance();
        //get commission

        // $this->mal_new_acc_bal = $this->mal_acc_balance + $this->mal_commission;

        //From Account Update
        // UpdateAccount($this->mal_acc, $this->mal_new_acc_bal);

        //From TransactionLog Update
        // UpdateTransactionLog($this->mal_acc, $this->mal_new_acc_bal, $TransactionType,$Status, $TransactionStatus,$TransactionRef, $TransactionStatusCode ,$Created);
      }

      //add money to pixel
      function add_pixel_acc_bal(){
        //Get account balance
        $this->pixel_acc_balance = $this->get_acc_balance();
        $this->pixel_new_acc_bal = $this->pixel_acc_balance +  $this->pixel_commission;

        //From Account Update
        UpdateAccount($this->pixel_acc, $this->pixel_new_acc_bal);

        //From TransactionLog Update
        UpdateTransactionLog($this->pixel_acc, $this->pixel_new_acc_bal, $TransactionType,$Status, $TransactionStatus,$TransactionRef, $TransactionStatusCode ,$Created);
      }

}

?>
