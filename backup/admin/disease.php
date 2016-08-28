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

//$weight = $disease -> getLastWeight();
if($_GET['type'] == "edit")
{
	$result = $disease->getById($_GET['id']);
	$editRow = $conn->fetchArray($result);	
	extract($editRow);
}
if($_POST['type'] == "Save")
{
	extract($_POST);
	
	if(!$disease -> isUnique($id, $urlname))
		$errMsg .= "<li>Alias Name already exists.</li>";
	
	if(empty($errMsg))
	{
		$pid = $disease -> save($id, $name, $urlname, $cropId, $cause, $symptom, $prevention, $treatment, $shortcontents, $contents, $publish, $weight);
		if($id > 0)
			$pid = $id;
		$disease -> saveImage($pid);
		if($id>0)
			header('Location: disease.php?cropId='.$cropId.'&type=edit&id='.$id.'&msg=Disease details updated successfully');
		else
			header('Location: disease.php?cropId='.$cropId.'&msg=Disease details saved successfully');
		exit();
	}		
}

if($_GET['type'] == "tooglePublish")
{
	$id = $_GET['id'];
	$changeTo = $_GET['changeTo'];
	
	$sql = "UPDATE disease SET publish='$changeTo' WHERE id='$id'";
	$conn->exec($sql);
	header('location: disease.php?cropId='.$cropId.'&msg=Disease Show/Hide status toogled successfully.');
	
}
	
