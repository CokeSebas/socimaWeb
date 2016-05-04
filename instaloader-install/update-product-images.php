<?php
/**
 * This script will update the images used by the native image upload solution 
 * and transform them into the easier, product related format. 
 * 
 * The native open cart image upload stores all the images in the image/data directory.
 * There is no way to upload several images at once, no drug and drop upload, no iPad support.
 * This is all fixed by the Simplier Image Upload module. 
 *
 * However to finish the installation of the module you need to run this script that
 * will do the following:
 *
 * - It will look in the product_image table for the image file reference
 * - It will check if the data/product-N folder exists (where N is the product id) 
 * - If this folder does not exist, script will create it
 * - Each referenced file will be moved to data/product-N
 * - The new location of the file will be stored in the table, old location will be deleted
 *
 * IMPORTANT!!!
 *
 * Don't forget to make image/data directory writable BEFORE you execute this script!!!
 * In order to do so, in your terminal type the following command and hit enter:
 *
 * $ cd image/data
 * $ sudo chmod -R 777 *
 *  
 * @author      Andrey I. Esaulov <esaulov.andrey@gmail.com>
 * @version     0.1
 * @copyright   Andrey I. Esaulov 2013
 */

// Include open cart configuration 
require_once '../config.php';

// And useful functions
require_once 'functions.php';

// We want to see all the errors for debug purposes
error_reporting(E_ALL);
ini_set("display_errors", 1);


// Get the file references from the product_image table
$st = $DB->query('SELECT * FROM ' . DB_PREFIX . 'product_image');


$log = '';
foreach ($st->fetchAll() as $row) {
    $log .= "Product #" . $row['product_id'] . " has the image <strong>" . $row['image'] . "</strong> <br/>\n";

    // It will check if the data/product-N folder exists (where N is the product id) 
    $dirExists = productDiretoryExists($row['product_id']) ? 'YES' : 'NO';
    $log .= "Checking if the <strong>data/product-" . $row['product_id'] . "</strong> directory exists...: \t" . $dirExists . "<br />\n";

    // If this folder does not exist, script will create it
    if ($dirExists === 'NO') {
        // Quit if could not create a directory
        if (createProductDirectory($row['product_id'])) {
            $createionStatus = 'Directory created';
        } else {
            $createionStatus = 'Failed to create a directory';
            die('Failed to create a directory');
        }
        $log .= $createionStatus . '<br />';
    }


    // If referenced file does not exist on the disk, delete a row from DB and move on
    if (!file_exists(DIR_IMAGE . $row['image'])) {
        $delSt = $DB->prepare('DELETE FROM ' . DB_PREFIX . 'product_image WHERE product_image_id = ?');
        if ($delSt->execute(array($row['product_image_id']))) {
            $log .= "Successfully delete the database row for non-existent file <br />\n";
            continue;
        }
    }

    // Each referenced file will be moved to data/product-N
    $newPath = moveProductImage(DIR_IMAGE . $row['image'], $row['product_id']);
    $log .= "Moving image file to new location... \t" . $newPath . "<br />\n";

    // Update the file reference in the database
    $updSt = $DB->prepare('UPDATE ' . DB_PREFIX . 'product_image SET image = ? WHERE product_image_id = ?');
    if ($updSt->execute(array($newPath, $row['product_image_id']))) {
        $log .= "Successfully updated the database row <br />\n";
    }
}

// TODO:
    // There may be cases, when you already have the images in the product-N directories, but those
    // are not referenced from the datbase. 
    // Go the directory structure and search for product-N folders
    // Go each file there and check if the reference exists in the DB
    // If it does not - create the reference with the product ID and the image name
    // 

$log .= "<strong>Checking the existing files with no references in the database</strong> <br />";

// Iterate though product ids
$productSt = $DB->query("SELECT product_id from " . DB_PREFIX . "product");

