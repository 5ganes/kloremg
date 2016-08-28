<?php
class Diarycat
{
	function saveOrUpdate($id=0, $name, $publish, $weight)
	{
		global $conn;
		
		$id = cleanQuery($id);
		$name = cleanQuery($name);
		$publish = cleanQuery($publish);
		$weight = cleanQuery($weight);
		
		if($id > 0)
			$sql = "UPDATE diarycategories SET name = '$name', publish = '$publish', weight='$weight' WHERE id = '$id'";
		else
			$sql = "INSERT INTO diarycategories SET name = '$name', publish = '$publish', weight='$weight'";
		
		$conn->exec($sql);
		
		if($id > 0)
			return $conn -> affRows();
		return $conn->insertId();
	}
	
	function delete($id)
	{  
		global $conn;
		
		$id = cleanQuery($id);
	
		$sql = "DELETE FROM diarycategories WHERE id = '$id'";
		$conn->exec($sql);
	}
	
	function getAll()
	{
		global $conn;
		
		$sql = "SElECT * FROM diarycategories ORDER BY name ASC";
		$result = $conn->exec($sql);
		
		return $result;
	}

	function getById($id)
	{
		global $conn;
		
		$id = cleanQuery($id);
		
		$sql = "SElECT * FROM diarycategories WHERE id = '$id'";
		$result = $conn->exec($sql);
		$row = $conn -> fetchArray($result);
		return $row;
	}
	
	function getName($id)
	{
		global $conn;
		
		$id = cleanQuery($id);
		$sql = "SElECT name FROM diarycategories WHERE id = '$id'";
		$result = $conn->exec($sql);
		$row = $conn -> fetchArray($result);
		
		return $row['title'];
	}
	
	function isEditable($id)
	{
		global $conn;
		global $questions;
		
		$id = cleanQuery($id);
		
		$sql = "SELECT COUNT(*) cnt FROM categories WHERE parentId = '$id'";
		$result = $conn -> exec($sql);
		$row = $conn -> fetchArray($result);
		if($row['cnt'] > 0)
			return false;
		else
		{
			//return true;
			$sql = "SELECT COUNT(*) cnt FROM diary WHERE categoryId = '$id'";
			$result = $conn -> exec($sql);
			$row = $conn -> fetchArray($result);
			if($row['cnt'] > 0)
				return false;
			return true;
		}
	}
	
	function getNameById($id)
	{
		global $conn;
		
		$sql = "SElECT name FROM diarycategories WHERE id = '$id'";
		$result = $conn->exec($sql);
		$row = $conn->fetchArray($result);
		return $row['title'];
	}
	
	function getLastWeight()
	{
		global $conn;
		
		$sql = "SElECT weight FROM diarycategories ORDER BY weight DESC LIMIT 1";
		$result = $conn->exec($sql);
		$numRows = $conn -> numRows($result);
		if($numRows > 0)
		{
			$row = $conn->fetchArray($result);
			return $row['weight'] + 10;
		}
		else
			return 10;
	}
}
?>
