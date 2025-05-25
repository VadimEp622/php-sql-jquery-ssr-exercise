<?php

// ##################################### HELP #####################################
// 1) when loading page, only 1 flash message must be displayed - budget accordingly
// ################################################################################


const FLASH = 'FLASH_MESSAGES';
const FLASH_TIMEOUT = 2000;

const FLASH_ERROR = 'error';
const FLASH_WARNING = 'warning';
const FLASH_INFO = 'info';
const FLASH_SUCCESS = 'success';

const FLASH_OPERATION_FORUM_CREATE = 'forum_create';
const FLASH_OPERATION_FORUM_DELETE = 'forum_delete';
const FLASH_OPERATION_USER_DELETE = 'user_delete';
const FLASH_OPERATION_POST_CREATE = 'post_create';
const FLASH_OPERATION_POST_DELETE = 'post_delete';


/**
 * Create a flash message
 *
 * @param string $name
 * @param string $message
 * @param string $type (error, warning, info, success)
 * @return void
 */
function create_flash_message(string $name, string $message, string $type): void
{
    // remove existing message with the name
    if (isset($_SESSION[FLASH][$name])) {
        unset($_SESSION[FLASH][$name]);
    }
    // add the message to the session
    $_SESSION[FLASH][$name] = ['message' => $message, 'type' => $type];
}

/**
 * Format a flash message
 *
 * @param array $flash_message
 * @return string
 */
function format_flash_message(array $flash_message): string
{
    return sprintf(
        '<div id="flash_message" data-timeout="%s" class="alert alert-%s fade show position-absolute top-0 right-0 left-0 opacity-60 z-index-1000 w-100">%s</div>',
        FLASH_TIMEOUT,
        get_valid_flash_type_class_string($flash_message['type']),
        $flash_message['message']
    );
}

/**
 * return valid class string for flash type
 *
 * @param string $flash_type
 * @return string
 */
function get_valid_flash_type_class_string(string $flash_type): string
{
    switch ($flash_type) {
        case FLASH_ERROR:
            return 'danger';
        case FLASH_WARNING:
            return 'warning';
        case FLASH_INFO:
            return 'info';
        case FLASH_SUCCESS:
            return 'success';
        default:
            return 'info';
    }
}

/**
 * Display a flash message
 *
 * @param string $name
 * @return void
 */
function display_flash_message(string $name): void
{
    if (!isset($_SESSION[FLASH][$name])) {
        return;
    }

    // get message from the session
    $flash_message = $_SESSION[FLASH][$name];

    // delete the flash message
    unset($_SESSION[FLASH][$name]);

    // display the flash message
    echo format_flash_message($flash_message);
}
