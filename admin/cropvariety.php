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
	
//$weight = $cropvariety -> getLastWeight();
if($_GET['type'] == "edit")
{
	//echo "dfd"; 
	$idd=$_GET['id']; //echo $idd;
	$result = mysql_fetch_assoc(mysql_query("select * from cropvariety where id='$idd'"));
	extract($result);
	//extract($editRow);
}
if($_POST['type'] == "Save")
{
	extract($_POST);
	
	$pid = $cropvariety -> save($id, $name, $cropId, $productionTime, $recommendedArea, $recommendedDate, $productivity, $publish, $weight);
	if($id > 0)
		$pid = $id;
	if($id>0)
		header('Location: cropvariety.php?cropId='.$cropId.'&type=edit&id='.$id.'&msg=Variety details updated successfully');
	else
		header('Location: cropvariety.php?cropId='.$cropId.'&msg=Variety details saved successfully');
	exit();	
}

if($_GET['type'] == "tooglePublish")
{
	$id = $_GET['id'];
	$changeTo = $_GET['changeTo'];
	
	$sql = "UPDATE cropvariety SET publish='$changeTo' WHERE id='$id'";
	$conn->exec($sql);
	header("location: cropvariety.php?&msg=Variety Show/Hide status toogled successfully.");
	
}

