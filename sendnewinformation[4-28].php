<? include('clientobjects.php'); ?>
<?php

if(!isset($_SESSION['userId']))

{

	//User authentication?>

	<script> document.location.href='<?=SITE_URL?>info-login.html';</script>

	<? //header("Location: /krishighar/info-login.html");

	//exit();
}

if(isset($_POST['id']))

	$id = $_POST['id'];

elseif(isset($_GET['id']))

	$id = $_GET['id'];

else

	$id = 0;

if($_GET['type'] == "edit")

{

	$result = $groups->getById($_GET['id']);

	$editRow = $conn->fetchArray($result);	

	extract($editRow);

}

if($_POST['type'] == "Send Information")

{

	//$name=$_POST['name']; $information=$_POST['information']; $dist_cat=$_POST['dist_cat']; $dev_region=$_POST['dev_region']; $dist=$_POST['dist']; $product=$_POST['product'];

	extract($_POST);

	//echo "hello"; exit();

	if(empty($name))

		$errMsg .= "<li>Please enter Information Title</li>";

	if(empty($contents))

		$errMsg .= "<li>Please enter Description</li>"	;

	$districtIds="";

	if($dist_cat=="all")

	{

		$sql=mysql_query("SELECT * FROM district ORDER BY id"); $i=1;

		while($dist=mysql_fetch_array($sql))

		{

			if($i==1) $districtIds=$dist['id'];

			else $districtIds=$districtIds.",".$dist['id'];

			$i++;

		}

	}

	else if($dist_cat=="some"){ $districtIds = implode(",", $dist); }

	else if($dist_cat=="tarai")

	{

		$sql=mysql_query("SELECT * FROM district where ecozone='तराइ' ORDER BY id"); $i=1;

		while($dist=mysql_fetch_array($sql))

		{

			if($i==1) $districtIds=$dist['id'];

			else $districtIds=$districtIds.",".$dist['id'];

			$i++;

		}

	}

	else if($dist_cat=="himal")

	{

		$sql=mysql_query("SELECT * FROM district where ecozone='हिमाल' ORDER BY id");$i=1;

		while($dist=mysql_fetch_array($sql))

		{

			if($i==1) $districtIds=$dist['id'];

			else $districtIds=$districtIds.",".$dist['id'];

			$i++;

		}

	}

	else if($dist_cat=="pahad")

	{

		$sql=mysql_query("SELECT * FROM district where ecozone='पहाड' ORDER BY id");$i=1;

		while($dist=mysql_fetch_array($sql))

		{

			if($i==1) $districtIds=$dist['id'];

			else $districtIds=$districtIds.",".$dist['id'];

			$i++;

		}

	}

	else if($dist_cat=="dev_region")

	{

		$sql="select * from district where devregion='"; $dev="";

		if (is_array($_POST['devregion']))

		{

			$c=count($_POST['devregion']); $j=1;

			foreach($_POST['devregion'] as $value)

			{

				if($j<$c){ $sql=$sql.$value."' or devregion='"; }

				else{ $sql=$sql.$value."'"; }

				$j++;

			}

		}

		else

		{

			$d=$_POST['$devregion'];

			$sql=$sql."devregion=".'$d'.'"';

			//echo $value;

		}

		//echo $sql; exit();

		$sql=mysql_query($sql);$i=1;

		while($di=mysql_fetch_array($sql))

		{

			if($i==1) $districtIds=$di['id'];

			else $districtIds=$districtIds.",".$di['id'];

			$i++;

		}

		//echo $district." dev region"; exit();

	}

	//user information

	$userId=$_SESSION['userId'];

	if(empty($errMsg))

	{	
    $usr=$conn->fetchArray($users->getById($userId)); $user_name=$usr['name'];
    $tdate=date("Y-m-d");
    $msg='New information has been posted by '.$user_name.' on '.$tdate.'. Click the below link and login to admin panel to verify it.<br><a href="http://krishighar.com/admin">http://krishighar.com/admin</a>';
      $headers  = "";
      $headers .= "MIME-Version: 1.0 \r\n";
      $headers .= "Content-type: text/html; charset=iso-8859-1 \r\n";
      $headers .= "X-Priority: 1\r\n";
      $headers .= "From: "."info@krishighar.com";
    
    //$arrTo = array("kh6ganesh@gmail.com","hridayakandel@gmail.com");
    $to="krishighar1@gmail.com";
    $subject = "New Information Posted :";
    
    mail($to, $subject, $msg, $headers);
    //mail($arrTo[1], $subject, $msg, $headers);

		$pid = $information -> save($id, $name, $contents, $districtIds, $cropId, $userId, "No");

		if($id > 0)

			$pid = $id;

		//$groups -> saveImage($pid);

		if($id>0)

			header("Location: sendnewinformation.php?type=edit&id=$id&msg=Information details updated successfully");

		else

		{?>

			<script> document.location.href='sendnewinformation.php?msg=Information detail sent successfully';</script>

			

		<? }

	}		

}

