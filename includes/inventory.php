<?php 
  
  // Require Database class
  require_once('database.php');

  class Inventory extends DatabaseObject {


    protected static $products_table_name = "products"; 
    protected static $purchase_table_name = "purchase"; 
    protected static $sales_table_name = "sales"; 

    protected static $products_fields = array('product', 'quantity_left', 'quantity_sold', 'price', 'sales', 'product_description', 'product_date');
    protected static $purchase_fields = array('product_id', 'units_purchase', 'purchase_date');
    protected static $sales_fields = array('product_id', 'quantity', 'sales_date', 'sales');

    public $id;

    // Product table Fields
    public $product;
    public $quantity_left;
    public $quantity_sold;
    public $price;
    public $sales;
    public $product_description;
    public $product_date;

    // Purchase and Sales table fields
    public $product_id = "";
    public $units_purchase;
    public $purchase_date;
    public $quantity;

    // for output return
    public $message="";


    protected function check_table_fields($tb_name) {

      if ($tb_name == self::$products_table_name) {
        $attributes = $this->attributes(self::$products_fields);
        return $attributes;

      } elseif ($tb_name == self::$purchase_table_name) {
        return $this->attributes(self::$purchase_fields);
        return $attributes;

      } elseif ($tb_name == self::$sales_table_name) {
        return $this->attributes(self::$sales_fields);
        return $attributes;

      }
    }

    protected function attributes($tb_fields) {
      // return an array of attribute keys and their values

      $attributes = array();
      foreach ($tb_fields as $field) {
        if (property_exists($this, $field)) {
          $attributes[$field] = $this->$field;
        }
      }
      return $attributes;
    }

    protected function sanitized_attributes($tb_fields) {
      global $database;
      $clean_attributes = array();
      $attributes = $this->check_table_fields($tb_fields);
      // sanitize the values before submitting
      // Note: does not alter the actual value of each attribute
      foreach ($attributes as $key => $value) {
        $clean_attributes[$key] = $database->escape_value($value);
      }
      return $clean_attributes;
    }

    public static function find_all_inventory() {
      global $database;

      return static::find_by_sql("SELECT * FROM ".static::$products_table_name);
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

      // MYSQL Transactions
      mysql_query("SET AUTOCOMMIT=0");
      mysql_query("START TRANSACTION");

      $attributes = $this->sanitized_attributes(self::$products_table_name);
      $query1 = "INSERT INTO ". self::$products_table_name ." (";
      $query1 .= join(", ", array_keys($attributes));
      $query1 .= ") VALUES ('";
      $query1 .= join("', '", array_values($attributes));
      $query1 .= "')";
      
      if ($database->query($query1)) {
        $this->id = $database->insert_id();
        $this->product_id = $this->id;
      } 
      
      $attributes = $this->sanitized_attributes(self::$purchase_table_name);
      $query2 = "INSERT INTO ". self::$purchase_table_name ." (";
      $query2 .= join(", ", array_keys($attributes));
      $query2 .= ") VALUES ('";
      $query2 .= join("', '", array_values($attributes));
      $query2 .= "')";

      if ($database->query($query2)) {
        $this->id = $database->insert_id();
        mysql_query("COMMIT");
        return $this->message = "Product added succesfully.";

      } else {
        mysql_query("ROLLBACK");
      }

      // if ($database->query($query1)) {
      //   $this->id = $database->insert_id();
      //   $database->query($query2);
      //   mysql_query("COMMIT");
      //   return true;
      // } else {
      //   mysql_query("ROLLBACK");
      //   return false;
      // }
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