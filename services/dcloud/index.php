<?php

//DEBUG
//error_reporting(E_ALL);
//ini_set('display_errors', 1);
$DEBUG = true;

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

// Get id
$id = (isset($_GET['id'])) ? $_GET['id'] : 0;
switch ($config['keytype']) {
case "int":
    if (!is_numeric($id))
	error("Invalid id (int)!");
    break;
case "varchar":
    if (preg_match('#[^a-zA-Z0-9@\.]#', $id) != 0)
	error("Invalid id (varchar)!");
    break;
default:
    error("Invalid id (unknown)!");
}

// Get data
$data = (isset($_GET['data'])) ? $_GET['data'] : 0;
if (preg_match('°[^a-zA-Z0-9=#%]°', $data) != 0)
    error("Invalid data!");

// Update database
if ($id) {
    if ($data) {
	// Update
	$sql = "INSERT INTO ".$config['table']."
	    SET id = '$id', data = '$data'
	    ON DUPLICATE KEY UPDATE data = '$data'
	;";
	if (!$Db->doUpdate($sql)) {
	    error("Update failed!".
		($DEBUG ? "(".$Db->getError().")" : ""));
	}
	send("Updated");
    } elseif ($data === 0) {
	// Fetch
	$sql = "SELECT data
	    FROM ".$config['table']."
	    WHERE id = '".$id."'
	;";
	$result = $Db->doSelect($sql);
	if (!$result)
	    error("Fetch failed!".
		($DEBUG ? "(".$Db->getError().")" : ""));
	send($result[0]['data']);
    } else {
	// Delete
	$sql = "DELETE FROM ".$config['table']."
	    WHERE id = '".$id."'
	;";
	if (!$Db->doDelete($sql))
	    error("Delete failed!".
		($DEBUG ? "(".$Db->getError().")" : ""));
	send("Deleted");
    }
} else {
    if ($data) {
	// Insert
	$sql = "INSERT INTO ".$config['table']."
	    SET data = '".$data."'
	;";
	if (!$Db->doUpdate($sql))
	    error("Insert failed!".
		($DEBUG ? "(".$Db->getError().")" : ""));
	send($Db->lastId());
    } else {
	error("Missing data!");
    }
}

/**
 * Send error to client
 */
function error ($msg) {
    echo "<error>".$msg."</error>";
    exit;
}

/**
 * Send data to client
 */
function send ($data) {
    echo "<root><data>".$data."</data></root>";
    exit;
}
?>
