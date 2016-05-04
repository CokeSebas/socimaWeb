<?php

require_once 'functions.php';

$file_name = $_GET['file_name'];
$file_path = __DIR__.'/'.$file_name;

download_file($file_path);