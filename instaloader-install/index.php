<?php
/**
 * TODO: Plugin Description from Top-Plugins
 */

include 'functions.php';

// Fix the 5.2 PHP problem
if( !defined( __DIR__ ) )define( __DIR__, dirname(__FILE__) );

// Fundamental directories that must be writable in order for plugin to work
$image = DIR_IMAGE;
$image_cache = DIR_IMAGE . 'cache';
$image_data = DIR_IMAGE . 'data';
$logs = __DIR__ . '/log';
$admin_link = HTTP_SERVER . 'admin/index.php?route=catalog/product';


// Start session to save the last valid page
session_start();
$_SESSION['page'] = isset($_SESSION['page']) ? $_SESSION['page'] : 1;
$_SESSION['error_warning'] = false;


    
    // Are directories writable?
    if ($_SESSION['page'] == 1) {


            $warning = '';
            if (!is_writable($image)) {
                $warning .= 'Warning: Image directory needs to be writable for Simplier Image Uploader Plugin to work! <br />';
            }

            if (!is_writable($image_cache)) {
                $warning .= 'Warning: Image cache directory needs to be writable for Simplier Image Uploader Plugin to work! <br />';
            }

            if (!is_writable($image_data)) {
                $warning .= 'Warning: Image data directory needs to be writable for Simplier Image Uploader Plugin to work! <br />';
            }

            if (!is_writable($logs)) {
                $warning .= 'Warning: Logs directory needs to be writable for Simplier Image Uploader Plugin to work! <br />';
            }

            if ($warning) {
                $_SESSION['error_warning'] = $warning;
                $_SESSION['page'] = 1;
            } else {
                $_SESSION['page'] = 2;
            }
        
    }

$page = $_SESSION['page'];
$error_warning = $_SESSION['error_warning'];
$action = '';

if ($page == 2) {
    require_once 'update-product-images.php';
    $_SESSION['page'] = 1;
    $log = file_get_contents($log_file_path);
    $log_link = 'download_log.php?file_name=' . $log_file_name;
}


include 'view/template/header.php';

include 'view/template/step_' . $page . '.php';


