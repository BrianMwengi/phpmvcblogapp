<?php
// Start the session
session_start();

// Set error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Define BASE_DIR as the absolute path to your project's root
define('BASE_DIR', __DIR__);


// Include Composer's autoloader
require_once BASE_DIR . '/vendor/autoload.php';

// Include utility functions
require_once BASE_DIR . '/utils.php';

// Include the database configuration and connection setup
require_once BASE_DIR . '/config/db.php';
