<?
if(!isset($_SESSION['userId']))
{

	//User authentication?>

	<script> document.location.href='<?=SITE_URL?>info-login.html';</script>

	<? //header("Location: /krishighar/info-login.html");

	//exit();

}

?>

<style>

	.master{ width:100%}

	.send_info {

	  background: green;

float: left;

height: 58px;

line-height: 24px;

margin: 3%;

padding: 48px 0;

text-align: center;

width: 26%;

border-radius: 15px;

	}

	.master .send_info:hover{ background:#87f284;}

	.master .send_info:hover a{ color:#000; text-decoration:underline}

	.master div.last-child{ margin-right:0;}

	.send_info a{ color:#FFF; font-size:24px; font-weight:bold}

	.send_info a:hover{ color:#0C0; background:}

	.questions{}

	.sent_info{}

</style>

<link rel="stylesheet" type="text/css" href="css/provider.css" />



<?php //include("includes/breadcrumb.php"); ?>



<div class="contentHdr">

	<?

    	$sess=$_SESSION['userId']; $user=mysql_query("select * from usergroups where id='$sess'");

		$userGet=mysql_fetch_array($user);

	?>

    <div style="float:right">

    	<a class="logout" href="<?=SITE_URL?>sendnewinformation.php">नयाँ जानकारी पठाउनुहोस्</a>

        <a class="logout" href="<?=SITE_URL?>sentinformation.php">पहिले पठाइएका जानकारीहरु</a>

        <a class="logout" href="questions.php">प्रश्नहरु</a>

    	<a href="viewprofile.php" class="logout">View Profile</a>

    	<a href="editprofile.php" class="logout">Edit Profile</a>

        <a href="changepswd.php" class="logout">Change Password</a>

    	<a class="logout" href="includes/logoutUser.php">Logout</a>

  	</div>

    <div style="clear:both"></div>

	<div style="margin-top:10px">

    	<h2><a href="information-provider.html" style="color:green; text-decoration:underline; font-size:18px">जानकारी प्रदायक ( <?=$userGet['name'];?> )</a></h2>

  		

    </div>

</div>



<div class="content">



	<div class="master">

		<div class="send_info">

    		<a href="sendnewinformation.php">नयाँ जानकारी<br/>पठाउनुहोस्</a>

    	</div>

        <div class="sent_info send_info">

        	<a href="sentinformation.php">पहिले पठाइएका<br/>जानकारीहरु</a>

        </div>

        <div class="questions send_info">

        	<a href="questions.php">प्रश्नहरु</a>

        </div>

        <div style="clear:both"></div>

    </div>



</div>