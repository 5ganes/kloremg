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
$weight = $undp -> getSuccessstoriesSubLastWeight();
//echo $weight;
if($_GET['type'] == "edit")
{
	$result = $undp->getSuccessstoriesById($_GET['id']);
	$editRow = $conn->fetchArray($result);
	extract($editRow);
}
if($_POST['type'] == "Save")
{
	extract($_POST);
	$pid = $undp -> saveSuccessstories($id, $name, $description, $publish, $weight);

	if($id>0)
		header("Location: successstories.php?type=edit&id=$id&msg=Success Story details updated successfully");
	else
		header("Location: successstories.php?msg=Success Story details saved successfully");
	exit();
			
}
if($_GET['type']=="del")
{
		$undp -> deleteSuccessstories($_GET['id']);?>
    	<script> document.location='successstories.php?&msg=Success Story deleted successfully.' </script>    
<? }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<title><?php echo ADMIN_TITLE; ?></title>
<link href="../css/admin.css" rel="stylesheet" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<!--for date picker-->
<script type="text/javascript" src="datepicker/jquery.js"></script>
<script type="text/javascript" src="datepicker/nepali.datepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="datepicker/nepali.datepicker.css" />
<script>
	$(document).ready(function(){
		$('.nepali-calendar').nepaliDatePicker();
		$('.collectedDate').nepaliDatePicker();
	});
</script>
<!--end date picker-->

<script type="text/javascript" src="../js/cms.js"></script>
<script type="text/javascript" src="../js/jquery.min.js"></script>

<style>
	.district p{width:150px;}
	.tahomabold11{width:180px;}
</style>

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
                      <td class="heading2">&nbsp; Manage  Success Stories
                        <div style="float: right;">
                          <?
							$addNewLink = "successstories.php";
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
                            <tr><td></td></tr>
                            <tr>
                              <td>&nbsp;</td>
                              <td class="tahomabold11"><strong> Name : <span class="asterisk">*</span></strong></td>
                              <td>
                                <input name="name" type="text" class="text" value="<?=$name;?>" required="required" />
                              </td>
                            </tr>
                            <tr><td></td></tr>
                            
                            <tr>
                              <td></td>
                              <td class="tahomabold11"><strong>Story :</strong></td>
                              <td>&nbsp;</td>
                            </tr>
                            <tr><td></td></tr>
                            <tr>
                              <td></td>
                              <td colspan="2">
								<?php
									include ("../fckeditor/fckeditor.php");
									$sBasePath="../fckeditor/";		
									$oFCKeditor = new FCKeditor('description');
									$oFCKeditor->BasePath	= $sBasePath ;
									$oFCKeditor->Value		= $description;
									$oFCKeditor->Height		= "200";
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
                              <td><input name="weight" type="text" class="text" id="weight" value="<?php echo $weight; ?>" style="width:25px;" /></td>
                            </tr>
                            <tr><td></td></tr>
							
                            <tr>
                              <td></td>
                              <td></td>
                              <td>
                              	<input name="type" type="submit" class="button" id="button" value="Save" />
                              	<?php if($_GET['type'] == "edit"){?>
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
            </table></td>
        </tr>
        <tr height="5"><td></td></tr>
        <tr>
          <td class="bgborder"><table width="100%" border="0" cellspacing="1" cellpadding="0">
              <tr>
                <td bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td class="heading2">&nbsp;Success Stories List</td>
                    </tr>
                    <tr>
                      <td><table width="100%"  border="0" cellpadding="4" cellspacing="0">
                          <tr bgcolor="#F1F1F1" class="tahomabold11">
                            <td width="1">&nbsp;</td>
							<td style="width:6px">SN</td>
                            <td style="width:148px"> Name </td>
                            <td style="width:200px"> Story </td>
                            <td style="width:10px;">Show</td>
                            <td style="width:10px">Weight</td>
                            <td style="width:73px"><strong>Action</strong></td>
                          </tr>
                          <?php
							$counter = 0;
							$pagename = "successstories.php?";
							$sql = "SELECT * FROM successstories";
							$sql .= " ORDER BY weight";
							//echo $sql;
							$limit = 50;
							include("paging.php"); $sn=1;
							while($row = $conn -> fetchArray($result))
							{?>
                          		<tr <?php if($counter%2 != 0) echo 'bgcolor="#F7F7F7"'; else echo 'bgcolor="#FFFFFF"'; ?>>
                                    <td valign="top">&nbsp;</td>
                                    <td><?=$sn; $sn++;?></td>
                                    <td valign="top"><?= $row['name'] ?></td>
                                    <td valign="top"><?= substr(strip_tags($row['description']),0,100); ?></td>
                                    <td valign="top">
                            		<?
									$changeTo = 'Yes';
									if ($row['publish'] == 'Yes')
										$changeTo = 'No';
									?>
                              		(<?=$row['publish'];?>)</td>
                            		<td valign="top"><?= $row['weight'] ?></td>
                            		<td valign="top"> [ <a href="successstories.php?type=edit&id=<?= $row['id']?>">Edit</a> | <a href="#" onClick="javascript: if(confirm('This will permanently remove this Success Story from database. Continue?')){ document.location='successstories.php?type=del&id=<?php echo $row['id']; ?>'; }">Delete</a> ]</td>
                          </tr>
                          <?
													}
													?>
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