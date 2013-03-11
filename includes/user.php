<?php 
  
  // Require Database class
  require_once('database.php');
  require_once('databaseobject.php');

	class User extends DatabaseObject {

    protected static $table_name = "users";
    protected static $db_fields = array(
      'id', 'username', 'password', 'email', 'first_name', 'last_name', 'address', 'age', 'gender', 'contact_number'
      );

    public $id;
    public $username;
    public $password;
    public $email;
    public $first_name;
    public $last_name;
    public $address;
    public $age;
    public $gender;
    public $contact_number;

    // Class Methods

    public function full_name() {
      if (isset($this->first_name) && isset($this->last_name)) {
        return $this->first_name . " " . $this->last_name;
      } else {
        return "";
      }
    }

    public static function authenticate($username="", $password="") {
      global $database;

      $username = $database->escape_value($username);
      $password = $database->escape_value($password);

      $sql  = "SELECT * FROM ". self::$table_name ." ";
      $sql .= "WHERE username = '$username' ";
      $sql .= "AND password = '$password' ";
      $sql .= "LIMIT 1";

      $result_array = self::find_by_sql($sql);
      return !empty($result_array) ? array_shift($result_array) : false;
    }
		
    // Common database object
    public static function count_all() {
      global $database;

      $query = "SELECT COUNT(*) FROM ". self::$table_name;
      $result_set = $database->query($query);
      $row = $database->fetch_array($result_set);
      return array_shift($row);
    }

    public static function count_search($keyword) {
      global $database;

      $query = "SELECT COUNT(*) FROM " .self::$table_name;
      $query .= " WHERE first_name LIKE '%" .$keyword. "%' "; 
      $query .= "OR last_name LIKE '%" .$keyword. "%'";
      $result_set = $database->query($query);
      $row = $database->fetch_array($result_set);
      return array_shift($row);
    }

    public static function find_all() {
      global $database;

      return self::find_by_sql("SELECT * FROM ".self::$table_name);
    }

    public static function find_by_id($id=0) {
      global $database;

      $result_array = self::find_by_sql("SELECT * FROM " . self::$table_name . " WHERE id={$id}");
      return !empty($result_array) ? array_shift($result_array) : false;
    }

    public static function find_by_sql($sql="") {
      global $database;

      $result_set = $database->query($sql);
      $object_array = array();
      while ($row = $database->fetch_array($result_set)) {
        $object_array[] = self::instantiate($row);
      }
      return $object_array;
    }

    private static function instantiate($record) {
      // Could check that $record exists and is an array
      // Simple long form approach

      $class_name = get_called_class();
      $object = new $class_name;
      // $object->id         = $record['id'];
      // $object->username   = $record['username'];
      // $object->password   = $record['password'];
      // $object->first_name = $record['first_name'];
      // $object->last_name  = $record['last_name'];

      // More dynamic, short-form approach
      foreach ($record as $attribute => $value) {
        if (self::has_attribute($attribute)) {
          $object->$attribute = $value; 
        }
      }
      return $object;
    }

    private static function has_attribute($attribute) {
      // get_object_vars returns an associative array with all attributes
      // (include private ones!) as the keys and their current values as the value
      $class_name = get_called_class();
      $object = new $class_name;
      $object_vars = get_object_vars($object);

      // We don't care about the value, we just want to know if the key exists
      // Will return true of false
      return array_key_exists($attribute, $object_vars);
    }

    protected function attributes() {
      // return an array of attribute keys and their values
      $attributes = array();
      foreach (self::$db_fields as $field) {
        if (property_exists($this, $field)) {
          $attributes[$field] = $this->$field;
        }
      }
      return $attributes;
    }

    protected function sanitized_attributes() {
      global $database;
      $clean_attributes = array();
      // sanitize the values before submitting
      // Note: does not alter the actual value of each attribute
      foreach ($this->attributes() as $key => $value) {
        $clean_attributes[$key] = $database->escape_value($value);
      }
      return $clean_attributes;
    }

    public function save() {
      // A new record won't have an id yet.
      return isset($this->id) ? $this->update() : $this->create();
    }

    public function create() {
      global $database;
      // Don't forget your SQL syntax and good habits:
      // - INSERT INTO table (key, key) VALUES ('value','value')
      // - single-quotes around all values
      // - escape all values to prevent sql injection
      $attributes = $this->sanitized_attributes();
      $sql = "INSERT INTO ". self::$table_name ." (";
      $sql .= join(", ", array_keys($attributes));
      $sql .= ") VALUES ('";
      $sql .= join("', '", array_values($attributes));
      $sql .= "')";
      if ($database->query($sql)) {
        $this->id = $database->insert_id();
        return true;
      } else {
        return false;
      }
    }

    public function update() {
      global $database;
      // Dont forget your SQL syntax and good habits
      // - UPDATE table SET key='value', key='value' WHERE condition
      // - single-quotes around all values
      // - escape all values to prevent SQL injection
      $attributes = $this->sanitized_attributes();
      $attribute_pairs = array();
      foreach ($attributes as $key => $value) {
        $attribute_pairs[] = "{$key}='{$value}'";
      }
      $sql = "UPDATE ". self::$table_name ." SET ";
      $sql .= join(", ", $attribute_pairs); 
      $sql .= " WHERE id=". $database->escape_value($this->id);
      $database->query($sql);
      return ($database->affected_rows() == 1) ? true : false;
    }

    public function delete() {
      global $database;
      // Don't forget SQL syntax and good habits:
      // - DELETE FROM table WHERE condition LIMIT 1
      // - escape all values to prevent SQL injection
      // - use LIMIT 1

      $sql = "DELETE FROM ". self::$table_name ." ";
      $sql .= "WHERE id=". $database->escape_value($this->id);
      $sql .= " LIMIT 1";
      $database->query($sql);
      return ($database->affected_rows() == 1) ? true : false; 
    }

	}

 ?>