<?php

require __DIR__ . '/../bootstrap.php'; 

$db = new Database;

// Create users table
$query = "CREATE TABLE IF NOT EXISTS users (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    is_admin TINYINT(1) NOT NULL DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

// Insert sample users
$query = "INSERT INTO users (username, password, is_admin) VALUES
   ('user1', '" . password_hash('password1', PASSWORD_DEFAULT) . "', 0) ";
$db->conn->exec($query);
echo "Users Table created successifully!";
