<?php

class Database{
	//Database credentials
	private $host = "localhost";
	private $db_name = "postapp";
	private $username = "root";
	private $password = "";
	public $conn;

	//Get Connection to database
	public function getConnection(){

		$this->conn = null;

		try{
			$this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
			$this->conn->exec("set anmes utf8");

		} catch(PDOException $e){
			echo "Connection error: " . $e->getMessage();
		}
		
		return $this->conn;
	}
}
?>