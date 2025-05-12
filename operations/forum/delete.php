<?php
session_start();
require_once __DIR__ . '/../../config/db-conn.php';
require_once __DIR__ . '/../../service/php/flash.service.php';


$res = array('error' => false, 'message' => 'Template message');

$id = $_POST['id'];
if (!is_numeric($id)) {
    $res['message'] = "invalid form id";
} else {

    $sql = "DELETE FROM Forums WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id); // The argument may be one of four types: i - integer, d - double, s - string, b - BLOB
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        create_flash_message(FLASH_OPERATION_FORUM_DELETE, "Forum deleted successfully", FLASH_SUCCESS);
    } else {
        create_flash_message(FLASH_OPERATION_FORUM_DELETE, "Forum deletion failed", FLASH_ERROR);
    }
}

$routes = array('index.php', 'admin.php');

$redirectRoute = '';
if (isset($_POST['current_route']) && in_array($_POST['current_route'], $routes)) {
    if ($_POST['current_route'] !== 'index.php') {
        $redirectRoute = $_POST['current_route'];
    }
}





Header("Location: ../../" . $redirectRoute );
die();
