<?php
// database/migrate.php

require_once __DIR__ . '/../bootstrap.php';

// Get all migration files
$migrations = glob(__DIR__ . '/migrations/[0-9]*_*.php');
sort($migrations); // Sort by filename to maintain order

foreach ($migrations as $migration) {
    echo "Running migration: " . basename($migration) . "\n";
    require_once $migration;
}

echo "All migrations completed!\n";