foreach($productSt->fetchAll() as $row) {
    $productId = $row['product_id'];
    $directory = DIR_IMAGE . 'data/product-' . $productId;
    if (is_dir($directory)) {
         $log .= "Directory <strong>$directory</strong> exists in the filesystem <br />";
         $log .= "Checking if the files inside referenced in the database... <br />";
          foreach (new DirectoryIterator($directory) as $file) {
            if ($file->isFile()) {
                 $fileName = 'data/product-' . $productId . '/' . $file->getBasename();
                 $rows = $DB->query('SELECT * FROM ' . DB_PREFIX . 'product_image WHERE image = "' . $fileName . '" AND product_id = '.$productId);
                 $firstRow = $rows->fetch();
                 if (is_array($firstRow)) {
                    $log .= "$fileName is referenced, nothing to do <br />";
                 } else {
                    $sort_order = lastSortOrder($productId) + 1;
                    $instSt = $DB->prepare('INSERT INTO ' . DB_PREFIX . 'product_image (product_id, image, sort_order) VALUES(?,?,?)');
                    $insertStatus = $instSt->execute(array($productId, $fileName, $sort_order)) ? 'SUCCESS' : 'FAILED';
                    $log .= "$fileName is NOT referenced, inserting... \t $insertStatus <br />";
                 }
            }
                
        }
    }
    $log .= "Move the main image to product_image table <br />";
    $imageRows = $DB->query('SELECT image FROM ' . DB_PREFIX . 'product WHERE product_id = '. $productId);
    $firstImage = $imageRows->fetch();
    $firstImage = DIR_IMAGE . $firstImage['image'];

    if (!productDiretoryExists($productId)) {
        createProductDirectory($productId);
    }

    $log .= "Preparing to copy $firstImage <br />";
    if (!file_exists($firstImage) || !is_file($firstImage)) {
        $log .= "Main image file does not exist: $firstImage, moving on <br />";
        continue;
    }
    $newImagePath = moveProductImage($firstImage, $productId);

    // Update the reference in the product table
    $updSt = $DB->prepare('UPDATE ' . DB_PREFIX . 'product SET image = ? WHERE product_id = ?');
    $updSt->execute(array($newImagePath, $productId));

    // Insert the reference in the product_image table
    // If the reference does not yet exist
    $rows = $DB->query('SELECT * FROM ' . DB_PREFIX . 'product_image WHERE image = "' . $newImagePath . '" AND product_id = '.$productId);
    $firstRow = $rows->fetch();
    if ($firstRow === false) {
        $insertSIt = $DB->prepare('INSERT INTO ' . DB_PREFIX . 'product_image (product_id, image, sort_order) VALUES(?,?,?)');
        if ($insertSIt->execute(array($productId, $newImagePath, 1))) {
            $log .= "Successfully moved main image <br />\n";
        }
    }

    // Update the product_image table for this product and set the sort_order to -1 - because we've inserted the main image
    $select_images = $DB->query('SELECT * FROM ' . DB_PREFIX . 'product_image WHERE product_id = ' . $productId . ' AND image != "' . $newImagePath  . '" ');
    $sort_order = 1;
    foreach ($select_images->fetchAll() as $image_row) {
        $sort_order += 1;
        $update_image = $DB->prepare('UPDATE ' . DB_PREFIX . 'product_image SET sort_order = ? WHERE product_image_id = ?');
        $update_image->execute(array($sort_order, $image_row['product_image_id']));
    }
}

$log .= "And finally create the thumbnails in the jQuery File Upload style ...<br />";
// Get the file references from the product_image table
$st = $DB->query('SELECT * FROM ' . DB_PREFIX . 'product_image');

foreach ($st->fetchAll() as $row) {

    $originalImage = $row['image'];
    $options = array(
        'max_width' => 80,
        'max_height' => 80,
        'product_id' => $row['product_id']
    );
    $version = 'thumbnail';

    $status = create_scaled_image($originalImage, $version, $options) ? 'SUCCESS' : 'FAILED';

    $log .= "Thumbnail for $originalImage ... $status <br />\n";

}

// Additional debug info about the system
$log .= '=================================SYSTEM==============================' . "\n";

$log .= print_system_info($image, $image_cache, $image_data, $logs);

// Write results to the logfile
$log_file_name = 'log/install-log-'.time().'.txt';
$log_file_path = __DIR__.'/'.$log_file_name;

$fh = fopen($log_file_path, 'w') or die("can't create log file");
if (-1 == fwrite($fh, $log)) {
    die("cant't write data to log file");
}
fclose($fh);
?>