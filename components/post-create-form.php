<?php
require_once __DIR__ . '/../config/db-conn.php';
require_once __DIR__ . '/../services/php/flash.services.php';
require_once __DIR__ . '/../services/php/forum.services.php';


$current_cmp = 'post-create-form';
$current_form = 'post_create_form';


fetch_forums($conn, $res[$current_cmp]);


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['current_form']) && $_POST['current_form'] == $current_form) {
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_SPECIAL_CHARS);
    $content = filter_input(INPUT_POST, 'content', FILTER_SANITIZE_SPECIAL_CHARS);
    $forum = filter_input(INPUT_POST, 'forum', FILTER_SANITIZE_NUMBER_INT);
}


?>

<section>
    <h3>Create Post</h3>
    <?php if ($res[$current_cmp]['error']) : ?>
        <div class="text-danger">Error</div>
        <div class="text-danger"><?= $res[$current_cmp]['message'] ?></div>
        <a class="btn btn-secondary" href="<?php htmlspecialchars($_SERVER['PHP_SELF']); ?>">Reload this page</a>
    <?php else : ?>
        <form method="post" class="w-50">
            <input type="hidden" name="current_form" value="<?= $current_form ?>">

            <div class="row mb-3">
                <label for="email" class="col-sm-3 col-form-label">Email</label>
                <div class="col-sm-9">
                    <input type="email" name="email" class="form-control" value="<?= isset($email) ? $email : '' ?>">
                </div>
                <?php if ($validation[$current_form]['email']['error']) : ?>
                    <div class="text-danger"><?= $validation[$current_form]['email']['message'] ?></div>
                <?php endif ?>
            </div>

            <div class="row mb-3">
                <label for="title" class="col-sm-3 col-form-label">Title</label>
                <div class="col-sm-9">
                    <input type="text" name="title" class="form-control" value="<?= isset($title) ? $title : '' ?>">
                </div>
                <?php if ($validation[$current_form]['title']['error']) : ?>
                    <div class="text-danger"><?= $validation[$current_form]['title']['message'] ?></div>
                <?php endif ?>
            </div>

            <div class="row mb-3">
                <label for="content" class="col-sm-3 col-form-label">Content</label>
                <div class="col-sm-9">
                    <textarea name="content" class="form-control" aria-label="post content"><?= isset($content) ? $content : '' ?></textarea>
                </div>
                <?php if ($validation[$current_form]['content']['error']) : ?>
                    <div class="text-danger"><?= $validation[$current_form]['content']['message'] ?></div>
                <?php endif ?>
            </div>

            <div class="row mb-3">
                <label for="forum" class="col-sm-3 col-form-label">Forum</label>
                <div class="col-sm-9">
                    <select name="forum" class="form-select" aria-label="forum select">
                        <option value='' selected>Select forum</option>
                        <?php foreach ($res[$current_cmp]['forums'] as $forum) : ?>
                            <option value="<?= $forum['id'] ?>"><?= $forum['title'] ?></option>
                        <?php endforeach ?>
                    </select>
                </div>
                <?php if ($validation[$current_form]['forum']['error']) : ?>
                    <div class="text-danger"><?= $validation[$current_form]['forum']['message'] ?></div>
                <?php endif ?>
            </div>

            <div>
                <input type="submit" value="Submit">
            </div>
        </form>
    <?php endif ?>
</section>