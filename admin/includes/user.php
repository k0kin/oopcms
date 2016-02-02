<?php 

/**
* 
*/
class User extends DbObject
{
	protected static $db_table ="users";
	protected static $dbTableFields = array('username' , 'password' , 'first_name' , 'last_name');
	public $id;
	public $username;
	public $password;
	public $first_name;
	public $last_name;






	public static function verifyUser($username,$password)
	{
		global $database;
		$username = $database->escapeString($username);
		$password = $database->escapeString($password);
		$sql =  "SELECT * FROM " . self::$db_table . "  WHERE ";
		$sql .= "username ='{$username}' ";
		$sql .= "AND password ='{$password}' ";
		$sql .= "LIMIT 1";
		$theResultArray = self::findByQuery($sql); 
		return !empty($theResultArray) ? array_shift($theResultArray) : false;
	}



	// protected function properties()
	// {
	// 	// return get_object_vars($this);

	// 	$properties = array();

	// 	foreach (self::$dbTableFields as $dbFields ) 
	// 	{
	// 		if (property_exists($this, $dbFields)) 
	// 		{
	// 			$properties[$dbFields] = $this->$dbFields;
	// 		}
	// 	}

	// 	return $properties;
	// }

	// protected function cleanProperties()
	// {
	// 	global $database;

	// 	$cleanProperties = array();

	// 	foreach ($this->properties() as $key => $value) 
	// 	{
	// 		$cleanProperties[$key] = $database->escapeString($value);
	// 	}

	// 	return $cleanProperties;

	// }

	// public function save()
	// {
	// 	return isset($this->id) ? $this->update() : $this->create();
	// }


	// public function create()
	// {
	// 	global $database;

	// 	// $properties = $this->properties();
	// 	$properties = $this->cleanProperties();
	// 	$keys = implode(",",array_keys($properties));
	// 	$values = implode("','",array_values($properties));
	// 	// var_dump($keys);
	// 	// echo "<br>";
	// 	// var_dump($values);

	// 	// $sql = "INSERT INTO " .self::$db_table . " (username,password,first_name,last_name)";
		
	// 	// $sql .= "VALUES ('";
	// 	// $sql .= $database->escapeString($this->username) . "','";
	// 	// $sql .= $database->escapeString($this->password) . "','";
	// 	// $sql .= $database->escapeString($this->first_name) . "','";
	// 	// $sql .= $database->escapeString($this->last_name) . "')";

	// 	$sql = "INSERT INTO " . self::$db_table . " (" . $keys .")";
	// 	$sql .= "VALUES ('".  $values  ."')";
		
	// 	if ($database->query($sql)) 
	// 	{
	// 		$this->id = $database->theInsertId();
	// 		return true;
	// 	}
	// 	else
	// 	{
	// 		return false;
	// 	}
	// }

	// public function update()
	// {
	// 	global $database;
	// 	// $properties = $this->properties();
	// 	$properties = $this->cleanProperties();
	// 	$propertiesPairs = array();

	// 	foreach ($properties as $key => $value) 
	// 	{
	// 		$properties_pairs[] = "{$key}='{$value}'";
	// 	}

	// 	$sql = "UPDATE " .self::$db_table . " SET ";
	// 	// $sql .= "username= '" . $database->escapeString($this->username) . "', ";
	// 	// $sql .= "password= '" . $database->escapeString($this->password) . "', ";
	// 	// $sql .= "first_name= ' " . $database->escapeString($this->first_name) . " ', ";
	// 	// $sql .= "last_name= '" . $database->escapeString($this->last_name) . "' ";
	// 	$sql.= implode(", ", $properties_pairs);
	// 	$sql .= " WHERE id= " . $database->escapeString($this->id);

	// 	//var_dump($sql);

	// 	$database->query($sql);


	// 	return (mysqli_affected_rows($database->connection) == 1) ? true : false;
	// }

	// public function delete()
	// {
	// 	global $database;

	// 	$sql ="DELETE FROM " .self::$db_table . " WHERE id=".  $database->escapeString($this->id);
	// 	$database->query($sql);
	// 	return (mysqli_affected_rows($database->connection) == 1) ? true : false;
	// }


} //Termina la clase

 ?>