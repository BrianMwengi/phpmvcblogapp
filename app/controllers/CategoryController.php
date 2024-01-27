<?php

namespace app\controllers;

require_once __DIR__ . '/../models/Category.php';

class CategoryController {
    private $model;

    public function __construct() {
        $this->model = new \app\models\Category;
    }

    public function index() {
        // Fetch all categories
        $categories = $this->model->getCategories(); 
        require __DIR__ . '/../views/admin/categories/index.php';
    }

    public function create() {
        // Display the category creation form
        require __DIR__ . '/../views/admin/categories/create.php';
    }

    public function showPosts($categoryId) {
        $category = $this->model->getCategory($categoryId);
        if (!$category) {
            die('Category not found');
        }

        $posts = $this->model->getPosts($categoryId);
        // A view that lists posts in this category
        require __DIR__ . '/../views/admin/categories/posts.php'; 
    }

    public function store($data) {
        // Create a new category
        $this->model->create($data);
        header('Location: /admin/categories');
    }
    
    public function edit($id) {
        $category = $this->model->getCategory($id);
        if (!$category) {
            die('Category not found');
        }
        require __DIR__ . '/../views/admin/categories/edit.php';
    }

    public function update($id, $data) {
        $this->model->updateCategory($id, $data);
        header('Location: /admin/categories');
    }

    public function delete($id) {
      $this->model->deleteCategory($id);
      header('Location: /admin/categories');         
    }
}
?>