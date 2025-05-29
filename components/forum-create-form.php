<?php
require_once __DIR__ . '/../config/db-conn.php';
require_once __DIR__ . '/../services/php/flash.services.php';
require_once __DIR__ . '/../services/php/forum.services.php';


$current_cmp = 'forum-create-form';
$current_form = 'forum_create_form';


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['current_form']) && $_POST['current_form'] == $current_form) {
    $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_SPECIAL_CHARS);
}

?>

<section>
    <h3>Create Forum</h3>
    <form action="<?= htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <input type="hidden" name="current_form" value="<?= $current_form ?>">
        <div>
            <label for="title">Title</label>
            <input type="text" placeholder="Title" name="title">
            <?php if ($validation[$current_form]['title']['error']) : ?>
                <p class="text-danger"><?= $validation[$current_form]['title']['message'] ?></p>
            <?php endif ?>
        </div>
        <div>
            <input type="submit" value="Submit">
        </div>
    </form>
</section>