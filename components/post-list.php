<?php
require_once __DIR__ . '/../config/db-conn.php';
require_once __DIR__ . '/../services/php/utils.services.php';

$res = array('error' => false, 'message' => 'Template error message');


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

// print_json($res);
$currentRoute = get_current_route();
?>


<section>
    <h3>Post list</h3>
    <?php if ($res['error']) : ?>
        <div class="d-flex gap-2">
            <p style="color: red;"><?= $res['message'] ?></p>
        </div>
    <?php else : ?>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Id</th>
                    <th scope="col">Title</th>
                    <th scope="col">Content</th>
                    <th scope="col">Forum</th>
                    <th scope="col">Poster Email</th>
                    <th scope="col">Delete</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($res['posts'] as $value) : ?>
                    <tr>
                        <th scope="row"><?= $value['id'] ?></th>
                        <td><?= $value['title'] ?></td>
                        <td><?= $value['content'] ?></td>
                        <td><?= $value['forum_title'] ?></td>
                        <td><?= $value['poster_email'] ?></td>
                        <td>
                            <form action="operations/posts/delete.php" method="post" class="d-flex justify-content-center">
                                <input type="hidden" name="current_route" value="<?= $currentRoute ?>">
                                <input type="hidden" name="id" value="<?= $value['id'] ?>">
                                <button class="btn btn-danger"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    <?php endif ?>
</section>