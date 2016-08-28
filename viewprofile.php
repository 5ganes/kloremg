<? include('clientobjects.php'); ?>

<?php



if(!isset($_SESSION['userId']))

{

	//User authentication?>

	<script> document.location.href='<?=SITE_URL?>info-login.html';</script>

	<? //header("Location: /krishighar/info-login.html");

	//exit();

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

						.content ul li{ list-style:none; margin:5px 0}

					</style>

                    <div style="margin:0;">

                       	<div style="float:left; width:25%">

							<ul>                       	

                                <li><strong>Organization Name:</strong></li>

                                <li><strong>Address:</strong></li>

                                <li><strong>Email:</strong></li>

                                <li><strong>Phone:</strong></li>

                                <li><strong>Subscription Date:</strong></li>

                                <li><strong>Expiry Date:</strong></li>

                                <li><strong>Renew:</strong></li>

                                <li><strong>Organization Head:</strong></li>

                                <li><strong>Phone:</strong></li>

                                <li><strong>Organization Detail:</strong></li>

                                

                       		</ul>

                    	</div>

                        <div style="float:left; width:74%">

							<ul>                       	

                                <li><?=$userGet['name'];?></li>

                                <li><?=$userGet['address'];?></li>

                                <li><?=$userGet['email'];?></li>

                                <li><?=$userGet['phone'];?></li>

                                <li><?=$userGet['subscriptionDate'];?></li>

                                <li><?=$userGet['expiryDate'];?></li>

                                <li><?=$userGet['renew'];?></li>

                                <li><?=$userGet['orgHead'];?></li>

                                <li><?=$userGet['orgHeadPhone'];?></li>

                                <li><?=$userGet['orgInfo'];?></li>

                       		</ul>

                    	</div>

                        <div style="clear:both"></div>

                       	

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