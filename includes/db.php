<?php
/**
 * Database connection helper
 */
require_once __DIR__ . '/config.php';

function ss_db_connect(): PDO
{
    $config = ss_get_config();
    $dsn = 'mysql:host=' . $config['host'] . ';dbname=' . $config['dbname'] . ';charset=utf8mb4';
    try {
        $pdo = new PDO($dsn, $config['user'], $config['pass'], [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]);
        return $pdo;
    } catch (PDOException $e) {
        // Display generic error for production; log detailed error
        error_log('Database connection error: ' . $e->getMessage());
        die('Database connection failed.');
    }
}