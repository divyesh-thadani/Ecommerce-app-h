<?php
class Database{
    private $host = "localhost";
    private $database = "ecommerceapp";
    private $username = "root";
    private $password = "";

    public $conn;

    public function getConnection(){
        $this->conn = null;
        try{
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->database, $this->username, $this->password);
            $this->conn->exec("set names utf8");
        }
        catch(PDOException $exception){
            echo "Database couldn't be Connected: " . $exception->getMessage();
        }
        return $this->conn;
    }
}
?>