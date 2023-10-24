<?php 

namespace Oracle\databases\mysql;
use \Oracle\lib\util\Util;
use Exception; // don't know why this was needed but it works. yay

include "../lib/env_loader/env_loader.php";

class mysql extends Util{
    private string $host;
    private string $user;
    private string $pass;
    private string $dbname;
    private $conn;
    private $stmt;

    public function __construct(){
        $loaded = loadEnv();
        if ($loaded) {
            echo "Environment variables loaded successfully from envFile.\n";
        } else {
            echo "No .env file found or failed to load environment variables.\n";
        }

        $this->host     = $_ENV['db_host'];
        $this->user     = $_ENV['db_username'];
        $this->pass     = $_ENV['db_password'];
        $this->dbname   = $_ENV['db_database'];

        try{
            $this->connect();
        }catch(Exception $error){
            echo $error;
        }
    }

    private function __destruct(){
        $this->conn     = null;
        $this->host     = null;
        $this->user     = null;
        $this->pass     = null;
        $this->dbname   = null;

        mysqli_close($this->conn);
        mysqli_stmt_close($this->stmt);
    }

    private function connect(){
        $this->conn = mysqli_connect(
            $this->host,
            $this->user,
            $this->pass,
            $this->dbname
        );

        // Check connection
        if (!$this->conn) {
          die("Connection failed: " . mysqli_connect_error());
        }
        echo "Connected successfully";
    }

    public function getConnection() {
        return $this->conn;
    }
    

    public function insert($table, array $Data){
        try{
            $questionMarks  = str_repeat('?,', count($Data) - 1) . '?';
            $this->stmt     = mysqli_prepare($this->conn, "INSERT INTO $table VALUES ($questionMarks)");
            
            if (!$this->stmt) {
                die("Preparation failed: " . mysqli_error($this->conn));
            }
            
            foreach($Data as $data){
                mysqli_stmt_bind_param(
                    $this->stmt, 
                    $this->getParamTypeString($data), 
                    $data
                );
            }
            
            if (mysqli_stmt_execute($this->stmt)) {
                echo "Record added successfully!";
            } else {
                echo "Error: " . mysqli_stmt_error($this->stmt);
            }

        }catch(Exception $error){
            echo $error;
        }
    }

    public function select($table, ...$col, ...$colData, ...$search){ // aka read
        try{
            $qMark = str_repeat('?,', count($colData) - 1) . '?';
            $conditionValue = [];
            $sql = "SELECT $col FROM $table WHERE $colData = $qMark";

            // Prepare the statement
            $this->stmt = mysqli_prepare($this->conn, $sql);

            // handle if preparation failed
            if (!$this->stmt) {
                die("Prepare failed: " . mysqli_error($this->conn));
            }

            foreach($colData as $data){
                $conditionValue[] = $data; // Replace with your condition value
            }

            // Bind the parameter to the statement
            mysqli_stmt_bind_param(
                $this->stmt, 
                $this->getParamTypeString($colData), 
                $conditionValue
            );

            // Execute the statement
            if (mysqli_stmt_execute($this->stmt)) {
                mysqli_stmt_store_result($this->stmt);

                // Bind result variables
                $col = null;
                mysqli_stmt_bind_result($this->stmt, $col);

                // Fetch and process results
                while (mysqli_stmt_fetch($this->stmt)) {
                    return $col;
                }
            } else {
                die("Execute failed: " . mysqli_stmt_error($this->stmt));
            }


        }catch(Exception $error){
            echo $error;
        }
    }


}