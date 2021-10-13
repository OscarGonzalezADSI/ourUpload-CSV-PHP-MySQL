<?php

class Connection{
	
    function __construct() {
		$this->servername = "localhost"; 
        $this->username = "root";
        $this->password = "";
        $this->dbname = "test";
	}
	
	function connection(){
		$servername = $this->servername; 
		$username = $this->username;
		$password = $this->password;
		$dbname = $this->dbname;	
		$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$this->conn = $conn;
		return $this->conn;
	}
}
