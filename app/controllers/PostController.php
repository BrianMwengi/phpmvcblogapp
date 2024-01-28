<?php

namespace app\controllers;

require_once __DIR__ . '/../models/Post.php';
require_once __DIR__ . '/../models/Comment.php';

class PostController {
    private $model;

    public function __construct() {
        $this->model = new \app\models\Post;
    }

    // Display all posts
    public function index() {
         // Determine the current page number
         $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
         $postsPerPage = 5; // Define how many posts you want per page
     
         // Fetch posts for the current page
         $posts = $this->model->getPosts($currentPage, $postsPerPage);
     
         // Calculate the total number of pages
         $totalPosts = $this->model->getTotalPostsCount(); 
         $totalPages = ceil($totalPosts / $postsPerPage);
 
        require __DIR__ . '/../views/posts/index.php';
    }

    // Display a single post
    public function show($id) {
        // Retrieve the specific post by its ID using the Post model
        $post = $this->model->getPost($id);
    
        // Instantiate the Comment model to interact with the comments data
        $commentModel = new \app\models\Comment;
    
        // Retrieve all comments associated with the post
        // This assumes that the getComments method fetches comments based on the post's ID
        $comments = $commentModel->getComments($id);
    
        // Load the view file that displays the details of the post
        // This view will show the post and its associated comments
        require __DIR__ . '/../views/posts/show.php';
    }       
}
?>