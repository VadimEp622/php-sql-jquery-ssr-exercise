<?php
require_once __DIR__ . '/../config/db-conn.php';
require_once __DIR__ . '/../services/php/utils.services.php';

$res = array('error' => false, 'message' => 'Template error message');

// TODO: 
//      1) select only data that is needed
//      2) get forum title using forum_id (some form of join)


$sql = "SELECT * FROM Posts";
$result = $conn->query($sql);

if (true) {
    $posts  = array();
    while ($row = $result->fetch_assoc()) {
        array_push($posts, $row);
    }
    $res['posts'] = $posts;

    if (count($posts) == 0) {
        $res['error']   = true;
        $res['message'] = "No posts found!";
    }
} else {
    $res['error']   = true;
    $res['message'] = "Posts fetch failed!";
}

print_json($res);
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
                    <th scope="col">Forum Id</th>
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
                        <td><?= $value['forum_id'] ?></td>
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