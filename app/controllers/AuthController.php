<?php

namespace app\controllers;

class AuthController {
    protected function ensureAdmin() {
        if (!isLoggedIn() || !isAdmin()) {
            header('Location: /users/login');
            exit;
        }
    }
}

