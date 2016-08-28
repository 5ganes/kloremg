<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?
	require_once("../data/conn1.php");
	require_once("../data/sqlinjection.php");
	$conn = new Dbconn();
	mysqli_query($GLOBALS["___mysqli_ston"], "delete from rainfall");
        mysqli_query($GLOBALS["___mysqli_ston"], "ALTER TABLE rainfall AUTO_INCREMENT = 1");
?>
<?
	$rainfall = file_get_contents("https://api.import.io/store/connector/bf24d9db-d0bd-49a0-a6a9-6782b0010465/_query?input=webpage/url:http%3A%2F%2Fwww.hydrology.gov.np%2Fnew%2Fbull3%2Findex.php%2Fhydrology%2Frainfall_watch%2Fget_table&&_apikey=8854a1dcad8146379c85b388bb44739e800f8a64d43641682ed34212ea0028be9d664b81efb58b3f95786bd481b0beceffa71bc060d93d59ec7c763ff73af84a202006687ed1ba8b1ad04073317c9669");
	
	$rainfall = json_decode($rainfall, true);
	
	$rainfall=$rainfall["results"];
	
	for($i=0;$i<count($rainfall);$i++)
	{
		$basinName=$rainfall[$i]["value_1"];
		$stationIndex=$rainfall[$i]["number_2/_source"];
		$stationName=$rainfall[$i]["value_2"];
		$rainfall1hr=$rainfall[$i]["table_value_1"];
		$rainfall3hr=$rainfall[$i]["table_value_2"];
		$rainfall6hr=$rainfall[$i]["table_value_3"];
		$rainfall12hr=$rainfall[$i]["table_value_4"];
		$rainfall24hr=$rainfall[$i]["table_number/_source"];
		$status=$rainfall[$i]["belowwarning_label"];
		
		$sql=mysqli_query($GLOBALS["___mysqli_ston"], "insert into rainfall set basinName='$basinName', stationIndex='$stationIndex', stationName='$stationName', 
		rainfall1hr='$rainfall1hr', rainfall3hr='$rainfall3hr', rainfall6hr='$rainfall6hr', rainfall12hr='$rainfall12hr', rainfall24hr='$rainfall24hr', 
		status='$status'");
		//echo $list[$i]["value_1"]; die();
	}
?>