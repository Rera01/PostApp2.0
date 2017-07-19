<?php
class Users{
	//Database connection and table name
	private $conn;
	private $table_name = "users";

	//object properties
	public $userid;
	public $username;
	public $password;
	public $picture = "d32776.png";

	//contructor with $db as database connection
	public function __construct($db){
		$this->conn = $db;
	}

	//read users
	function read(){
		//select all query
		$query = "SELECT * FROM " . $this->table_name;

		//prepare query statement
		$stmt = $this->conn->prepare($query);

		//execute query
		$stmt->execute();

		return $stmt;
	}

	function update_pass(){
		//update query
		$query = "UPDATE " . $this->table_name . " SET password = :password WHERE userid = :userid";

		//prepare query statement
		$stmt = $this->conn->prepare($query);

		//sanitize
		$this->password=htmlspecialchars(strip_tags($this->password));

		// //bind new values
		$stmt->bindParam(':password', $this->password);
		$stmt->bindParam(':userid', $this->userid);

		//execute query
		if($stmt->execute()){
			return true;
		}
		else {
			return false;
		}
	}

	function update_pic(){
		//update query
		$query = "UPDATE " . $this->table_name . " SET picture = :picture WHERE userid = :userid";

		//prepare query statement
		$stmt = $this->conn->prepare($query);

		//sanitize
		$this->picture=htmlspecialchars(strip_tags($this->picture));

		// //bind new values
		$stmt->bindParam(':picture', $this->picture);
		$stmt->bindParam(':userid', $this->userid);

		//execute query
		if($stmt->execute()){
			return true;
		}
		else {
			return false;
		}
	}

	function delete(){
		//update query

		$query = "DELETE FROM " . $this->table_name . " WHERE userid= :userid";

		//prepare query statement
		$stmt = $this->conn->prepare($query);

		// //bind new values
		$stmt->bindParam(':userid', $this->userid);

		//execute query
		if($stmt->execute()){
			return true;
		}
		else {
			return false;
		}
	}

	function create(){
		//update query

		$query = "INSERT INTO " . $this->table_name . " SET username = :username, password = :password, picture = :picture";

		//prepare query statement
		$stmt = $this->conn->prepare($query);

		//sanitize
		$this->username=htmlspecialchars(strip_tags($this->username));
		$this->password=htmlspecialchars(strip_tags($this->password));


		// //bind new values
		$stmt->bindParam(':username', $this->username);
		$stmt->bindParam(':password', $this->password);
		$stmt->bindParam(':picture', $this->picture);

		//execute query
		if($stmt->execute()){
			return true;
		}
		else {
			return false;
		}
	}
}