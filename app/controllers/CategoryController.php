<?php

namespace app\controllers;

require_once BASE_DIR . '/app/models/Category.php';

class CategoryController extends AuthController {
    private $model;

    public function __construct() {
        $this->model = new \app\models\Category;
    }

    public function index() {
        $this->ensureAdmin();
        // Fetch all categories
        $categories = $this->model->getCategories(); 
        require BASE_DIR . '/app/views/admin/categories/index.php';
    }

    public function create() {
        $this->ensureAdmin();
        // Display the category creation form
        require BASE_DIR . '/app/views/admin/categories/create.php';
    }

    public function showPosts($categoryId) {
        $category = $this->model->getCategory($categoryId);
        if (!$category) {
            die('Category not found');
        }

        $posts = $this->model->getPosts($categoryId);
        // A view that lists posts in this category
        require BASE_DIR . '/app/views/admin/categories/posts.php'; 
    }

    public function store($data) {
        $this->ensureAdmin();
        // Create a new category
        $this->model->create($data);
        header('Location: /admin/categories');
    }
    
    public function edit($id) {
        $this->ensureAdmin();
        $category = $this->model->getCategory($id);
        if (!$category) {
            die('Category not found');
        }
        require BASE_DIR . '/app/views/admin/categories/edit.php';
    }

    public function update($id, $data) {
        $this->ensureAdmin();
        $this->model->updateCategory($id, $data);
        header('Location: /admin/categories');
    }

    public function delete($id) {
      $this->ensureAdmin();
      $this->model->deleteCategory($id);
      header('Location: /admin/categories');         
    }
}
?>