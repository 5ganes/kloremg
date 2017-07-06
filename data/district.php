<?php

class District

{	

	function save($id, $name, $code, $ecozone, $devregion, $publish, $weight)

	{

		global $conn;

		

		$id = cleanQuery($id);

		$name = cleanQuery($name);

		$code = cleanQuery($code);

		$ecozone = cleanQuery($ecozone);

		$devregion = cleanQuery($devregion);

		$publish = cleanQuery($publish);

		$weight = cleanQuery($weight);

		

		if($id > 0)

		$sql = "UPDATE district

						SET

							name = '$name',

							code = '$code',

							ecozone = '$ecozone',

							devregion = '$devregion',

							publish = '$publish',

							weight = '$weight'

						WHERE

							id = '$id'";

		else

		$sql = "INSERT INTO district

							SET

								name = '$name',

								code = '$code',

								ecozone = '$ecozone',

								devregion = '$devregion',

								publish = '$publish',

								weight = '$weight'";

		//echo $sql; die();

		$conn->exec($sql);

		if($id > 0)

			return $conn -> affRows();

		return $conn->insertId();

	}

	function getDistricts()
	{
		global $conn;

		$sql = "SElECT * FROM district order by weight";
		$result = $conn->exec($sql);
		return $result;
	}

	function getById($id)

	{

		global $conn;



		$id = cleanQuery($id);



		$sql = "SElECT * FROM district WHERE id = '$id'";

		$result = $conn->exec($sql);

		

		return $result;

	}

	

	function getLastWeight()

	{

		global $conn;

		

		$sql = "SElECT weight FROM district ORDER BY weight DESC LIMIT 1";

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

