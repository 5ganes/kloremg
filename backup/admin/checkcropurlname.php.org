<?php
require_once("../data/conn.php");
require_once("../data/crop.php");

$conn 					= new Dbconn();		
$crop					= new Crop();

$id = $_GET['id'];
$urlname = $_GET['value'];

if($crop -> isUnique($id, $urlname))
	echo "<span style='color:#0000FF'>Alias Name available</span>";
else
	echo "<span style='color:#FF0000'>Alias Name already exists</a>";
?>