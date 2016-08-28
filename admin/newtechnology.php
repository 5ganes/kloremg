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
  $result = mysql_fetch_assoc(mysql_query("select * from newtechnology where id='$idd'"));
  extract($result);
  //extract($editRow);
}
if($_POST['type'] == "Save")
{
  extract($_POST);
  
  $pid = $newtechnology -> save($id, $cropId, $name, $description, $publish, $weight);
  if($id > 0)
    $pid = $id;
  if($id>0)
    header('Location: newtechnology.php?cropId='.$cropId.'&type=edit&id='.$id.'&msg=New Technology details updated successfully');
  else
    header('Location: newtechnology.php?cropId='.$cropId.'&msg=New Technology details saved successfully');
  exit(); 
}

if($_GET['type'] == "tooglePublish")
{
  $id = $_GET['id'];
  $changeTo = $_GET['changeTo'];
  
  $sql = "UPDATE newtechnology SET publish='$changeTo' WHERE id='$id'";
  $conn->exec($sql);
  header("location: newtechnology.php?&msg=Show/Hide status toogled successfully.");
  
}

if($_GET['type']=="del")
{
    $delid=$_GET['id'];
    mysql_query("delete from newtechnology where id='$delid'"); //$groups -> delete($_GET['id']);
    $cropId=$_GET['cropId'];
    ?>
      <script> document.location='newtechnology.php?cropId=<?=$cropId;?>&msg=Variety deleted successfully.' </script>    
<? }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<title><?php echo ADMIN_TITLE; ?></title>
<link href="../css/admin.css" rel="stylesheet" type="text/css">
<style type="text/css">
.t-text{width: 140px}
</style>
<script type="text/javascript" src="../js/cms.js"></script>
<script type="text/javascript" src="../js/jquery.min.js"></script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<script type="text/javascript" src="ckeditor/ckeditor.js"></script>

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
                      <td class="heading2">&nbsp; Manage New Technology
                        <div style="float: right;">
                      <?
              if($_GET['cropId']){ $cropId=$_GET['cropId'];}else{ $cropId="select";}
              $addNewLink = "newtechnology.php?cropId=$cropId";
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
                              <td class="tahomabold11" style="width: 190px" width="100"><strong> वाली छान्नुहोस् :</td>
                              <td>
                                <select name="cropId" onChange="changeNewTechnolgy(this);">
                                  <option value="select">Select Crop</option>
                  <?php
                  $crops=$crop->getCrops();
                  while($cropGet=$conn->fetchArray($crops))
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
                              <td class=""><strong> Name : <span class="asterisk">*</span></strong></td>
                              <td>
                                <input name="name" type="text" class="text" value="<?=$name?>" required />     
                              </td>
                            </tr>
                            <tr><td></td></tr>
                            
                            <tr>
                              <td>&nbsp;</td>
                              <td class="">
                                <strong> Description : <span class="asterisk">*</span></strong>
                              </td>
                              
                            </tr>
                            <tr>
                            <td colspan="20">
                            
                              <textarea id="description" name="description"><?=$description;?>
                              </textarea>
                              <script type="text/javascript">
                                //CKEDITOR.basepath = "/ckeditor/";
                                CKEDITOR.replace('description');
                              </script>    
                                  
                            </td>
                            </tr>
                            <tr><td></td></tr>
                            
                            <tr>
                              <td>&nbsp;</td>
                              <td class=""><strong> Publish :</strong></td>
                              <td>
                                <input type="radio" name="publish" value="Yes" checked="checked" /> Yes
                                <input type="radio" name="publish" value="No" <? if($publish=="No"){ echo 'checked="checked"';}?> /> No   
                              </td>
                            </tr>
                            <tr><td></td></tr>
                            
                            <tr>
                              <td>&nbsp;</td>
                              <td class=""><strong> Weight :</strong></td>
                              <?php
                if (!isset($weight))
                {
                  $weight = $newtechnology -> getLastWeight($_GET['cropId']);
                  
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
              echo "Showing Crop Technology List";
            }
            else{
              $crop=mysql_fetch_array(mysql_query("select name from crop where id='$cropId'")); 
              echo "Technology List of " . $crop['name'];
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
                            
                            <td style="width:150px">Upload Date</td>
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
                $pagename='newtechnology.php?cropId='.$cropId.'&';
                
                
                $sql = "SELECT newtechnology.id, newtechnology.name, newtechnology.onDate as onDate, newtechnology.publish as publish, newtechnology.weight 
                        FROM newtechnology
                        where newtechnology.cropId='$cropId'";
                $sql=$sql." ORDER BY weight";
                include("paging.php");
                while($row = $conn -> fetchArray($result))
                {?>
                  <tr <?php if($counter%2 != 0) echo 'bgcolor="#F7F7F7"'; else echo 'bgcolor="#FFFFFF"'; ?>>
                    <td valign="top">&nbsp;</td>
                    <td valign="top"><?php echo ++$counter;?></td>
                    <td valign="top"><?= $row['name'] ?></td>
                    
                    <td valign="top"><?=$row['onDate'];?></td>
                    <td valign="top"><?= $row['publish'] ?></td>
                    <td valign="top"><?= $row['weight'] ?></td>
                     
                    <td valign="top"> [ <a href="newtechnology.php?cropId=<?=$cropId?>&type=edit&id=<?= $row['id']?>">Edit</a> | <a href="#" 
                                        onClick="javascript: if(confirm('This will permanently remove this Technology from database. Continue?')){ 
                                        document.location='newtechnology.php?cropId=<?=$cropId?>&type=del&id=<?php echo $row['id']; ?>'; }">Delete</a> ]</td>
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