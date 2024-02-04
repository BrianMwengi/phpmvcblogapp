<?php

namespace app\controllers;

require_once BASE_DIR . '/app/models/Post.php';
require_once BASE_DIR . '/app/models/Comment.php';

class AdminController extends AuthController {
    private $model;

    public function __construct() {
        $this->model = new \app\models\Post;
    }

    // Read: Display a list of posts
    public function index() {
        $this->ensureAdmin();
       // Determine the current page number
       $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
       // Define how many posts you want per page
       $postsPerPage = 5; 
   
       // Fetch posts for the current page
       $posts = $this->model->getPosts($currentPage, $postsPerPage);
   
       // Calculate the total number of pages
       $totalPosts = $this->model->getTotalPostsCount(); 
       $totalPages = ceil($totalPosts / $postsPerPage);
    
        // Load the view for displaying posts
        require BASE_DIR . '/app/views/admin/posts/index.php';
    }
    
    public function create() {
        $this->ensureAdmin();
        // Create an instance of the Category model
        $categoryModel = new \app\models\Category;

        // Fetch all categories
        $categories = $categoryModel->getCategories();
        // Load the view for creating a new post
        require BASE_DIR . '/app/views/admin/posts/create.php';
    }
    

    // Read: Display a single post
    public function show($id) {
        $this->ensureAdmin();
        // Fetch the post with the given ID
        $post = $this->model->getPost($id);

        if ($post === null) {
            // Post not found, display 404 page
            require BASE_DIR . '/app/views/404.php';
            return;
        }
         // Create an instance of the Comment model
         $commentModel = new \app\models\Comment;

         // Fetch the comments for the post
         $comments = $commentModel->getComments($id);
        // Load the view for displaying the single post
        require BASE_DIR . '/app/views/admin/posts/show.php';
    }

    // Create: Store a new post
    public function store($postData) {
        $this->ensureAdmin();
        // Retrieve form data
        $title = $postData['title'];
        $content = $postData['content'];
        $category_id = $postData['category_id'];
        $imageFilename = null;  // Default to null if no image is uploaded

        // Validate title, content, and category
        $errors = [];
        if (empty($title)) {
            $errors[] = 'Title is required.';
        }
        if (empty($content)) {
            $errors[] = 'Content is required.';
        }
        if (empty($category_id)) {
            $errors[] = 'Category is required.';
        }
    
        // Only proceed if there are no errors
        if (empty($errors)) {
        // Check if an image file is uploaded and there are no upload errors
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            // Define allowed file types and size
            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
            $maxSize = 5 * 1024 * 1024; // 5 MB

            // Extract file information from the uploaded image
            $fileTmpPath = $_FILES['image']['tmp_name']; // Temporary path where the uploaded file is stored
            $fileName = $_FILES['image']['name'];       // Original name of the uploaded file
            $fileType = $_FILES['image']['type'];       // MIME type of the uploaded file
            $fileSize = $_FILES['image']['size'];       // Size of the uploaded file in bytes


            // Check file type and size
            if (in_array($fileType, $allowedTypes) && $fileSize <= $maxSize) {
                // Create a unique file name to avoid overwriting existing files
                $newFileName = uniqid() . '-' . $fileName;

                // Set the upload path for the image
                $uploadPath = 'S:/xampp/htdocs/php8mvcblog/public/images/'; // Define the directory where uploaded images will be stored
                $destination = $uploadPath . $newFileName; // Concatenate the upload path with the new file name to create the full destination path

                // Ensure the upload directory exists
                if (!file_exists($uploadPath)) {
                    // Create the directory if it does not exist, with full read/write/execute permissions (0777) and enable recursion (true)
                    mkdir($uploadPath, 0777, true); 
                }

                // Move the uploaded file
                if (move_uploaded_file($fileTmpPath, $destination)) {
                    // File uploaded successfully
                    $imageFilename = $newFileName; // Set this for database storage
                } else {
                    // Handle error (file move failed)
                    $errors[] = 'Failed to upload image.';
                }
            } else {
                // Handle invalid file type or size
                $errors[] = 'Invalid file type or size.';
            }
        } else {
            // Handle no file uploaded or upload error
            if ($_FILES['image']['error'] != UPLOAD_ERR_NO_FILE) {
                $errors[] = 'Error in file upload.';
            }
        }
    }

