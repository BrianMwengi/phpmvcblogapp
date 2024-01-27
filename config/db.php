<?php

// Define database connection details
class Database {
    private $host = 'localhost'; // Database server address
    private $db_name = 'phpblogapp'; // Database name
    private $username = 'root'; // Database username
    private $password = ''; // Database password (leave empty for security)
    public $conn; // PDO connection object

    // Establish database connection upon object creation
    public function __construct() {
        try {
            // Create a PDO connection
            $this->conn = new PDO(
                "mysql:host=$this->host;dbname=$this->db_name",
                $this->username,
                $this->password
            );

            // Set character encoding to UTF-8
            $this->conn->exec("set names utf8");
        } catch (PDOException $exception) {
            // Handle connection error
            echo "Connection error: " . $exception->getMessage();
        }
    }
}


