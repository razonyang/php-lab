<?php

require __DIR__ . '/Connection.php';

// PDO DSN(data source name)
define('DB_DSN', 'mysql:host=127.0.0.1');

// PDO database username
define('DB_USERNAME', 'root');

// PDO database password
define('DB_PASSWORD', '');

define('DB_ATTRIBUTES', [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_PERSISTENT => true, // enable persistent connection
]);

/**
 * @param array $attributes PDO attributes
 * @return Connection
 */
function getConnection($attributes = [])
{
    $attributes = $attributes + DB_ATTRIBUTES;

    return new Connection(DB_DSN, DB_USERNAME, DB_PASSWORD, $attributes);
}