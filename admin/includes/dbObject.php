<?php 
class DbObject
{
	protected static $db_table ="users";
	public static function findAll()
	{
		
		return static::findByQuery("SELECT * FROM " . static::$db_table ." ");

	}

	public static function findById($id)
	{
		global $database;
		$theResultArray = static::findByQuery("SELECT * FROM " . static::$db_table . " WHERE id = $id LIMIT 1");

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

	public static function findByQuery($sql)
	{
		global $database;
		$result_set = $database->query($sql);
		$theObjectArray = array();
		while ($row = mysqli_fetch_array($result_set)) {
			$theObjectArray[] = static::instantiation($row);
		}
		return $theObjectArray;

	}

	public static function instantiation($foundUser)
	{
		$callingClass = get_called_class();
        // $theObject = new static;
        $theObject = new $callingClass;


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

		foreach (static::$dbTableFields as $dbFields ) 
		{
			if (property_exists($this, $dbFields)) 
			{
				$properties[$dbFields] = $this->$dbFields;
			}
		}

		return $properties;
	}

	protected function cleanProperties()
	{
		global $database;

		$cleanProperties = array();

		foreach ($this->properties() as $key => $value) 
		{
			$cleanProperties[$key] = $database->escapeString($value);
		}

		return $cleanProperties;

	}

	public function save()
	{
		return isset($this->id) ? $this->update() : $this->create();
	}

	public function create()
	{
		global $database;

		// $properties = $this->properties();
		$properties = $this->cleanProperties();
		$keys = implode(",",array_keys($properties));
		$values = implode("','",array_values($properties));
		// var_dump($keys);
		// echo "<br>";
		// var_dump($values);

		// $sql = "INSERT INTO " .static::$db_table . " (username,password,first_name,last_name)";
		
		// $sql .= "VALUES ('";
		// $sql .= $database->escapeString($this->username) . "','";
		// $sql .= $database->escapeString($this->password) . "','";
		// $sql .= $database->escapeString($this->first_name) . "','";
		// $sql .= $database->escapeString($this->last_name) . "')";

		$sql = "INSERT INTO " . static::$db_table . " (" . $keys .")";
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
		// $properties = $this->properties();
		$properties = $this->cleanProperties();
		$propertiesPairs = array();

		foreach ($properties as $key => $value) 
		{
			$properties_pairs[] = "{$key}='{$value}'";
		}

		$sql = "UPDATE " .static::$db_table . " SET ";
		// $sql .= "username= '" . $database->escapeString($this->username) . "', ";
		// $sql .= "password= '" . $database->escapeString($this->password) . "', ";
		// $sql .= "first_name= ' " . $database->escapeString($this->first_name) . " ', ";
		// $sql .= "last_name= '" . $database->escapeString($this->last_name) . "' ";
		$sql.= implode(", ", $properties_pairs);
		$sql .= " WHERE id= " . $database->escapeString($this->id);

		//var_dump($sql);

		$database->query($sql);


		return (mysqli_affected_rows($database->connection) == 1) ? true : false;
	}

	public function delete()
	{
		global $database;

		$sql ="DELETE FROM " .static::$db_table . " WHERE id=".  $database->escapeString($this->id);
		$database->query($sql);
		return (mysqli_affected_rows($database->connection) == 1) ? true : false;
	}

}


 ?>