    // Check again for any errors including file upload errors
    if (empty($errors)) {
        // Create the post in the database
        try {
            $this->model->createPost($title, $content, $category_id, $imageFilename);
            // Redirect to the posts page after successful creation
            header('Location: /admin/posts');
            $_SESSION['message'] = 'Post created successfully!.';
            exit;
        } catch (Exception $e) {
            // If there's a database error, display it
            echo 'Error creating post: ' . $e->getMessage();
            exit; 
        } 
        } else {
            // Handle validation errors
            $_SESSION['form_errors'] = $errors;
            header('Location: /admin/posts/create');
            exit;
        }
    } 

    public function edit($id) {
        $this->ensureAdmin();
        $post = $this->model->getPost($id);
        // Fetch categories
        $categoryModel = new \app\models\Category;
        $categories = $categoryModel->getCategories();
        // Pass post and categories to the view
        require BASE_DIR . '/app/views/admin/posts/edit.php';
    }

    // Update: Update an existing post
    public function update($postData, $id) {
        $this->ensureAdmin();
        $title = $postData['title'];
        $content = $postData['content'];
        $category_id = $postData['category_id'];
        // Initialize the image filename from existing data
        $imageFilename = $postData['existing_image_filename'] ?? null;

         // Validation
         $errors = [];
         if (empty($title)) {
             $errors[] = 'Title is required.';
         }
         if (empty($content)) {
             $errors[] = 'Content is required.';
         }
         if (empty($category_id)) {
             $errors[] = 'Category is required.';
         }
 
         // Only proceed if there are no errors
         if (empty($errors)) {
            // Check if an image file is uploaded and there are no upload errors
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                // Define allowed file types and size
                $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
                $maxSize = 5 * 1024 * 1024; // 5 MB

                // Extract file information from the uploaded image
                $fileTmpPath = $_FILES['image']['tmp_name']; // Temporary path where the uploaded file is stored
                $fileName = $_FILES['image']['name'];       // Original name of the uploaded file
                $fileType = $_FILES['image']['type'];       // MIME type of the uploaded file
                $fileSize = $_FILES['image']['size'];       // Size of the uploaded file in bytes

                // Check file type and size
                if (in_array($fileType, $allowedTypes) && $fileSize <= $maxSize) {
                    // Create a unique file name to avoid overwriting existing files
                    $newFileName = uniqid() . '-' . $fileName;

                    // Set the upload path
                    $uploadPath = 'S:/xampp/htdocs/php8mvcblog/public/images/';
                    $destination = $uploadPath . $newFileName;
                    // Ensure the upload directory exists
                    if (!file_exists($uploadPath)) {
                        mkdir($uploadPath, 0777, true);
                    }

                    // Move the uploaded file
                    if (move_uploaded_file($fileTmpPath, $destination)) {
                        // File uploaded successfully
                        $imageFilename = $newFileName; // Update $imageFilename with new filename for database storage
                    } else {
                        // Handle error (file move failed)
                        $errors[] = 'Failed to upload image.';
                    }
                } else {
                    // Handle invalid file type or size
                    $errors[] = 'Invalid file type or size.';
                }
            } elseif ($_FILES['image']['error'] != UPLOAD_ERR_NO_FILE) {
                $errors[] = 'Error in file upload.';
            }
         }
        // Check again for any errors including file upload errors
        if (empty($errors)) {
            try {
                // Call the updatePost method 
                $this->model->updatePost($id, $title, $content, $category_id, $imageFilename);
            
                // Redirect to the posts page after successful update
                $_SESSION['message'] = 'Post updated successfully!.';
                header('Location: /admin/posts');
                exit;
            } catch (Exception $e) {
                // If there's a database error, display it
                echo 'Error updating post: ' . $e->getMessage();
                exit;
            } 
            } else {
                // Handle validation errors
                $_SESSION['form_errors'] = $errors;
                header('Location: /admin/posts/edit/' . $id);
                exit;
            }
        }

    // Delete: Remove a post
    public function delete($id) {
        $this->ensureAdmin();
        $postDeleted = $this->model->deletePost($id);
            if ($postDeleted) {
                header('Location: /admin/posts');
            } else {
                die('Comment not found');
            }
        }        
    }
