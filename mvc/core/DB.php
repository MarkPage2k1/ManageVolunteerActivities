<?php 
    class Database {
        protected $serverName = "localhost";
        protected $username = "root";
        protected $password = "";
        protected $dbname = "managevolunteeractivities";
        public $conn;

        function __construct() {
            try {
                $this->conn = new PDO("mysql:host=$this->serverName;dbname=$this->dbname", $this->username, $this->password);
                // set the PDO error mode to exception
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                // echo "Connected successfully";
            } catch(PDOException $e) {
                echo "Connection failed: " . $e->getMessage();
            }
        }
    }
?>