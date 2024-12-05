<?php
// database/migrations/Migration.php

class Migration {
    protected $db;

    public function __construct() {
        require_once __DIR__ . '/../../bootstrap.php';
        $this->db = new Database();
    }

    public function execute() {
        try {
            $this->up();
            echo "Migration executed successfully!\n";
        } catch (PDOException $e) {
            echo "Migration failed: " . $e->getMessage() . "\n";
        }
    }

    protected function up() {
        // This method should be overridden by child classes
    }
}