<?php
class Database{

    private $server_name = "localhost";
    private $username    = "root";
    private $password    = "root"; // for Mac user $password = "root"
    private $db_name     = "the_company";
    protected $conn;  // MySQL class, connection object

    public function __construct(){
        $this->conn = new mysqli($this->server_name, $this->username, $this->password, $this->db_name);
        // mysqli(server name, username, password, database name) 
        if($this->conn->connect_error){  // error logs
            die("Unable to connect to the database: " . $this->conn->connect_error);
        }
    }
}
?>