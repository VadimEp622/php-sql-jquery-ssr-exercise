<?php
require_once __DIR__ . '/../config/db-conn.php';
require_once __DIR__ . '/../services/php/user.services.php';
require_once __DIR__ . '/../services/php/utils.services.php';

$res = array('error' => false, 'message' => 'Template error message');

$sql = "SELECT id, full_name, email, age, phone_number FROM Users";
$result = $conn->query($sql);

if ($result) {
    $users  = array();
    while ($row = $result->fetch_assoc()) {
        array_push($users, $row);
    }
    $res['users'] = $users;

    if (count($users) == 0) {
        // TODO: consider making a seperate operation for inserting template data, and on this page, having a button called "generate demo users"
        $demo_users = get_demo_users();

        foreach ($demo_users as $value) {
            $sql = "INSERT INTO Users (full_name, email, password, age, phone_number) VALUES (?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssis", $value['full_name'], $value['email'], $value['password'], $value['age'], $value['phone_number']); // The argument may be one of four types: i - integer, d - double, s - string, b - BLOB
            $stmt->execute();
        }

        redirect_to_current_page_and_die();
    }
} else {
    $res['error']   = true;
    $res['message'] = "Forums list fetch failed!";
}


?>

<section>
    <h3>User list</h3>
    <?php if ($res['error']) : ?>
        <p style="color: red;"><?= $res['message'] ?></p>
    <?php else : ?>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">id</th>
                    <th scope="col">Full name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Age</th>
                    <th scope="col">Phone</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($res['users'] as $value) : ?>
                    <tr>
                        <th scope="row"><?= $value['id'] ?></th>
                        <td><?= $value['full_name'] ?></td>
                        <td><?= $value['email'] ?></td>
                        <td><?= $value['age'] ?></td>
                        <td><?= $value['phone_number'] ?></td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    <?php endif ?>
</section>