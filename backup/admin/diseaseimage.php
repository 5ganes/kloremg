<?php
include("init.php");
if(!isset($_SESSION['sessUserId']))//User authentication
{
 header("Location: login.php");
 exit();
}

if(isset($_POST['id']))
	$id = $_POST['id'];
elseif(isset($_GET['id']))
	$id = $_GET['id'];
else
	$id = 0;

if(isset($_GET['cropId']))
	$cropId=$_GET['cropId'];
if(isset($_GET['diseaseId']))
	$diseaseId=$_GET['diseaseId'];

//$weight = $video -> getLastWeight();
if($_GET['type'] == "edit")
{
	$result = $video->getById($_GET['id']);
	$editRow = $conn->fetchArray($result);	
	extract($editRow);
}
if($_POST['type'] == "Save")
{
	extract($_POST);
		
		$pid = $diseaseimage -> save($_FILES, $_POST['contents'], $cropId, $diseaseId);
		
		for ($i=0; $i < count($_POST['oldcontents']); $i++)
		{
		 	$diseaseimage->saveImages($_POST['oldcontentids'][$i], $_POST['oldcontents'][$i]);
		}
		
		if($id>0)
			header("Location: diseaseimage.php?cropId=$cropId&diseaseId=$diseaseId&type=edit&id=$id&msg=Image details updated successfully");
		else
			header("Location: diseaseimage.php?cropId=$cropId&diseaseId=$diseaseId&msg=Image details saved successfully");
		exit();		
}

if (isset($_GET['imageId']) && isset($_GET['deleteImage']))
{
	$diseaseimage->delete($_GET['imageId']);
	header("Location: diseaseimage.php?cropId=$cropId&diseaseId=$diseaseId&msg=Disease image deleted successfully"); 
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<title><?php echo ADMIN_TITLE; ?></title>
<link href="../css/admin.css" rel="stylesheet" type="text/css">

<script type="text/javascript" src="../js/cms.js"></script>
<script type="text/javascript" src="../js/jquery.min.js"></script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>
<table width="<?php echo ADMIN_PAGE_WIDTH; ?>" border="0" align="center" cellpadding="0"
	cellspacing="5" bgcolor="#FFFFFF">
  <tr>
    <td colspan="2"><?php include("header.php"); ?></td>
  </tr>
  <tr>
    <td width="<?php echo ADMIN_LEFT_WIDTH; ?>" valign="top"><?php include("leftnav.php"); ?></td>
    <td width="<?php echo ADMIN_BODY_WIDTH; ?>" valign="top">
    <table width="100%" border="0" cellspacing="1" cellpadding="0">
        <tr>
          <td class="bgborder"><table width="100%" border="0" cellspacing="1" cellpadding="0">
              <tr>
                <td bgcolor="#fff"><table width="100%" border="0" cellspacing="0" cellpadding="2">
                    <tr>
                      <td class="heading2">&nbsp; Manage Crop Disease Images
                        <div style="float: right;">
                          <?
						    $link="";
							if($_GET['cropId']){ $link="cropId=".$_GET['cropId'];}else{ $link="cropId=select";}
							if($_GET['diseaseId']){ $link=$link."&diseaseId=".$_GET['diseaseId'];}else{ $link=$link."&diseaseId=select";}
							$addNewLink = "diseaseimage.php?".$link;
						  ?>
                          <a href="<?= $addNewLink?>" class="headLink">Add New</a></div></td>
                    </tr>
                    <tr>
                      <td>
                      <form action="<?= $_REQUEST['uri']?>" method="post" enctype="multipart/form-data">
                      <table width="100%" border="0" cellpadding="2" cellspacing="0">
                          <?php if(!empty($errMsg)){ ?>
                          <tr align="left">
                            <td colspan="3" class="err_msg"><?php echo $errMsg; ?></td>
                          </tr>
                          <?php } ?>                          
                            
                            <tr>
                              <td width="100"><strong>Select Crop : <span class="asterisk">*</span></strong></td>
                              <td>
                                 <select name="cropId" id="cropId" onchange="changeImageCrop(this);">
                                	<option value="select">Select Crop</option>
									<?php
									$crop=$crop->getCrops();
									while($cropGet=$conn->fetchArray($crop))
									{?>
                                    	<option value="<?=$cropGet['id'];?>" <? if($cropId==$cropGet['id'] or $_GET['cropId']==$cropGet['id'])
										{ echo 'selected="selected"';}?>>
											<?=$cropGet['name'];?>
                                      	</option>
                                	<? }?>
                               	</select>
                                <span id="errCrop"></span>
                           	</td>
                            </tr>
                            <tr><td></td></tr>
                            
                            <? if(isset($_GET['cropId']) and $_GET['cropId']!="select")
							{?>
                            	<tr>
                              		<td><strong>Select Disease : <span class="asterisk">*</span></strong></td>
                                  	<td>
                                    	<select name="diseaseId" onchange="changeImageDisease(this);">
                                        	<option value="select">Select Disease</option>
                                        	<?php
                                        	$disease=$disease->getByCropId($_GET['cropId']);
                                        	while($diseaseGet=$conn->fetchArray($disease))
                                        	{?>
                                            	<option value="<?=$diseaseGet['id'];?>" <? if($diseaseId==$diseaseGet['id'] or $_GET['diseaseId']==$diseaseGet[
												'id']){ echo 'selected="selected"';}?>>
                                                	<?=$diseaseGet['name'];?>
                                            	</option>
                                        	<? }?>
                                      	</select>	
                                	</td>
                            	</tr>
                            	<tr><td></td></tr>
                            <? }?>
                            
                            <? if(isset($_GET['cropId']) and isset($_GET['diseaseId']) and $_GET['cropId']!="select" and $_GET['diseaseId']!="select")
							{?>
                            <tr>
                              <td>&nbsp;</td>
                              <td>
                              	<div id="galleryDiv" class="groupBox">
                              	<? include("ajaxdiseaseimage.php");?>
                              	</div>
                              </td>
							</tr>                           
                            <tr><td></td></tr>
                            
                            <tr>
                              <td></td>
                              <td>
                              	<input name="type" type="submit" class="button" id="button" value="Save" />
                              	<?php if($_GET['type'] == "edit"){ ?>
                              	<input type="hidden" value="<?= $id?>" name="id" id="id" />
                                <?php }else{ ?>                                
                                <input name="reset" type="reset" class="button" id="button2" value="Clear" />
                                <?php } ?>
                                </td>
                            </tr>                       
                        	<? }?>
                        </table>
                        </form></td>
                    </tr>
                  </table></td>
              </tr>
            </table></td>
        </tr>
        <tr height="5"><td></td></tr>
      </table></td>
  </tr>
  <tr>
    <td colspan="2"><?php include("footer.php"); ?></td>
  </tr>
</table>
</body>
</html>