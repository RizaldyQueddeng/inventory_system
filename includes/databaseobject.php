<?php 
  
  require_once('database.php');
  require_once('user.php');

  class DatabaseObject {

    // protected static $table_name; 
    
    // // Common database object
    // public static function find_all() {
    //   global $database;

    //   return static::find_by_sql("SELECT * FROM ".static::$table_name);
    // }

    // public static function find_by_id($id=0) {
    //   global $database;

    //   $result_array = static::find_by_sql("SELECT * FROM " . static::$table_name . " WHERE id={$id}");
    //   return !empty($result_array) ? array_shift($result_array) : false;
    // }

    // public static function find_by_sql($sql="") {
    //   global $database;

    //   $result_set = $database->query($sql);
    //   $object_array = array();
    //   while ($row = $database->fetch_array($result_set)) {
    //     $object_array[] = static::instantiate($row);
    //   }
    //   return $object_array;
    // }

    // private static function instantiate($record) {
    //   // Could check that $record exists and is an array
    //   // Simple long form approach

    //   $class_name = get_called_class();
    //   $object = new $class_name;
    //   // $object->id         = $record['id'];
    //   // $object->username   = $record['username'];
    //   // $object->password   = $record['password'];
    //   // $object->first_name = $record['first_name'];
    //   // $object->last_name  = $record['last_name'];

    //   // More dynamic, short-form approach
    //   foreach ($record as $attribute => $value) {
    //     if (self::has_attribute($attribute)) {
    //       $object->$attribute = $value; 
    //     }
    //   }
    //   return $object;
    // }

    // private static function has_attribute($attribute) {
    //   // get_object_vars returns an associative array with all attributes
    //   // (include private ones!) as the keys and their current values as the value
    //   $class_name = get_called_class();
    //   $object = new $class_name;
    //   $object_vars = get_object_vars($object);

    //   // We don't care about the value, we just want to know if the key exists
    //   // Will return true of false
    //   return array_key_exists($attribute, $object_vars);
    // }

   
  }


 ?>