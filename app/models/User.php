<?php

namespace app\models;

// Include the bootstrap file for global setup
require_once BASE_DIR . '/bootstrap.php';

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

    public function doesUsernameExist($username) {
        $stmt = $this->db->conn->prepare("SELECT COUNT(*) FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $count = $stmt->fetchColumn();
        return $count > 0;
    }

    // Authenticates a user by username and password
    public function createPasswordResetToken($email) {
        $token = bin2hex(random_bytes(32));
        $expires = date('Y-m-d H:i:s', strtotime('+1 hour'));
        
        $stmt = $this->db->conn->prepare('UPDATE users SET reset_token = ?, reset_expires = ? WHERE email = ?');
        $stmt->execute([$token, $expires, $email]);
        
        return $token;
    }
    
    // Verifies the password reset token
    public function verifyResetToken($token) {
        $stmt = $this->db->conn->prepare('SELECT * FROM users WHERE reset_token = ? AND reset_expires > NOW() AND reset_token IS NOT NULL');
        $stmt->execute([$token]);
        return $stmt->fetch(\PDO::FETCH_OBJ);
    }
    
    // Updates the user's password
    public function updatePassword($userId, $newPassword) {
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        $stmt = $this->db->conn->prepare('UPDATE users SET password = ?, reset_token = NULL, reset_expires = NULL WHERE id = ?');
        return $stmt->execute([$hashedPassword, $userId]);
    }
    
    // Retrieves a user by email
    public function getUserByEmail($email) {
        $stmt = $this->db->conn->prepare('SELECT * FROM users WHERE email = ?');
        $stmt->execute([$email]);
        return $stmt->fetch(\PDO::FETCH_OBJ);
    }
}
