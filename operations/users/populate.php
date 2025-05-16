<?php
session_start();
require_once __DIR__ . '/../../config/db-conn.php';
require_once __DIR__ . '/../../services/php/flash.services.php';
require_once __DIR__ . '/../../services/php/user.services.php';


$res = array('error' => false, 'message' => 'Template message');

$demo_users = get_demo_users();

foreach ($demo_users as $value) {
    $sql = "INSERT INTO Users (full_name, email, password, age, phone_number) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssis", $value['full_name'], $value['email'], $value['password'], $value['age'], $value['phone_number']); // The argument may be one of four types: i - integer, d - double, s - string, b - BLOB
    $stmt->execute();
}


$routes = array('index.php', 'admin.php');

$redirectRoute = '';
if (isset($_POST['current_route']) && in_array($_POST['current_route'], $routes)) {
    if ($_POST['current_route'] !== 'index.php') {
        $redirectRoute = $_POST['current_route'];
    }
}


Header("Location: ../../" . $redirectRoute);
die();
