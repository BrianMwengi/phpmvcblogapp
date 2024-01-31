<?php

namespace app\controllers;

require_once __DIR__ . '/../models/Comment.php';

class CommentController {
    private $model;

    public function __construct() {
        $this->model = new \app\models\Comment;
    }

    public function store($data) {
        $postId = $data['post_id'];
        $content = $data['content'];
        // Store the comment in the database
        $this->model->createComment($postId, $content);
        header('Location: /posts/show/' . $postId);
    }

    public function edit($id) {
        $this->ensureAdmin();
        // Get the comment from the database
        $comment = $this->model->getCommentById($id);
    
        // Check if the comment exists
        if (!$comment) {
            die('Comment not found');
        }
    
        // Create an instance of the Post model
        $postModel = new \app\models\Post;
    
        // Fetch the post related to the comment
        $post = $postModel->getPost($comment->post_id);
    
        // Check if the post exists
        if (!$post) {
            die('Post not found');
        }
    
        // Include the edit form view, pass both comment and post
        require __DIR__ . '/../views/admin/comments/edit.php';
    }
    
    public function update($data, $id) {
        $this->ensureAdmin();
        $data = $_POST;
        $result = $this->model->updateComment($id, $data); // Update the comment
        if (isset($data['post_id']) && !empty($data['post_id'])) {
            $postId = $data['post_id'];
            $_SESSION['message'] = 'Comment updated successfully!.';
            header('Location: /admin/posts/show/' . $postId);
        } else {
            // Handle the error or redirect to a default page
            header('Location: /admin/posts');
        }
    }
    
    public function delete($id) {
        $this->ensureAdmin();
      // Delete the comment
     $this->model->deleteComment($id);
     // Redirect to the related post or a default page if successful
          header('Location: /admin/posts');
    }    
}