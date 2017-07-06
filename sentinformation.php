<? include('clientobjects.php'); ?>
<?php
if(!isset($_SESSION['userId']))
{
	//User authentication?>
	<script> document.location.href='<?=SITE_URL?>info-login.html';</script>
	<? //header("Location: /krishighar/info-login.html");
	exit();
}
if(isset($_POST['id']))
	$id = $_POST['id'];
elseif(isset($_GET['id']))
	$id = $_GET['id'];
else
	$id = 0;
if($_GET['type']=="show" )
{ 	
	$cdetail = $information -> getById($id);
}
if(isset($_POST['reply']) and $_POST['reply'] == "reply")
{
	$msg=""; //echo "hi"; die();
	extract($_POST);
	if($answer=="" or $answer=="<br />")
	{
		$msg="Please write reply for this question";	
	}
	if(empty($msg))
	{
		//echo $id.$answer.$questionId.",".$providerId.$publish.$infoId; die();
		$pid = $question -> save($id,$answer,$questionId,$providerId,$publish);
		$information->sendEmailToFarmer($questionId,$providerId);
    if($id>0)
			header("Location: sentinformation.php?type=questions&id=$infoId&msg=Reply Updated Successfully");
		else
			header("Location: sentinformation.php?type=questions&id=$infoId&msg=Replied Successfully");
	}
}

