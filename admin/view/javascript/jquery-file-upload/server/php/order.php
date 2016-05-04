<?php
//error_reporting(E_ALL | E_STRICT);
if( !defined( __DIR__ ) )define( __DIR__, dirname(__FILE__) );
require __DIR__.'/../../../../../../config.php';

$product_id = $_POST['product_id'];
$sort_order = $_POST['sort_order'] + 1;
$image = $image = 'data/product-' . $product_id . '/' . $_POST['file_name'];

$add_to_db = query("UPDATE `" . DB_PREFIX . "product_image` SET sort_order = $sort_order WHERE product_id = $product_id AND image = '$image'") or die(mysql_error());  

# Don't forget to update product table with the leading image
if ($sort_order == 1) {
    $add_to_db = query("UPDATE `" . DB_PREFIX . "product` SET image = '$image' WHERE product_id = $product_id") or die(mysql_error());   
}

return $add_to_db; 


 function query($query) {    
        $database = DB_DATABASE;  
        $host = DB_HOSTNAME;  
        $username = DB_USERNAME;  
        $password = DB_PASSWORD;  
        $link = mysqli_connect($host,$username,$password);  
        if (!$link) {  
            die(mysqli_error($link));  
        }
        $db_selected = mysqli_select_db($link, $database);  
        if (!$db_selected) {  
            die(mysql_error($link));  
        }  
        $result = mysqli_query($link, $query);  
        mysqli_close($link);  
        return $result;  
} 



