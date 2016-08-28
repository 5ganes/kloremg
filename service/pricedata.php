<?
header('Access-Control-Allow-Origin: *');
require_once("../data/conn1.php");
$conn = new Dbconn();		

$qtype=$_GET['q']; //echo $qtype; die();
if($qtype=="pricedata")
{
	//$onDate="2016-03-19";
	$sql="select id,name,unit,thokAverage,khudraAverage,onDate from pricelist where onDate in(select max(onDate) from pricelist) order by id";
}
else if($qtype=="riverwatch")
{
	$sql="select id,stationIndex,stationName,dateTime,waterLevel,flow,warningLevel,dangerLevel,trend,status from riverwatch order by id";
}
else if($qtype=="rainfall")
{
	$sql="select id,basinName,stationIndex,stationName,rainfall1hr,rainfall3hr,rainfall6hr,rainfall12hr,rainfall24hr,status from rainfall order by id";
}
else if($qtype=="insurance")
{
	if(isset($_GET['c'])){
		$c=$_GET['c']; $sql="select id,bimak,district,contactPerson,contactPhone,contactOffice,weight from insurance where id>'$c' and publish='Yes' order by weight"; //echo $sql; die();
	}
	else{
		$sql="select id,bimak,district,contactPerson,contactPhone,contactOffice,weight from insurance where publish='Yes' order by weight";
	}
}
else if($qtype=="agrinews")
{
	if(isset($_GET['c'])){
		$c=$_GET['c']; $sql="select id,name,description,newsDate,newsSource,weight from agrinews where id>'$c' and publish='Yes' order by weight"; //echo $sql; die();
	}
	else{
		$sql="select id,name,description,newsDate,newsSource,weight from agrinews where publish='Yes' order by weight";
	}
}
else if($qtype=="successstories")
{
	if(isset($_GET['c'])){
		$c=$_GET['c']; $sql="select id,name,description,weight from successstories where id>'$c' and publish='Yes' order by weight"; //echo $sql; die();
	}
	else{
		$sql="select id,name,description,weight from successstories where publish='Yes' order by weight";
	}
}
else if($qtype=="agrievents")
{
	if(isset($_GET['c'])){
		$c=$_GET['c']; $sql="select id,name,onDate,address,description,weight from agrievents where id>'$c' and publish='Yes' order by weight"; //echo $sql; die();
	}
	else{
		$sql="select id,name,onDate,address,description,weight from agrievents where publish='Yes' order by weight";
	}
}

//echo $sql; die();
$sql=mysql_query($sql);
//$row=mysql_fetch_row($sql);
//print json_encode($row);
$rows = array();
while($r = mysql_fetch_array($sql, MYSQL_ASSOC)) {
	//$rows['body'][] = $r;
	$rows[] = $r;
}
print json_encode($rows);

//html tags truncate
//echo $data;
//new
/*while($obj = mysql_fetch_object($rs)) {
$arr[] = $obj;
}
echo '{"members":'.json_encode($arr).'}';*/
die();
?>