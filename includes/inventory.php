<?php 
  
  // Require Database class
  require_once('database.php');
  // require_once('databaseobject.php');

  class Inventory extends DatabaseObject {


    protected static $products_table_name = "products"; 
    protected static $purchase_table_name = "purchase"; 
    protected static $sales_table_name = "sales"; 

    protected static $products_fields = array('product_id','product', 'quantity_left', 'quantity_sold', 'price', 'sales', 'product_description', 'product_date');
    protected static $purchase_fields = array('product_id', 'units_purchase', 'purchase_date');
    protected static $sales_fields = array('product_id', 'units_sold', 'sales_date', 'sales');

    public $id;

    // Product table Fields
    public $product;
    public $quantity_left;
    public $quantity_sold;
    public $price;
    public $sales;
    public $product_description;
    public $product_date;

    // Purchase table fields
    public $product_id = "";
    public $units_purchase;
    public $purchase_date;

    // Sales table fields
    public $units_sold;
    public $sales_date;

    // for product image
    public $filename;



     // Common database object
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

    public static function count_all() {
      global $database;

      $query = "SELECT COUNT(*) FROM ". self::$products_table_name;
      $result_set = $database->query($query);
      $row = $database->fetch_array($result_set);
      return array_shift($row);
    }

    public static function count_search($keyword) {
      global $database;

      $query = "SELECT COUNT(*) FROM " .self::$products_table_name;
      $query .= " WHERE product LIKE '%" .$keyword. "%'"; 
      $result_set = $database->query($query);
      $row = $database->fetch_array($result_set);
      return array_shift($row);
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




    // Class Methods


    // Method to check what table to use and will return attributes from the specific table
    protected function check_table_fields($tb_name) {

      if ($tb_name == self::$products_table_name) {
        $attributes = $this->attributes(self::$products_fields);
        return $attributes;

      } elseif ($tb_name == self::$purchase_table_name) {
        $attributes = $this->attributes(self::$purchase_fields);
        return $attributes;

      } elseif ($tb_name == self::$sales_table_name) {
        $attributes = $this->attributes(self::$sales_fields);
        return $attributes;

      }
    }

    // return an array of attribute keys and their values
    protected function attributes($tb_fields) {

      $attributes = array();
      foreach ($tb_fields as $field) {
        if (property_exists($this, $field)) {
          $attributes[$field] = $this->$field;
        }
      }
      return $attributes;
    }

    // Sanitize the values before submitting and returns clean attributes
    protected function sanitized_attributes($tb_name) {
      global $database;
      $clean_attributes = array();
      $attributes = $this->check_table_fields($tb_name);
      // sanitize the values before submitting
      // Note: does not alter the actual value of each attribute
      foreach ($attributes as $key => $value) {
        $clean_attributes[$key] = $database->escape_value($value);
      }
      return $clean_attributes;
    }

    // Method to check what table to use and will return table name
    protected static function check_table_name($tb_name) {
      if ($tb_name == self::$products_table_name) {
        return self::$products_table_name;

      } elseif ($tb_name == self::$purchase_table_name) {
        return self::$purchase_fields;

      } elseif ($tb_name == self::$sales_table_name) {
        return self::$sales_fields;
      }
    }

    // Selects all on products table
    public static function find_all_inventory($table_name) {
      global $database;

      return self::find_by_sql("SELECT * FROM " .$table_name);
    }

    public static function inventory_join_image() {
      global $database;

      $query = "SELECT products.product_id, products.product, products.price, products.product_description, product_image.filename ";
      $query .= "FROM products LEFT JOIN product_image ";
      $query .= "ON products.product_id=product_image.product_id";
      return self::find_by_sql($query);
    }

    // Find if record exist
    public static function find_if_exist($product_name, $table_name) {
      global $database;

      return self::find_by_sql("SELECT * FROM " . self::check_table_name($table_name) . " WHERE product = '{$product_name}'");
    }

    // Find record by id
    public static function find_by_product_id($id, $table_name) {
      global $database;

      $result_array = self::find_by_sql("SELECT * FROM " . $table_name . " WHERE product_id={$id}");
      return !empty($result_array) ? array_shift($result_array) : false;
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
        return true;
      } else {
        mysql_query("ROLLBACK");
        return false;
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

    public function add_item() {
      global $database;
      // Don't forget your SQL syntax and good habits:
      // - INSERT INTO table (key, key) VALUES ('value','value')
      // - single-quotes around all values
      // - escape all values to prevent sql injection

      // MYSQL Transactions
      mysql_query("SET AUTOCOMMIT=0");
      mysql_query("START TRANSACTION");

      $sales = Inventory::find_by_product_id($this->product_id, self::$sales_table_name);

      $attributes = $this->sanitized_attributes(self::$purchase_table_name);
      $query1 = "INSERT INTO ". self::$purchase_table_name ." (";
      $query1 .= join(", ", array_keys($attributes));
      $query1 .= ") VALUES ('";
      $query1 .= join("', '", array_values($attributes));
      $query1 .= "')";
      
      if ($database->query($query1)) {
        $this->id = $database->insert_id();
      } 

      $product = Inventory::find_by_product_id($this->product_id, self::$products_table_name);

      $attributes = $this->sanitized_attributes(self::$products_table_name);
      $query2 = "UPDATE ". self::$products_table_name ." SET ";
      $query2 .= "quantity_left = " .$product->quantity_left. " + ".$this->units_purchase." "; 
      $query2 .= "WHERE product_id=". $attributes['product_id'];

      if ($database->query($query2)) {
        mysql_query("COMMIT");
        $this->product_id = "";
        return true;
      } else {
        mysql_query("ROLLBACK");
        return false;
      }
    }

    public function items_sold() {
      global $database;
      // MYSQL Transactions
      mysql_query("SET AUTOCOMMIT=0");
      mysql_query("START TRANSACTION");

      $product = Inventory::find_by_product_id($this->product_id, self::$products_table_name);

      $attributes = $this->sanitized_attributes(self::$sales_table_name);
      $query1 = "INSERT INTO ". self::$sales_table_name ." (";
      $query1 .= join(", ", array_keys($attributes));
      $query1 .= ") VALUES (";
      $query1 .= "'".$attributes['product_id']."', '". $attributes['units_sold'] ."', '". $attributes['sales_date'] ."', '". $attributes['sales'] ."' * " .$product->price;
      $query1 .= ")";

      $difference = $product->quantity_left - $this->units_sold;
      if ($difference < 0) {
        return $message = "Units sold is over Quantity left! Cannot be subtracted.";
      } else {
        $query2 = "UPDATE ". self::$products_table_name ." SET ";
        $query2 .= "quantity_left = " .$product->quantity_left. " - ".$this->units_sold.", "; 
        $query2 .= "quantity_sold = " .$product->quantity_sold. " + ".$this->units_sold." "; 
        $query2 .= "WHERE product_id=". $product->product_id;

        if ($database->query($query1) && $database->query($query2)) {

          $updated_product = Inventory::find_by_product_id($this->product_id, self::$products_table_name);

          $query3 = "UPDATE ". self::$products_table_name ." SET ";
          $query3 .= "sales = " .$updated_product->quantity_sold. " * ".$updated_product->price." "; 
          $query3 .= "WHERE product_id=". $updated_product->product_id;

          $database->query($query3);
          mysql_query("COMMIT");
          $this->product_id = "";
          return true;

        } else {
          mysql_query("ROLLBACK");
          return false;
        }
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

      // MYSQL Transactions
      mysql_query("SET AUTOCOMMIT=0");
      mysql_query("START TRANSACTION");

      $sales = Inventory::find_by_product_id($this->product_id, self::$sales_table_name);

      if (is_object($sales)) {

        $product = Inventory::find_by_product_id($this->product_id, self::$products_table_name);

        $query1 = "DELETE FROM ". self::$products_table_name ." ";
        $query1 .= "WHERE product_id=". $database->escape_value($product->product_id);
        $query1 .= " LIMIT 1";

        $purchase = Inventory::find_by_product_id($this->product_id, self::$purchase_table_name);

        $query2 = "DELETE FROM ". self::$purchase_table_name ." ";
        $query2 .= "WHERE product_id=". $database->escape_value($purchase->product_id);

        $sales = Inventory::find_by_product_id($this->product_id, self::$sales_table_name);

        $query3 = "DELETE FROM ". self::$sales_table_name ." ";
        $query3 .= "WHERE product_id=". $database->escape_value($sales->product_id);
        
        if ($database->query($query1) && $database->query($query2) && $database->query($query3)) {
          mysql_query("COMMIT");
          return $message = "Record Deleted.";
        }
      } else {
       
        $product = Inventory::find_by_product_id($this->product_id, self::$products_table_name);

        $query1 = "DELETE FROM ". self::$products_table_name ." ";
        $query1 .= "WHERE product_id=". $database->escape_value($product->product_id);
        $sql .= " LIMIT 1";

        $purchase = Inventory::find_by_product_id($this->product_id, self::$purchase_table_name);

        $query2 = "DELETE FROM ". self::$purchase_table_name ." ";
        $query2 .= "WHERE product_id=". $database->escape_value($purchase->product_id);

        if ($database->query($query1) && $database->query($query2)) {
          mysql_query("COMMIT");
          return true;
        } else {
          mysql_query("ROLLBACK");
          return false;
        }
      }
    }


   

  }

 ?>