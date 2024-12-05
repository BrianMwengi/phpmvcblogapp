<?php

require __DIR__ . '/../bootstrap.php';
$db = new Database;

$query = "ALTER TABLE users 
          ADD COLUMN email VARCHAR(255) UNIQUE AFTER username,
          ADD COLUMN reset_token VARCHAR(64) DEFAULT NULL,
          ADD COLUMN reset_expires DATETIME DEFAULT NULL";

try {
    $db->conn->exec($query);
    echo "Reset password fields added successfully!";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}