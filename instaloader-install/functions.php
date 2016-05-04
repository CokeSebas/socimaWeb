<?php
// Include open cart configuration 
require_once '../config.php';

// Fundamental directories that must be writable in order for plugin to work
$image = DIR_IMAGE;
$image_cache = DIR_IMAGE . 'cache';
$image_data = DIR_IMAGE . 'data';
$logs = __DIR__ . '/log';


// Connect to database
$DB = new PDO('mysql:host=' . DB_HOSTNAME . ';dbname=' . DB_DATABASE, DB_USERNAME, DB_PASSWORD);

/**
 * Modified version of the method that UploadHandler of jQuery File Upload uses to create
 * 'versions' of the images. 
 * Used in our case to create thumbnails.
 * 
 * @param  [type] $file_name [description]
 * @param  [type] $version   [description]
 * @param  [type] $options   [description]
 * @return [type]            [description]
 */
function create_scaled_image($file_name, $version, $options) {
        $file_path = DIR_IMAGE . $file_name;
        $pathParts = pathinfo($file_path);
        $baseName = $pathParts['basename'];

        if (!empty($version)) {
            $version_dir = DIR_IMAGE . 'data/product-' . $options['product_id'] . '/' . $version;
            if (!is_dir($version_dir)) {
                mkdir($version_dir, 0777, true);
            }
            $new_file_path = $version_dir.'/'.$baseName;
        } else {
            $new_file_path = $file_path;
        }
        list($img_width, $img_height) = getimagesize($file_path);
        if (!$img_width || !$img_height) {
            return false;
        }
        $scale = min(
            $options['max_width'] / $img_width,
            $options['max_height'] / $img_height
        );
        if ($scale >= 1) {
            if ($file_path !== $new_file_path) {
                return copy($file_path, $new_file_path);
            }
            return true;
        }
        $new_width = $img_width * $scale;
        $new_height = $img_height * $scale;
        $new_img = @imagecreatetruecolor($new_width, $new_height);
        switch (strtolower(substr(strrchr($baseName, '.'), 1))) {
            case 'jpg':
            case 'jpeg':
                $src_img = @imagecreatefromjpeg($file_path);
                $write_image = 'imagejpeg';
                $image_quality = isset($options['jpeg_quality']) ?
                    $options['jpeg_quality'] : 75;
                break;
            case 'gif':
                @imagecolortransparent($new_img, @imagecolorallocate($new_img, 0, 0, 0));
                $src_img = @imagecreatefromgif($file_path);
                $write_image = 'imagegif';
                $image_quality = null;
                break;
            case 'png':
                @imagecolortransparent($new_img, @imagecolorallocate($new_img, 0, 0, 0));
                @imagealphablending($new_img, false);
                @imagesavealpha($new_img, true);
                $src_img = @imagecreatefrompng($file_path);
                $write_image = 'imagepng';
                $image_quality = isset($options['png_quality']) ?
                    $options['png_quality'] : 9;
                break;
            default:
                $src_img = null;
        }
        $success = $src_img && @imagecopyresampled(
            $new_img,
            $src_img,
            0, 0, 0, 0,
            $new_width,
            $new_height,
            $img_width,
            $img_height
        ) && $write_image($new_img, $new_file_path, $image_quality);
        // Free up memory (imagedestroy does not delete files):
        @imagedestroy($src_img);
        @imagedestroy($new_img);
        return $success;
}

function productDiretoryExists($productId) 
{
    $basePath = DIR_IMAGE . 'data/product-' . $productId;

    if (is_dir($basePath)) {
        return true;
    }

    return false;
}

function createProductDirectory($productId)
{
    $basePath = DIR_IMAGE . 'data/product-' . $productId;

    return mkdir($basePath, 0777);
}

function moveProductImage($oldPath, $productId)
{
    // Parse old path, so we can get the file name
    $pathParts = pathinfo($oldPath);
    $baseName = $pathParts['basename'];

    $basePath = 'data/product-' . $productId . '/' . $baseName;
    $newPath = DIR_IMAGE . 'data/product-' . $productId . '/' . $baseName;

    if (!file_exists($newPath)) {
        if (is_file($oldPath)) {
            copy($oldPath, $newPath) or die("couldn't move $oldPath to $newPath: $php_errormsg");
        } 
    }
    
    return $basePath;

}

/**
 * Deliver the last image order for this product, zero is no images
 * 
 * @param  [type] $productId [description]
 * @return [type]            [description]
 */
