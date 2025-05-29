<?php

function fetch_forums($conn, &$res): void
{
    try {
        $queryForumsSql = "SELECT * FROM Forums";
        $queryForumsResult = $conn->query($queryForumsSql);
        if ($queryForumsResult->num_rows > 0) {
            $forums  = array();
            while ($row = $queryForumsResult->fetch_assoc()) {
                array_push($forums, $row);
            }
            $res['forums'] = $forums;
        } else {
            $res['error']   = true;
            $res['message'] = "No forums found! either create one, or reload this page";
        }
    } catch (Exception $e) {
        $res['error']   = true;
        $res['message'] = "Forums list fetch failed!";
    }
}

function check_if_forum_title_already_exists($conn, $forum_title): bool
{
    try {
        $sql = "SELECT * FROM Forums WHERE title = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $forum_title); // The argument may be one of four types: i - integer, d - double, s - string, b - BLOB
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->num_rows > 0;
    } catch (Exception $e) {
        return false;
    }
}
