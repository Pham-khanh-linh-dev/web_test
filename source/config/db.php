<?php
function getDbConnection() {
    $host = "localhost";
    $dbname = "da19db";
    $username = "root";
    $password = "";
    try {
        $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
        } 
    catch (PDOException $e) {
        die("Kết nối database thất bại: " . $e->getMessage());
    }
}

