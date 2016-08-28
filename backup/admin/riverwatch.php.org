<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?
	require_once("../data/conn1.php");
	require_once("../data/sqlinjection.php");
	$conn = new Dbconn();
	mysqli_query($GLOBALS["___mysqli_ston"], "delete from riverwatch");
        mysqli_query($GLOBALS["___mysqli_ston"], "ALTER TABLE riverwatch AUTO_INCREMENT = 1");
?>
<?
	$riverwatch = file_get_contents("https://api.import.io/store/connector/2af3875d-883b-4700-b65a-b9baf0f52d1e/_query?input=webpage/url:http%3A%2F%2Fhydrology.gov.np%2Fnew%2Fbull3%2Findex.php%2Fhydrology%2Fscreen_display&&_apikey=8854a1dcad8146379c85b388bb44739e800f8a64d43641682ed34212ea0028be9d664b81efb58b3f95786bd481b0beceffa71bc060d93d59ec7c763ff73af84a202006687ed1ba8b1ad04073317c9669");
	
	$riverwatch = json_decode($riverwatch, true);
	
	$riverwatch=$riverwatch["results"]; //print_r($riverwatch); die();
	
	for($i=0;$i<count($riverwatch);$i++)
	{
		$stationIndex=$riverwatch[$i]["stationindex_number"]; //echo $stationIndex; die();
		$stationName=$riverwatch[$i]["stationname_value_1"];
		$dateTime=$riverwatch[$i]["stationname_value_2"];
		$waterLevel=$riverwatch[$i]["waterlevelm_number"];
		$flow=$riverwatch[$i]["flowm3sec_value"];
		$warningLevel=$riverwatch[$i]["warninglevel_value"];
		$dangerLevel=$riverwatch[$i]["dangerlevelm_value"];
		$trend=$riverwatch[$i]["trend_value"];
		$status=$riverwatch[$i]["status_value"];
		
		$sql=mysqli_query($GLOBALS["___mysqli_ston"], "insert into riverwatch set stationIndex='$stationIndex', stationName='$stationName', dateTime='$dateTime', 
		waterLevel='$waterLevel', flow='$flow', warningLevel='$warningLevel', dangerLevel='$dangerLevel', trend='$trend', status='$status'");
		//echo $list[$i]["value_1"]; die();
	}
?>