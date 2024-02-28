<?php

namespace app\models;

// Include the bootstrap file for global setup
require_once BASE_DIR . '/bootstrap.php';


class Comment {
    private $db;

    // Initialize connection in constructor
    public function __construct() {
        $this->db = new \Database; // Create a Database object for connection
    }

    public function createComment($postId, $content) {
        // Prepare a SQL statement
        $stmt = $this->db->conn->prepare("INSERT INTO comments (post_id, content) VALUES (?, ?)");
        // Execute the statement with the post ID and the content
        $stmt->execute([$postId, $content]);
    }
    
    public function getComments($postId) {
        // Prepare a SQL statement
        $stmt = $this->db->conn->prepare("SELECT * FROM comments WHERE post_id = ?");
        // Execute the statement with the post ID
        $stmt->execute([$postId]);
        // Return the result as an object
        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }
    
    public function getCommentById($id) {
        // Prepare a SQL statement
        $stmt = $this->db->conn->prepare("SELECT * FROM comments WHERE id = ?");
        // Execute the statement with the ID
        $stmt->execute([$id]);
        // Return the result as an object
        return $stmt->fetch(\PDO::FETCH_OBJ);
    }

    public function updateComment($id, $data) {
        // Prepare a SQL statement
        $stmt = $this->db->conn->prepare("UPDATE comments SET content = ? WHERE id = ?");
        // Execute the statement with the new content and the ID
        return $stmt->execute([$data['content'], $id]); // Return the result
    }

    public function deleteComment($id) {
        // Get the comment
        $comment = $this->getCommentById($id);
        // Check if the comment exists
        if ($comment) {
            // Prepare a SQL statement
            $stmt = $this->db->conn->prepare("DELETE FROM comments WHERE id = ?");
            // Execute the statement with the ID
            $stmt->execute([$id]);
        }
    }
}

?>