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
	
$weight = $district -> getLastWeight();
if($_GET['type'] == "edit")
{
	//echo "dfd"; 
	$idd=$_GET['id']; //echo $idd;
	$result = mysqli_fetch_assoc(mysqli_query($GLOBALS["___mysqli_ston"], "select * from district where id='$idd'"));
	extract($result);
	//extract($editRow);
}
if($_POST['type'] == "Save")
{
	extract($_POST);
	//echo $id;
	$vall="";
	if(empty($name))
		$errMsg .= "<li>Please enter District</li>";
	if(empty($code))
		$errMsg .= "<li>Please enter District Code</li>";
	if(empty($ecozone))
		$errMsg .= "<li>Please Select Ecological Zone</li>";
		
	if(empty($devregion))
		$errMsg .= "<li>Please Select Development Region</li>";
	if(empty($errMsg))
	{
		$pid = $district -> save($id, $name, $code, $ecozone, $devregion, $publish, $weight);
		if($id > 0)
			$pid = $id;
		if($id>0)
			header("Location: district.php?type=edit&id=$id&msg=District details updated successfully");
		else
			header("Location: district.php?msg=District details saved successfully");
		exit();
	}		
}

if($_GET['type'] == "tooglePublish")
{
	$id = $_GET['id'];
	$changeTo = $_GET['changeTo'];
	
	$sql = "UPDATE district SET publish='$changeTo' WHERE id='$id'";
	$conn->exec($sql);
	header("location: district.php?&msg=District Show/Hide status toogled successfully.");
	
}

