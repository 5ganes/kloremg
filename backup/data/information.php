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
		
		mysqli_query($GLOBALS["___mysqli_ston"], "delete from flip where editId='$id'");
		$f=mysqli_query($GLOBALS["___mysqli_ston"], "insert into flip set tableName='information', type='edit', editId='$id', addId=''");
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
}