function lastSortOrder($productId) 
{
    global $DB;
    
    $query = 'SELECT * FROM ' . DB_PREFIX . 'product_image WHERE product_id = '.$productId.' ORDER BY sort_order DESC LIMIT 1';
    $rows = $DB->query($query);
    $firstRow = $rows->fetch();
    
    if (is_array($firstRow)) {
        return $firstRow['sort_order'];
    } 

    return 0;
}

/**
 * Download the file instead of displaying it.
 * 
 * @param  string $file_name Absolute path to the file
 * @return resource  File or 404 page
 */
function download_file($file_name) {

    if (!file_exists($file_name)) { die("<b>404 File not found!</b>"); }
   
    $file_extension = strtolower(substr(strrchr($file_name,"."),1));
    $file_size = filesize($file_name);
    $md5_sum = md5_file($file_name);
   
   //This will set the Content-Type to the appropriate setting for the file
    switch($file_extension) {
        case "exe": $ctype="application/octet-stream"; break;
        case "zip": $ctype="application/zip"; break;
        case "mp3": $ctype="audio/mpeg"; break;
        case "mpg":$ctype="video/mpeg"; break;
        case "avi": $ctype="video/x-msvideo"; break;
        case "txt": $ctype="text/plain"; break;

        //The following are for extensions that shouldn't be downloaded (sensitive stuff, like php files)
        case "php":
        case "htm":
        case "html": die("<b>Cannot be used for ". $file_extension ." files!</b>"); break;

        default: $ctype="application/force-download";
    }
   
    if (isset($_SERVER['HTTP_RANGE'])) {
        $partial_content = true;
        $range = explode("-", $_SERVER['HTTP_RANGE']);
        $offset = intval($range[0]);
        $length = intval($range[1]) - $offset;
    }
    else {
        $partial_content = false;
        $offset = 0;
        $length = $file_size;
    }
   
    //read the data from the file
    $handle = fopen($file_name, 'r');
    $buffer = '';
    fseek($handle, $offset);
    $buffer = fread($handle, $length);
    $md5_sum = md5($buffer);
    if ($partial_content) $data_size = intval($range[1]) - intval($range[0]);
    else $data_size = $file_size;
    fclose($handle);
   
    // send the headers and data
    header("Content-Length: " . $data_size);
    header("Content-md5: " . $md5_sum);
    header("Accept-Ranges: bytes");   
    if ($partial_content) header('Content-Range: bytes ' . $offset . '-' . ($offset + $length) . '/' . $file_size);
    header("Connection: close");
    header("Content-type: " . $ctype);
    header('Content-Disposition: attachment; filename=' . $file_name);
    echo $buffer;
    flush();
}

function print_system_info($image, $image_cache, $image_data, $logs) {
    $out = "PHP Version: \t" . phpversion() . "\n";
    $out .= 'Register Globals: ' . (ini_get('register_globals')) ? 'On' : 'Off' . "\n";
    $out .= "Magic Quotes GPC: \t" . (ini_get('magic_quotes_gpc')) ? 'On' : 'Off' . "\n";
    $out .= "File Uploads: \t" . (ini_get('file_uploads')) ? 'On' : 'Off' . "\n";
    $out .= "Session Auto Start: \t" . (ini_get('session_auto_start')) ? 'On' : 'Off' . "\n";
    $out .= "MySQL: \t" . extension_loaded('mysql') ? 'On' : 'Off' . "\n";
    $out .= "GD: \t" . extension_loaded('gd') ? 'On' : 'Off' . "\n";
    $out .= "cURL: \t" . extension_loaded('curl') ? 'On' : 'Off' . "\n";
    $out .= "mCrypt: \t" . function_exists('mcrypt_encrypt') ? 'On' : 'Off' . "\n";
    $out .= "ZIP: \t" . extension_loaded('zlib') ? 'On' : 'Off' . "\n";
    $out .= "$image :\t" . is_writable($image) ? 'Writable' : 'Unwritable' . "\n";
    $out .= "$image_cache :\t" . is_writable($image_cache) ? 'Writable' : 'Unwritable' . "\n";
    $out .= "$image_data :\t" . is_writable($image_data) ? 'Writable' : 'Unwritable' . "\n";
    $out .= "$logs :\t" . is_writable($logs) ? 'Writable' : 'Unwritable' . "\n";

    return $out;
}