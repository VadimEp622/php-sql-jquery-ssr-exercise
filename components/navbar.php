<?php
$navlinks = array('Home' => '.', 'Admin' => 'admin.php');
?>


<nav>
    <ul style="list-style-type: none; display: flex; gap: 20px;">
        <?php foreach ($navlinks as $key => $value) : ?>
            <li><a href="<?= $value ?>"><?= $key ?></a></li>
        <?php endforeach
        ?>
    </ul>
</nav>