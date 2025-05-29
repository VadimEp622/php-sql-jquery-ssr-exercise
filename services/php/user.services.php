<?php

function fetch_users($conn, &$res): void
{
    try {
        $sql = "SELECT id, full_name, email, age, phone_number FROM Users";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $users  = array();
            while ($row = $result->fetch_assoc()) {
                array_push($users, $row);
            }
            $res['users'] = $users;
        } else {
            $res['error']   = true;
            $res['message'] = "No users found!";
            $res['is_error_no_users'] = true;
        }
    } catch (Exception $e) {
        $res['error']   = true;
        $res['message'] = "Users list fetch failed!";
    }
}

function check_if_user_email_exists($conn, $email): bool
{
    try {
        $sql = "SELECT * FROM Users WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email); // The argument may be one of four types: i - integer, d - double, s - string, b - BLOB
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->num_rows > 0;
    } catch (Exception $e) {
        return false;
    }
}

function get_demo_users()
{
    return array(
        array('full_name' => 'John Doe', 'email' => 'johndoe@me.com', 'password' => 'password', 'age' => 20, 'phone_number' => '1234567890'),
        array('full_name' => 'Jane Doe', 'email' => 'janedoe@me.com', 'password' => 'password', 'age' => 21, 'phone_number' => '1234567891'),
        array('full_name' => 'John Smith', 'email' => 'johnsmith@me.com', 'password' => 'password', 'age' => 22, 'phone_number' => '1234567892'),
        array('full_name' => 'Jane Smith', 'email' => 'janesmith@me.com', 'password' => 'password', 'age' => 23, 'phone_number' => '1234567893'),
    );
}
