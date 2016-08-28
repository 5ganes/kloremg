<?php
class Newtechnology
{
	function save($id, $cropId, $name, $description, $publish, $weight)
	{
		global $conn;
		
		$id = cleanQuery($id);
		$cropId = cleanQuery($cropId);
		$name = cleanQuery($name);
		$description  = cleanQuery($description);

		$publish = cleanQuery($publish);
		$weight = cleanQuery($weight);
		
		if($id > 0)
		{
			$sql = "UPDATE newtechnology
						SET
							cropId = '$cropId',
							name='$name',
							description = '$description',
							publish = '$publish',
							weight = '$weight'
							
						WHERE
							id = '$id'";
		}
		else
		{
			$sql = "INSERT INTO newtechnology 
						SET
							cropId = '$cropId',
							name='$name',
							description = '$description',
							publish = '$publish',
							weight = '$weight',
							onDate = NOW()";
		}
		$conn->exec($sql);
		$id=$conn->insertId(); //echo $iid; die();
		
		return $id;
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
		
		$sql = "DELETE FROM newtechnology WHERE id = '$id'";
		$conn->exec($sql);
	}


	function getLastWeight($cropId)
	{
		global $conn;
		
		$sql = "SElECT weight FROM newtechnology where cropId='$cropId' ORDER BY weight DESC LIMIT 1"; //echo "hi"; die();
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