if($_GET['type']=="del")
{
		$delid=$_GET['id'];
		mysql_query("delete from cropvariety where id='$delid'"); //$groups -> delete($_GET['id']);
		$cropId=$_GET['cropId'];
		?>
    	<script> document.location='cropvariety.php?cropId=<?=$cropId;?>&msg=Variety deleted successfully.' </script>    
<? }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<title><?php echo ADMIN_TITLE; ?></title>
<link href="../css/admin.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
.style1 {
	color: #FF0000
}
-->
</style>
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
                      <td class="heading2">&nbsp; Manage Crop Variety
                        <div style="float: right;">
                     	<?
							if($_GET['cropId']){ $cropId=$_GET['cropId'];}else{ $cropId="select";}
							$addNewLink = "cropvariety.php?cropId=$cropId";
						?>
                          <a href="<?= $addNewLink?>" class="headLink">Add New</a></div></td>
                    </tr>
                    <tr>
                      <td>
                      <form action="<?= $_REQUEST['uri']?>" method="post" enctype="multipart/form-data">
                      	<table width="100%" border="0" cellpadding="2" cellspacing="0">
                          <?php
                          if(!empty($errMsg))
						  {?>
                              <tr align="left">
                                <td colspan="3" class="err_msg"><?php echo $errMsg; ?></td>
                              </tr>
                          <? }?>
                          
                          <tr>
                              <td>&nbsp;</td>
                              <td class="tahomabold11"><strong> Select Crop :</td>
                              <td>
                              	<select name="cropId" onChange="changeVarietyCrop(this);">
                                	<option value="select">Select Crop</option>
									<?php
									$crop=$crop->getCrops();
									while($cropGet=$conn->fetchArray($crop))
									{?>
                                    	<option value="<?=$cropGet['id'];?>" <? if($cropId==$cropGet['id'] or $_GET['cropId']==$cropGet['id'])
										{ echo 'selected="selected"';}?>><?=$cropGet['name'];?></option>
                                	<? }?>		
                           	  	</select>
                              </td>
                            </tr>
                            <tr><td></td></tr>
                            
                            <? if(isset($_GET['cropId']) and $_GET['cropId']!="select")
							{?>
                                                    
                            <tr>
                              <td>&nbsp;</td>
                              <td class="tahomabold11"><strong> Variety Name : <span class="asterisk">*</span></strong></td>
                              <td>
                                <input name="name" type="text" class="text" value="<?=$name?>" required/>			
                           	  </td>
                            </tr>
                            <tr><td></td></tr>
                            
                            <tr>
                              <td>&nbsp;</td>
                              <td class="tahomabold11">
                              	<strong> Production Time : <span class="asterisk">*</span></strong>
                              </td>
                              <td>
                                <input name="productionTime" type="text" class="text" value="<?=$productionTime?>" required />			
                           	  </td>
                            </tr>
                            <tr><td></td></tr>
                            
                            <tr>
                              <td>&nbsp;</td>
                              <td class="tahomabold11"><strong> Recommended Area : <span class="asterisk">*</span></strong>
                              </td>
                              <td>
                              <input name="recommendedArea" type="text" class="text" value="<?=$recommendedArea?>" required />
                           	  </td>
                            </tr>
                            <tr><td></td></tr>
                            
                            <tr>
                              <td>&nbsp;</td>
                              <td class="tahomabold11">
                              	<strong> Recommended Date : <span class="asterisk">*</span></strong>
                              </td>
                              <td>
							  <input name="recommendedDate" type="text" class="text" value="<?=$recommendedDate?>" required />                              </td>
                            </tr>
                            <tr><td></td></tr>
                            
                            <tr>
                              <td>&nbsp;</td>
                              <td class="tahomabold11">
                              	<strong> Productivity :</strong>
                              </td>
                              <td>
							  	<input name="productivity" type="text" class="text" value="<?=$productivity?>" />
                              </td>
                            </tr>
                            <tr><td></td></tr>
                            
                            <tr>
                              <td>&nbsp;</td>
                              <td class="tahomabold11"><strong> Publish :</strong></td>
                              <td>
                              	<input type="radio" name="publish" value="Yes" checked="checked" /> Yes
                                <input type="radio" name="publish" value="No" <? if($publish=="No"){ echo 'checked="checked"';}?> /> No		
                           	  </td>
                            </tr>
                            <tr><td></td></tr>
                            
                            <tr>
                              <td>&nbsp;</td>
                              <td class="tahomabold11"><strong> Weight :</strong></td>
                              <?php
								if (!isset($weight))
								{
									$weight = $cropvariety -> getLastWeight($_GET['cropId']);
									
								} ?>
                              <td>
                                <input name="weight" type="text" class="text" value="<?=$weight?>"/>			
                           	  </td>
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
                        </form>
                   	  </td>
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
							echo "Showing Variety List";
						}
						else{
							$crop=mysql_fetch_array(mysql_query("select name from crop where id='$cropId'")); 
							echo "Variety List of " . $crop['name'];
						}
						?>
                  	  </td>
                    </tr>
                    <tr>
                      <td><table width="100%"  border="0" cellpadding="4" cellspacing="0">
                          <tr bgcolor="#F1F1F1" class="tahomabold11">
                            <td width="1">&nbsp;</td>
                            <td>SN</td>
                            <td style="width:155px">Name</td>
                            <td style="width:155px">Production Time</td>
                            <td style="width:155px">Recommended Area</td>
                            <td style="width:155px">Recommended Date</td>
                            <td style="width:150px">Productivity</td>
                            <td style="width:150px">Crop</td>
                            <td style="width:80px">Publish</td>
                            <td style="width:80px">Weight</td>
                            <td style="width:100px"><strong>Action</strong></td>
                          </tr>
                          <?php
							if(isset($_GET['cropId']))
							{
								$counter = 0;
								$limit = 50;
								//for pagename
								$cropId=$_GET['cropId'];
								$pagename='cropvariety.php?cropId='.$cropId.'&';
								
								
								$sql = "SELECT * FROM cropvariety where cropId='$cropId'";
								$sql=$sql." ORDER BY weight";
								include("paging.php");
								while($row = $conn -> fetchArray($result))
								{?>
									<tr <?php if($counter%2 != 0) echo 'bgcolor="#F7F7F7"'; else echo 'bgcolor="#FFFFFF"'; ?>>
										<td valign="top">&nbsp;</td>
										<td valign="top"><?php echo ++$counter;?></td>
										<td valign="top"><?= $row['name'] ?></td>
										<td valign="top"><?= $row['productionTime'] ?></td>
										<td valign="top"><?=$row['recommendedArea'];?></td>
										<td valign="top"><?=$row['recommendedDate'];?></td>
										<td valign="top"><?=$row['productivity'];?></td>
										<td valign="top">
											<? $cropId=$row['cropId'];
											$crop=mysql_fetch_array(mysql_query("select name from crop where 
											id='$cropId'")); echo $crop['name'];?>
										</td>
										<td valign="top"><?= $row['publish'] ?></td>
										<td valign="top"><?= $row['weight'] ?></td>
									   
										<td valign="top"> [ <a href="cropvariety.php?cropId=<?=$cropId?>&type=edit&id=<?= $row['id']?>">Edit</a> | <a href="#" 
                                        onClick="javascript: if(confirm('This will permanently remove this Variety from database. Continue?')){ 
                                        document.location='cropvariety.php?cropId=<?=$cropId?>&type=del&id=<?php echo $row['id']; ?>'; }">Delete</a> ]</td>
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
      </table></td>
  </tr>
  <tr>
    <td colspan="2"><?php include("footer.php"); ?></td>
  </tr>
</table>
</body>
</html>
<?php die(); ?>
<!--<a href="excel.php">Export to Excel</a>-->