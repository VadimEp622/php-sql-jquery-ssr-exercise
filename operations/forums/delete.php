<?php
session_start();
require_once __DIR__ . '/../../config/db-conn.php';
require_once __DIR__ . '/../../services/php/flash.services.php';
require_once __DIR__ . '/../../services/php/utils.services.php';


$res = array('error' => false, 'message' => 'Template message');

$id = $_POST['id'];
if (!is_numeric($id)) {
    create_flash_message(FLASH_OPERATION_FORUM_DELETE, "Forum deletion failed - invalid form id", FLASH_ERROR);
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

redirect_to_route_and_die($_POST['current_route']);