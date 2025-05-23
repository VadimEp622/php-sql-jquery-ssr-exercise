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

$currentForm = 'post_create_form';

// TODO: 
// 1) mysql query all forums into selector
// 2) handle forums query errors


$queryForumsSql = "SELECT * FROM Forums";
$queryForumsResult = $conn->query($queryForumsSql);
if ($queryForumsResult) {
    $forums  = array();
    while ($row = $queryForumsResult->fetch_assoc()) {
        array_push($forums, $row);
    }

    if (count($forums) == 0) {
        $res['error']   = true;
        $res['message'] = "No forums found! either create one, or reload this page";
    }
    $res['forums'] = $forums;
} else {
    $res['error']   = true;
    $res['message'] = "Forums list fetch failed!";
}

// print_json($res);


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['current_form']) && $_POST['current_form'] == $currentForm) {
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_SPECIAL_CHARS);
    $content = filter_input(INPUT_POST, 'content', FILTER_SANITIZE_SPECIAL_CHARS);
    $forum = filter_input(INPUT_POST, 'forum', FILTER_SANITIZE_NUMBER_INT);

    // echo '<br>' . 'email:' . $email . '<br>';
    // echo 'title:' . $title . '<br>';
    // echo 'content:' . $content . '<br>';
    // echo 'forum:' . $forum . '<br>';


    if (empty($email)) {
        $validation['email']['error'] = true;
        $validation['email']['message'] = "Email is required";
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $validation['email']['error'] = true;
        $validation['email']['message'] = "Email is invalid";
    } else if (!checkIfEmailExists($conn, $email)) {
        $validation['email']['error'] = true;
        $validation['email']['message'] = "Email does not exist";
    }
    if (empty($title)) {
        $validation['title']['error'] = true;
        $validation['title']['message'] = "Title is required";
    }
    if (empty($content)) {
        $validation['content']['error'] = true;
        $validation['content']['message'] = "Content is required";
    }
    if (empty($forum)) {
        $validation['forum']['error'] = true;
        $validation['forum']['message'] = "Forum is required";
    } else if (!filter_var($forum, FILTER_VALIDATE_INT)) {
        $validation['forum']['error'] = true;
        $validation['forum']['message'] = "Forum is invalid";
    }

    if (!hasValidationErrors($validation)) {
        echo 'no validation errors';
    }

    // TODO: 
    //   * make post mysql insert


}

function checkIfEmailExists($conn, $email): bool
{
    $sql = "SELECT * FROM Users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email); // The argument may be one of four types: i - integer, d - double, s - string, b - BLOB
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->num_rows > 0;
}


function hasValidationErrors(array $validation): bool
{
    foreach ($validation as $field => $data) {
        if ($data['error']) {
            return true;
        }
    }
    return false;
}

?>

<section>
    <h3>Create Post</h3>
    <?php if ($res['error']) : ?>
        <div class="text-danger">Error</div>
        <div class="text-danger"><?= $res['message'] ?></div>
        <a class="btn btn-secondary" href="<?php htmlspecialchars($_SERVER['PHP_SELF']); ?>">Reload this page</a>
    <?php else : ?>
        <form method="post" class="w-50">
            <input type="hidden" name="current_form" value="<?= $currentForm ?>">

            <div class="row mb-3">
                <label for="email" class="col-sm-3 col-form-label">Email</label>
                <div class="col-sm-9">
                    <input type="email" name="email" class="form-control" value="<?= isset($email) ? $email : '' ?>">
                </div>
                <?php if ($validation['email']['error']) : ?>
                    <div class="text-danger"><?= $validation['email']['message'] ?></div>
                <?php endif ?>
            </div>

            <div class="row mb-3">
                <label for="title" class="col-sm-3 col-form-label">Title</label>
                <div class="col-sm-9">
                    <input type="text" name="title" class="form-control" value="<?= isset($title) ? $title : '' ?>">
                </div>
                <?php if ($validation['title']['error']) : ?>
                    <div class="text-danger"><?= $validation['title']['message'] ?></div>
                <?php endif ?>
            </div>

            <div class="row mb-3">
                <label for="content" class="col-sm-3 col-form-label">Content</label>
                <div class="col-sm-9">
                    <textarea name="content" class="form-control" aria-label="post content"><?= isset($content) ? $content : '' ?></textarea>
                </div>
                <?php if ($validation['content']['error']) : ?>
                    <div class="text-danger"><?= $validation['content']['message'] ?></div>
                <?php endif ?>
            </div>

            <div class="row mb-3">
                <label for="forum" class="col-sm-3 col-form-label">Forum</label>
                <div class="col-sm-9">
                    <select name="forum" class="form-select" aria-label="forum select">
                        <option value='' selected>Select forum</option>
                        <?php foreach ($res['forums'] as $forum) : ?>
                            <option value="<?= $forum['id'] ?>"><?= $forum['title'] ?></option>
                        <?php endforeach ?>
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
    <?php endif ?>
</section>