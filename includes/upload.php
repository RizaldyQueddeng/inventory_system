<?php 

  require_once('database.php');

  class Upload extends DatabaseObject {

    protected static $table_name = "product_image";
    protected static $db_fields = array('id', 'filename', 'type', 'size');

    public $id;
    public $filename;
    public $type;
    public $size;
    
    private $temp_path;
    protected $upload_dir = "img";
    public $errors = array();
    protected $upload_errors = array(
      UPLOAD_ERR_OK         => "No errors.",
      UPLOAD_ERR_INI_SIZE   => "Larger than upload_max_filesize.",
      UPLOAD_ERR_FORM_SIZE  => "Larger than form MAX_FILE_SIZE",
      UPLOAD_ERR_PARTIAL    => "Partial upload.",
      UPLOAD_ERR_NO_FILE    => "No file.",
      UPLOAD_ERR_NO_TMP_DIR => "No temporary directory.",
      UPLOAD_ERR_CANT_WRITE => "Can't write to disk.",
      UPLOAD_ERR_EXTENSION  => "File upload stopped by an extension."
    );

    // Pass in $_FILE(['upload_file']) as an argument
    public function attach_file($file) {
      // Perform error checking on the form parameters
      if (!$file || empty($file) || !is_array($file)) {
        // error: nothing uploaded or wrong argument usage
        $this->errors[] = "No such file was uploaded.";
        return false;
      } elseif ($file['error'] != 0) {
        // error: report what PHP says went wrong
        $this->errors[] = $this->upload_errors[$file['errors']];
        return false;
      } else {
        // Set object attributes to the form parameters
        $this->temp_path = $file['tmp_name'];
        $this->filename = basename($file['name']);
        $this->type = $file['type'];
        $this->size = $file['size'];

        // Don't worry about saving anything to the database yet
        return true; 
      }
    }

    public function save() {
      // A new record won't have an id yet.
      if (isset($this->id)) {
        // Just to update the caption
        $this->update();
      } else {
        // Attempt to move the file
        // Make sure there are no errors
        // Cant save if there are pre-existing errors
        if (!empty($this->errors)) { return false; }

        // Can't save without filename and temp location
        if (empty($this->filename) || empty($this->temp_path)) {
          $this->errors[] = "The file location was not available.";
          return false;
        }

        // Determine the target_path
        $target_path = 'c:/xampp/localhost/inventory_system/assets/img/' . $this->upload_dir "/" . $this->filename;

        // Make sure a file doesn't already exist in the target location
        if (file_exists($target_path)) {
          $this->errors[] = "The file {$this->filename} already exists.";
          return false;
        }

        // Attempt to move the file
        if (move_uploaded_file($this->temp_path, $target_path)) {
          // Success
          // Save a corresponding entry to the database
          if ($this->create()) {
            // We are done with temp_path, the file isn't there anymore
            unset($this->temp_path);
            return true;
          }
        } else {
          // File was not moved.
          $this->errors[] = "The file uploaded failed, possibly due to incorrect permissions on the upload folder.";
          return false;
        }
      }
    }
    

    // DatabaseObject methods

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

    // replace with a custom save()
    // public function save() {
    //   // A new record won't have an id yet.
    //   return isset($this->id) ? $this->update() : $this->create();
    // }

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