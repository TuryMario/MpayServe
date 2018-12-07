<?php
class DB{

    //  database credentials
    public $DBconnect;
    private $host = "localhost";
    private $db_name = "mpay_final";
    private $username = "root";
    private $password = "mario1211";

    // public function __construct(){
    //   $this->DBConnection();
    // }

    // get the database connection
    public function DBConnection(){

        $this->DBconnect = null;

        try{
            $this->DBconnect = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->DBconnect->exec("set names utf8");
        }catch(PDOException $exception){
            echo "Connection error: " . $exception->getMessage();
        }

        return $this->DBconnect;
    }
}
?>
