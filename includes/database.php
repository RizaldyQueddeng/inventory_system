<?php 

  include_once("config.php");

  class MySQLDatabase {
    private $connection;
    public $last_query;
    private $magic_quotes_active;

    function __construct() {
      $this->open_connection();
      $this->magic_quotes_active = get_magic_quotes_gpc();
    }

    public function open_connection() {
      $this->connection = mysql_connect('localhost', "root", "");
      if (!$this->connection) {
        die("Database connection failed: " . mysql_error());
      } else {
        $db_select = mysql_select_db('liveedit', $this->connection);
        if (!$db_select) {
          die("Database selection failed: " . mysql_error());
        }
      }
    }

    public function close_connection() {
      if (isset($this->connection)) {
        mysql_close($this->connection);
        unset($this->connection);
      }
    }

    public function query($sql) {
      $this->last_query = $sql;
      $result = mysql_query($sql, $this->connection);
      $this->confirm_query($result);
      return $result;
    }

    public function escape_value($value) {
      if ($this->magic_quotes_active) {
        $value = stripslashes($value);
      }
      $value = mysql_real_escape_string($value);
      return $value;
    }

    // "database-neutral" methods 

    public function fetch_array($result_set) {
      return mysql_fetch_array($result_set);
    }

    public function num_rows($result_set) {
      return mysql_num_rows($result_set);
    }

    public function insert_id() {
      // get the last id inserted over the current db connection
      return mysql_insert_id($this->connection);
    }

    public function affeted_rows() {
      return mysql_affected_rows($this->connection);
    }

    private function confirm_query($result) {
      if (!$result) {
        $output = "Database query failed: " . mysql_error() . "<br />";
        $output .= "Last SQL query: " . $this->last_query;
        die($output);
      }
    }

  }

  $database = new MySQLDatabase();

 ?>