<?php 

use BlueCore\Configure;

/**
 * Debug
 */
function debug($variable)
{
    echo "<pre>";
    echo print_r($variable, true);
    echo "</pre>";
}

// Show error in development mode
if (Configure::read('debug')) {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
}

/**
 * Init 
 */
$page = new App\Pages();
try {
    $page->render();
} catch (Exception $e) {
    debug($e->getMessage());
}
