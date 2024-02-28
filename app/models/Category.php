<?php

namespace app\models;

// Include the bootstrap file for global setup
require_once BASE_DIR . '/bootstrap.php';

class Category {
    private $db;

    // Initialize connection in constructor
    public function __construct() {
        $this->db = new \Database; // Create a Database object for connection
    }
    
    public function getCategory($id) {
        // Prepare a SQL statement
        $stmt = $this->db->conn->prepare("SELECT * FROM categories WHERE id = ?");
        // Execute the statement with the ID
        $stmt->execute([$id]);
        // Fetch the category and return it
        return $stmt->fetch(\PDO::FETCH_OBJ);
    }

    public function getCategories() {
        // Fetch all categories from the database
        $stmt = $this->db->conn->query("SELECT * FROM categories");
        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }

    public function create($data) {
        // Insert a new category into the database
        $stmt = $this->db->conn->prepare("INSERT INTO categories (name) VALUES (:name)");
        $stmt->execute([':name' => $data['name']]);
    }

    public function updateCategory($data, $id) {
        $stmt = $this->db->conn->prepare("UPDATE categories SET name = :name WHERE id = :id");
        $stmt->execute([':name' => $data['name'], ':id' => $id]);
    }

    public function getPosts($categoryId) {
        // Get the posts in a specific category
        $stmt = $this->db->conn->prepare("SELECT * FROM posts WHERE category_id = ?");
        $stmt->execute([$categoryId]);
        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }

    public function deleteCategory($id) {
        // Delete a category from the database
        $stmt = $this->db->conn->prepare("DELETE FROM categories WHERE id = :id");
        $stmt->execute([':id' => $id]);
    }
}