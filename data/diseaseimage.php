<?php
class Diseaseimage
{	
	function save($files, $contents, $cropId, $diseaseId)
	{
		global $conn;
		
		//$id = cleanQuery($id);
		///$contents = cleanQuery($contents);
		//echo "inside data"; die();
		$cropId = cleanQuery($cropId);
		$diseaseId = cleanQuery($diseaseId);
		//print_r($contents); die();
		for ($i=0; $i<count($files['image']['name']); $i++)
		{
			//echo "inside data"; die();
			$img=$files['image']['name'][$i];
			
			if(!empty($files['image']['name'][$i]))
			{
				$sql="insert into diseaseimage set image='$cropId$diseaseId$img', contents='$contents[$i]', cropId='$cropId', diseaseId='$diseaseId'";
				$id=$conn->exec($sql);
				copy($files['image']['tmp_name'][$i], "../" . CMS_GROUPS_DIR . $cropId.$diseaseId.$files['image']['name'][$i]);
			}
		}
		
		//$conn->exec($sql);
		//if($id > 0)
		//	return $conn -> affRows();
		//return $conn->insertId();
	}

	function getById($id)
	{
		global $conn;

		$id = cleanQuery($id);

		$sql = "SElECT * FROM diseaseimage WHERE id = '$id'";
		$result = $conn->exec($sql);
		
		return $result;
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
		
		$sql = "DELETE FROM diseaseimage WHERE id = '$id'";
		$conn->exec($sql);
	}
	
	function saveImages($id, $contents)
	{
		global $conn;
		
		$id = cleanQuery($id);
		$contents = cleanQuery($contents);
		
		$sql = "UPDATE diseaseimage
						SET
							contents = '$contents'
						WHERE
							id = '$id'";
		$conn->exec($sql);
		return $conn->insertId();
	}
}
?>