?>





<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<!-- saved from url=(0022)http://krishighar.com/ -->

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

    

    <!--accordion js-->

    <link rel="stylesheet" type="text/css" href="accordion/accnew.css">

    <script src="accordion/jquery.min.js"></script>

    <script>

		jQuery(function() {

			jQuery('.ss_button').on('click',function() {

				jQuery('.ss_content').slideUp('fast');

				jQuery(this).next('.ss_content').slideDown('fast');

			});

		});

	</script>

    <!--accordion js ended-->



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

                    

			</div>

                

         	<div class="content">

                    

                    <table width="<?php echo ADMIN_PAGE_WIDTH; ?>" style="border:1px solid #008000" align="center" cellpadding="0"

	cellspacing="5" bgcolor="#FFFFFF">

      	

      	<tr>

            <form action="" method="post" enctype="multipart/form-data">

        	<td width="50%" valign="top">

            <table width="100%" border="0" cellspacing="1" cellpadding="0">

    

            <tr>

    

              <td class=""><table width="100%" border="0" cellspacing="1" cellpadding="0">

    

                  <tr>

    

                    <td bgcolor="#fff"><table width="100%" border="0" cellspacing="0" cellpadding="0">

    

                        <tr>

    

                          <td>

    

                          <table width="100%" border="0" cellpadding="2" cellspacing="0">

    

                              <?php

                              if(!empty($errMsg)){ $msg=$errMsg;}elseif($_GET['msg']){ $msg=$_GET['msg'];}

							  if(!empty($msg))

							  {?>

                              	<tr align="left">

                                	<td colspan="3" class="err_msg"><?php echo $msg; ?></td>

                              	</tr>

                              <? }?>                          

    							<tr><td></td></tr>

                                <tr>

    

                                  <td>

                                  	<p style="font-size:15px; font-weight:bold; margin-bottom:5px; color:#6C0000">शीर्षक</p>

                                    <input style="width:460px; height:20px" name="name" type="text" class="text" value="<?= $name; ?>" />

                                  </td>

    

                                </tr>

                                

                                <tr><td></td></tr>

                                <tr><td></td></tr>

                                

                                <tr>

                                	

                                    <td>

                                    	<p style="margin-bottom:0;">

                                        	<strong style="font-size:15px; color:#6c0000">जानकारी सामग्री :</strong>

                                      	</p>

                                		

                                    </td>

                             	</tr>

                                <tr><td></td></tr>

                                <tr>

                                  <td colspan="2" style="width:600px">

                                    <?php

                                        include ("fckeditor/fckeditor.php");

                                        $sBasePath="fckeditor/";									

                                        $oFCKeditor = new FCKeditor('contents');

                                        $oFCKeditor->BasePath	= $sBasePath ;

                                        $oFCKeditor->Value		= $shortcontents;

                                        $oFCKeditor->Height		= "602";

                                        $oFCKeditor->ToolbarSet	= "Rupens";	

                                        $oFCKeditor->Create();

                                    ?>

                                  </td>

    

                                </tr>

                                              

                            </table>

                            </td>

                        </tr>

                      </table></td>

                  </tr>

                </table></td>

    

            </tr>

    

            <tr height="5"><td></td></tr>

    

          	</table>

            </td>

          

          	<td width="50%" valign="top">

            	

                <div class="second">

                	

					<style> .marg{ margin:0;}</style>

                	<p class=""><strong class="tahomabold11" style="font-size:15px">जिल्ला छनोट गर्नुहोस: <span class="asterisk">*</span></strong></p>

                    <div>

                    	

                        <div id="ss_menu">

                        	<div class="ss_button">

                            	<label style="cursor:pointer">

                                	<input type="radio" name="dist_cat" value="all" checked /> सबै जिल्लाहरु छनोट गर्नुहोस

                              	</label>

                          	</div>

                            

                            <div class="ss_button">

                            	<label style="cursor:pointer">

                                	<input type="radio" name="dist_cat" value="some" />केहि जिल्लाहरु छनोट गर्नुहोस

                               	</label>

                         	</div>

							<div class="ss_content">

                            	<div class="marg" style="margin-left:10px;">

									<style> .districtlist{ float:left; width:92px;} </style>

                                    <?

                                 	$dis=mysql_query("SELECT * FROM `district` ORDER BY `district`.`devregion` DESC"); $i=1;

									while($disGet=mysql_fetch_array($dis))

									{

										if(($i-1)%15==0){echo '<div class="districtlist">';}?>

										<p style="margin:0;">

                                            <input type="checkbox" name="dist[]" value="<?=$disGet['id'];?>" width="30" />

                                            <?=$disGet['name'];?>

										</p>								

										<? if($i%15==0){ echo "</div>";}

										$i++;

									}

                                    ?>

                                    <div style="clear:both"></div>

                                    

                                </div>

                          	</div>

                            

                            <div class="ss_button">

                            	<label style="cursor:pointer">

                                	<input type="radio" name="dist_cat" value="tarai" /> तराई जिल्लाहरु

                              	</label>

                          	</div>

                            

                            <div class="ss_button">

                            	<label style="cursor:pointer">

                                	<input type="radio" name="dist_cat" value="himal" /> हिमाली जिल्लाहरु

                              	</label>

                          	</div>

                            

                            <div class="ss_button">

                            	<label style="cursor:pointer">

                                	<input type="radio" name="dist_cat" value="pahad" /> पहाडी जिल्लाहरु

                              	</label>

                          	</div>

                            

                            <div class="ss_button">

                            	<label style="cursor:pointer">

                                	<input type="radio" name="dist_cat" value="dev_region" /> विकास क्षेत्र

                              	</label>

                          	</div>

                            <div class="ss_content">

                            	<div class="marg" style="margin-left:25px;">

								<?

                                    $dev=mysql_query("select distinct(devregion) from district"); $i=1;

                                    while($devGet=mysql_fetch_array($dev))

                                    {?>

                                        <input type="checkbox" name="devregion[]" value="<?=$devGet['devregion'];?>" /> <?=$devGet['devregion']; if($i==3){ echo '<br />';} $i++;?> 		

                                    <? }

                                ?>

                    			</div>

                            </div>

                        

                        </div>

                        

                    </div>

                    <div style="clear:both"></div>

                    

                    <br />

                    <p class=""><strong class="tahomabold11" style="font-size:15px">

                    	जानकारीको प्रकार: <span class="asterisk">*</span></strong>

                   	</p>

                    

                    <?

                    $cat=$groups->getByLinkType("Activity"); $k=1;

					while($catGet=$conn->fetchArray($cat))

					{?>

						

                        <div class="ss_button">

                            <label style="cursor:pointer">

                                <? if($catGet['id']==351 or $catGet['id']==362 or $catGet['id']==363 or $catGet['id']==364 or 

								$catGet['id']==365 or $catGet['id']==366)

								{?>

									<input type="radio" name="cropId" value="<?=$catGet['id'];?>" checked />

								<? }

								else echo "->";?>

								<?=$catGet['name'];?> 

                            </label>

                        </div>

                        <?

                        $c=$crop->getByCategoryId($catGet['id']);

						if($conn->numRows($c)>0)

						{?>

                            <div class="ss_content">

                                <div class="marg" style="margin-left:25px">

                                    <?

                                    while($cGet=$conn->fetchArray($c))

                                    {?>

                                        <input type="radio" name="cropId" value="<?=$cGet['id'];?>" <? if($k==1){?>checked<? }?>/> 									<?=$cGet['name'];?> 

                                    <? $k++; }?>

                                </div>

                            </div>

                       	<? }?>

					<? }

					?>

                    

                    <p class="marg" style="font-weight:bold">

                    	

                  	</p>

                    <br />

                    <div>

                    

                    	<table>

                        	

                            <tr>

                              <td><input name="type" type="submit" class="button" id="button" value="Send Information" /></td>

                              <td>

                                <?php if($_GET['type'] == "edit"){?>

                                <input type="hidden" value="<?= $id?>" name="id" id="id" />

                                <?php }else{ ?>                                

                                <input name="reset" type="reset" class="button" id="button2" value="Clear" />

                                <?php } ?>

                                </td>

                            </tr> 

                            

                        </table>

                    

                    </div>

                    

                </div>

                

            </td>

          </form>

      	</tr>

      

    </table>

                    

				</div>

                

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

            

        </div>

		<!-- Wrapper-->

           

 	</div><!--Container-->

	

	</div>

	



</body>

</html>

<? echo die();?>

    

    

    

    

    