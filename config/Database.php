<?php

class Database {
    private $host = "172.21.0.2";
    private $database_name = "homestead";
    private $username = "homestead";
    private $password = "secret";

    public function __construct(){
       $this->getConnection();
    }

    public function getConnection(){
        $conn = new mysqli($this->host, $this->username, $this->password, $this->database_name);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }else{
          return $conn;
        }
    }

}
