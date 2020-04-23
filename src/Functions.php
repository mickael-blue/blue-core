<?php 

use Symfony\Component\Dotenv\Dotenv;

/**
 * Debug
 */
function debug($variable)
{
    echo "<pre>";
    echo print_r($variable, true);
    echo "</pre>";
}


$dotenv = new Dotenv();
$dotenv->load(CONFIG_DIR . '.env');

// Show error in development mode
if ($_ENV['NODE_ENV'] == 'development') {
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
