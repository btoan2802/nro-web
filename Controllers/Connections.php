<?php

if (!isset($databaseConfig)) {
    $databaseConfig = [
        'ip' => "103.78.0.226",
        'port' => "3306",
        'dbname' => "ngocrong",
        'user' => "btoan",
        'pass' => "toanhotface"
    ];
}

date_default_timezone_set('Asia/Ho_Chi_Minh');

if (!function_exists('getDatabaseConnection')) {

    function getDatabaseConnection($connConfig)
    {
        try {
            $dsn = "mysql:host={$connConfig['ip']};port={$connConfig['port']};dbname={$connConfig['dbname']};charset=utf8mb4";
            $conn = new PDO($dsn, $connConfig['user'], $connConfig['pass']);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conn;
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }

}

$conn = getDatabaseConnection($databaseConfig);