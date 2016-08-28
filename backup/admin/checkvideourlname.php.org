<?php
require_once("../data/conn.php");
require_once("../data/disease.php");

$conn 					= new Dbconn();		
$video					= new Video();

$id = $_GET['id'];
$urlname = $_GET['value'];

if($video -> isUnique($id, $urlname))
	echo "<span style='color:#0000FF'>Alias Name available</span>";
else
	echo "<span style='color:#FF0000'>Alias Name already exists</a>";
?>