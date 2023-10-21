<?php 

namespace Oracle\databases\mysql;
use \Oracle\lib\util\Util;
use Exception; // don't know why this was needed but it works. yay

include "../lib/env_loader/env_loader.php";

class mysql extends Util{
    private $conn;
    private $host;
    private $user;
    private $pass;
    private $dbname;
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
            $questionMarks = str_repeat('?,', count($Data) - 1) . '?';
            $this->stmt = mysqli_prepare($this->conn, "INSERT INTO $table VALUES ($questionMarks)");
            
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

    public function select(){
        try{

        }catch(Exception $error){
            echo $error;
        }
    }


}