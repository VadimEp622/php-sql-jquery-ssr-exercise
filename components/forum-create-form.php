<?php
require_once __DIR__ . '/../config/db-conn.php';
require_once __DIR__ . '/../services/php/flash.services.php';
require_once __DIR__ . '/../services/php/utils.services.php';

$res = array('error' => false, 'message' => 'Template error message');

$validation = array(
    'title' => array('error' => false, 'message' => '')
);

$currentForm = 'forum_create_form';


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['current_form']) && $_POST['current_form'] == $currentForm) {
    $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_SPECIAL_CHARS);

    if (empty($title)) {
        $validation['title']['error'] = true;
        $validation['title']['message'] = "Title is required";
    } else {
        $sql = "INSERT INTO Forums (title) VALUES (?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $title); // The argument may be one of four types: i - integer, d - double, s - string, b - BLOB
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            create_flash_message(FLASH_OPERATION_FORUM_CREATE, "Forum created successfully", FLASH_SUCCESS);
        } else {
            create_flash_message(FLASH_OPERATION_FORUM_CREATE, "Forum creation failed", FLASH_ERROR);
        }


        redirect_to_current_page_and_die();
    }
}


?>


<section>
    <h3>Create Forum</h3>
    <form method="post">
        <input type="hidden" name="current_form" value="<?= $currentForm ?>">
        <div>
            <label for="title">Title</label>
            <input type="text" placeholder="Title" name="title">
            <?php if ($validation['title']['error']) : ?>
                <p class="text-danger"><?= $validation['title']['message'] ?></p>
            <?php endif ?>
        </div>
        <div>
            <input type="submit" value="Submit">
        </div>
    </form>
</section>