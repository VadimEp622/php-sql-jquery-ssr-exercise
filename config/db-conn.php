<?php

// Create connection
$conn = new mysqli("localhost", "root", "", "php_sql_exercise_db");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
