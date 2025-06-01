<?php

const ROUTES = array('index.php', 'admin.php');

function redirect_to_current_page_and_die()
{
    $currentRoute = basename(htmlspecialchars($_SERVER["PHP_SELF"]));
    $outputRoute = '';

    if (!in_array($currentRoute, ROUTES)) {
        $currentRoute = 'index.php';
    }

    if ($currentRoute !== 'index.php') {
        $outputRoute = $currentRoute;
    }

    header(sprintf('Location: %s', $outputRoute));
    exit;
}

function redirect_to_route_and_die($route): void
{
    $redirectRoute = '';
    if (isset($route) && in_array($route, ROUTES)) {
        if ($_POST['current_route'] !== 'index.php') {
            $redirectRoute = $route;
        }
    }

    Header("Location: ../../" . $redirectRoute);
    exit;
}

function get_current_route()
{
    $currentRoute = basename(htmlspecialchars($_SERVER["PHP_SELF"]));

    if (!in_array($currentRoute, ROUTES)) {
        $currentRoute = 'index.php';
    }
    return $currentRoute;
}

function has_validation_errors(array $validation): bool
{
    foreach ($validation as $field => $data) {
        if ($data['error']) {
            return true;
        }
    }
    return false;
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
