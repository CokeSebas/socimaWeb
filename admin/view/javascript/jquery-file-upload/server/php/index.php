<?php
/*
 * jQuery File Upload Plugin PHP Example 5.14
 * https://github.com/blueimp/jQuery-File-Upload
 *
 * Copyright 2010, Sebastian Tschan
 * https://blueimp.net
 *
 * Licensed under the MIT license:
 * http://www.opensource.org/licenses/MIT
 */
//error_reporting(E_ALL | E_STRICT);
if( !defined( __DIR__ ) )define( __DIR__, dirname(__FILE__) );
require __DIR__.'/../../../../../../config.php';
require('UploadHandler.php');

$product_id = $_GET['product_id'];

$upload_handler = new UploadHandler(null, true, null, $product_id);
