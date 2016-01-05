<?php 

/**
* 
*/
class User 
{
	protected static $db_table ="users";
	protected static $dbTableFields = array('username' , 'password' , 'first_name' , 'last_name');
	public $id;
	public $username;
	public $password;
	public $first_name;
	public $last_name;


	public static function findAllUsers()
	{
		
		return self::findThisQuery("SELECT * FROM users");

	}

	public static function findUserById($id)
	{
		global $database;
		$theResultArray = self::findThisQuery("SELECT * FROM users WHERE id = $id LIMIT 1");

		// If $theresultArray is not empye "?:i want you to do this"  array_shift($theResultArray) ": else" return false; 
		return !empty($theResultArray) ? array_shift($theResultArray) : false;




		// if(!empty($theResultArray))
		// {
		// 	$firstItem = array_shift($theResultArray);
		// 	return $firstItem;
		// }
		// else{
		// 	return false;
		// }
		
	}

	public static function findThisQuery($sql)
	{
		global $database;
		$result_set = $database->query($sql);
		$theObjectArray = array();
		while ($row = mysqli_fetch_array($result_set)) {
			$theObjectArray[] = self::instantiation($row);
		}
		return $theObjectArray;

	}

	public static function verifyUser($username,$password)
	{
		global $database;
		$username = $database->escapeString($username);
		$password = $database->escapeString($password);
		$sql =  "SELECT * FROM users WHERE ";
		$sql .= "username ='{$username}' ";
		$sql .= "AND password ='{$password}' ";
		$sql .= "LIMIT 1";
		$theResultArray = self::findThisQuery($sql); 
		return !empty($theResultArray) ? array_shift($theResultArray) : false;
	}

	public static function instantiation($foundUser)
	{
        $theObject = new self;


        // $user->id = $foundUser['id'];
        // $user->username = $foundUser['username'];
        // $user->password = $foundUser['password'];
        // $user->first_name = $foundUser['first_name'];
        // $user->last_name = $foundUser['last_name'];		

        foreach ($foundUser as $theAttribute => $value) 
        {
        	if($theObject->hasTheAttribute($theAttribute))
        	{
        		$theObject->$theAttribute = $value;
        	}
        }
        return $theObject;
	}

	private function hasTheAttribute($theAttribute)
	{
		$objectProperties = get_object_vars($this);
		return array_key_exists($theAttribute, $objectProperties);

	}

	protected function properties()
	{
		// return get_object_vars($this);

		$properties = array();

		foreach (self::$dbTableFields as $dbFields ) 
		{
			if (property_exists($this, $dbFields)) 
			{
				$properties[$dbFields] = $this->$dbFields;
			}
		}

		return $properties;
	}

	public function save()
	{
		return isset($this->id) ? $this->update() : $this->create();
	}


	public function create()
	{
		global $database;

		$properties = $this->properties();
		$keys = implode(",",array_keys($properties));
		$values = implode("','",array_values($properties));
		// var_dump($keys);
		// echo "<br>";
		// var_dump($values);

		// $sql = "INSERT INTO " .self::$db_table . " (username,password,first_name,last_name)";
		$sql = "INSERT INTO " . self::$db_table . " (" . $keys .")";
		// $sql .= "VALUES ('";
		// $sql .= $database->escapeString($this->username) . "','";
		// $sql .= $database->escapeString($this->password) . "','";
		// $sql .= $database->escapeString($this->first_name) . "','";
		// $sql .= $database->escapeString($this->last_name) . "')";

		$sql .= "VALUES ('".  $values  ."')";
		
		if ($database->query($sql)) 
		{
			$this->id = $database->theInsertId();
			return true;
		}
		else
		{
			return false;
		}
	}

	public function update()
	{
		global $database;

		$sql = "UPDATE " .self::$db_table . " SET ";
		$sql .= "username= '" . $database->escapeString($this->username) . "', ";
		$sql .= "password= '" . $database->escapeString($this->password) . "', ";
		$sql .= "first_name= ' " . $database->escapeString($this->first_name) . " ', ";
		$sql .= "last_name= '" . $database->escapeString($this->last_name) . "' ";
		$sql .= " WHERE id= " . $database->escapeString($this->id);

		$database->query($sql);


		return (mysqli_affected_rows($database->connection) == 1) ? true : false;
	}

	public function delete()
	{
		global $database;

		$sql ="DELETE FROM " .self::$db_table . " WHERE id=".  $database->escapeString($this->id);
		$database->query($sql);
		return (mysqli_affected_rows($database->connection) == 1) ? true : false;
	}


} //Termina la clase

 ?>