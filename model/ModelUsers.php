<?php

include "Connection.php";

class ModelUsers{
	
    function __construct() {
		$conn = new Connection();
		$this->conn = $conn->connection();
		$this->bindParamUsers();
	}

	function bindParamUsers(){	
		$conn = $this->conn;
		$stmt = $conn->prepare("INSERT INTO usuarios (nombre, apellido, correo)
		VALUES (:nombre, :apellido, :correo)");
		$stmt->bindParam(':nombre', $this->firstname);
		$stmt->bindParam(':apellido', $this->lastname);
		$stmt->bindParam(':correo', $this->email);
		$this->stmt = $stmt;
    }

	function insertUser($row){
		try {
			$myFirstname = $row["nombre"];
			$myLastname = $row["apellido"];
			$myEmail = $row["correo"];
			$this->firstname = $myFirstname;
			$this->lastname = $myLastname;
			$this->email = $myEmail;
			$this->stmt->execute();
			return 1;
		} catch(PDOException $e) {
			return "Error: " . $e->getMessage();
		}
	}
	
	function closeconnection(){
		$this->conn = null;
	}
}
