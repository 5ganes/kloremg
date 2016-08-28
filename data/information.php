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

}
