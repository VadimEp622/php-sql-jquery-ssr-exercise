<?php
require_once __DIR__ . '/../config/db-conn.php';
require_once __DIR__ . '/../services/php/user.services.php';
require_once __DIR__ . '/../services/php/utils.services.php';

$res = array('error' => false, 'message' => 'Template error message');

fetchUsers($conn, $res);

$currentRoute = get_current_route();
?>

<section>
    <h3>User list</h3>
    <?php if ($res['error']) : ?>
        <div class="d-flex gap-2">
            <p style="color: red;"><?= $res['message'] ?></p>
            <?php if (isset($res['is_error_no_users']) && $res['is_error_no_users']) : ?>
                <form action="operations/users/populate.php" method="post">
                    <input type="hidden" name="current_route" value="<?= $currentRoute ?>">
                    <button>Populate demo users</button>
                </form>
            <?php endif ?>
        </div>
    <?php else : ?>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">id</th>
                    <th scope="col">Full name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Age</th>
                    <th scope="col">Phone</th>
                    <th scope="col">Delete</th>
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
                        <td>
                            <form action="operations/users/delete.php" method="post" class="d-flex justify-content-center">
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