if($_GET['type']=="del")
{
		$delid=$_GET['id'];
		mysqli_query($GLOBALS["___mysqli_ston"], "delete from district where id='$delid'"); //$groups -> delete($_GET['id']);
		//echo "hello";
		//header("Location : district.php?&msg=product deleted successfully.");?>
    	<script> document.location='district.php?&msg=District deleted successfully.' </script>    
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
                      <td class="heading2">&nbsp; Manage District
                        <div style="float: right;">
                     	<?
							$addNewLink = "district.php";
							//if(isset($_GET['category']) && !empty($_GET['category']))
								//$addNewLink .= "?category=".$_GET['category'];
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
                              <td class="tahomabold11"><strong> District Name : <span class="asterisk">*</span></strong></td>
                              <td><label for="title"></label>
                                <input name="name" type="text" class="text" value="<?=$name?>"/>			
                           	  </td>
                            </tr>
                            <tr><td></td></tr>
                            
                            <tr>
                              <td>&nbsp;</td>
                              <td class="tahomabold11"><strong> District Code : <span class="asterisk">*</span></strong></td>
                              <td>
                                <input name="code" type="text" class="text" value="<?=$code?>"/>			
                           	  </td>
                            </tr>
                            <tr><td></td></tr>
                            
                            <tr>
                              <td>&nbsp;</td>
                              <td class="tahomabold11"><strong> Ecological Zone : <span class="asterisk">*</span></strong>
                              </td>
                              <td>
                              	<select name="ecozone">
                                	<option value="तराइ"><? echo html_entity_decode("तराइ");?></option>
                                	<option value="पहाड" <? if($ecozone=="पहाड"){ echo 'selected="selected"';}?>>
                                    	पहाड
                                   	</option>
                                	<option value="हिमाल" <? if($ecozone=="हिमाल"){ echo 'selected="selected"';}?>>
                                    	हिमाल
                                  	</option>
                                </select>
                           	  </td>
                            </tr>
                            <tr><td></td></tr>
                            
                            <tr>
                              <td>&nbsp;</td>
                              <td class="tahomabold11">
                              	<strong> Development Region : <span class="asterisk">*</span></strong>
                              </td>
                              <td>
								   <select name="devregion">
                                        <option value="पूर्वाञ्चल विकास क्षेत्र" selected="selected">पूर्वाञ्चल विकास क्षेत्र</option>
                                        <option value="मध्यमाञ्चल विकास क्षेत्र" <? if($devregion=="मध्यमाञ्चल विकास क्षेत्र"){ echo 'selected="selected"';}?>>
                                            मध्यमाञ्चल विकास क्षेत्र
                                        </option>
                                        <option value="पश्चिमाञ्चल विकास क्षेत्र" <? if($devregion=="पश्चिमाञ्चल विकास क्षेत्र"){ echo 'selected="selected"';}?>>
                                            पश्चिमाञ्चल विकास क्षेत्र
                                        </option>
                                        <option value="मध्य-पश्चिमाञ्चल विकास क्षेत्र" <? if($devregion=="मध्य-पश्चिमाञ्चल विकास क्षेत्र"){ echo 'selected="selected"';}?>>
                                            मध्य-पश्चिमाञ्चल विकास क्षेत्र
                                        </option>
                                        <option value="सुदूर-पश्चिमाञ्चल विकास क्षेत्र" <? if($devregion=="सुदूर-पश्चिमाञ्चल विकास क्षेत्र"){ echo 'selected="selected"';}?>>
                                            सुदूर-पश्चिमाञ्चल विकास क्षेत्र
                                        </option>
                                    </select>                            
                              </td>
                            </tr>
                            <tr><td></td></tr>
                            
                            <tr>
                              <td>&nbsp;</td>
                              <td class="tahomabold11"><strong> Publish : <span class="asterisk">*</span></strong></td>
                              <td>
                              	<input type="radio" name="publish" value="Yes" checked="checked" /> Yes
                                <input type="radio" name="publish" value="No" 
								<? if($publish=="No"){ echo 'checked="checked"';}?> /> No		
                           	  </td>
                            </tr>
                            <tr><td></td></tr>
                            
                            <tr>
                              <td>&nbsp;</td>
                              <td class="tahomabold11"><strong> Weight : <span class="asterisk">*</span></strong></td>
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
                        </table>
                        </form></td>
                    </tr>
                  </table></td>
              </tr>
			
              <tr height="5"><td></td></tr>
        	<tr>
          <td class="bgborder"><table width="100%" border="0" cellspacing="1" cellpadding="0">
              <tr>
                <td bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td class="heading2">&nbsp;District Lists</td>
                    </tr>
                    <tr>
                      <td><table width="100%"  border="0" cellpadding="4" cellspacing="0">
                          <tr bgcolor="#F1F1F1" class="tahomabold11">
                            <td width="1">&nbsp;</td>
                            <td>SN</td>
                            <td style="width:155px"> District </td>
                            <td style="width:155px"> Code </td>
                            <td style="width:155px"> Eco Zone </td>
                            <td style="width:155px"> Dev Region </td>
                            <td style="width:155px"> Publish </td>
                            <td style="width:155px"> Weight </td>
                            <td style="width:120px"><strong>Action</strong></td>
                          </tr>
                          <?php
							$counter = 0;
							$pagename = "district.php?";
							$sql = "SELECT * FROM district";
							$sql .= " ORDER BY weight";
							//echo $sql;
							$limit = 100;
							include("paging.php");
							while($row = $conn -> fetchArray($result))
							{?>
                          		<tr <?php if($counter%2 != 0) echo 'bgcolor="#F7F7F7"'; else echo 'bgcolor="#FFFFFF"'; ?>>
                                    <td valign="top">&nbsp;</td>
                                    <td valign="top"><?php echo ++$counter;?></td>
                                    <td valign="top"><?= $row['name'] ?></td>
                                    <td valign="top"><?= $row['code'] ?></td>
                                    <td valign="top"><?=$row['ecozone'];?></td>
                                   	<td valign="top"><?=$row['devregion'];?></td>
                                    <td valign="top"><?= $row['publish'] ?></td>
                                    <td valign="top"><?= $row['weight'] ?></td>
                                   
                            		<td valign="top"> [ <a href="district.php?type=edit&id=<?= $row['id']?>">Edit</a> | <a href="#" onClick="javascript: if(confirm('This will permanently remove this district from database. Continue?')){ document.location='district.php?type=del&id=<?php echo $row['id']; ?>'; }">Delete</a> ]</td>
                          </tr>
                          <?
													}
													?>
                        </table>
                      <?php //include("paging_show.php"); ?></td>
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
<!--<a href="excel.php">Export to Excel</a>-->