<?php

namespace app\controllers;

require_once __DIR__ . '/../models/User.php';

class UserController {
    private $model;

    // Constructor to initialize the model
    public function __construct() {
        $this->model = new \app\models\User;
    }

    // Display the registration form
    public function register() {
        require __DIR__ . '/../views/users/register.php';
    }

    // Handle the user registration request
    public function store($data) {
        // Check if username and password are provided
        if (empty($data['username']) || empty($data['password'])) {
            // Set an error message and redirect to the registration page
            $_SESSION['message'] = 'Username and password are required';
            header('Location: /users/register');
            exit();
        }
    
        // Hash the password for secure storage
        $hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT);
        // Create a new user record in the database
        $this->model->createUser($data['username'], $hashedPassword);
    
        // Set a success message and redirect to the login page
        $_SESSION['message'] = 'Registration successful. Please log in.';
        header('Location: /users/login');
        exit();
    }
    
    // Display the login form
    public function showLoginForm() {
        require __DIR__ . '/../views/users/login.php';
    }

    // Authenticate the user
    public function authenticate($data) {
        // Validate the provided username and password
        if (empty($data['username']) || empty($data['password'])) {
            // Set an error message and redirect to the login page
            $_SESSION['message'] = 'Username and password are required';
            header('Location: /users/login');
            exit();
        }

        // Retrieve the user from the database
        $user = $this->model->getUserByUsername($data['username']);

        // Check if the user exists and the password is correct
        // Access properties with -> since $user is now an object
        if ($user && password_verify($data['password'], $user->password)) {
            // Initialize session with user info
            // Make sure to access properties as object properties, not array keys
            $this->initializeUserSession($user);

            // Redirect user to the appropriate page based on their role
            // Again, accessing is_admin as an object property
            $this->redirectBasedOnRole($user->is_admin);
        } else {
            // If authentication fails, set an error message and redirect
            $_SESSION['message'] = 'Invalid username or password';
            header('Location: /users/login');
            exit();
        }
    }

    // Initialize the session with user data
    private function initializeUserSession($user) {
        // Set user ID and admin status in the session
        $_SESSION['user_id'] = $user->id;
        $_SESSION['is_admin'] = $user->is_admin;
    }

    // Redirect user based on their role
    private function redirectBasedOnRole($isAdmin) {
        // If user is an admin, redirect to the admin posts page
        if ($isAdmin) {
            header('Location: /admin/posts');
        } else {
            // If user is not an admin, redirect to a general user page
            header('Location: /'); // Replace with the appropriate user page
            }
            exit();
            }

        // Handle the user logout process
        public function logout() {
            // Clear all session variables, and destroy the session
            session_unset();
            session_destroy();
            // Redirect to the login page after logout
            header('Location: /users/login');
            exit();
        }
    }
