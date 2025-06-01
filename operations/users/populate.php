<?php
session_start();
require_once __DIR__ . '/../../config/db-conn.php';
require_once __DIR__ . '/../../services/php/flash.services.php';
require_once __DIR__ . '/../../services/php/user.services.php';
require_once __DIR__ . '/../../services/php/utils.services.php';


$res = array('error' => false, 'message' => 'Template message');

$demo_users = get_demo_users();

foreach ($demo_users as $value) {
    $sql = "INSERT INTO Users (full_name, email, password, age, phone_number) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssis", $value['full_name'], $value['email'], $value['password'], $value['age'], $value['phone_number']); // The argument may be one of four types: i - integer, d - double, s - string, b - BLOB
    $stmt->execute();
}


redirect_to_route_and_die($_POST['current_route']);