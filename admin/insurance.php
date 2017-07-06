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
$weight = $groups -> getInsuranceSubLastWeight();
//echo $weight;
if($_GET['type'] == "edit")
{
	$result = $groups->getInsuranceById($_GET['id']);
	$editRow = $conn->fetchArray($result);
	$d=$editRow['district']; //$dd=explode(",", $d); print_r($dd); die();
	$id=$editRow['id'];$bimak=$editRow['bimak'];$contactPerson=$editRow['contactPerson'];$contactPhone=$editRow['contactPhone'];
	$contactOffice=$editRow['contactOffice'];$publish=$editRow['publish'];$weight=$editRow['weight'];
	//extract($editRow);
}
if($_POST['type'] == "Save")
{
	extract($_POST);
	
	$pid = $groups -> saveInsurance($id, $bimak, $district, $contactPerson, $contactPhone, $contactOffice, $publish, $weight);

	if($id>0)
		header("Location: insurance.php?type=edit&id=$id&msg=Insurance details updated successfully");
	else
		header("Location: insurance.php?msg=Insurance details saved successfully");
	exit();
			
}
if($_GET['type']=="del")
{
		$groups -> deleteInsurance($_GET['id']);?>
    	<script> document.location='insurance.php?&msg=Insurance deleted successfully.' </script>    
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

<script src="../sumoselect/jquery.sumoselect.js"></script>
<link href="../sumoselect/sumoselect.css" rel="stylesheet" />
<script type="text/javascript">
	$(document).ready(function () {
		window.testSelAll2 = $('.testSelAll2').SumoSelect({selectAll:true });
	});
</script>
<script>
	function sumoSelect()
	{
		var district = [];
		$('.district').find('.selected').each(function(){
			district.push($(this).attr('data-val'));
		});
		district=district.toString();
		
		$('<input />').attr('type', 'hidden')
          .attr('name', "district")
          .attr('value', district)
          .appendTo('#myForm');
	    
		//alert(month); return false;
		return true;
	}
</script>

<style>
	.district p{width:150px;}
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
                      <td class="heading2">&nbsp; Manage Insurance Info
                        <div style="float: right;">
                          <?
							$addNewLink = "insurance.php";
						  ?>
                          <a href="<?= $addNewLink?>" class="headLink">Add New</a></div></td>
                    </tr>
                    <tr>
                      <td>
                      <form action="<?= $_REQUEST['uri']?>" method="post" enctype="multipart/form-data" id="myForm" onSubmit="sumoSelect();">
                      <table width="100%" border="0" cellpadding="2" cellspacing="0">
                          <?php if(!empty($errMsg)){ ?>
                          <tr align="left">
                            <td colspan="3" class="err_msg"><?php echo $errMsg; ?></td>
                          </tr>
                          <?php } ?>                          
                            <tr>
                              <td>&nbsp;</td>
                              <td class="tahomabold11"><strong> बिमक : <span class="asterisk">*</span></strong></td>
                              <td>
                                <input name="bimak" type="text" class="text" value="<?=$bimak;?>" 
                                required="required" />
                              </td>
                            </tr>
                            <tr><td></td></tr>                           
                            <tr>
                              <td>&nbsp;</td>
                              <td class="tahomabold11"><strong> तोकिएको जिल्ला : <span class="asterisk">*</span></strong></td>
                              <td>
                                <div class="district" style="width:35%; height:24px;" id="district">
                                    <select multiple="multiple" placeholder="Select District" class="testSelAll2" 
                                    onchange="console.log($(this).children(':selected').length)" required>
                                        <?
                                        $dist=$district->getDistricts(); $dd=explode(",", $d);
                                        while($distGet=$conn->fetchArray($dist))
                                        {?>
                                            <option value="<?=$distGet['name'];?>" <? if(in_array($distGet['name'],$dd)){?> selected="selected" <? }?>>
                                                <?=$distGet['name'];?>
                                            </option>
                                        <? }
                                        ?>
                                    </select>
                                </div>
                              </td>
                            </tr>
                            <tr><td></td></tr>
                            
                            <tr>
                              <td>&nbsp;</td>
                              <td class="tahomabold11"><strong> सम्पर्क गर्ने व्यक्ति : <span class="asterisk">*</span></strong></td>
                              <td>
                                <input name="contactPerson" type="text" class="text" value="<?= $contactPerson; ?>" 
                                required="required" />
                              </td>
                            </tr>
                            <tr><td></td></tr>
                            
                            <tr>
                              <td>&nbsp;</td>
                              <td class="tahomabold11"><strong> सम्पर्क नंबर : <span class="asterisk">*</span></strong></td>
                              <td>
                                <input name="contactPhone" type="text" class="text" value="<?= $contactPhone; ?>" 
                                required="required" /></td>
                            </tr>
                            <tr><td></td></tr>
                            
                            <tr>
                              <td>&nbsp;</td>
                              <td class="tahomabold11"><strong> सम्पर्क कार्यालय :</strong></td>
                              <td>
                                <input name="contactOffice" type="text" class="text" value="<?= $contactOffice; ?>" /></td>
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
                      <td class="heading2">&nbsp;Unsurance List</td>
                    </tr>
                    <tr>
                      <td><table width="100%"  border="0" cellpadding="4" cellspacing="0">
                          <tr bgcolor="#F1F1F1" class="tahomabold11">
                            <td width="1">&nbsp;</td>
							<td style="width:6px">SN</td>
                            <td style="width:148px"> Bimak </td>
                            <td style="width:10px;">Show</td>
                            <td style="width:10px">Weight</td>
                            <td style="width:73px"><strong>Action</strong></td>
                          </tr>
                          <?php
							$counter = 0;
							$pagename = "insurance.php?";
							$sql = "SELECT * FROM insurance";
							$sql .= " ORDER BY weight";
							//echo $sql;
							$limit = 50;
							include("paging.php"); $sn=1;
							while($row = $conn -> fetchArray($result))
							{?>
                          		<tr <?php if($counter%2 != 0) echo 'bgcolor="#F7F7F7"'; else echo 'bgcolor="#FFFFFF"'; ?>>
                                    <td valign="top">&nbsp;</td>
                                    <td><?=$sn; $sn++;?></td>
                                    <td valign="top"><?= $row['bimak'] ?></td>
                                    <td valign="top">
                            		<?
									$changeTo = 'Yes';
									if ($row['publish'] == 'Yes')
										$changeTo = 'No';
									?>
                              		(<?=$row['publish'];?>)</td>
                            		<td valign="top"><?= $row['weight'] ?></td>
                            		<td valign="top"> [ <a href="insurance.php?type=edit&id=<?= $row['id']?>">Edit</a> | <a href="#" onClick="javascript: if(confirm('This will permanently remove this Insurance from database. Continue?')){ document.location='insurance.php?type=del&id=<?php echo $row['id']; ?>'; }">Delete</a> ]</td>
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