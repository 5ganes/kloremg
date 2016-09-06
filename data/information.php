<?php
class Information 
{
	function save($id, $name, $contents, $districtIds, $cropId, $userId, $publish)
	{
		global $conn;
		
		$id = cleanQuery($id);
		$name = cleanQuery($name);
		$contents = cleanQuery($contents);
		$districtIds = cleanQuery($districtIds);
		$cropId = cleanQuery($cropId);
		$userId = cleanQuery($userId);
		$publish = cleanQuery($publish);
		
		$sql="INSERT INTO information 
					SET
						name = '$name',
						contents = '$contents',
						districtIds = '$districtIds',
						cropId = '$cropId',
						userId = '$userId',
						publish = '$publish',
						onDate = NOW()";
		//echo $sql;
		$result = $conn -> exec($sql);
		if($id > 0)
			return $conn -> affRows();
		return $conn ->insertId();
	}
	
	function updateInformation($id,$contents)
	{
		global $conn;
		$id = cleanQuery($id);
		$contents = cleanQuery($contents);
		$sql="UPDATE information 
					SET
						contents = '$contents'
					WHERE
						id = '$id'";
		$conn->exec($sql);
		$iid=$conn->insertId(); //echo $iid; die();
		
		mysql_query("delete from flip where editId='$id'");
		$f=mysql_query("insert into flip set tableName='information', type='edit', editId='$id', addId=''");
		return $iid;	
	}
	
	function getAll()		
	{
		global $conn;
		
		$sql = "SELECT * FROM information ORDER BY id DESC, onDate DESC";

		$result = $conn->exec($sql);
		return $result;
	}
	
	function updateStatus($id)
	{
		global $conn;
		
		$row = $this -> getById($id);
		if($row['publish'] == "Yes")
			$stat = "No";
		else
			$stat = "Yes";

		$sql="UPDATE information SET `publish` = '$stat' WHERE id = '$id'";

		$result = $conn->exec($sql);
		return $conn -> affRows();
	}
	
	function getById($id)
	{
		global $conn;
		
		$sql = "SELECT * FROM information WHERE id = '$id'";

		$result = $conn->exec($sql);
		return $conn -> fetchArray($result);
	}
		
	function delete($id)
	{
		global $conn;
		
		$sql = "DELETE FROM information WHERE id = '$id'";
		
		$result = $conn -> exec($sql);
		return $conn -> affRows();
	}

	function sendEmailToUser($infoId){
		global $conn;

		$userEmail=$conn->fetchArray($conn->exec("select email
		from information inner join usergroups on information.userId=usergroups.id
		where information.id='$infoId'"));

		$msg='Your information has been approved. Now farmers can view it in Krishighar app. Thank you.';
      	$headers  = "";
      	$headers .= "MIME-Version: 1.0 \r\n";
      	$headers .= "Content-type: text/html; charset=iso-8859-1 \r\n";
      	$headers .= "X-Priority: 1\r\n";
      	$headers .= "From: "."info@krishighar.com";

	    //$to="krishighar1@gmail.com";
	    $subject = "New Information Posted :";
	    //echo $userEmail['email']; die();
	    mail($userEmail['email'], $subject, $msg, $headers);
	}

	function sendEmailToFarmer($questionId,$providerId){
		global $conn;

		$farmerEmailName=$conn->exec("
			select name as emailname
				from usergroups where id='$providerId'
			union
			select email as emailname
				from questions where id='$questionId'
		");
		$provider=$conn->fetchArray($farmerEmailName);
		$msg='Your question has been replied by '.$provider['emailname'].'. Please check your krishighar app. Thank you.';
      	$headers  = "";
      	$headers .= "MIME-Version: 1.0 \r\n";
      	$headers .= "Content-type: text/html; charset=iso-8859-1 \r\n";
      	$headers .= "X-Priority: 1\r\n";
      	$headers .= "From: "."info@krishighar.com";

	    //$to="krishighar1@gmail.com";
	    $subject = "Reply of question from provider :";
	    //echo $userEmail['email']; die();
	    $provider=$conn->fetchArray($farmerEmailName);
	    //echo $provider['emailname']; die();
	    mail($provider['emailname'], $subject, $msg, $headers);
	}

	function sendNotification($info_id){
		// API access key from Google API's Console
		define( 'API_ACCESS_KEY', 'AIzaSyBvG5kDXkFX6uzMpyJA4yaQVZjZltaYNi4' ); 

		$sql=mysql_fetch_array(mysql_query("select count(id) as maxx from farmer")); $count=$sql['maxx'];
		$limit=1000; $i=1;
		while($count>0)
		{
			$lower=($i-1)*$limit;
			$sql=mysql_query("select registration_id from farmer limit $lower,$limit"); $i++; $count-=$limit;
			
			$registrationIds=array();
			$j=0;
			while($rId=mysql_fetch_array($sql))
			{
				$registrationIds[$j]=$rId['registration_id']; $j++;
			}
			//$registrationIds = array( $sql['registrationId'] );
			//echo print_r($registrationIds); die();
			//registration Id: APA91bHc0yu1JMO74RzSm6IrccQ0Rd-1Ndb90VHU2VZFlLvCFEPZSi1Nk8k8OB-NZ5KLqhdOHkBS3hMVsWurdZg3ui7TIJQ84y7wGvnIMWYBgiFhbbt-NIo
			
			// prep the bundle
			$info=mysql_fetch_array(mysql_query("select name from information where id='$info_id'"));
			// echo $info['name']; die();
			$msg = array
			(
				'message' 	=> $info['name'],
				'title'		=> '',
				'subtitle'	=> 'Subtitle',
				'tickerText'	=> 'Ticker Text',
				'vibrate'	=> 1,
				'sound'		=> 1,
				'largeIcon'	=> 'large_icon',
				'smallIcon'	=> 'small_icon'
			);
			
			$fields = array
			(
				'registration_ids' 	=> $registrationIds,
				'data'			=> $msg
			);
			 
			$headers = array
			(
				'Authorization: key=' . API_ACCESS_KEY,
				'Content-Type: application/json'
			);
			 
			$ch = curl_init();
			curl_setopt( $ch,CURLOPT_URL, 'https://android.googleapis.com/gcm/send' );
			curl_setopt( $ch,CURLOPT_POST, true );
			curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
			curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
			curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
			curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
			$result = curl_exec($ch );
			curl_close( $ch );
			
			// echo $result;
			//echo "<br><br><br>";
		}
	}

}
