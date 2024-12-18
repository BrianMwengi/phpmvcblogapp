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
        if (empty($data['username']) || empty($data['email']) || empty($data['password'])) {
            $_SESSION['message'] = 'All fields are required';
            header('Location: /users/register');
            exit;
        }

        // Validate email format
        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $_SESSION['message'] = 'Invalid email format';
            header('Location: /users/register');
            exit;
        }

        // Check if the username already exists
        if ($this->model->doesUsernameExist($data['username'])) {
            // Handle the error, e.g., set an error message in the session
            $_SESSION['message'] = "Username already exists. Please choose another username.";
            header('Location: /users/register');
            exit;
        }

        // Check if email exists
        if ($this->model->doesEmailExist($data['email'])) {
            $_SESSION['message'] = 'Email already exists';
            header('Location: /users/register');
            exit;
        }
            
        // Hash the password for secure storage
        $hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT);
        // Create a new user record in the database
        if ($this->model->createUser($data['username'], $data['email'], $hashedPassword)) {
            $_SESSION['message'] = 'Registration successful. Please log in.';
            header('Location: /users/login');
        } else {
            $_SESSION['message'] = 'Registration failed. Please try again.';
            header('Location: /users/register');
        }
        exit;
    }
    
    // Display the login form
    public function showLoginForm() {
        require BASE_DIR . '/app/views/users/login.php';
    }

    // Authenticate the user
    public function authenticate($data) {
        if (empty($data['email']) || empty($data['password'])) {
            $_SESSION['message'] = 'Email and password are required';
            header('Location: /users/login');
            exit();
        }

        // Retrieve the user from the database
        $user = $this->model->getUserByEmail($data['email']);

        // Check if the user exists and the password is correct
        // Access properties with -> since $user is now an object
        if ($user && password_verify($data['password'], $user->password)) {
            $this->initializeUserSession($user);
            $this->redirectBasedOnRole($user->is_admin);
        } else {
            $_SESSION['message'] = 'Invalid email or password';
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
                try {
                    // Generate and save token
                    $token = $this->model->createPasswordResetToken($email);
                    
                    // Configure PHPMailer
                    $mail = new \PHPMailer\PHPMailer\PHPMailer(true);
                    $mail->isSMTP();
                    $mail->Host = 'smtp.gmail.com';
                    $mail->SMTPAuth = true;
                    $mail->Username = 'mwengibrian@gmail.com';
                    $mail->Password = 'pmmp stmc nner gsdq';
                    $mail->SMTPSecure = \PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
                    $mail->Port = 587;
                    
                    // Set SSL options
                    $mail->SMTPOptions = [
                        'ssl' => [
                            'verify_peer' => false,
                            'verify_peer_name' => false,
                            'allow_self_signed' => true
                        ]
                    ];
                    
                    // Build email content
                    $resetLink = "http://" . $_SERVER['HTTP_HOST'] . "/users/reset-password/" . $token;
                    
                    $mail->setFrom('mwengibrian@gmail.com', 'PHP MVC Blog');
                    $mail->addAddress($email);
                    $mail->isHTML(true);
                    $mail->Subject = 'Password Reset Request';
                    $mail->Body = "Click the following link to reset your password: <a href='{$resetLink}'>{$resetLink}</a>";
                    $mail->AltBody = "Click the following link to reset your password: {$resetLink}";
                    
                    $mail->send();
                    
                    // Log success
                    error_log("Reset email sent to: $email with token: $token");
                    $_SESSION['message'] = 'Password reset instructions have been sent to your email';
                    header('Location: /users/login');
                } catch (Exception $e) {
                    error_log("Email sending failed: " . $e->getMessage());
                    $_SESSION['message'] = 'Error sending email. Please try again later.';
                    header('Location: /users/forgot-password');
                }
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
                // Add debug information
                error_log("Token validation failed. Token: " . $token);
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

   



        