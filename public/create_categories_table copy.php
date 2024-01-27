<?php

require __DIR__ . '/../config/db.php';

$db = new Database;

// Create categories table
$query = "CREATE TABLE IF NOT EXISTS categories (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
$db->conn->exec($query);

echo 'Categories table created successfully';
?>


