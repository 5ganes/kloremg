<?php
include("init.php");
if(!isset($_SESSION['sessUserId']))//User authentication
{
 header("Location: login.php");
 exit();
}

$cat=$_GET['categoryid'];

if(isset($_POST['id']))
	$id = $_POST['id'];
elseif(isset($_GET['id']))
	$id = $_GET['id'];
else
	$id = 0;

if(isset($_POST['regionId']))
	$regionId = $_POST['regionId'];
elseif(isset($_GET['regionId']))
	$regionId = $_GET['regionId'];
else
	$regionId = 0;

if(isset($_POST['categoryId']))
	$categoryId = $_POST['categoryId'];
elseif(isset($_GET['categoryId']))
	$categoryId = $_GET['categoryId'];
else
	$categoryId = 0;

//$weight = $groups -> getSubLastWeight(0, "Product");

if($_GET['type'] == "edit")
{
	$result = $groups->getById($_GET['id']);
	$editRow = $conn->fetchArray($result);	
	extract($editRow);
}
if($_POST['type'] == "Save")
{
	extract($_POST);
	
	//echo $vall;
	//print_r($_POST); die();

	if(empty($title))
		$errMsg .= "<li>Please enter Product Title</li>";
	
	if(empty($weight))
		$errMsg .= "<li>Please Enter product Weight</li>";
	
	if(empty($errMsg))
	{
		$pid = $groups -> saveProductWeight($id, $title, $code, $weight);
		
		if($id>0)
			header("Location: productsort.php?categoryid=$cat&type=edit&id=$id&msg=Product weight updated successfully");
		exit();
	}		
}

if($_GET['type'] == "toogle")
{
	if($package->toggleStatus($_GET['id']) > 0)
		header("location: productsort.php?categoryid=$cat&msg=Product status toogled successfully.");
}

if($_GET['type'] == "toogleFeatured")
{
	$id = $_GET['id'];
	$changeTo = $_GET['changeTo'];
	$sql = "UPDATE groups SET featured='$changeTo' WHERE id='$id'";
	$conn->exec($sql);
	header("location: productsort.php?categoryid=$cat&msg=Product feature status toogled successfully.");
}

if($_GET['type'] == "tooglePublish")
{
	$id = $_GET['id'];
	$changeTo = $_GET['changeTo'];
	$sql = "UPDATE groups SET publish='$changeTo' WHERE id='$id'";
	$conn->exec($sql);
	header("location: productsort.php?categoryid=$cat&msg=product Show/Hide status toogled successfully.");
}

if($_GET['type']=="del")
{
		$groups -> delete($_GET['id']);
		//echo "hello";
		//header("Location : product.php?&msg=product deleted successfully.");?>
    	<script> document.location='productsort.php?categoryid=<?=$cat?>&msg=Product deleted successfully.' </script>    
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
                      <td class="heading2">&nbsp; Manage Category Product Weights: 
                        <div style="float: right;">
                          <?
														$addNewLink = "productsort.php";
													if(isset($_GET['category']) && !empty($_GET['category']))
														$addNewLink .= "?category=".$_GET['category'];
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
                              <td class="tahomabold11"><strong> Product Name : <span class="asterisk">*</span></strong></td>
                              <td><label for="title"></label>
                                <input name="title" type="text" class="text" id="title" value="<?= $name; ?>" onChange="copySame('urlname', this.value);" /></td>
                            </tr>
                            <tr><td></td></tr>
                            
                            <tr>
                              <td></td>
                              <td class="tahomabold11"><strong>Product Code : <span class="asterisk">*</span></strong></td>
                              <td>
                              		<input type="text" name="code" value="<?=$code;?>" /> 
                              </td>
                            </tr>
                            
                            <tr><td></td></tr>
                            
                            <tr>
                              <td></td>
                              <td class="tahomabold11"><strong>Weight :</strong></td>
                              <td><input name="weight" type="text" class="text" id="weight" value="<?php echo $weight; ?>" style="width:100px;" /></td>
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
            </table></td>
        </tr>
        <tr height="5"><td></td></tr>
        <tr>
          <td class="bgborder"><table width="100%" border="0" cellspacing="1" cellpadding="0">
              <tr>
                <td bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <? $catName=mysqli_query($GLOBALS["___mysqli_ston"], "select * from groups where id='$cat'"); $catName=mysqli_fetch_array($catName); $catName=$catName['name']; ?>
                      <td class="heading2">&nbsp;Product Lists: <?=$catName;?></td>
                    </tr>
                    <tr>
                      <td><table width="100%"  border="0" cellpadding="4" cellspacing="0">
                          <tr bgcolor="#F1F1F1" class="tahomabold11">
                            <td width="1">&nbsp;</td>
                            <td style="width:20px"><strong>Image</strong></td>
                            <td style="width:155px"> Product </td>
                            <td style="width:75px">Block</td>
                            <td style="width:100px">Category</td>
                            <td style="width:50px;">Code</td>
                            <td style="width:50px;">Price</td>
                            <td style="width:10px;">Show</td>
                            <td style="width:10px">Featured</td>
                            <td style="width:10px">Weight</td>
                            <td style="width:73px"><strong>Action</strong></td>
                          </tr>
                          <?php
							$counter = 0;
							$pagename = "productsort.php?";
							$sql = "SELECT * FROM groups WHERE linkType = 'Product' and activity='$catName'";
							$sql .= " ORDER BY weight";
							//echo $sql;
							$limit = 100;
							include("paging.php");
							while($row = $conn -> fetchArray($result))
							{?>
                          		<tr <?php if($counter%2 != 0) echo 'bgcolor="#F7F7F7"'; else echo 'bgcolor="#FFFFFF"'; ?>>
                                    <td valign="top">&nbsp;</td>
                                    <td valign="top"><img src="../<?= CMS_GROUPS_DIR.$row['image']; ?>" width="40" height="30" /></td>
                                    <td valign="top"><?= $row['name'] ?></td>
                                    
                                    <td valign="top"><?=$row['block'];?></td>
                                    <td valign="top"><?=$row['activity'];?></td>
                                    <td valign="top"><?=$row['code'];?></td>
                                    <td valign="top"><?=$row['price'];?></td>
                                    
                                    <td valign="top">
                            		<?
									$changeTo = 'Yes';
									if ($row['publish'] == 'Yes')
										$changeTo = 'No';
									?>
                              		(<a href="productsort.php?categoryid=<?=$cat?>&type=tooglePublish&id=<?= $row['id']?>&changeTo=<?=$changeTo;?>"><?=$row['publish'];?></a>)</td>
                                    
                                    <td valign="top">
                            		<?
									$changeTo = 'Yes';
									if ($row['featured'] == 'Yes')
										$changeTo = 'No';
									?>
                              (<a href="productsort.php?categoryid=<?=$cat?>&type=toogleFeatured&id=<?= $row['id']?>&changeTo=<?=$changeTo;?>"><?=$row['featured'];?></a>)</td>
                              
                            		<td valign="top"><?= $row['weight'] ?></td>
                            		<td valign="top"> [ <a href="productsort.php?categoryid=<?=$cat?>&type=edit&id=<?= $row['id']?>">Edit</a> | <a href="#" onClick="javascript: if(confirm('This will permanently remove this product from database. Continue?')){ document.location='productsort.php?categoryid=<?=$cat?>&type=del&id=<?php echo $row['id']; ?>'; }">Delete</a> ]</td>
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