<?php
require_once __DIR__ . '/Migration.php';

class UpdateUsersTable extends Migration {
    protected function up() {
        $query = "ALTER TABLE users 
                  MODIFY COLUMN email VARCHAR(255) NOT NULL,
                  ADD UNIQUE INDEX email_unique (email)";
        
        $this->db->conn->exec($query);
    }
}

$migration = new UpdateUsersTable();
$migration->execute();