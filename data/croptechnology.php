<?php
class Croptechnology
{
	function save($id, $cropId, $cropvarietyId, $highMountain, $mediumMountain, $tarai, $fertilizer, $dyandyan, $plantplant, $seedRate, $publish, $weight)
	{
		global $conn;
		
		$id = cleanQuery($id);
		$cropId = cleanQuery($cropId);
		$cropvarietyId = cleanQuery($cropvarietyId);
		$highMountain  = cleanQuery($highMountain);
		$mediumMountain = cleanQuery($mediumMountain);
		$tarai = cleanQuery($tarai);
		$fertilizer = cleanQuery($fertilizer);
		$dyandyan = cleanQuery($dyandyan);
		$plantplant = cleanQuery($plantplant);
		$seedRate = cleanQuery($seedRate);

		$publish = cleanQuery($publish);
		$weight = cleanQuery($weight);
		
		if($id > 0)
		{
			$sql = "UPDATE croptechnology
						SET
							cropId = '$cropId',
							cropvarietyId='$cropvarietyId',
							highMountain = '$highMountain',
							mediumMountain = '$mediumMountain',
							tarai = '$tarai',
							fertilizer = '$fertilizer',
							dyandyan = '$dyandyan',
							plantplant = '$plantplant',
							seedRate = '$seedRate',
							publish = '$publish',
							weight = '$weight'
							
						WHERE
							id = '$id'";
		}
		else
		{
			$sql = "INSERT INTO croptechnology 
						SET
							cropId = '$cropId',
							cropvarietyId='$cropvarietyId',
							highMountain = '$highMountain',
							mediumMountain = '$mediumMountain',
							tarai = '$tarai',
							fertilizer = '$fertilizer',
							dyandyan = '$dyandyan',
							plantplant = '$plantplant',
							seedRate = '$seedRate',
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
		
		$sql = "DELETE FROM croptechnology WHERE id = '$id'";
		$conn->exec($sql);
	}

	function getCropVariety()
	{
		global $conn;
		
		$sql = "SElECT * FROM cropvariety WHERE publish = 'Yes' order by weight";
		$result = $conn->exec($sql);
		return $result;
	}

	function getLastWeightCropTechnology($cropId)
	{
		global $conn;
		
		$sql = "SElECT weight FROM croptechnology where cropId='$cropId' ORDER BY weight DESC LIMIT 1"; //echo "hi"; die();
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

