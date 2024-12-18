<?php
// app/controllers/MigrationController.php

namespace app\controllers;

class MigrationController {
    public function run() {
        if (getenv('APP_ENV') !== 'production') {
            require_once BASE_DIR . '/database/migrate.php';
        } else {
            die('Migrations disabled in production');
        }
    }
}