<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Define BASE_DIR as the absolute path to your project's root
define('BASE_DIR', dirname(__DIR__));

require BASE_DIR . '/vendor/autoload.php';
require BASE_DIR . '/utils.php';

// Extract the path component from the full URL of the current request
$request = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
// Further trim any leading or trailing slashes from the path
$request = trim($request, '/');

$routes = [
    'GET' => [
        // Frontend Routes
        '' => ['controller' => '\app\controllers\PostController', 'method' => 'index'],
        'posts/show/([0-9]+)' => ['controller' => 'app\controllers\PostController', 'method' => 'show'],
        // Admin Posts Routes
        'admin/posts' => ['controller' => '\app\controllers\AdminController', 'method' => 'index'],
        'admin/posts/create' => ['controller' => '\app\controllers\AdminController', 'method' => 'create'],
        'admin/posts/show/([0-9]+)' => ['controller' => '\app\controllers\AdminController', 'method' => 'show'],
        'admin/posts/edit/([0-9]+)' => ['controller' => '\app\controllers\AdminController', 'method' => 'edit'],

        // Admin categories Routes
        'admin/categories/create' => ['controller' => '\app\controllers\CategoryController', 'method' => 'create'],
        'admin/categories' => ['controller' => '\app\controllers\CategoryController', 'method' => 'index'],
        'admin/categories/edit/([0-9]+)' => ['controller' => '\app\controllers\CategoryController', 'method' => 'edit'],
        'admin/categories/posts/([0-9]+)' => ['controller' => '\app\controllers\CategoryController', 'method' => 'showPosts'],
        // Admin Comment Routes
        'admin/comments/edit/([0-9]+)' => ['controller' => '\app\controllers\CommentController', 'method' => 'edit'],
        // User Auth Routes
        'users/register' => ['controller' => '\app\controllers\UserController', 'method' => 'register'],
        'users/login' => ['controller' => '\app\controllers\UserController', 'method' => 'showLoginForm'],
        'users/logout' => ['controller' => '\app\controllers\UserController', 'method' => 'logout'],
        // Add more routes for other controllers and actions
    ],
    'POST' => [
        // Admin Post Routes
        'admin/posts/store' => ['controller' => '\app\controllers\AdminController', 'method' => 'store'],
        'admin/posts/update/([0-9]+)' => ['controller' => '\app\controllers\AdminController', 'method' => 'update'],
        'admin/posts/delete/([0-9]+)' => ['controller' => '\app\controllers\AdminController', 'method' => 'delete'],
         // Admin categories Routes
        'admin/categories/store' => ['controller' => '\app\controllers\CategoryController', 'method' => 'store'],
        'admin/categories/update/([0-9]+)' => ['controller' => '\app\controllers\CategoryController', 'method' => 'update'],
        'admin/categories/delete/([0-9]+)' => ['controller' => '\app\controllers\CategoryController', 'method' => 'delete'],
         // Admin Comment Routes
         'admin/comments/update/([0-9]+)' => ['controller' => '\app\controllers\CommentController', 'method' => 'update'],
         'comments/store' => ['controller' => '\app\controllers\CommentController', 'method' => 'store'],
         'admin/comments/delete/([0-9]+)' => ['controller' => '\app\controllers\CommentController', 'method' => 'delete'],
         // User Auth Routes
         'users/store' => ['controller' => '\app\controllers\UserController', 'method' => 'store'],
         'users/authenticate' => ['controller' => '\app\controllers\UserController', 'method' => 'authenticate'],
    ]  
];

// Retrieve the URL path from the current request
$path = $request;

// Obtain the HTTP method (e.g., GET, POST) of the current request
$method = $_SERVER['REQUEST_METHOD'];

// Iterate over each route defined for the current HTTP method
foreach ($routes[$method] as $route => $info) {
    // Modify the route string to a regular expression for matching URL patterns
    $pattern = preg_replace('#/([0-9]+)#', '/([0-9]+)', $route);

    // Check if the current URL path matches the route pattern
    if (preg_match("#^$pattern$#", $path, $matches)) {
        // Create an instance of the controller specified in the route information
        $controller = new $info['controller'];
        
        // Extract any numeric ID present in the URL, default to null if not found
        $id = $matches[1] ?? null;

        // Execute the controller method with parameters based on the request method
        // For POST requests (excluding delete operations), pass both POST data and ID
        if ($method === 'POST' && $info['method'] !== 'delete') {
            $controller->{$info['method']}($_POST, $id);
        } else {
            // For other request methods, pass only the ID
            $controller->{$info['method']}($id);
        }    
        // Exit the loop after finding and handling the matching route
        break;
    }
}


// If no route was matched, return a 404 response
if (!isset($controller)) {
    http_response_code(404);
    require __DIR__ . '/../app/views/404.php';
}