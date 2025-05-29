<?php

function fetch_posts($conn, &$res): void
{
    try {
        // INFO: 
        //      * COALESCE() function returns the first non-null value in a list
        //      * LEFT JOIN returns all rows from the left table, even if there are no matches in the right table
        $sql = "SELECT
            Posts.id,
            Posts.title,
            Posts.content,
            COALESCE(Forums.title, Posts.forum_id) AS forum_title,
            Posts.poster_email
        FROM
            Posts
        LEFT JOIN Forums ON Posts.forum_id = Forums.id";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $posts  = array();
            while ($row = $result->fetch_assoc()) {
                array_push($posts, $row);
            }
            $res['posts'] = $posts;
        } else {
            $res['error']   = true;
            $res['message'] = "No posts found!";
        }
    } catch (Exception $e) {
        $res['error']   = true;
        $res['message'] = "Posts fetching failed!";
    }
}
