<?php

require("init.php");

if(isset($_SESSION['sessUserId'])){		//User authentication

	header("Location: index.php");

	exit();

}

if(isset($_POST['btnUserLogin']))

{

	$uname = trim($_POST['uname']);

	$pswd = trim($_POST['pswd']); //echo $pswd;

	$userExists = $users -> validateUser($uname,$pswd);
	//echo $userExists;
	if($userExists)

	{

		$users -> updateLastLogin($_SESSION['sessUserId']);

		$users -> updateLoginTimes($_SESSION['sessUserId']);

		

		header("Location: index.php");

		exit();

	}

	else

	{

		$errMsg = "Login failed!! Try again";

	}

}

?>

