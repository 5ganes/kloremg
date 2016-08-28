<?
	//header("Content-Type: application/json");
	//header('Content-type: text/html; charset=UTF-8');
	//mysql_query("SET NAMES 'utf8'");
	//echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
	header('Access-Control-Allow-Origin: *');
require_once("../data/conn1.php");
$conn = new Dbconn();		

//$crop=$groups->getByLinkType("Disease");
$qtype=$_GET['q']; //$id=$_GET['id'];
if($qtype=="district")
{
        if(isset($_GET['c'])){
		$c=$_GET['c'];
		$sql="select id,name,code,ecozone,devregion from district where id>'$c' and publish='Yes' order by weight";
	}
	else{
	    $sql="select id,name,code,ecozone,devregion from district order by weight";
        }
}
else if($qtype=="crop")
{
	if(isset($_GET['c'])){
		$c=$_GET['c'];
		$sql="select id,name,categoryId,code,contents,publish,image,weight from crop where id>'$c' and publish='Yes'";
	}
	else{
		$sql="select id,name,categoryId,code,contents,publish,image,weight from crop where publish='Yes' order by weight";
	}
}
else if($qtype=="cropcategory")
{
	if(isset($_GET['c'])){
		$c=$_GET['c'];
		$sql="select id,name,weight from groups where linkType='Activity' and id>'$c' order by weight";
	}
	else
	{
		$sql="select id,name,weight from groups where linkType='Activity' order by weight";
	}
}
else if($qtype=="user")
{
	if(isset($_GET['c'])){
		$c=$_GET['c'];
		$sql="select id,name,email,phone,website,address,memberType,orgHead,orgHeadPhone,orgInfo,publish,weight from usergroups where id>'$c' and publish='Yes' order by weight";
	}
	else
	{
		$sql="select id,name,email,phone,website,address,memberType,orgHead,orgHeadPhone,orgInfo,publish,weight from usergroups where publish='Yes' order by weight";	
	}
}
else if($qtype=="info")
{
	if(isset($_GET['c'])){
		$c=$_GET['c'];
		$sql="select id,name,contents,districtIds,cropId,userId,onDate from information where id>'$c' and publish='Yes' order by id DESC";	
		//echo $sql;
	}
	else{
		$sql="select id,name,contents,districtIds,cropId,userId,onDate from information where publish='Yes' order by id DESC";	
		//echo $sql;
	}
}
else if($qtype=="cropvariety")
{
	if(isset($_GET['c'])){
		$c=$_GET['c'];
		$sql="select id,name,cropId,productionTime,recommendedArea,recommendedDate,productivity,weight from cropvariety where id>'$c' and publish='Yes' order by weight";
	}
	else
	{
		$sql="select id,name,cropId,productionTime,recommendedArea,recommendedDate,productivity,weight from cropvariety where publish='Yes' order by weight";	
	}
}
else if($qtype=="diarycategory")
{
	if(isset($_GET['c'])){
		$c=$_GET['c'];
		$sql="select id,name, weight from diarycategories where id>'$c' and publish='Yes' order by weight";
	}
	else
	{
		$sql="select id,name, weight from diarycategories where publish='Yes' order by weight";	
	}
}
else if($qtype=="diary")
{
	if(isset($_GET['c'])){
		$c=$_GET['c'];
		$sql="select id,name,categoryId,phone,fax,email,website,weight from diary where id>'$c' and publish='Yes' order by weight";
	}
	else
	{
		$sql="select id,name,categoryId,phone,fax,email,website,weight from diary where publish='Yes' order by weight";	
	}
}
//question web service
else if($qtype=="question")
{
	if(!isset($_GET['c']))
	{
		//echo "fuck";
		$sql="select id,name,phone,email,question,deviceId,infoId,onDate from questions where publish='Yes' order by id DESC";	
	}
	else
	{
		//echo "fuck";
		$infoId=$_GET['c']; //echo $infoId;
		$sql="select questions.id as questionId,questions.name as questionName,questions.phone as phone,questions.email as email,questions.question as question,questions.deviceId as deviceId,questions.onDate as onDate,reply.answer as answer from questions
		inner join reply on questions.id=reply.questionId 
		where questions.id='$infoId' and questions.publish='Yes'"; //echo $sql; die();
	}
}
else if($qtype=="reply")
{
	if(!isset($_GET['qid']))
	{
		$sql="select id,answer,questionId,providerId,onDate from reply where publish='Yes' order by id DESC";	
	}
	else
	{
		$questionId=$_GET['qid'];
		$sql="select id,answer,questionId,providerId,onDate from reply where questionId='$questionId' and publish='Yes'";
	}
}
else if($qtype=="information" and isset($_GET['c']))
{
	$id=$_GET['c']; //echo $id;
	$sql="select questions.name as name,questions.phone as phone,questions.email as email,questions.question as question,questions.deviceId as deviceId,questions.infoId as infoId,reply.answer as answer,reply.questionId as questionId,reply.providerId as providerId from questions,reply where questions.infoId=$id and questions.id=reply.questionId and questions.publish='Yes' and reply.publish='Yes'";
	//echo $sql; die();
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