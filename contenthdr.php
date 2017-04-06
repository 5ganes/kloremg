<div class="contentHdr">
	<?
    	$sess=$_SESSION['userId']; $user=mysql_query("select * from usergroups where id='$sess'");
		$userGet=mysql_fetch_array($user);
	?>
	<div style="float:left">
    	<h2 style="text-decoration:underline; color:green">जानकारी प्रदायक (Information Provider)</h2>
  		<h3 style="margin:12px 0 0 0;"><?=$userGet['name'];?></h3>
        <p style="margin:0;"><?=$userGet['address'];?></p>
    </div>
    <div style="float:right">
    	<a href="editprofile.php" class="logout">Edit Profile</a>
    	<a class="logout" href="includes/logoutUser.php">Logout</a>
  	</div>
    <div style="clear:both"></div>
</div>