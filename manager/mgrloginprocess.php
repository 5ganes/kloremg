<?php

require("../admin/init.php");

if(isset($_SESSION['sessMgrId'])){		//User authentication

	header("Location: index.php");

	exit();

}

if(isset($_POST['btnMgrLogin']))

{

	$uname = trim($_POST['uname']);

	$pswd = trim($_POST['pswd']); //echo $pswd;

	$userExists = $users -> validateMgr($uname,$pswd);
	//echo $userExists;
	if($userExists)

	{

		$users -> updateLastLogin($_SESSION['sessMgrId']);

		$users -> updateLoginTimes($_SESSION['sessMgrId']);

		

		header("Location: index.php");

		exit();

	}

	else

	{

		$errMsg = "Login failed!! Try again";

	}

}

?>

