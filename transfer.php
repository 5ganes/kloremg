<?php
	//mysql_query("SET NAMES 'utf8'");
	header('Content-type: text/html; charset=UTF-8');
	include("clientobjects.php");
	//$linkType=$_GET['linkType'];
	$sql = "SELECT * FROM `information` order by id";
	$result=mysql_query($sql);
	while($row = $conn -> fetchArray($result))
	{
		extract($row);
			$in="insert into info set name='$name', contents='$contents', districtIds='$districtIds', cropId='$cropId', userId='$userId', publish='$publish'";
		mysql_query($in);
	}
?>
