<?php

const ROUTES = array('index.php', 'admin.php');

function redirect_to_current_page_and_die()
{
    $currentRoute = explode('/', htmlspecialchars($_SERVER["PHP_SELF"]))[4];
    $redirectRoute = '';

    if (!in_array($currentRoute, ROUTES)) {
        $currentRoute = 'index.php';
    }

    if ($currentRoute !== 'index.php') {
        $redirectRoute = $currentRoute;
    }

    Header("Location: ./" . $redirectRoute);
    die();
}

function get_current_route()
{
    $currentRoute = explode('/', htmlspecialchars($_SERVER["PHP_SELF"]))[4];

    if (!in_array($currentRoute, ROUTES)) {
        $currentRoute = 'index.php';
    }
    return $currentRoute;
}

// learning purposes
function print_organized_global_server_variable()
{
    echo "<pre>";
    print_r($_SERVER);
    echo "</pre>";
}

// learning purposes
function print_json($data)
{
    echo json_encode($data);
}
