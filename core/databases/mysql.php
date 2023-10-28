<?php 

namespace Oracle\databases\mysql;
use \Oracle\lib\util\Util;
use Exception; // don't know why this was needed but it works. yay

include "../lib/env_loader/env_loader.php";

class MySQL extends Util {
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
        } catch(Exception $error){
            echo $error;
        }
    }

    private function __destruct(){
        $this->conn   = null;
        $this->host   = null;
        $this->user   = null;
        $this->pass   = null;
        $this->dbname = null;

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
        echo "Connected successfully\n";
    }

    public function getConnection() {
        return $this->conn;
    }

    public function insert($table, $data) {
        $columns = implode(", ", array_keys($data));
        $values = str_repeat("?, ", count($data) - 1) . "?";
        $query = "INSERT INTO $table ($columns) VALUES ($values)";

        $stmt = $this->prepareStatement($query, array_values($data));

        if ($stmt->execute()) {
            return "Record added successfully!\n";
        } else {
            return "Error: " . $stmt->error;
        }
    }

    public function select($table, $columns, $whereColumn, $whereValue) {
        $columnList = implode(", ", $columns);
        $query = "SELECT $columnList FROM $table WHERE $whereColumn = ?";

        $stmt = $this->prepareStatement($query, [$whereValue]);
        $stmt->execute();
        $result = $stmt->get_result();

        $rows = [];
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }

        $stmt->close();
        return $rows;
    }

    public function update($table, $data, $whereColumn, $whereValue) {
        $setClause = implode(" = ?, ", array_keys($data)) . " = ?";
        $query = "UPDATE $table SET $setClause WHERE $whereColumn = ?";

        $stmt = $this->prepareStatement($query, array_merge(array_values($data), [$whereValue]));

        if ($stmt->execute()) {
            return "Updated rows: " . $stmt->affected_rows . "\n";
        } else {
            return "Error: " . $stmt->error;
        }
    }

    public function delete($table, $whereColumn, $whereValue) {
        $query = "DELETE FROM $table WHERE $whereColumn = ?";

        $stmt = $this->prepareStatement($query, [$whereValue]);

        if ($stmt->execute()) {
            return "Deleted rows: " . $stmt->affected_rows . "\n";
        } else {
            return "Error: " . $stmt->error;
        }
    }

    private function prepareStatement($query, $params) {
        $stmt = $this->conn->prepare($query);

        if (!$stmt) {
            die("Prepare failed: " . $this->conn->error);
        }

        if ($params) {
            $types = '';
            $paramReferences = [];
            foreach ($params as &$param) {
                if (is_int($param)) {
                    $types .= 'i'; // Integer
                } elseif (is_double($param)) {
                    $types .= 'd'; // Double
                } else {
                    $types .= 's'; // String
                }
                $paramReferences[] = &$param;
            }

            array_unshift($paramReferences, $types);

            call_user_func_array([$stmt, 'bind_param'], $paramReferences);
        }

        return $stmt;
    }
}

// $mysql = new MySQL();

// Example usages
// echo $mysql->insert("users", ["username" => "john", "email" => "john@example.com"]);
// echo $mysql->select("users", ["id", "username", "email"], "username", "john");
// echo $mysql->update("users", ["email" => "new_email@example.com"], "username", "john");
// echo $mysql->delete("users", "username", "john");
