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
  $result = mysql_fetch_assoc(mysql_query("select * from croptechnology where id='$idd'"));
  extract($result);
  //extract($editRow);
}
if($_POST['type'] == "Save")
{
  extract($_POST);
  
  $pid = $croptechnology -> save($id, $cropId, $cropvarietyId, $highMountain, $mediumMountain, $tarai, $fertilizer, $dyandyan, $plantplant, $seedRate, $publish, $weight);
  if($id > 0)
    $pid = $id;
  if($id>0)
    header('Location: croptechnology.php?cropId='.$cropId.'&type=edit&id='.$id.'&msg=Technology details updated successfully');
  else
    header('Location: croptechnology.php?cropId='.$cropId.'&msg=Technology details saved successfully');
  exit(); 
}

if($_GET['type'] == "tooglePublish")
{
  $id = $_GET['id'];
  $changeTo = $_GET['changeTo'];
  
  $sql = "UPDATE croptechnology SET publish='$changeTo' WHERE id='$id'";
  $conn->exec($sql);
  header("location: croptechnology.php?&msg=Technology Show/Hide status toogled successfully.");
  
}

if($_GET['type']=="del")
{
    $delid=$_GET['id'];
    mysql_query("delete from croptechnology where id='$delid'"); //$groups -> delete($_GET['id']);
    $cropId=$_GET['cropId'];
    ?>
      <script> document.location='croptechnology.php?cropId=<?=$cropId;?>&msg=Variety deleted successfully.' </script>    
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
                      <td class="heading2">&nbsp; Manage Crop Technology
                        <div style="float: right;">
                      <?
              if($_GET['cropId']){ $cropId=$_GET['cropId'];}else{ $cropId="select";}
              $addNewLink = "croptechnology.php?cropId=$cropId";
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
                                <select name="cropId" onChange="changeCropTechnolgyy(this);">
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
                              <td class=""><strong> वालीको जात : <span class="asterisk">*</span></strong></td>
                              <td>
                                <select name="cropvarietyId">                               
                                    <?php
                                    $cropvty=$cropvariety->getCropVariety();

                                    while($cropvtyGet=$conn->fetchArray($cropvty))
                                    {?>
                                      <option value="<?=$cropvtyGet['id'];?>" <? if($cropvarietyId==$cropvtyGet['id'])
                                      { echo 'selected="selected"';}?>><?=$cropvtyGet['name'];?></option>
                                    <? }?>    
                                </select>     
                              </td>
                            </tr>
                            <tr><td></td></tr>
                            
                            <tr>
                              <td>&nbsp;</td>
                              <td class="">
                                <strong> बेर्ना सार्ने समय : <span class="asterisk">*</span></strong>
                              </td>
                              <td>
                                उच्च पहाड <input name="highMountain" type="text" class="t-text" value="<?=$highMountain?>" required />
                                मध्य पहाड <input name="mediumMountain" type="text" class="t-text" value="<?=$mediumMountain?>" required />
                                तराई <input name="tarai" type="text" class="t-text" value="<?=$tarai?>" required />      
                              </td>
                            </tr>
                            <tr><td></td></tr>
                            
                            <tr>
                              <td>&nbsp;</td>
                              <td class=""><strong> मलखाद के जी / रो. : <span class="asterisk">*</span></strong>
                              </td>
                              <td>
                                <input name="fertilizer" type="text" class="text" value="<?=$fertilizer?>" required />
                              </td>
                            </tr>
                            <tr><td></td></tr>
                            
                            <tr>
                              <td>&nbsp;</td>
                              <td class="">
                                <strong> बेर्ना लगाउने दुरी (से मी) : <span class="asterisk">*</span></strong>
                              </td>
                              <td>
                                ड्याङ्ग ड्याङ्ग <input name="dyandyan" type="text" class="t-text" value="<?=$dyandyan?>" required />
                                बोट बोट <input name="plantplant" type="text" class="t-text" value="<?=$plantplant?>" required />
                              </td>
                            </tr>
                            <tr><td></td></tr>
                            
                            <tr>
                              <td>&nbsp;</td>
                              <td class="">
                                <strong> बिउ / बेर्ना डर (ग्राम वा संख्या) :</strong>
                              </td>
                              <td>
                                <input name="seedRate" type="text" class="t-text" value="<?=$seedRate?>" required />
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
                  $weight = $croptechnology -> getLastWeightCropTechnology($_GET['cropId']);
                  
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
                            <td style="width:155px">वालीको जात</td>
                            <td style="width:155px">बिउ / बेर्ना डर (ग्राम वा संख्या)</td>
                            
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
                $pagename='croptechnology.php?cropId='.$cropId.'&';
                
                
                $sql = "SELECT croptechnology.id, seedRate, croptechnology.onDate as onDate, croptechnology.publish as publish, croptechnology.weight, 
                        cropvariety.name as variety 
                        FROM croptechnology 
                        INNER JOIN cropvariety on croptechnology.cropvarietyId=cropvariety.id
                        where croptechnology.cropId='$cropId'";
                $sql=$sql." ORDER BY weight";
                include("paging.php");
                while($row = $conn -> fetchArray($result))
                {?>
                  <tr <?php if($counter%2 != 0) echo 'bgcolor="#F7F7F7"'; else echo 'bgcolor="#FFFFFF"'; ?>>
                    <td valign="top">&nbsp;</td>
                    <td valign="top"><?php echo ++$counter;?></td>
                    <td valign="top"><?= $row['variety'] ?></td>
                    <td valign="top"><?= $row['seedRate'] ?></td>
                    <td valign="top"><?=$row['onDate'];?></td>
                    <td valign="top"><?= $row['publish'] ?></td>
                    <td valign="top"><?= $row['weight'] ?></td>
                     
                    <td valign="top"> [ <a href="croptechnology.php?cropId=<?=$cropId?>&type=edit&id=<?= $row['id']?>">Edit</a> | <a href="#" 
                                        onClick="javascript: if(confirm('This will permanently remove this Technology from database. Continue?')){ 
                                        document.location='croptechnology.php?cropId=<?=$cropId?>&type=del&id=<?php echo $row['id']; ?>'; }">Delete</a> ]</td>
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