<? include('clientobjects.php'); ?>
<?php
if(!isset($_SESSION['userId']))
{
	//User authentication?>
	<script> document.location.href='<?=SITE_URL?>info-login.html';</script>
	<? //header("Location: /krishighar/info-login.html");
	//exit();
}
if(isset($_POST['updatepass']))
{
	$msg="";
	extract($_POST);
	$userId=$_SESSION['userId'];
	
	$sql=mysql_query("select * from usergroups where id='$userId'");
	$data=mysql_fetch_assoc($sql);
	if(md5($oldpass)!=$data['password'])
	{
		$msg="Old password did not match";
	}
	else if($newpass!=$confirmpass)
	{
		$msg="Please supply matching confirm password";	
	}
	
	if(empty($msg))
	{
		$newpass=md5($newpass);
		$xyz="update usergroups set password='$newpass' where id='$userId'"; //echo $xyz; die();
		if(mysql_query($xyz))
		{?>
        	<script> document.location.href='changepswd.php?msg=Password updated successfully';</script>	
		<? }
			
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
		
		<title>
			Krishi Ghar-
    		<?php if($pageName!=""){ echo $pageName;}else if(isset($_GET['action'])){ echo $_GET['action'];}else{ echo "Home";}?>
		</title>
        <? include('baselocation.php'); ?>
       	<link rel="shortcut icon" type="image/png" href="images/agri.png">
		<link href="css/stylesheet.css" rel="stylesheet" type="text/css">
		<link href="css/default.css" rel="stylesheet" type="text/css">
        <link href="css/user.css" rel="stylesheet" type="text/css">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		
<link rel="stylesheet" type="text/css" href="css/provider.css" />
</head>
	
<body>
	<div id="container">
		
        <div id="wrapper">
			
            <? include("header.php");?>
			<!-- Main Content Starts here-->
			
            <div id="content"> 
				
				<div class="contentHdr" style="margin-bottom:10px">
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
                   
             	</div>
                
                <div class="content">
                    <style>
						.content ul{ margin:0; padding:0;}
						.content ul li{ list-style:none; margin:20px 0}
						.content ul li input{ width:200px}
						.content ul li span{color:red;}
					</style>
                    <div style="margin:0;">
                    	<?
                        if(isset($_GET['msg']))
							$msg=$_GET['msg'];
						else if(!empty($msg))
							$msg=$msg;
						if($msg)
							echo '<h4 style="color:red; margin:4px 0">'.$msg.'</h4>';?>
                        
                    	<form method="post" action="">
                       	<div style="float:left; width:20%">
							<ul>                       	
                                <li><strong>Enter Old Password<span> *</span></strong></li>
                                <li><strong>Enter New Password:<span> *</span></strong></li>
                                <li><strong>Confirm Password:<span> *</span></strong></li>
                                
                       		</ul>
                    	</div>
                        <div style="float:left; width:74%">
							<ul>                       	
                                <li><input type="password" name="oldpass" required /></li>
                                <li><input type="password" name="newpass" required /></li>
                                <li><input type="password" name="confirmpass" required /></li>
                       		</ul>
                    	</div>
                        <div style="clear:both"></div>
                        <input type="submit" name="updatepass" value="Update Password" style="cursor:pointer"/>
                        </form>
                       	
                    </div>
                    
				</div>
                
			</div>
          
			<!-- Wrapper-->
			
            <div id="footer">
            	
                <div class="footer-social-icon">
            		<h4> &#2361;&#2366;&#2350;&#2381;&#2352;&#2379; &#2309;&#2344;&#2354;&#2366;&#2312;&#2344; &#2360;&#2350;&#2381;&#2346;&#2352;&#2381;&#2325; </h4>
            		<ul>
                		<li><iframe src="//www.facebook.com/plugins/like.php?href=https%3A%2F%2Ffacebook.com%2Fkrishighar&amp;width&amp;layout=standard&amp;action=like&amp;show_faces=false&amp;share=true&amp;height=35" scrolling="no" frameborder="0" style="border:none; overflow:hidden; height:35px;" allowTransparency="true"></iframe></li>
                		
            		</ul>
            
            	</div>
            	
                <div class="last-footer">
            		<p class="footer-text" style="font-weight:bold; font-size:16px; margin-top:10px;"> Collaborative Partners</p>
            			<img src="images/moad doa.png" title="MOAD DOA" />
                        <img src="images/moad aicc.png" title="MOAD AICC" />
                        <img src="images/moap.png" title="MOAP" />
                        <img src="images/ictan.png" title="ICT in Agricluture Nepal" /> 
                        <img src="images/undp.png" title="UNDP" />
            	</div>
            
            </div>
		</div><!--Container-->
	
	</div>
	
</body>
</html>
<? echo die();?>