?>
<!DOCTYPE html>
<html>
<head>
	<!--<meta charset="utf-8">-->
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
                    
                    <table width="100%" cellspacing="1" cellpadding="0" border="0">
						<tbody>
						
                        <!-- for information detail-->
						<? if(isset($_GET['type']) and $_GET['type']=="show")
						{
							//$infoId==$_GET['id'];
							$row = $conn->fetchArray($conn->exec("SELECT information.name AS info_name, information.contents, usergroups.name AS user_name, 
							information.districtIds as districts, crop.name AS crop_name, information.cropId as cropId
							FROM information
							INNER JOIN usergroups ON usergroups.id = information.userId
							LEFT JOIN crop ON crop.id = information.cropId
							WHERE information.id = '$id'")); extract($row);?>
                        	<tr>
							<td class="bgborder">
                      			<table width="100%" cellspacing="1" cellpadding="0" border="0">
									<tbody>
                                    <tr>
                						<td bgcolor="#FFFFFF">
                							<table width="100%" cellspacing="0" cellpadding="0" border="0">
                    						<tbody>
                                                <tr style="background:#0b8e04; height:30px">
                                                  <td class="heading3">&nbsp;Information Detail</td>
                                                </tr>
                                                <tr>
                    								<td>
                                                    	<table width="100%" cellspacing="1" cellpadding="4" border="0">
                      										<tbody>
                                                            <tr>
                                                            	<td><strong>Information Provider:</strong></td>
                        										<td><?=$user_name;?></td>
                                                           	</tr>
                      										<tr>
                                                            	<td><strong>Info Title</strong> :</td>
                                                            	<td><?=$info_name;?></td>
                                                          	</tr>
                                                            <tr>
                                                                <td><strong>Info Detail</strong> :</td>
                                                                <td><?=$contents;?></td>
                                                            </tr>
                                                            <tr>
                                                                <td width="10%" valign="top"><strong>Districts : </strong></td>
                                                                <td valign="top">
                                                                	<?
																	$dis=explode(",", $districts);
																	if(count($dis)!=75)
																	{
																		$dis=$conn->fetchArray(mysql_query("select GROUP_CONCAT(name  separator ', ') 
																		concated_districts from district where id in ($districts) group by publish"));
																		echo $dis['concated_districts'];
																	}
																	else
																		echo "All Districts";
																	?>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td width="10%" valign="top"><strong>Info About : </strong></td>
                                                                <td valign="top">
                                                                  <?
                                                                    if($cropId==SOIL)
                                                                      echo "माटो ब्यबस्थापन";
                                                                    else if($cropId==INSECT)
                                                                      echo "कीट सम्बन्धि";
                                                                    else if($cropId==CROPSAVE)
                                                                      echo "वाली सरक्षण";
                                                                    else if($cropId==IRRIGATION)
                                                                      echo "सिँचाइ";
                                                                    else if($cropId==POLICY)
                                                                      echo "नीति";
                                                                    else if($cropId==OTHER)
                                                                      echo "अन्य";
                                                                    else if($cropId==OTHER)
                                                                      echo "अन्य";
                                                                    else
                                                                      echo $crop_name;
                                                                  ?>
                                                                </td>
                                                            </tr>
                    
                    										</tbody>
                                                       	</table>
                                                  	</td>
                  								</tr>
                                                
                  							</tbody>
                    						</table>
             							</td>
              						</tr>
									</tbody>
                            	</table>
                       		</td>
						</tr>
                        <? }?>
                        
                        <!--for question list of an information-->
						<? if(isset($_GET['type']) and $_GET['type']=="questions")
						{?>
                        	
                            <tr>
                            <td class="bgborder">
                      			<table width="100%" cellspacing="1" cellpadding="0" border="0">
									<tbody>
                                    <tr>
                						<td bgcolor="#FFFFFF">
                							<table width="100%" cellspacing="0" cellpadding="0" border="0">
                    						<tbody>
                                                <tr style="background:#0b8e04; height:30px">
                                                  <td class="heading3">&nbsp;Question List 
                                                  <span style=" float:right; color:#ff3535; margin-right:5px;"><?=$_GET['msg'];?></span></td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                    <table width="100%" cellspacing="0" cellpadding="4" border="0">
                                                      <tbody>
                                                      <tr bgcolor="#F1F1F1" class="tahomabold11">
                                                        <td width="1">&nbsp;</td>
                                                        <td><strong>SN</strong></td>
                                                        <td width="300"><strong>Question</strong></td>
                                                        <td width="180"><strong>Farmer Name</strong></td>
                                                        <td width="100"><strong>User Email</strong></td>
                                                        <td width="90" style="text-align:center"><strong>Verified</strong></td>
                                                        <td width="90"><strong>Posted Date</strong></td>
                                                        <td width="220"><strong>Information Title</strong></td>
                                                        <td width="50"><strong>Action</strong></td>
                                                      </tr>
                                                  	<?php
													$counter = 0; $usr=$userGet['id'];
													$sql = $conn->exec("SELECT questions.id as id, questions.name as farmer_name, questions.email as farmer_email, questions.question AS 
													question, questions.publish as publish, questions.onDate as onDate, information.name as information_name 
													FROM questions
													INNER JOIN information ON questions.infoId=information.id
													WHERE information.id = '$id' and information.userId='$usr' 
													ORDER BY questions.id DESC, questions.onDate Desc");
													while($row = mysql_fetch_array($sql))
													{?>                 
                                                      <tr <?php if($counter%2 != 0) echo 'bgcolor="#F7F7F7"'; else echo 'bgcolor="#FFFFFF"'; ?>>
                                                        <td valign="top">&nbsp;</td>
                                                        <td valign="top"><?=++$counter;?></td>
                                                        <td valign="top" style="font-weight:bold"><?=$row['question'];?></td>
                                                        <td valign="top" style="text-align:justify"><? echo $row['farmer_name'];?></td>
                                                        <td valign="top"><?=$row['farmer_email'];?></td>
                                                        <td valign="top" style="text-align:center"><?=$row['publish'];?></td>
                                                        <td valign="top">
                                                        	<?php 
															$arrDate = explode(' ',$row['onDate']); 
															$arrDate1 = explode('-',$arrDate[0]);
															echo date("M j, Y",mktime(0,0,0,$arrDate1[1],$arrDate1[2],$arrDate1[0]));
															?>	
                                                        </td>
                                                        <td valign="top"><?=$row['information_name'];?></td>
                                                        <td valign="top">
                                                            [<a href="<?php SITE_URL?>sentinformation.php?type=reply&id=<?php echo $row['id'];?>">Reply</a>]
                                                      </tr>
                                                      <? }?>
                                                      
                                                        </tbody>
                                                    </table>
                                                    </td>
                                                </tr>
                                                
                  							</tbody>
                    						</table>
             							</td>
              						</tr>
									</tbody>
                            	</table>
                       		</td>
							</tr>
                        <? }?>
                        
                        <!--for reply to a specific question-->
						<? if(isset($_GET['type']) and $_GET['type']=="reply")
						{
							$questionGet=$conn->fetchArray($conn->exec("select questions.id as id, questions.question as question, reply.id as reply_id, 
							reply.answer as answer, questions.infoId as infoId, reply.publish as publish from questions LEFT JOIN reply on 	
							questions.id=reply.questionId where questions.id='$id'")); extract($questionGet);?>
                        	
                            <tr>
                            <td class="bgborder">
                      			
                                <form action="sentinformation.php" method="post" enctype="multipart/form-data">
                                
                                <table width="100%" cellspacing="1" cellpadding="0" border="0">
									<tbody>
                                    <tr>
                						<td bgcolor="#FFFFFF">
                							<table width="100%" cellspacing="0" cellpadding="0" border="0">
                    						<tbody>
                                                <tr style="background:#0b8e04; height:30px">
                                                  <td class="heading3">&nbsp;Reply to this question</td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <table width="100%" border="0" cellspacing="1" cellpadding="4">
                                                            <tr>
                                                            <td width="160"><strong>Question:</strong></td>
                                                        	<td style=" font-weight:bold">
                                                            <?=$question;?>
                                                        	</td>
                                                      		</tr>
                                                        	<input type="hidden" name="questionId" value="<?=$id;?>" />
                                                        	<input type="hidden" name="providerId" value="<?=$_SESSION['userId'];?>" />
                                                            <input type="hidden" name="infoId" value="<?=$infoId;?>" />
                                                      		<tr>
                                                        	<td><strong>Reply Answer</strong> :</td>
                                
                                                            <td colspan="2" style="width:170px">
                                                                <textarea name="answer" rows="6" style="padding:5px;" cols="128"><?=$answer;?></textarea>
                                                          	</td>
                                                    	</tr>
                                                    	<tr>
                                                          	<td><strong>Publish :</strong></td>
                                                          	<td>
                                                            	<label>
                                                              	<input name="publish" type="radio" id="featured_0" value="No" checked="checked" />
                                                              	No</label>
                                                            	<label>
                                                              	<input type="radio" name="publish" value="Yes" id="featured_1" 
															  	<? if($publish == 'Yes') echo 'checked="checked"';?> />
                                                              	Yes</label>
                                                          	</td>
                                                   		</tr>
                                              		</table>
                                                    </td>
                                
                                                  </tr>
                                                
                  							</tbody>
                    						</table>
             							</td>
              						</tr>
									</tbody>
                            	</table>
                                
                                <table width="100%" bgcolor="#FFF" border="1" bordercolor="#006193">
                                    <tr>
                                        <td>
                                            <? if(isset($id))
                                            {?>
                                                <input type="hidden" value="<?= $reply_id?>" name="id" id="id" />
                                            <? }?>
                                            <input name="reply" type="submit" class="button" id="button" value="reply" />
                                        </td>
                                    </tr>
                             	</table>
                                </form>
                       		</td>
							</tr>
                        <? }?>
                        
                        <!-- for list of informations-->
                        <tr>
							<td class="bgborder">
                      			<table width="100%" cellspacing="1" cellpadding="0" border="0">
									<tbody>
                                    <tr>
                						<td bgcolor="#FFFFFF">
                							<table width="100%" cellspacing="0" cellpadding="0" border="0">
                    						<tbody>
                                                <tr style="background:#0b8e04; height:30px">
                                                  <td class="heading3">&nbsp;Informations</td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                    <table width="100%" cellspacing="0" cellpadding="4" border="0">
                                                      <tbody>
                                                      <tr bgcolor="#F1F1F1" class="tahomabold11">
                                                        <td width="1">&nbsp;</td>
                                                        <td><strong>SN</strong></td>
                                                        <td width="300"><strong>Title</strong></td>
                                                        <td width="250"><strong>Crop Name</strong></td>
                                                        <td style="text-align:center"><strong>Verified</strong></td>
                                                        <td><strong>Date</strong></td>
                                                        <td width="105"><strong>Detail/Question</strong></td>
                                                      </tr>
                                                  	<?php
													$counter = 0; $usr=$userGet['id'];
													$sql = mysql_query("SELECT information.id as id,information.name as info_name,information.onDate as 
													onDate,information.publish as publish,crop.name as crop_name 
													FROM information 
													INNER JOIN crop on information.cropId=crop.id 
													where userId='$usr' ORDER BY information.id DESC, onDate Desc");

													while($row = mysql_fetch_array($sql))
													{?>                 
                              <tr <?php if($counter%2 != 0) echo 'bgcolor="#F7F7F7"'; else echo 'bgcolor="#FFFFFF"'; ?>>
                                <td valign="top">&nbsp;</td>
                                <td valign="top"><?=++$counter;?></td>
                                <td valign="top" style="font-weight:bold"><?=$row['info_name'];?></td>
                                <td valign="top" style="text-align:justify">
    															<? echo $row['crop_name'];?>
                              	</td>
                                <td valign="top" style="text-align:center"><?=$row['publish'];?></td>
                                <td valign="top">
                                	<?php 
      															$arrDate = explode(' ',$row['onDate']); 
      															$arrDate1 = explode('-',$arrDate[0]);
      															echo date("M j, Y",mktime(0,0,0,$arrDate1[1],$arrDate1[2],$arrDate1[0]));
      															?>	
                                </td>
                                <td valign="top">
                                    [<a href="<?php SITE_URL?>sentinformation.php?type=show&id=<?php echo $row['id'];?>">Details</a>]
                                    [<a href="<?php SITE_URL?>sentinformation.php?type=questions&id=<?php echo $row['id'];?>">Questions</a>]
                              </tr>
                              <? }
                          $sql=mysql_query("SELECT information.id as id,information.name as info_name,information.onDate as 
                          onDate,information.publish as publish,groups.name as crop_name 
                          FROM information 
                          INNER JOIN groups on information.cropId=groups.id 
                          where userId='$usr' and (groups.id='351' or groups.id='362' or groups.id='363' or groups.id='364' or groups.id='365' or groups.id='366') ORDER BY information.id DESC, onDate Desc");
                          while($row = mysql_fetch_array($sql))
                          {?>                 
                            <tr <?php if($counter%2 != 0) echo 'bgcolor="#F7F7F7"'; else echo 'bgcolor="#FFFFFF"'; ?>>
                                <td valign="top">&nbsp;</td>
                                <td valign="top"><?=++$counter;?></td>
                                <td valign="top" style="font-weight:bold"><?=$row['info_name'];?></td>
                                <td valign="top" style="text-align:justify">
                                  <span style="color:red"><? echo $row['crop_name'];?></span>
                                </td>
                                <td valign="top" style="text-align:center"><?=$row['publish'];?></td>
                                <td valign="top">
                                  <?php 
                                    $arrDate = explode(' ',$row['onDate']); 
                                    $arrDate1 = explode('-',$arrDate[0]);
                                    echo date("M j, Y",mktime(0,0,0,$arrDate1[1],$arrDate1[2],$arrDate1[0]));
                                    ?>  
                                </td>
                                <td valign="top">
                                    [<a href="<?php SITE_URL?>sentinformation.php?type=show&id=<?php echo $row['id'];?>">Details</a>]
                                    [<a href="<?php SITE_URL?>sentinformation.php?type=questions&id=<?php echo $row['id'];?>">Questions</a>]
                            </tr>
                          <? }?>
                                                      
                          </tbody>
                          </table>
                          </td>
                          </tr>
                                                
                  							</tbody>
                    						</table>
             							</td>
              						</tr>
									</tbody>
                            	</table>
                       		</td>
						</tr>
						</tbody>
                	</table>
                    
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