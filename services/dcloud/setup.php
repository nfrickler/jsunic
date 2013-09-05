<?php

//DEBUG
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Load configuration
$config = array(
    "keytype" => "int",
    "host" => "localhost",
    "user" => "",
    "password" => "",
    "database" => "dcloud",
    "table" => "dcloud_data"
);
include "config.php";

// Start db
include_once 'Mysql.class.php';
$Db = new Mysql(
    $config['host'],
    $config['user'],
    $config['password'],
    $config['database']
);

// Get type
$type = "int(11)";
switch ($config['keytype']) {
case "int":
    $type = "int(11)";
    break;
case "varchar":
    $type = "varchar(200)";
    break;
default:
    echo "Error: Invalid keytype!";
    exit;
}

// Create table in database
$sql = "CREATE TABLE IF NOT EXISTS `".$config['table']."` (
  `id` $type  NOT NULL,
  `data` text NOT NULL,
  `timestamp` timestamp NOT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM;";
if (!$Db->doQuery($sql)) {
    echo "Database error: ".$Db->getError()."\n";
    exit;
}

echo "Setup ready.\n";

?>
