<?php
class Diary
{	
	function saveOrUpdate($id, $name, $categoryId, $phone, $fax, $email, $website, $publish, $weight)
	{
		global $conn;
		
		$id = cleanQuery($id);
		$name = cleanQuery($name);
		$categoryId = cleanQuery($categoryId);
		$phone = cleanQuery($phone);
		$fax = cleanQuery($fax);
		$email = cleanQuery($email);
		$website = cleanQuery($website);
		$publish = cleanQuery($publish);
		$weight = cleanQuery($weight);
		
		if($id > 0)
		$sql = "UPDATE diary
						SET
							name = '$name',
							categoryId='$categoryId',
							phone = '$phone',
							fax = '$fax',
							email = '$email',
							website = '$website',
							publish = '$publish',
							weight = '$weight'
						WHERE
							id = '$id'";
		else
		$sql = "INSERT INTO diary 
						SET
							name = '$name',
							categoryId='$categoryId',
							phone = '$phone',
							fax = '$fax',
							email = '$email',
							website = '$website',
							publish = '$publish',
							weight = '$weight',
							onDate = NOW()";
		
		$conn->exec($sql);
		if($id > 0)
			return $conn -> affRows();
		return $conn->insertId();
	}
	
	function getById($id)
	{
		global $conn;

		$id = cleanQuery($id);

		$sql = "SElECT * FROM diary WHERE id = '$id'";
		$result = $conn->exec($sql);
		
		return $result;
	}
	
	function getByParentIdAndType($id, $categoryId)
	{
		global $conn;
		
		$id = cleanQuery($id);
		$categoryId = cleanQuery($categoryId);
		
		$sql = "SElECT * FROM diary WHERE `categoryId` = '$categoryId' ORDER BY weight";
		$result = $conn->exec($sql);
		
		return $result;
	}
	
	function getByCategoryId($CategoryId)
	{
		global $conn;
		
		$parentId = cleanQuery($parentId);
		
		$sql = "SElECT * FROM diary WHERE categoryId = '$CategoryId' ORDER BY weight";
		$result = $conn->exec($sql);
		
		return $result;
	}
	
	function updateImage($id, $image)
	{
		global $conn;
		
		$id = cleanQuery($id);
		$image = cleanQuery($image);
		
		$sql = "UPDATE diary SET image = '$image' WHERE id = '$id'";
		$conn->exec($sql);
	}
	
	function delete($id)
	{  
		global $conn;
		
		$id = cleanQuery($id);
			
		$sql = "DELETE FROM diary WHERE id = '$id'";
		$conn->exec($sql);
	}
	
	function getLastWeight()
	{
		global $conn;
		
		$sql = "SElECT weight FROM diary ORDER BY weight DESC LIMIT 1";
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
	
	function getCategories()
	{
		global $conn;
		
		$sql = "SElECT * FROM diarycategories order by weight";
		$result = $conn->exec($sql);	
		return $result;
	}
	
	
}
?>
