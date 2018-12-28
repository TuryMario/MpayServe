<?php
class Account{

    /**
     * 
     * database connection and table name
     */
    private $DBconnect;
    private $table_name = "accounts";
    private $user_table = "users";
    private $pix = "1543562952943218147575940775";
    private $mal = "1544101404558610911389235196";
    public $Yopay_charge =500;

    /**
     * object properties
     */ 
    public $AccountNumber;
    public $AccountName;
    public $AccountBalance;
    public $AccountType;
    public $deposit;


    public $trans_Id;
    public $amount;
    public $time_stamp;
    public $sender_acc;
    public $recipient_no;
    public $recipient_name;
    public $narrative;
    public $pixel_acc;
    public $mal_acc;
    public $acc_charge;
    public $TransactionType;

    /** 
     *  yoAPI return proprties
     *  */

    public $status;
    public $transaction_status;
    public $transaction_reference;
    public $status_code;
    public $status_code_message;

    /**
     * 
     * constructor with $db as database connection
     */ 
public function __construct($db)
    { 
        $this->DBconnect = $db;

    }

function read()
    {
      // select all query
     $query = "SELECT
                  accounts.AccountNumber,
                  accounts.AccountName,
                  accounts.AccountType,
                  accounts.AccountBalance,
                  accounts.Created,
                  users.Email

              FROM " . $this->table_name ." INNER JOIN " .$this->user_table . "

                  ON  accounts.AccountNumber = users.AccountNumber ";

      // prepare query statement
      $stmt = $this->DBconnect->prepare($query);

      // execute query
      $stmt->execute();

      return $stmt;
    }

      /**
       *  create Account ethod
       */
function create()
    {

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

      /**
       *  used when filling up the update account form
       */
function readOne()
    {

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

      /**
       *  update the account
       */
function update()
    {

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

      /**
       *  debit the account
       */
function debit()
    {

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

      /**
       * credit Account  method
       */
function credit()
    {

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

      /**
       *  delete the Account
       */
function delete()
    {

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

      /**
       * search
       *  */  
function search($keywords)
    {

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

  /**
   * PAYMENTS METHODS
   * get_Account_Balance()   --> for the sender
   * subtract_sender_acc_bal()  --> debit sender account
   * get_mal_acc_balance()  --> get mal account balance
   * update_mal_acc_bal()  --> update mal account balance
   * get_pixel_acc_balance() --> get pix account balance
   * update_pixel_acc_bal() --> update pix account balance
   * 
   */


   /**
    * get the sender account balance
    */
function get_Account_Balance()
    {
        
          // query to read single record
          $query = "SELECT AccountBalance,AccountCharge FROM  " . $this->table_name . " WHERE AccountNumber = ? LIMIT 0,1";

          // prepare query statement
          $stmt = $this->DBconnect->prepare( $query );

          // bind id of product to be updated
          $stmt->bindParam(1, $this->AccountNumber);

          // execute query
          $stmt->execute();

          // get retrieved row
          $row = $stmt->fetch(PDO::FETCH_ASSOC);

          // set values to object properties

          $result=array("AccountBalance" => $row['AccountBalance'],
                         "AccountCharge" => $row['AccountCharge']);

          return $result;
    }


    /**
     * uodate the sender account
     */


function  subtract_sender_acc_bal($sender_acc,$actual_bal)
    {
        
          // update query
          $query = "UPDATE ".$this->table_name." SET AccountBalance = '$actual_bal' WHERE AccountNumber = '$sender_acc'";

            // prepare query statement
            $stmt = $this->DBconnect->prepare($query);

          // bind new values

            // $stmt->bindParam(':AccountBalance', $actual_bal);
            // $stmt->bindParam(':AccountNumber', $sender_acc);

        // execute the query
                if($stmt->execute()){
        return true;
                }

        return false;
     
    }

      /**
       *   get mal account balance
       */
   
function get_mal_acc_balance()
    {

        // query to read single record
        $query = "SELECT AccountBalance FROM ". $this->table_name . " WHERE AccountNumber = ? LIMIT 0,1";

        // prepare query statement
        $stmt = $this->DBconnect->prepare( $query );

        // bind id of product to be updated
        $stmt->bindParam(1, $this->mal);

        // execute query
        $stmt->execute();

        // get retrieved row
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // set values to object properties
        $this->AccountBalance = $row['AccountBalance'];

        return $this->AccountBalance;

    }

     /*
      *  update mal account
      */
     
function update_mal_acc_bal($mal_new_account_balance)
    {
       
    // update query
    $query = "UPDATE " . $this->table_name ." SET AccountBalance = :AccountBalance WHERE AccountNumber = :AccountNumber";
     
     // prepare query statement
     $stmt = $this->DBconnect->prepare($query);
          
     // bind new values 
     $stmt->bindParam(':AccountBalance', $mal_new_account_balance);
     $stmt->bindParam(':AccountNumber', $this->mal);
     
     // execute the query
         if($stmt->execute())
         {

        return true;
        }

        return false;
    }


     /*
      * get pixel account balance  
      */
function get_pixel_acc_balance()
    {

        // query to read single record
        $query = "SELECT AccountBalance FROM ". $this->table_name . " WHERE AccountNumber = ? LIMIT 0,1";

        // prepare query statement
        $stmt = $this->DBconnect->prepare( $query );

        // bind id of product to be updated
        $stmt->bindParam(1, $this->pix);

        // execute query
        $stmt->execute();

        // get retrieved row
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // set values to object properties
        $this->AccountBalance = $row['AccountBalance'];

        return $this->AccountBalance;

    }

      
      /*
      * add money to pixel  
      */
function update_pixel_acc_bal($pix_new_account_balance)
    {
          // update query
        $query = "UPDATE " . $this->table_name ." SET AccountBalance = :AccountBalance WHERE AccountNumber = :AccountNumber";
     
        // prepare query statement
         $stmt = $this->DBconnect->prepare($query);
         
            // bind new values 
        $stmt->bindParam(':AccountBalance', $pix_new_account_balance);
        $stmt->bindParam(':AccountNumber', $this->pix);
    
            // execute the query
        if($stmt->execute())
            {

       return true;
            }

       return false;
       
    }


    /**
     *   END OF PAYMENTS METHODS
     */

}

?>
