<?php
class Users
{
 function validate($uname,$pswd)
 {
 	global $conn;
	
  $sql = "SELECT * FROM users u, usergroups ug WHERE u.userGroupId = ug.id AND md5(u.username) = '". md5(cleanQuery($uname)). "' AND md5(u.password) = '". md5(cleanQuery($pswd)) ."' AND u.status = 'A'";
  //echo $sql;
  $result = $conn -> exec($sql);
  $numRows = $conn -> numRows($result);
  if($numRows)
  {
   $row = $conn -> fetchArray($result);
   $_SESSION['sessUserId'] = $row['id'];
   $_SESSION['sessUsername'] = $row['username'];
   $_SESSION['sessLastLogin'] = $row['lastLogin'];

   return true;
  }
  else
  {
   return false;
  }
 }
 
 function validateUser($uname,$pswd)
 {
 	global $conn;
	
  $sql = "SELECT * FROM users WHERE username='admin' AND password='$pswd'";
  //echo $sql;
  $result = $conn -> exec($sql);
  $numRows = $conn -> numRows($result);
  if($numRows)
  {
   $row = $conn -> fetchArray($result);
   $_SESSION['sessUserId'] = $row['id'];
   $_SESSION['sessUsername'] = $row['username'];
   $_SESSION['sessLastLogin'] = $row['lastLogin'];

   return true;
  }
  else
  {
   return false;
  }
 }

 function updateLastLogin($id)
 {
 	global $conn;
	
  $sql = "UPDATE users SET lastLogin = NOW() WHERE id = '$id'";
  $result = $conn -> exec($sql);
 }

 function updateLoginTimes($id)
 {
 	global $conn;
	
  $sql = "UPDATE users SET loginTimes = (loginTimes + 1) WHERE id = '$id'";
  $result = $conn -> exec($sql);
 }

 function validatePassword($id,$pswd)
 {
 	global $conn;
	
  $sql = "SELECT COUNT(*) cnt FROM users WHERE id = '$id' AND password = '$pswd'";
  //echo $sql;
  $result = $conn -> exec($sql);
  $row = $conn -> fetchArray($result);
  if($row['cnt'] > 0)
   return true;
  else
   return false;
 }

 function updatePassword($id,$pswd)
 {
 	global $conn;
	
  $sql = "UPDATE users SET password = '$pswd' WHERE id = '$id'";
  //echo $sql;
  $result = $conn -> exec($sql);
  $affRows = $conn -> affRows();
  if($affRows)
   return true;
  else
   return false;
 }
 
 function getSubLastWeight()
 {
	global $conn;
	$sql = "SElECT max(weight) FROM usergroups";
	$result = $conn->exec($sql);
	$numRows = $conn -> numRows($result);
	if($numRows > 0)
	{
		$row = $conn->fetchArray($result);
		return $row['max(weight)'] + 10;
	}
	else
		return 10;	 
 }
 
 function saveUser($id, $name, $username, $password, $email, $phone, $website, $address, $subscriptionDate, $expiryDate, $renew, $memberType, $orgHead, $orgHeadPhone, $orgInfo, $publish, $weight)
	{
		global $conn;
		$id = cleanQuery($id);
		$name = cleanQuery($name);
		$username = cleanQuery($username);
		$password = cleanQuery($password);
		$email=cleanQuery($email);
		$phone=cleanQuery($phone);
		$website=cleanQuery($website);
		$address=cleanQuery($address);
		$subscriptionDate=cleanQuery($subscriptionDate);
		$expiryDate=cleanQuery($expiryDate);
		$renew=cleanQuery($renew);
		$memberType=cleanQuery($memberType);
		$orgHead=cleanQuery($orgHead);
		$orgHeadPhone=cleanQuery($orgHeadPhone);
		
		$orgInfo=cleanQuery($orgInfo);
		$publish=cleanQuery($publish);
		$weight=cleanQuery($weight);
		if($id > 0)
		{
			$sql = "UPDATE usergroups
						SET
							name = '$name',
							username = '$username',
							email = '$email',
							phone = '$phone',
							website = '$website',
							address = '$address',
							subscriptionDate = '$subscriptionDate',
							expiryDate = '$expiryDate',
							renew = '$renew',
							memberType = '$memberType',
							orgHead = '$orgHead',
							orgHeadPhone = '$orgHeadPhone',
							orgInfo='$orgInfo',
							publish='$publish',
							weight = '$weight'						
						WHERE
							id = '$id'";
			$f="edit";
		}
		else
		{
			$sql = "INSERT INTO usergroups SET name = '$name',username = '$username',password = '$password',email = '$email',phone='$phone',website='$website',address = '$address',subscriptionDate = '$subscriptionDate',expiryDate = '$expiryDate',renew = '$renew',memberType = '$memberType',orgHead = '$orgHead',orgHeadPhone = '$orgHeadPhone',orgInfo='$orgInfo',publish = '$publish',weight = '$weight'";
			$f="add";
		
		}
		$conn->exec($sql);
		//if($id > 0)
		//	return $conn -> affRows();
		$iid=$conn->insertId(); //echo $iid; die();
		if($f=="edit")
		{
			//$editCount=mysql_num_rows(mysql_query("select * from flip where editId='$id'"));
			//if($editCount==0)
			mysql_query("delete from flip where editId='$id'");
			$f=mysql_query("insert into flip set tableName='usergroups', type='edit', editId='$id', addId=''");
		}
		return $iid;
	}
	
