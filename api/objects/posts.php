<?php
class Posts{
	//Database connection and table name
	private $conn;


	//object properties
	public $id;
	public $username;
	public $title;
	public $body;
	public $picture;

	//contructor with $db as database connection
	public function __construct($db){
		$this->conn = $db;
	}

	//read users
	function read(){
		//select all query
		$query = "SELECT posts.id, posts.username, posts.title, posts.body, users.picture FROM posts INNER JOIN users ON posts.username = users.username";

		//prepare query statement
		$stmt = $this->conn->prepare($query);

		//execute query
		$stmt->execute();

		return $stmt;
	}
}