<?php
    // Database configuration
    $host = 'localhost';
    $dbname = 'your_database_name';
    $username = 'tbl_';
    $password = 'Jzz4Qp1e5Za1k@can';

    // Create a database connection
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>