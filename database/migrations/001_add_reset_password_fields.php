<?php
// database/migrations/001_add_reset_password_fields.php

require_once __DIR__ . '/Migration.php';

class AddResetPasswordFields extends Migration {
    protected function up() {
        $query = "ALTER TABLE users 
                  ADD COLUMN IF NOT EXISTS email VARCHAR(255) UNIQUE AFTER username,
                  ADD COLUMN IF NOT EXISTS reset_token VARCHAR(64) DEFAULT NULL,
                  ADD COLUMN IF NOT EXISTS reset_expires DATETIME DEFAULT NULL";
        
        $this->db->conn->exec($query);
    }
}

// Execute migration
$migration = new AddResetPasswordFields();
$migration->execute();