<?php
  class DB {
    private $conn;

    public function __construct($db_config) {
      try{
          $this->conn = new mysqli(
              $db_config["server"],
              $db_config["user"],
              $db_config["password"],
              $db_config["dbname"],
            );
      }
      catch(mysqli_sql_exception){
          echo "Connection failed";
      }
    }

    public function getConnection() {
      return $this->conn;
    }
  }
?>