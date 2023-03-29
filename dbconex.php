<?php

class Conex {
    private $servername = "localhost";
    private $username = "root";
    private $password = "passwd";
    private $dbname = "db_cv";
    private $conn;

    public function __construct() {
        $this->conn = mysqli_connect($this->servername, $this->username, $this->password, $this->dbname);
        if (!$this->conn) {
            die("Conexión fallida: " . mysqli_connect_error());
        }
    }

    public function getConnection() {
        return $this->conn;
    }
    
}

?>