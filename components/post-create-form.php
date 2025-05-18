<?php
require_once __DIR__ . '/../config/db-conn.php';
require_once __DIR__ . '/../services/php/flash.services.php';
require_once __DIR__ . '/../services/php/utils.services.php';

$res = array('error' => false, 'message' => 'Template error message');

$validation = array(
    'title' => array('error' => false, 'message' => ''),
    'content' => array('error' => false, 'message' => ''),
    'forum' => array('error' => false, 'message' => ''),
    'email' => array('error' => false, 'message' => '')
);

// TODO: 
// 1) mysql query all forums into selector
// 2) handle forums query errors

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_SPECIAL_CHARS);
    $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_SPECIAL_CHARS);
    $content = filter_input(INPUT_POST, 'content', FILTER_SANITIZE_SPECIAL_CHARS);
    $forum = filter_input(INPUT_POST, 'forum', FILTER_SANITIZE_SPECIAL_CHARS);

    echo 'email:' . $email . '<br>';
    echo 'title:' . $title . '<br>';
    echo 'content:' . $content . '<br>';
    echo 'forum:' . $forum . '<br>';

    if (empty($email) || empty($title) || empty($content) || empty($forum)) {
        if (empty($email)) {
            $validation['email']['error'] = true;
            $validation['email']['message'] = "Email is required";
        }
        if (empty($title)) {
            $validation['title']['error'] = true;
            $validation['title']['message'] = "Title is required";
        }
        if (empty($content)) {
            $validation['content']['error'] = true;
            $validation['content']['message'] = "Content is required";
        }
        // if (empty($forum)) {
        //     $validation['forum']['error'] = true;
        //     $validation['forum']['message'] = "Forum is required";
        // }

    } else {
    }
}


?>



<section>
    <h3>Create Post</h3>
    <form method="post" class="w-50">

        <div class="row mb-3">
            <label for="email" class="col-sm-3 col-form-label">Email</label>
            <div class="col-sm-9">
                <input type="email" name="email" class="form-control">
            </div>
            <?php if ($validation['email']['error']) : ?>
                <div class="text-danger"><?= $validation['email']['message'] ?></div>
            <?php endif ?>
        </div>

        <div class="row mb-3">
            <label for="title" class="col-sm-3 col-form-label">Title</label>
            <div class="col-sm-9">
                <input type="text" name="title" class="form-control">
            </div>
            <?php if ($validation['title']['error']) : ?>
                <div class="text-danger"><?= $validation['title']['message'] ?></div>
            <?php endif ?>
        </div>

        <div class="row mb-3">
            <label for="content" class="col-sm-3 col-form-label">Content</label>
            <div class="col-sm-9">
                <textarea name="content" class="form-control" aria-label="post content"></textarea>
            </div>
            <?php if ($validation['content']['error']) : ?>
                <div class="text-danger"><?= $validation['content']['message'] ?></div>
            <?php endif ?>
        </div>

        <div class="row mb-3">
            <label for="forum" class="col-sm-3 col-form-label">Forum</label>
            <div class="col-sm-9">
                <select name="forum" class="form-select" aria-label="forum select">
                    <option value="null" selected>Select forum</option>
                    <option value="1">One</option>
                    <option value="2">Two</option>
                    <option value="3">Three</option>
                </select>
            </div>
            <?php if ($validation['forum']['error']) : ?>
                <div class="text-danger"><?= $validation['forum']['message'] ?></div>
            <?php endif ?>
        </div>

        <div>
            <input type="submit" value="Submit">
        </div>
    </form>
</section>