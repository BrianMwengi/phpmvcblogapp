<?php

namespace app\models;

// Include database configuration file
require_once BASE_DIR . '/config/db.php';

// Define class for managing posts
class Post {
    private $db; // Database connection object

    // Initialize connection in constructor
    public function __construct() {
        $this->db = new \Database; // Create a Database object for connection
    }

   /**
     * Create a new post with title and content.
     *
     * @param string $title The title of the post.
     * @param string $content The content of the post.
     */
    public function createPost($title, $content, $category_id, $imageFilename = null) {
      // Prepare an SQL statement to insert a new post into the 'posts' table
      $stmt = $this->db->conn->prepare('INSERT INTO posts (title, content, category_id, image) VALUES (?, ?, ?, ?)');
        
       // Bind title, content, category, and image to prepared statement parameters
       $stmt->execute([$title, $content, $category_id, $imageFilename]);
    }

    /**
     * Retrieve a single post by its ID.
     *
     * @param int $id The ID of the post to retrieve.
     * @return object The fetched post as an object.
     */
    public function getPost($id) {
        // Prepare an SQL statement to select a post from the 'posts' table by its ID
        $stmt = $this->db->conn->prepare('SELECT posts.*, categories.name as category_name, posts.image as image FROM posts LEFT JOIN categories ON posts.category_id = categories.id WHERE posts.id = :id');
        
        // Execute the SQL statement with the provided post ID
        $stmt->execute(['id' => $id]);
        
        // Return the fetched post as an object
        return $stmt->fetch(\PDO::FETCH_OBJ);
    }
    
    /**
     * Retrieve all posts, ordered by ID in descending order.
     *
     * @return array An array of post objects.
     */
    public function getPosts($pageNum = 1, $postsPerPage = 5) {
        // Calculate the offset for the SQL query based on the current page number and posts per page
        $offset = ($pageNum - 1) * $postsPerPage;

        // Prepare an SQL statement to fetch posts with pagination
        // Posts are ordered by their ID in descending order
        // :limit and :offset are placeholders for pagination values
        $stmt = $this->db->conn->prepare('SELECT posts.*, categories.name as category_name, posts.image as image FROM posts LEFT JOIN categories ON posts.category_id = categories.id ORDER BY posts.id DESC LIMIT :limit OFFSET :offset');

        // Bind the limit and offset values to the prepared statement
        // PDO::PARAM_INT ensures these values are treated as integers
        $stmt->bindValue(':limit', $postsPerPage, \PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, \PDO::PARAM_INT);
    
        // Execute the SQL statement
        $stmt->execute();

        // Return all fetched posts as an array of objects
        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }

    public function getTotalPostsCount() {
        // Prepare an SQL query to count the total number of posts in the database
        $stmt = $this->db->conn->query('SELECT COUNT(*) FROM posts');  
        // Execute the query and return the count result
        // fetchColumn() retrieves the value of the first column in the result set
        return $stmt->fetchColumn();
    }

    // Update an existing post with new title, content and category_id 
    public function updatePost($id, $title, $content, $category_id, $imageFilename = null) {
        $sql = 'UPDATE posts SET title = :title, content = :content, category_id = :category_id, image = :image WHERE id = :id';
        $stmt = $this->db->conn->prepare($sql);
        try {
            $stmt->execute(['title' => $title, 'content' => $content, 'category_id' => $category_id,'image' => $imageFilename, 'id' => $id]);
        } catch (PDOException $e) {
            // Log the error
            error_log("Database error: " . $e->getMessage() . " in " . $e->getFile() . ":" . $e->getLine());
    
            // Optionally, display a user-friendly error message
            echo "<p>An error occurred while updating the post. Please try again later.</p>";
        }
    }

    public function searchPosts($query) {
        // Prepare the query for a LIKE statement
        $query = "%" . $query . "%"; 
        $stmt = $this->db->conn->prepare('SELECT posts.*, categories.name as category_name FROM posts LEFT JOIN categories ON posts.category_id = categories.id WHERE posts.title LIKE :query OR posts.content LIKE :query ORDER BY posts.id DESC');
        $stmt->bindValue(':query', $query, \PDO::PARAM_STR);
        $stmt->execute();
        // Fetch and return the results
        return $stmt->fetchAll(\PDO::FETCH_OBJ); 
    }

    public function deletePost($id) {
        $stmt = $this->db->conn->prepare('DELETE FROM posts WHERE id = ?');
        $stmt->execute([$id]);
    }
}
    