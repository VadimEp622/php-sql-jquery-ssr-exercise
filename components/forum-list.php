<?php
require_once __DIR__ . '/../config/db-conn.php';

$res = array('error' => false, 'message' => 'Template error message');

$sql = "SELECT * FROM Forums";
$result = $conn->query($sql);

if ($result) {
    $forums  = array();
    while ($row = $result->fetch_assoc()) {
        array_push($forums, $row);
    }
    $res['forums'] = $forums;
} else {
    $res['error']   = true;
    $res['message'] = "Forums list fetch failed!";
}

// echo json_encode($res);


// echo "<pre>";
// print_r($_SERVER);
// echo "</pre>";


$routes = array('index.php', 'admin.php');
$currentRoute = explode('/', htmlspecialchars($_SERVER["PHP_SELF"]))[4];

if (!in_array($currentRoute, $routes)) {
    $currentRoute = 'index.php';
}



?>

<section>
    <h3>Forum list</h3>
    <?php if ($res['error']) : ?>
        <p style="color: red;"><?= $res['message'] ?></p>
    <?php else : ?>
        <ul id="forum-list">
            <?php foreach ($res['forums'] as $value) : ?>
                <li>
                    <p><?= $value['title'] ?></p>
                    <form action="operations/forums/delete.php" method="post">
                        <input type="hidden" name="current_route" value="<?= $currentRoute ?>">
                        <input type="hidden" name="id" value="<?= $value['id'] ?>">
                        <button><i class="bi bi-trash"></i></button>
                    </form>
                </li>
            <?php endforeach ?>
        </ul>
    <?php endif ?>
</section>

<style>
    #forum-list {
        list-style-type: none;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: flex-start;
        max-width: 500px;
    }

    #forum-list li {
        list-style-type: none;
        display: flex;
        align-items: center;
        gap: 20px;
        position: relative;
        width: 100%;
    }

    #forum-list li:hover:after {
        content: '';
        position: absolute;
        width: 100%;
        height: 100%;
        border: 1px solid green;
        pointer-events: none;

    }

    #forum-list li button {
        height: 20px;
        border: none;
        background-color: inherit;
    }

    #forum-list li button:hover {
        cursor: pointer;
        color: rgb(255, 109, 109);
    }
</style>