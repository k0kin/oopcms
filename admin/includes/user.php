<?php 

/**
* 
*/
class User 
{
	public $id;
	public $username;
	public $password;
	public $firstName;
	public $lastName;


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
        // $user->firstName = $foundUser['first_name'];
        // $user->lastName = $foundUser['last_name'];		

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


	public function create()
	{
		global $database;

		$sql = "INSERT INTO users(username,password,first_name,last_name)";
		$sql .= "VALUES ('";
		$sql .= $database->escapeString($this->username) . "','";
		$sql .= $database->escapeString($this->password) . "','";
		$sql .= $database->escapeString($this->firstName) . "','";
		$sql .= $database->escapeString($this->lastName) . "')";
		
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


} //Termina la clase

 ?>