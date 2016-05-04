<?php
/**
 * Created by PhpStorm.
 * User: Alvaro
 * Date: 22/09/14
 * Time: 21:50
 */


session_start();
session_destroy();

header('location: index.php');
