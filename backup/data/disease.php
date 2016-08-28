<?php
class Disease
{	
	function save($id, $name, $urlname, $cropId, $cause, $symptom, $prevention, $treatment, $shortcontents, $contents, $publish, $weight)
	{
		global $conn;
		
		$id = cleanQuery($id);
		$name = cleanQuery($name);
		$urlname = cleanQuery($urlname);
		$cropId = cleanQuery($cropId);
		$cause = cleanQuery($cause);
		$symptom = cleanQuery($symptom);
		$prevention = cleanQuery($prevention);
		$treatment = cleanQuery($treatment);
		$shortcontents = cleanQuery($shortcontents);
		$contents = cleanQuery($contents);
		$publish = cleanQuery($publish);
		$weight = cleanQuery($weight);
		
		if($id > 0)
		$sql = "UPDATE disease
						SET
							name = '$name',
							urlname = '$urlname',
							cropId = '$cropId',
							cause = '$cause',
							symptom = '$symptom',
							prevention = '$prevention',
							treatment = '$treatment',
							shortcontents = '$shortcontents',
							contents = '$contents',
							publish = '$publish',
							weight = '$weight'
						WHERE
							id = '$id'";
		else
		$sql = "INSERT INTO disease
							SET
								name = '$name',
								urlname = '$urlname',
								cropId = '$cropId',
								cause = '$cause',
								symptom = '$symptom',
								prevention = '$prevention',
								treatment = '$treatment',
								shortcontents = '$shortcontents',
								contents = '$contents',
								publish = '$publish',
								weight = '$weight'";
		//echo $sql; die();
		$conn->exec($sql);
		if($id > 0)
			return $conn -> affRows();
		return $conn->insertId();
	}

	function getById($id)
	{
		global $conn;

		$id = cleanQuery($id);

		$sql = "SElECT * FROM disease WHERE id = '$id'";
		$result = $conn->exec($sql);
		
		return $result;
	}
	
	function getLastWeight($cropId)
	{
		global $conn;
		
		$sql = "SElECT weight FROM disease where cropId='$cropId' ORDER BY weight DESC LIMIT 1";
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
	
	function isUnique($id=0, $urlname)
	{
		global $conn;
		
		$sql = "SELECT COUNT(id) cnt FROM disease WHERE urlname = '$urlname' AND id <> '$id'";

		$result = $conn->exec($sql);
		$row = $conn -> fetchArray($result);
		if($row['cnt'] > 0)
		{
			return false;
		}
		return true;
	}
	
	function saveImage($id)
	{
		global $conn;
		global $_FILES;
		
		if ($_FILES['image']['size'] <= 0)
			return;
		
		$id = cleanQuery($id);
		$filename = $_FILES['image']['name'];
	
		$image = $filename;
		
		copy($_FILES['image']['tmp_name'], "../". CMS_GROUPS_DIR . $image);
		
		$sql = "UPDATE disease SET image = '$image' WHERE id = '$id'";
		$conn->exec($sql);
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
		
		$sql = "UPDATE disease SET image = '' WHERE id = '$id'";
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
		
		$sql = "DELETE FROM disease WHERE id = '$id'";
		$conn->exec($sql);
	}
	
	function getDisease()
	{
		global $conn;
		
		$sql = "SElECT * FROM disease WHERE publish = 'Yes' order by weight";
		$result = $conn->exec($sql);
		return $result;
	}
	
	function getByCropId($cropId)
	{
		global $conn;
		$cropId=cleanQuery($cropId);
		$sql = "SElECT * FROM disease WHERE cropId='$cropId' and publish = 'Yes' order by weight";
		$result = $conn->exec($sql);
		return $result;
	}
}

