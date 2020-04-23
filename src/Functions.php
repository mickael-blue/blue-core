<?php 

/**
 * Debug
 */
function debug($variable)
{
    echo "<pre>";
    echo print_r($variable, true);
    echo "</pre>";
}