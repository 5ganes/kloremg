<?php
class Cropvariety
{	
	function save($id, $name, $cropId, $productionTime, $recommendedArea, $recommendedDate, $productivity, $publish, $weight)
	{
		global $conn;
		
		$id = cleanQuery($id);
		$name = cleanQuery($name);
		$cropId = cleanQuery($cropId);
		$productionTime = cleanQuery($productionTime);
		$recommendedArea = cleanQuery($recommendedArea);
		$recommendedDate = cleanQuery($recommendedDate);
		$productivity = cleanQuery($productivity);
		$publish = cleanQuery($publish);
		$weight = cleanQuery($weight);
		
		if($id > 0)
		$sql = "UPDATE cropvariety
						SET
							name = '$name',
							cropId = '$cropId',
							productionTime = '$productionTime',
							recommendedArea = '$recommendedArea',
							recommendedDate = '$recommendedDate',
							productivity = '$productivity',
							publish = '$publish',
							weight = '$weight'
						WHERE
							id = '$id'";
		else
		$sql = "INSERT INTO cropvariety
							SET
								name = '$name',
								cropId = '$cropId',
								productionTime = '$productionTime',
								recommendedArea = '$recommendedArea',
								recommendedDate = '$recommendedDate',
								productivity = '$productivity',
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

		$sql = "SElECT * FROM cropvariety WHERE id = '$id'";
		$result = $conn->exec($sql);
		
		return $result;
	}
	
	function getLastWeight($cropId)
	{
		global $conn;
		
		$sql = "SElECT weight FROM cropvariety where cropId='$cropId' ORDER BY weight DESC LIMIT 1";
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

	function getCropVariety()
	{
		global $conn;
		
		$sql = "SElECT * FROM cropvariety WHERE publish = 'Yes' order by weight";
		$result = $conn->exec($sql);
		return $result;
	}
}
