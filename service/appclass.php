<?php
class App
{
	function saveFarmerInfo($device_id,$registration_id,$district_id,$crops_id,$contacts)
	{
		global $conn;
		//$d = cleanQuery($device_id);
		
		$district_id = cleanQuery($district_id);
		$registration_id = cleanQuery($registration_id);
		$crops_id = cleanQuery($crops_id);
		$contacts = cleanQuery($contacts);
		$dup=mysql_query("SELECT count(device_id) FROM `farmer` WHERE device_id='$device_id'"); $dupGet=mysql_fetch_array($dup);
		if($dupGet['count(device_id)']==1)
		{
			//echo "update";
			$sql = "update farmer set registration_id='$registration_id', district_id='$district_id', crops_id='$crops_id', contacts='$contacts' where device_id='$device_id'";
		}
		else
		{
			//echo "insert";
			$sql = "INSERT INTO farmer SET device_id='$device_id', registration_id='$registration_id', district_id='$district_id', crops_id='$crops_id', contacts='$contacts', onDate = NOW()";
		}
		mysql_query($sql);
		return true;
		//return $conn->insertId();
	}
	
	function saveQuestion($name,$phone,$email,$question,$deviceId,$infoId)
	{
		global $conn;
		$name = cleanQuery($name);
		$phone = cleanQuery($phone);
		$email = cleanQuery($email);
		$question = cleanQuery($question);
		$deviceId = cleanQuery($deviceId);
		$infoId = cleanQuery($infoId);
		
		$sql = "INSERT INTO questions SET name='$name', phone='$phone', email='$email', question='$question', deviceId='$deviceId', infoId='$infoId', publish='No', onDate = NOW()";
          //return $sql; exit();
		if(mysql_query($sql))
		return true;
                else return false;		
//return $conn->insertId();
	}

}
?>

