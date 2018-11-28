<?php
class Account{

    // database connection and table name
    private $DBconnect;
    private $table_name = "accounts";

    // object properties
    public $AccountNumber;
    public $AccountName;
    public $AccountBalance;
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
                  *
              FROM
                  " . $this->table_name . "
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
                      AccountName=:AccountName, AccountNumber=:AccountNumber";

          // prepare query
          $stmt = $this->DBconnect->prepare($query);

          // sanitize
          $this->AccountName=htmlspecialchars(strip_tags($this->AccountName));
          $this->AccountNumber=htmlspecialchars(strip_tags($this->AccountNumber));;

          // bind values
          $stmt->bindParam(":AccountName", $this->AccountName);
          $stmt->bindParam(":AccountNumber", $this->AccountNumber);

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

}

?>
