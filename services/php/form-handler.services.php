<?php
require_once __DIR__ . '/../../services/php/utils.services.php';
require_once __DIR__ . '/../../services/php/flash.services.php';

function form_handler_post_create($conn, &$validation)
{
    require_once __DIR__ . '/../../services/php/user.services.php';

    $current_form = 'post_create_form';


    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_SPECIAL_CHARS);
    $content = filter_input(INPUT_POST, 'content', FILTER_SANITIZE_SPECIAL_CHARS);
    $forum = filter_input(INPUT_POST, 'forum', FILTER_SANITIZE_NUMBER_INT);

    echo '<br>' . 'email:' . $email . '<br>';
    echo 'title:' . $title . '<br>';
    echo 'content:' . $content . '<br>';
    echo 'forum:' . $forum . '<br>';


    if (empty($email)) {
        $validation[$current_form]['email']['error'] = true;
        $validation[$current_form]['email']['message'] = "Email is required";
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $validation[$current_form]['email']['error'] = true;
        $validation[$current_form]['email']['message'] = "Email is invalid";
    } else if (!check_if_user_email_exists($conn, $email)) {
        $validation[$current_form]['email']['error'] = true;
        $validation[$current_form]['email']['message'] = "Email does not exist";
    }
    if (empty($title)) {
        $validation[$current_form]['title']['error'] = true;
        $validation[$current_form]['title']['message'] = "Title is required";
    }
    if (empty($content)) {
        $validation[$current_form]['content']['error'] = true;
        $validation[$current_form]['content']['message'] = "Content is required";
    }
    if (empty($forum)) {
        $validation[$current_form]['forum']['error'] = true;
        $validation[$current_form]['forum']['message'] = "Forum is required";
    } else if (!filter_var($forum, FILTER_VALIDATE_INT)) {
        $validation[$current_form]['forum']['error'] = true;
        $validation[$current_form]['forum']['message'] = "Forum is invalid";
    }

    if (!has_validation_errors($validation[$current_form])) {
        try {
            $sql = "INSERT INTO Posts (poster_email, title, content, forum_id) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssi", $email, $title, $content, $forum); // The argument may be one of four types: i - integer, d - double, s - string, b - BLOB
            $stmt->execute();

            if ($stmt->affected_rows > 0) {
                create_flash_message(FLASH_OPERATION_POST_CREATE, "Post created successfully", FLASH_SUCCESS);
            } else {
                create_flash_message(FLASH_OPERATION_POST_CREATE, "Post creation failed", FLASH_ERROR);
            }
        } catch (Exception $e) {
            create_flash_message(FLASH_OPERATION_POST_CREATE, "Post creation failed", FLASH_ERROR);
        } finally {
            redirect_to_current_page_and_die();
        }
    }
}

function form_handler_forum_create($conn, &$validation)
{
    require_once __DIR__ . '/../../services/php/forum.services.php';
    
    $current_form = 'forum_create_form';

    $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_SPECIAL_CHARS);

    if (empty($title)) {
        $validation[$current_form]['title']['error'] = true;
        $validation[$current_form]['title']['message'] = "Title is required";
    } else if (check_if_forum_title_already_exists($conn, $title)) {
        $validation[$current_form]['title']['error'] = true;
        $validation[$current_form]['title']['message'] = "Title already exists";
    }

    if (!has_validation_errors($validation[$current_form])) {
        try {
            $sql = "INSERT INTO Forums (title) VALUES (?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $title); // The argument may be one of four types: i - integer, d - double, s - string, b - BLOB
            $stmt->execute();

            if ($stmt->affected_rows > 0) {
                create_flash_message(FLASH_OPERATION_FORUM_CREATE, "Forum created successfully", FLASH_SUCCESS);
            } else {
                create_flash_message(FLASH_OPERATION_FORUM_CREATE, "Forum creation failed", FLASH_ERROR);
            }
        } catch (Exception $e) {
            create_flash_message(FLASH_OPERATION_FORUM_CREATE, "Forum creation failed", FLASH_ERROR);
        } finally {
            redirect_to_current_page_and_die();
        }
    }
}
