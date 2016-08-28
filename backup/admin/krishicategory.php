<?php
include("init.php");
if(!isset($_SESSION['sessUserId']))//User authentication
{
	session_destroy();
 	header("Location: login.php");
 	exit();
}

if(isset($_POST['id']))
	$id = $_POST['id'];
elseif(isset($_GET['id']))
	$id = $_GET['id'];
else
	$id = 0;

$editable = true;
$weight=$diarycat->getLastWeight();

if(isset($_POST['btnSubmit']) || isset($_POST['btnChange']))
{
	extract($_POST);
	
	if(empty($name))
		$err = "<li>Please enter Category Name</li>";
	
	if(empty($err))
	{		
		$diarycat -> saveOrUpdate($id, $name, $publish, $weight);
		header("Location: krishicategory.php?msg=Category details added successfully");
		exit();
	}
}
elseif (isset($_GET['delete']))
{
	//echo $_GET['delete']; die();
	
	$diarycat->delete($_GET['delete']);
	header("Location: krishicategory.php?msg=Category details deleted successfully");
	
}
elseif($_GET['action'] == "edit")
{
	$row = $diarycat -> getById($id);
	extract($row);	
	
	//$editable = $diarycat -> isEditable($id);
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<title><?php echo ADMIN_TITLE; ?></title>
<link href="../css/admin.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="../js/jquery-1.8.2.min.js"></script>
<script type="text/javascript">
$(document).ready(function(e) {
  $("input[name='set']").change(function(e){
		if($("input:radio[name='set']:checked").val() == "yes")
			$("#setParameters").show();
		else
			$("#setParameters").hide();
	});
});
</script>
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
              <td bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td class="heading2">Manage Krishi Diary Category</td>
                  </tr>
                  <tr>
                    <td>
                    <form name="frmCategory" method="post" action="">
                    <table width="100%" border="0" cellspacing="0" cellpadding="2"> 
                    	<?php if(!empty($err)){ ?>
                      <tr>
                        <td colspan="2" class="err_msg"><?php echo $err; ?></td>
                      </tr>
                      <?php } ?>                   	
                      
                      <tr>
                     	<td width="15%"><strong>Category Name :</strong></td>
						<td><input type="text" name="name" value="<?php echo $name; ?>" class="text" /></td>
                      </tr>
                      
                      <tr>
                      	  <td width="15%"><strong>Publish :</strong></td>
                          <td>
                           		<label>
                                <input name="publish" type="radio" id="featured_0" value="No" checked="checked" />
                                    No
                                </label>
                                <label>
                                <input type="radio" name="publish" value="Yes" id="featured_1" <? if($publish == 'Yes') 
                                echo 'checked="checked"';?> />
                                  Yes
                                </label>
                       		</td>
                      </tr>
                      
                      <tr>
                     	<td width="15%"><strong>Weight :</strong></td>
						<td><input type="text" name="weight" value="<?php echo $weight; ?>" class="text" /></td>
                      </tr>
                      
                      
                      <tr>
                        <td valign="top">&nbsp;</td>
                        <td valign="top">
                          <?php if(isset($_GET['action']) && $_GET['action'] == "edit"){ ?>
                          <input type="hidden" name="id" value="<?php echo $id; ?>" />
                          <input type="submit" name="btnChange" value="Change" class="btn_submit" />
                          <?php } else { ?>
                          <input type="submit" name="btnSubmit" value="Save" class="btn_submit" />
                          <?php } ?>
                          </td>
                      </tr>
                    </table>
                    </form>
                    </td>
                  </tr>
              </table></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="5"></td>
        </tr>
        <tr>
          <td class="bgborder"><table width="100%" border="0" cellspacing="1" cellpadding="0">
              <tr>
                <td bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td class="heading2">Krishi Categories</td>
                    </tr>
                    <tr>
                      <td>
                      	<table width="100%"  border="0" cellpadding="4" cellspacing="0">
                  			<tr bgcolor="#F1F1F1">
                            	<td width="1">&nbsp;</td>
                            	<td width="10%"><strong>SN</strong></td>
                            	<td><strong>Category Name</strong></td>
                                <td><strong>Publish</strong></td>
                                <td><strong>Weight</strong></td>
                            	<td width="130"><strong>Action</strong></td>
                          	</tr>
						    
                            <?
							$count=1;
							$sql=mysqli_query($GLOBALS["___mysqli_ston"], "select * from diarycategories order by weight");
							while($data=$conn->fetchArray($sql))
							{ extract($data);?>
                           	<tr>
                            	<td></td>
                            	<td><?=$count++;?></td>
                                <td><?=$name;?></td>
                                <td><?=$publish;?></td>
                                <td><?=$weight;?></td>
                                <td>
                                	[ 
                                    <a href="krishicategory.php?action=edit&id=<?=$id;?>">Edit</a> | 
                                    <a href="#" onClick="javascript: if(confirm('This will permanently delete Category details from database. Continue?')){ document.location='krishicategory.php?delete=<?php echo $id; ?>'; }">Delete</a> 
                                    ]
                                </td>
                            </tr>
							<? }?>  
                        </table>
                        </td>
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