<?php
session_start();
require_once __DIR__ . '/services/php/flash.services.php';

// TODO:
// 1) add some bootstrap styling
// 2) add user/forums components/operations 
// 3) add sorting
// 4) add db action error handling (try/catch ?) (do like here:  https://www.w3schools.com/php/php_mysql_select_where.asp)

display_flash_message(FLASH_OPERATION_FORUM_CREATE);
display_flash_message(FLASH_OPERATION_FORUM_DELETE);
display_flash_message(FLASH_OPERATION_USER_DELETE);
display_flash_message(FLASH_OPERATION_POST_CREATE);
display_flash_message(FLASH_OPERATION_POST_DELETE);



// INFO: include rendered components here and not directly in the html body,
//        to prevent header redirect errors (Functions that send/modify HTTP headers must be invoked before any output is made. Otherwise the call fails)
// ################ Views ################
include_once __DIR__ . '/components/navbar.php';
echo '<h1>HOME</h1>';
include_once __DIR__ . '/components/forum-create-form.php';
include_once __DIR__ . '/components/forum-list.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP-SQL-EXERCISE</title>
    <script src="libs/jquery-3.7.1.min.js"></script>
    <script src="libs/jquery.validate.min.js"></script>
    <script src="libs/additional-methods.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
</head>

<body>
    <script src="services/js/utils.services.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>

    <script>
        $(document).ready(function() {
            flash_timeout_remove()
        });
    </script>
</body>

</html>