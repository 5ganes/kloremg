<?php
include("admin/initUser.php");
if(isset($_SESSION['userId'])){	//User authentication ?>

	

	<script>

		window.location.href = '<?=SITE_URL?>information-provider.html';

	</script>

	<? //echo "hello";

	//header("Location: SITE_URL/information-provider.html");

	//exit();

}





if(isset($_POST['btnUserLogin']))

{

	$uname = trim($_POST['uname']);



	$pswd = md5(trim($_POST['pswd'])); //echo $pswd;

	//echo $uname." ".$pswd;

	

	$userExists = $users -> validateInfoUser($uname,$pswd);

	//echo $userExists;

	if($userExists)



	{

		//$users -> updateLastLogin($_SESSION['sessUserId']);

		//$users -> updateLoginTimes($_SESSION['sessUserId']);

		//echo $uname." ".$pswd;?>

        <script>

			window.location.href = '<?=SITE_URL?>information-provider.html';

		</script>

		<? //header("Location: SITE_URL/information-provider.html");

		exit();

	}



	else



	{



		$errMsg = "Login failed!! Try again";



	}



}



?>



