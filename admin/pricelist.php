<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?
	require_once("../data/conn1.php");
	require_once("../data/sqlinjection.php");
	$conn = new Dbconn();

	$d=date("d");$m=date("m");$y=date("Y"); //echo $d."/".$m."/".$y."<br>";
	//to nepali
	/*$d=$d+17; if($d>30){ $d=$d-30; $ma=1;}
	if(!empty($ma)){ $m++;}
	$m=$m+8;
	if($m>12){ $m=$m-12; $ya=1;}
	if(!empty($ya)){ $y++;}
	$y=$y+56;*/
	//echo $d."/".$m."/".$y; die();
	$onDate=date("Y/m/d"); //echo $onDate; die();
?>
<?
	$thok = file_get_contents("https://api.import.io/store/connector/9bf9078b-d253-41ab-b7ba-5dd6f2542813/_query?input=webpage/url:http%3A%2F%2Fkalimatimarket.com.np/home/wpricelist%2F&&_apikey=8854a1dcad8146379c85b388bb44739e800f8a64d43641682ed34212ea0028be9d664b81efb58b3f95786bd481b0beceffa71bc060d93d59ec7c763ff73af84a202006687ed1ba8b1ad04073317c9669");
	$khudra = file_get_contents("https://api.import.io/store/connector/020744dd-3216-4426-b046-49b2ca2a367f/_query?input=webpage/url:http%3A%2F%2Fkalimatimarket.com.np/home/rpricelist%2F&&_apikey=8854a1dcad8146379c85b388bb44739e800f8a64d43641682ed34212ea0028be9d664b81efb58b3f95786bd481b0beceffa71bc060d93d59ec7c763ff73af84a202006687ed1ba8b1ad04073317c9669");
	
	$thok = json_decode($thok, true);
	$khudra = json_decode($khudra, true); 
	
	$thok=$thok["results"];
	$khudra=$khudra["results"];
	
	for($i=0;$i<count($thok);$i++)
	{
		$name=$thok[$i]["value_1"]; $thokAverage=$thok[$i]["value_5"]; $khudraAverage=$khudra[$i]["value_5"]; $unit=$thok[$i]["value_2"];
		$sql=mysql_query("insert into pricelist set name='$name', unit='$unit', thokAverage='$thokAverage', khudraAverage='$khudraAverage', onDate='$onDate'");
		//echo $list[$i]["value_1"]; die();
	}
?>