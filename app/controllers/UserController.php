<?php

namespace app\controllers;

require_once BASE_DIR . '/app/models/User.php';

class UserController {
    private $model;

    // Constructor to initialize the model
    public function __construct() {
        $this->model = new \app\models\User;
    }

    // Display the registration form
    public function register() {
        require BASE_DIR . '/app/views/users/register.php';
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

        // Check if the username already exists
        if ($this->model->doesUsernameExist($data['username'])) {
            // Handle the error, e.g., set an error message in the session
            $_SESSION['message'] = "Username already exists. Please choose another username.";
            header('Location: /users/register');
            exit;
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
        require BASE_DIR . '/app/views/users/login.php';
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

        // Display the forgot password form
        public function showForgotPasswordForm() {
            require BASE_DIR . '/app/views/users/forgot-password.php';
        }
        
        public function resetPasswordRequest() {
            $email = $_POST['email'] ?? '';
            
            if (empty($email)) {
                $_SESSION['message'] = 'Email is required';
                header('Location: /users/forgot-password');
                exit();
            }
        
            $user = $this->model->getUserByEmail($email);
            
            if ($user) {
                $token = $this->model->createPasswordResetToken($email);
                
                // Send email with reset link
                $resetLink = "http://" . $_SERVER['HTTP_HOST'] . "/users/reset-password/" . $token;
                $to = $email;
                $subject = "Password Reset Request";
                $message = "Click the following link to reset your password: {$resetLink}";
                $headers = "From: noreply@yourblog.com";
                
                mail($to, $subject, $message, $headers);
                
                $_SESSION['message'] = 'Password reset instructions have been sent to your email';
                header('Location: /users/login');
            } else {
                $_SESSION['message'] = 'Email not found';
                header('Location: /users/forgot-password');
            }
            exit();
        }
        
        // Display the reset password form
        public function showResetPasswordForm($token) {
            $user = $this->model->verifyResetToken($token);
            
            if (!$user) {
                $_SESSION['message'] = 'Invalid or expired reset token';
                header('Location: /users/login');
                exit();
            }
            
            require BASE_DIR . '/app/views/users/reset-password.php';
        }
        
        // Update the user password
        public function updatePassword() {
            $token = $_POST['token'] ?? '';
            $password = $_POST['password'] ?? '';
            $confirmPassword = $_POST['confirm_password'] ?? '';
            
            if ($password !== $confirmPassword) {
                $_SESSION['message'] = 'Passwords do not match';
                header("Location: /users/reset-password/{$token}");
                exit();
            }
            
            $user = $this->model->verifyResetToken($token);
            
            if ($user && $this->model->updatePassword($user->id, $password)) {
                $_SESSION['message'] = 'Password has been updated successfully';
                header('Location: /users/login');
            } else {
                $_SESSION['message'] = 'Error updating password';
                header('Location: /users/forgot-password');
            }
            exit();
        }
    }
