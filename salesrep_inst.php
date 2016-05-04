<?php

define('SR_VERSION', 140312);

// Configuration
require_once('config.php');

// Install 
if (!defined('DIR_APPLICATION')) {
	header('Location: ../install/index.php');
	exit;
}

// Startup
require_once(DIR_SYSTEM . 'startup.php');

// Application Classes
require_once(DIR_SYSTEM . 'library/currency.php');
require_once(DIR_SYSTEM . 'library/user.php');
require_once(DIR_SYSTEM . 'library/weight.php');
require_once(DIR_SYSTEM . 'library/length.php');

// Registry
$registry = new Registry();

// Loader
$loader = new Loader($registry);
$registry->set('load', $loader);

// Config
$config = new Config();
$registry->set('config', $config);

// Database
$db = new DB(DB_DRIVER, DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE);


$db->query("CREATE TABLE IF NOT EXISTS " . DB_PREFIX . "salesrep (
  `salesrep_id` int(11) AUTO_INCREMENT,
  `store_id` int(11) NOT NULL DEFAULT '0',
  `name` varchar(32) COLLATE utf8_bin NOT NULL DEFAULT '',
  `email` varchar(96) COLLATE utf8_bin NOT NULL DEFAULT '',
  `username` varchar(20) COLLATE utf8_bin NOT NULL DEFAULT '',  
  `password` varchar(32) COLLATE utf8_bin NOT NULL DEFAULT '',
  `telephone` varchar(32) COLLATE utf8_bin NOT NULL DEFAULT '',  
  `fax` varchar(32) COLLATE utf8_bin NOT NULL DEFAULT '',
  `area` varchar(32) COLLATE utf8_bin NOT NULL DEFAULT '',
  `address` varchar(128) NOT NULL DEFAULT '',
  `geo_zone_id` int(11) NOT NULL,
  `code` varchar(64) COLLATE utf8_bin NOT NULL,
  `commission` decimal(4,2) NOT NULL DEFAULT '0.00',
  `tax` varchar(64) COLLATE utf8_bin NOT NULL,
  `status` int(1) NOT NULL,
  `public` int(1) NOT NULL,
  `alert` int(1) NOT NULL, 
  `date_added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `additional_emails` varchar(128) NOT NULL DEFAULT '',  
  PRIMARY KEY (`salesrep_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin ;");
	
$db->query("INSERT INTO " . DB_PREFIX . "salesrep (
`salesrep_id` ,
`store_id` ,
`name` ,
`email` ,
`username` ,
`password` ,
`telephone` ,
`fax`,
`area`,
`address`,
`geo_zone_id`,
`code`,
`commission`,
`tax`,
`status`,
`public`,
`alert`,
`date_added`,
`additional_emails`
)
VALUES (
'0' , '0', '--- None ---', '', '', '', '', '', '', '', '', '', '', '', '1', '1', '0', '0000-00-00 00:00:00',''
);
");

$db->query("UPDATE " .DB_PREFIX . "salesrep SET  `salesrep_id` = '0' WHERE " . DB_PREFIX . "salesrep.`salesrep_id` = 1;");

$db->query("INSERT INTO " . DB_PREFIX . "user_group (`user_group_id`, `name`, `permission`) VALUES
('', 'Sales Representatives', 'a:2:{s:6:''access'';a:7:{i:0;s:21:''report/customer_order'';i:1;s:12:''sale/contact'';i:2;s:11:''sale/coupon'';i:3;s:13:''sale/customer'';i:4;s:19:''sale/customer_group'';i:5;s:10:''sale/order'';i:6;s:13:''sale/salesrep'';}s:6:''modify'';a:4:{i:0;s:12:''sale/contact'';i:1;s:13:''sale/customer'';i:2;s:10:''sale/order'';i:3;s:13:''sale/salesrep'';}}');");


try {
	$_hasc = false;
	$res = $db->query("show columns from " . DB_PREFIX . "customer");
	foreach($res->rows as $_r) {
		if($_r['Field'] == 'salesrep_id') {
			$_hasc = true;
			break;
		}		
	}
	if(!$_hasc) $db->query("alter table " . DB_PREFIX . "customer ADD  `salesrep_id` INT( 11 ) NOT NULL DEFAULT  '0';");
	
        $_hasc = false;
	$res = $db->query("show columns from " . DB_PREFIX . "order");
	foreach($res->rows as $_r) {
		if($_r['Field'] == 'salesrep_id') {
			$_hasc = true;
			break;
		}		
	}
        if(!$_hasc) $db->query("alter table " . DB_PREFIX . "order ADD  `salesrep_id` INT( 11 ) NOT NULL DEFAULT  '0';");
        
} catch(Exception $_exc) {
	$res = array();
}

die('Done!');