	function saveImage($id)
	{
		global $conn;
		global $_FILES;
		
		if ($_FILES['image']['size'] <= 0)
			return;
		
		$id = cleanQuery($id);
		$filename = $_FILES['image']['name'];
		
		/*$ext = end(explode(".", $filename));
		$image = $id . "." . $ext;*/
		$image = $filename;
		
		copy($_FILES['image']['tmp_name'], "../". CMS_GROUPS_DIR . $image);
		
		$sql = "UPDATE usergroups SET image = '$image' WHERE id = '$id'";
		$conn->exec($sql);
	}
	
	function getById($id)
	{
		global $conn;
		$id = cleanQuery($id);
		$sql = "SElECT * FROM usergroups WHERE id = '$id'";
		$result = $conn->exec($sql);
		return $result;
	}
	
	function deleteImage($id)
	{
		global $conn;
		
		$id = cleanQuery($id);
		$result = $this->getById($id);
		$row = $conn->fetchArray($result);
		$image = "../". CMS_GROUPS_DIR . $row['image'];
		
		if (file_exists($image))
			unlink($image);
		
		$sql = "UPDATE usergroups SET image = '' WHERE id = '$id'";
		$conn->exec($sql);
	}
	
	function delete($id)
	{  
		global $conn;
		
		$id = cleanQuery($id);
		
		$result = $this->getById($id);
		$row = $conn->fetchArray($result);
		
		$file = "../" . CMS_GROUPS_DIR . $row['image'];
		
		if (file_exists($file) && !empty($row['image']))
			unlink($file);
		
		$sql = "DELETE FROM usergroups WHERE id = '$id'";
		$conn->exec($sql);
	}
	
	function validateInfoUser($uname,$pswd)
	{
		global $conn;
		
		$sql = "SELECT * FROM usergroups WHERE username='$uname' AND password='$pswd'";
	  	//echo $sql;
	  	$result = $conn -> exec($sql);
	  	$numRows = $conn -> numRows($result);
	  	if($numRows)
	  	{
	   		$row = $conn -> fetchArray($result);
	   		$_SESSION['userId'] = $row['id'];
	   		$_SESSION['userName'] = $row['username'];
	   		//$_SESSION['sessLastLogin'] = $row['lastLogin'];
	
	   		return true;
	  	}
	  	else
	  	{
	   		return false;
	  	}
	 }
	 
	 function validateMgr($uname,$pswd)
	 {
		global $conn;
		
	  	$sql = "SELECT * FROM users WHERE username='$uname' AND password='$pswd'";
	  	//echo $sql;
	  	$result = $conn -> exec($sql);
	  	$numRows = $conn -> numRows($result);
	  	if($numRows)
	  	{
	   		$row = $conn -> fetchArray($result);
	   		$_SESSION['sessMgrId'] = $row['id'];
	   		$_SESSION['sessMgrname'] = $row['username'];
	   		//$_SESSION['sessLastLogin'] = $row['lastLogin'];
	   		return true;
	  	}
	  	else
	  	{
	   		return false;
	  	}
	 }
	 
	 function validateMgrPassword($id,$pswd)
	 {
		global $conn;
		
	  	$sql = "SELECT COUNT(*) cnt FROM users WHERE id = '$id' AND password = '$pswd'";
	  	//echo $sql;
	  	$result = $conn -> exec($sql);
	  	$row = $conn -> fetchArray($result);
	  	if($row['cnt'] > 0)
	   		return true;
	 	else
	   		return false;
	 }

 
}
