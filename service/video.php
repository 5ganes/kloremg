<?
header('Access-Control-Allow-Origin: *');
require_once("../data/conn1.php");
$conn = new Dbconn();		

$qtype=$_GET['q'];
if($qtype=="videos" or $qtype == 'videos-with-cropid-as-objects'){
	$sql="select 
			crop.id as cropId, crop.name as cropName, video.id as videoId,video.name as videoTitle,video.url as videoUrl 
		  from 
			crop 
		  left join 
			video on crop.id = video.cropId
		  where 
			video.publish='Yes'
		  order by 
		  	crop.id";
}

$sql=mysql_query($sql);
$rows = array();
while($r = mysql_fetch_array($sql, MYSQL_ASSOC)) {
	if($qtype == 'videos'){
		$rows[] = $r;
	}
	else if($qtype == 'videos-with-cropid-as-objects'){
		$cropId = $r['cropId'];
		unset($r['cropId']);
		$rows[$cropId][] = $r;
	}
}
print json_encode($rows);
die();
?>