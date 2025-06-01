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


<section class="container my-5 d-flex justify-content-center">
    <div class="p-4 shadow border rounded">
        <h3 class="mb-4">Create Forum</h3>
        <form action="<?= htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <input type="hidden" name="current_form" value="<?= $current_form ?>">
            <div class="row mb-3">
                <label for="title" class="col-sm-2 col-form-label">Title</label>
                <div class="col-sm-10">
                    <input type="text" placeholder="Title" name="title" class="form-control">
                    <?php if ($validation[$current_form]['title']['error']) : ?>
                        <p class="text-danger"><?= $validation[$current_form]['title']['message'] ?></p>
                    <?php endif ?>
                </div>
            </div>
            <input type="submit" value="Submit">
        </form>
    </div>
</section>