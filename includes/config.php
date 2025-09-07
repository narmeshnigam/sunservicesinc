<?php
/**
 * Configuration file for Sun Services Inc
 *
 * Returns an array of database credentials for both local and production
 * environments. The environment is auto‑detected based on the HTTP_HOST.
 */

function ss_get_config(): array
{
    $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
    // Determine environment: treat localhost and 127.0.0.1 as local
    $is_local = preg_match('/^(localhost|127\.0\.0\.1)(:\d+)?$/', $host) === 1;
    // Default credentials – replace these with actual values before deployment
    $config = [
        'local' => [
            'host' => 'localhost',
            'dbname' => 'sunservices_local',
            'user' => 'root',
            'pass' => '',
        ],
        'production' => [
            'host' => '127.0.0.1',
            'dbname' => 'u574381819_sunservicesinc',
            'user' => 'u574381819_sunservicesinc',
            'pass' => 'kZ@5#Q&&]i3',
        ],
    ];
    return $is_local ? $config['local'] : $config['production'];
}