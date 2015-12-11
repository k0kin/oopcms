<?php 
require_once("config.php");


class Database {

	public $connection;

	function __construct(){
		$this->openDBConnection();
	}

	public function openDBConnection(){
		// $this->connection = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);

		$this->connection = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);

		if($this->connection->connect_errno){
			die("Database Failed" . $this->connection->connect_error);
		}

	}

	public function query($sql){
		$result = $this->connection->query($sql);
		$this->confirmQuery($result);
		return $result;
	}

	private function  confirmQuery($result){
		if(!$result){
			die("Query Failed" . $this->connection->error);
		}
	}

	public function escapeString($string){
		$escapeString = $this->connection->real_escape_string($string);
		return $escapeString;
	}

	public function theInsertId(){
		return $this->connection->insert_id;
	}




}


$database = new Database;




?>