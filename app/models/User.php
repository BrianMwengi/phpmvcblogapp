<?php

namespace app\models;

require_once __DIR__ . '/../../config/db.php';

class User {
    private $db;

    // Constructor: Initializes database connection
    public function __construct() {
        $this->db = new \Database; // Establishes database connection
    }

    // Fetches all users from the database
    public function getUsers() {
        $result = $this->db->conn->query('SELECT * FROM users');
        return $result->fetchAll(\PDO::FETCH_OBJ); // Returns users as objects
    }
    
    // Retrieves a single user by username
    public function getUserByUsername($username) {
        $stmt = $this->db->conn->prepare('SELECT * FROM users WHERE username = ?');
        $stmt->execute([$username]); // Executes with provided username
        return $stmt->fetch(\PDO::FETCH_OBJ); // Returns the user as an object
    }

    // Creates a new user record
    public function createUser($username, $password, $is_admin = 0) {
        $stmt = $this->db->conn->prepare('INSERT INTO users (username, password, is_admin) VALUES (?, ?, ?)');
        $stmt->execute([$username, $password, $is_admin]); // Inserts new user
    }

    // Updates an existing user's username and password
    public function updateUser($id, $username, $password) {
        $stmt = $this->db->conn->prepare('UPDATE users SET username = ?, password = ? WHERE id = ?');
        $stmt->execute([$username, $password, $id]); // Updates user by ID
    }

    // Deletes a user by ID
    public function deleteUser($id) {
        $stmt = $this->db->conn->prepare('DELETE FROM users WHERE id = ?');
        $stmt->execute([$id]); // Deletes the specified user
    }
}