if($_GET['type'] == "removeImage")
{
	$disease->deleteImage($_GET['id']);
	//echo "hello";
	//header("location: disease.php?type=edit&id=".$_GET['id']."&msg=product image deleted successfully.");?>
	<script> document.location='disease.php?cropId=<?=$cropId;?>&type=edit&id=<?=$_GET['id']?>&msg=disease image deleted successfully.' </script>
<? }
if($_GET['type']=="del")
{
		$disease -> delete($_GET['id']);
		//echo "hello";
		//header("Location : disease.php?&msg=product deleted successfully.");?>
    	<script> document.location='disease.php?cropId=<?=$cropId;?>&msg=Disease deleted successfully.' </script>    
<? }
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
    <td width="<?php echo ADMIN_BODY_WIDTH; ?>" valign="top"><table width="100%" border="0" cellspacing="1" cellpadding="0">
        <tr>
          <td class="bgborder"><table width="100%" border="0" cellspacing="1" cellpadding="0">
              <tr>
                <td bgcolor="#fff"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td class="heading2">&nbsp; Manage Disease
                        <div style="float: right;">
                          <?
							if($_GET['cropId']){ $cropId=$_GET['cropId'];}else{ $cropId="select";}
							$addNewLink = "disease.php?cropId=$cropId";
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
                              <td>&nbsp;</td>
                              <td class="tahomabold11"><strong>Select Crop : <span class="asterisk">*</span></strong></td>
                              <td>
                                <select name="cropId" onchange="changeDiseaseCrop(this);">
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
                           	</td>
                            </tr>
                            <tr><td></td></tr>
                            
                            <? if(isset($_GET['cropId']) and $_GET['cropId']!="select")
							{?>
                            <tr>
                              <td>&nbsp;</td>
                              <td class="tahomabold11">
                              	<strong> Disease Name : <span class="asterisk">*</span></strong>
                              </td>
                              <td>
                                <input name="name" type="text" class="text" id="title" value="<?= $name; ?>" onChange="copySame('urlname', this.value);" 
                                required />
                              </td>
                            </tr>
                            <tr><td></td></tr>                           
                            <tr>
                              <td>&nbsp;</td>
                              <td class="tahomabold11"><strong> Alias Name : <span class="asterisk">*</span></strong></td>
                              <td>
                              	<div style="float:left"><label for="urlname"></label>
                                <input name="urlname" type="text" class="text" id="urlname" value="<?= $urlname; ?>" onChange="copySame('urlname', this.value);" onBlur="checkDiseaseUrlName('<?php echo $id; ?>', this.value, 'urlmsg');" required /></div>
                                <div style="padding-left:10px; float:left; width:150px;" id="urlmsg">&nbsp;</div></td>
                            </tr>
                            <tr><td></td></tr>
                            
                            <tr>
                              <td>&nbsp;</td>
                              <td class="tahomabold11">
                              	<strong> Cause :</strong>
                              </td>
                              <td>
                                <textarea name="cause" rows="4" cols="75"><?=$cause;?></textarea>
                              </td>
                            </tr>
                            <tr><td></td></tr>
                            
                            <tr>
                              <td>&nbsp;</td>
                              <td class="tahomabold11">
                              	<strong> Symptoms :</strong>
                              </td>
                              <td>
                                <textarea name="symptom" rows="4" cols="75"><?=$symptom;?></textarea>
                              </td>
                            </tr>
                            <tr><td></td></tr>
                            
                            <tr>
                              <td>&nbsp;</td>
                              <td class="tahomabold11">
                              	<strong> Prevention :</strong>
                              </td>
                              <td>
                                <textarea name="prevention" rows="4" cols="75"><?=$prevention;?></textarea>
                              </td>
                            </tr>
                            <tr><td></td></tr>
                            
                            <tr>
                              <td>&nbsp;</td>
                              <td class="tahomabold11">
                              	<strong> Treatment :</strong>
                              </td>
                              <td>
                                <textarea name="treatment" rows="4" cols="75"><?=$treatment;?></textarea>
                              </td>
                            </tr>
                            <tr><td></td></tr> 
                            
                            <tr>
                              <td></td>
                              <td class="tahomabold11"><strong>Summary :</strong></td>
                              <td>&nbsp;</td>
                            </tr>
                            <tr><td></td></tr>
                            <tr>
                              <td></td>
                              <td colspan="2" style="width:400px">
								<?php
									include ("../fckeditor/fckeditor.php");
									$sBasePath="../fckeditor/";
									
									$oFCKeditor = new FCKeditor('shortcontents');
									$oFCKeditor->BasePath	= $sBasePath ;
									$oFCKeditor->Value		= $shortcontents;
									$oFCKeditor->Height		= "200";
									$oFCKeditor->ToolbarSet	= "Rupens";	
									$oFCKeditor->Create();
								?>
                              </td>
                            </tr>
                            <tr><td></td></tr>
                            
                            <tr>
                              <td></td>
                              <td class="tahomabold11"><strong>Detail :</strong></td>
                              <td>&nbsp;</td>
                            </tr>
                            <tr><td></td></tr>
                            <tr>
                              <td></td>
                              <td colspan="2">
								<?php
									$oFCKeditor = new FCKeditor('contents');
									$oFCKeditor->BasePath	= $sBasePath ;
									$oFCKeditor->Value		= $contents;
									$oFCKeditor->Height		= "250";
									$oFCKeditor->ToolbarSet	= "Rupens";	
									$oFCKeditor->Create();
								?>
                              </td>
                            </tr>
                            <tr><td></td></tr>
                            
                            <tr>
                              <td></td>
                              <td class="tahomabold11"><strong>Publish :</strong></td>
                              <td>
                              	<label>
                                  <input name="publish" type="radio" id="featured_0" value="No" checked="checked" />
                                  No</label>
                                <label>
                                  <input type="radio" name="publish" value="Yes" id="featured_1" <? if($publish == 'Yes') echo 'checked="checked"';?> />
                                  Yes</label>
                              </td>
                            </tr>
                            <tr><td></td></tr>      
                           
                            <tr>
                              <td></td>
                              <td class="tahomabold11"><strong>Weight :</strong></td>
                              <?php
								if (!isset($weight))
								{
									$weight = $disease -> getLastWeight($_GET['cropId']);
									
								} ?>
                              <td><input name="weight" type="text" class="text" id="weight" value="<?php echo $weight; ?>" style="width:25px;" required /></td>
                            </tr>
                            <tr><td></td></tr>
                            
                            
							<? if(file_exists("../".CMS_GROUPS_DIR.$editRow['image']) and $editRow['image']!='' && $_GET['type'] == 'edit')
							{?>
                                <tr>
                                  <td></td>
                                  <td class="tahomabold11"><strong>Current Image : </strong></td>
                                  <td><img src="../data/imager.php?file=../<?= CMS_GROUPS_DIR.$editRow['image']; ?>&amp;mw=150&amp;mh=150" />
                                  [ <a href="disease.php?cropId=<?=$cropId;?>&type=removeImage&id=<?= $id?>">Remove Image</a>]</td>
                                </tr>
                                
                            <? }?>
                            <tr><td></td></tr>
                            <tr>
                              <td></td>
                              <td class="tahomabold11"><strong>Image :</strong></td>
                              <td><label for="image"></label>
                                <input type="file" name="image" id="image" /></td>
                            </tr>
                            <tr><td></td></tr>
                            
                            <tr>
                              <td></td>
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
        <tr>
          <td class="bgborder"><table width="100%" border="0" cellspacing="1" cellpadding="0">
              <tr>
                <td bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td class="heading2">
                      	<?php
						$cropId=$_GET['cropId'];
						if (!isset($_GET['cropId'])){
							echo "Showing Disease List";
						}
						else{
							$crop=mysqli_fetch_array(mysqli_query($GLOBALS["___mysqli_ston"], "select name from crop where id='$cropId'")); 
							echo "Disease List of " . $crop['name'];
						}
						?>
                      </td>
                    </tr>
                    <tr>
                      <td><table width="100%"  border="0" cellpadding="4" cellspacing="0">
                          <tr bgcolor="#F1F1F1" class="tahomabold11">
                            <td width="1">&nbsp;</td>
                            <td style="width:20px"><strong>Image</strong></td>
                            <td style="width:155px"> Disease </td>
                            <td style="width:75px">Crop</td>
                            <td style="width:10px;">Show</td>
                            <td style="width:10px">Weight</td>
                            <td style="width:73px"><strong>Action</strong></td>
                          </tr>
                          <?php
							if(isset($_GET['cropId']))
							{
								$counter = 0;
								$limit = 50;
								$sql = "SELECT * FROM disease where cropId='$cropId'";
								$sql=$sql." ORDER BY weight";
								include("paging.php");
								while($row = $conn -> fetchArray($result))
								{?>
                                    <tr <?php if($counter%2 != 0) echo 'bgcolor="#F7F7F7"'; else echo 'bgcolor="#FFFFFF"'; ?>>
                                        <td valign="top">&nbsp;</td>
                                        <td valign="top"><img src="../<?= CMS_GROUPS_DIR.$row['image']; ?>" width="40" height="30" /></td>
                                        <td valign="top"><?= $row['name'] ?></td>
                                        
                                        <td valign="top">
                                            <? $cropId=$row['cropId']; $crop=mysqli_fetch_array(mysqli_query($GLOBALS["___mysqli_ston"], "select name from crop where id='$cropId'")); 
                                            echo $crop['name'];?>
                                        </td>
                                       
                                        <td valign="top">
                                        <?
                                        $changeTo = 'Yes';
                                        if ($row['publish'] == 'Yes')
                                            $changeTo = 'No';
                                        ?>
                                        (<a href="disease.php?cropId=<?=$cropId;?>&type=tooglePublish&id=<?= $row['id']?>&changeTo=<?=$changeTo;?>"><?=$row['publish'];?></a>)</td>
                                        
                                        <td valign="top"><?= $row['weight'] ?></td>
                                        <td valign="top"> [ <a href="disease.php?cropId=<?=$cropId;?>&type=edit&id=<?= $row['id']?>">Edit</a> | <a href="#" onClick="javascript: if(confirm('This will permanently remove this Disease from database. Continue?')){ document.location='disease.php?cropId=<?=$cropId;?>&type=del&id=<?php echo $row['id']; ?>'; }">Delete</a> ]</td>
                              </tr>
                          		<? }
							}?>
                        
                        </table>
                      <?php include("paging_show.php"); ?></td>
                    </tr>
                  </table></td>
              </tr>
            </table></td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td colspan="2"><?php include("footer.php"); ?></td>
  </tr>
</table>
</body>
</html>