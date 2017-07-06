<?php

class Undp

{	
	//agri news
	function saveAgrinews($id, $name, $description, $newsDate, $newsSource, $publish, $weight)
	{
		global $conn;
		$id = cleanQuery($id);
		$name = cleanQuery($name);
		$description = cleanQuery($description);
		$newsDate = cleanQuery($newsDate);
		$newsSource=cleanQuery($newsSource);
		$publish = cleanQuery($publish);
		$weight = cleanQuery($weight);
		
		if($id > 0)
		$sql = "UPDATE agrinews
						SET
							name = '$name',
							description = '$description',
							newsDate = '$newsDate',
							newsSource = '$newsSource',
							publish = '$publish',
							weight = '$weight'
						WHERE
							id = '$id'";
		else

		$sql = "INSERT INTO agrinews 
						SET
							name = '$name',
							description = '$description',
							newsDate = '$newsDate',
							newsSource = '$newsSource',
							publish = '$publish',
							weight = '$weight'";
		$conn->exec($sql);
		if($id > 0)
			return $conn -> affRows();
		return $conn->insertId();
	}
	
	function getAgrinewsSubLastWeight()
	{
		global $conn;

		$sql = "SElECT weight FROM agrinews ORDER BY weight DESC LIMIT 1";
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
	
	function getAgrinewsById($id)
	{
		global $conn;

		$id = cleanQuery($id);
		$sql = "SElECT * FROM agrinews WHERE id = '$id'";
		$result = $conn->exec($sql);
		return $result;
	}
	
	function deleteAgrinews($id)
	{
		global $conn;
		
		$id = cleanQuery($id);
		$sql = "DELETE FROM agrinews WHERE id = '$id'";
		$conn->exec($sql);

	}
	
	//for successstories
	function saveSuccessstories($id, $name, $description, $publish, $weight)
	{
		global $conn;
		$id = cleanQuery($id);
		$name = cleanQuery($name);
		$description = cleanQuery($description);
		$publish = cleanQuery($publish);
		$weight = cleanQuery($weight);
		
		if($id > 0)
		$sql = "UPDATE successstories
						SET
							name = '$name',
							description = '$description',
							publish = '$publish',
							weight = '$weight'
						WHERE
							id = '$id'";
		else

		$sql = "INSERT INTO successstories 
						SET
							name = '$name',
							description = '$description',
							publish = '$publish',
							weight = '$weight'";
		$conn->exec($sql);
		if($id > 0)
			return $conn -> affRows();
		return $conn->insertId();
	}
	
	function getSuccessstoriesSubLastWeight()
	{
		global $conn;

		$sql = "SElECT weight FROM successstories ORDER BY weight DESC LIMIT 1";
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
	function getSuccessstoriesById($id)
	{
		global $conn;

		$id = cleanQuery($id);
		$sql = "SElECT * FROM successstories WHERE id = '$id'";
		$result = $conn->exec($sql);
		return $result;
	}
	
	function deleteSuccessstories($id)
	{
		global $conn;
		
		$id = cleanQuery($id);
		$sql = "DELETE FROM successstories WHERE id = '$id'";
		$conn->exec($sql);

	}
	
	//for Agri Events
	function saveAgrievents($id, $name, $onDate, $address, $description, $publish, $weight)
	{
		global $conn;
		$id = cleanQuery($id);
		$name = cleanQuery($name);
		$onDate = cleanQuery($onDate);
		$address = cleanQuery($address);
		$description = cleanQuery($description);
		$publish = cleanQuery($publish);
		$weight = cleanQuery($weight);
		
		if($id > 0)
		$sql = "UPDATE agrievents
						SET
							name = '$name',
							onDate = '$onDate',
							address = '$address',
							description = '$description',
							publish = '$publish',
							weight = '$weight'
						WHERE
							id = '$id'";
		else

		$sql = "INSERT INTO agrievents 
						SET
							name = '$name',
							onDate = '$onDate',
							address = '$address',
							description = '$description',
							publish = '$publish',
							weight = '$weight'";
		$conn->exec($sql);
		if($id > 0)
			return $conn -> affRows();
		return $conn->insertId();
	}
	
	function getAgrieventsSubLastWeight()
	{
		global $conn;

		$sql = "SElECT weight FROM agrievents ORDER BY weight DESC LIMIT 1";
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
	function getAgrieventsById($id)
	{
		global $conn;

		$id = cleanQuery($id);
		$sql = "SElECT * FROM agrievents WHERE id = '$id'";
		$result = $conn->exec($sql);
		return $result;
	}
	
	function deleteAgrievents($id)
	{
		global $conn;
		
		$id = cleanQuery($id);
		$sql = "DELETE FROM agrievents WHERE id = '$id'";
		$conn->exec($sql);

	}
}