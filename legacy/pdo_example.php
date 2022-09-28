<?php

# env variables: DB_HOST, DB_DATABASE, DB_USERNAME, DB_PASSWORD
function open_database_connection_read_only(): PDO
{
    $host = '85.190.14.42';
    $port = '3306';
    $dbname = 'gsqt_core';
    $username = 'autoranker_www';
    $password = 'DT20fDfoZfmN30';

    $connection = new PDO(
        'mysql:host=' . $host . ';dbname=' . $dbname . ';port=' . $port . ';charset=utf8mb4',
        $username,
        $password,
        [
            PDO::ATTR_EMULATE_PREPARES => false,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        ]
    );

    return $connection;
}
