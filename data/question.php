<?php

	class Question

	{

		function save($id,$answer,$questionId,$providerId,$publish)

		{

			global $conn;

			$id = cleanQuery($id);

			$answer = cleanQuery($answer);

			$questionId = cleanQuery($questionId);

			$providerId = cleanQuery($providerId);

			$publish=cleanQuery($publish);

			if($id > 0)

			{

				$sql = "UPDATE reply

							SET

								answer = '$answer',

								questionId = '$questionId',

								providerId = '$providerId',

								publish = '$publish'						

							WHERE

								id = '$id'";

			}

			else

			{

				$sql = "INSERT INTO reply SET answer = '$answer',questionId = '$questionId',providerId = '$providerId',publish = '$publish',onDate=NOW()";

			}
			$conn->exec("update questions set publish='$publish' where id=$questionId");

			$conn->exec($sql);

			$id=$conn->insertId(); //echo $iid; die();

			return $id;

	}

		function getById($id)

		{

			global $conn;

			$sql = "SELECT * FROM questions WHERE id = '$id'";

			$result = $conn->exec($sql);

			return $conn -> fetchArray($result);	

		}

		

		function updateStatus($id)

		{

			global $conn;

			$row = $this -> getById($id);

			if($row['publish'] == "Yes")

				$stat = "No";

			else

				$stat = "Yes";



			$sql="UPDATE questions SET `publish` = '$stat' WHERE id = '$id'";



			$result = $conn->exec($sql);

			return $conn -> affRows();	

		}

		

		function delete($id)

		{  

			global $conn;

			$id = cleanQuery($id);

			

			$replycount = mysql_fetch_array(mysql_query("select id,count(id) as count from reply where questionId='$id'"));

			if($replycount['count']>0)

			{

				$replyId=$replycount['id'];

				$sql=mysql_query("delete from reply where id='$replyId'");	

			}

			

			$sql = "DELETE FROM questions WHERE id = '$id'";

			$conn->exec($sql);

		}

	}

	

	

	