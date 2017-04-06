<?php 

include("../admin/init.php");



if(!isset($_SESSION['sessMgrId'])){   //User authentication

  header("Location: mgrlogin.php");

  exit();

}

$id=$_GET['id'];  





if($_POST['type'] == "Update")

{

  

  extract($_POST);

  

  if(empty($errMsg))

  {

    //echo "jj"; echo $contents." ".$id; die();

    $pid = $information -> updateInformation($id,$contents); //$id, $name, $contents, $districtIds, $cropId, $userId, $publish

    if($id>0)

      header("Location: index.php?type=edit&id=$id&msg=Information details updated successfully");

  }

}

if($_GET['type']=="status")

{ 

  $cdetail = $information -> updateStatus($id);

  header("Location: index.php?msg=Information status changed successfully");

  exit();

}

elseif($_GET['type']=="show" )

{ 

  $cdetail = $information -> getById($id);

}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html>

<head>

<title><?php echo ADMIN_TITLE; ?></title>

<link href="../css/admin.css" rel="stylesheet" type="text/css">

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

</head>

<body>

<table width="<?php echo ADMIN_PAGE_WIDTH; ?>" border="0" align="center" cellpadding="0"

  cellspacing="5" bgcolor="#FFFFFF">

  <tr>

    <td colspan="2"><?php include("../admin/header.php"); ?></td>

  </tr>

  <tr>

    <td width="<?php echo ADMIN_LEFT_WIDTH; ?>" valign="top"><?php include("leftnav.php"); ?></td>

    <td width="<?php echo ADMIN_BODY_WIDTH; ?>" valign="top"><table width="100%" border="0" cellspacing="1" cellpadding="0">

  <? if(isset($_GET['type']) && $_GET['type'] == "show")

  { ?>

        <tr>

          <td class="bgborder"><table width="100%" border="0" cellspacing="1" cellpadding="0">

            <tr>

              <td bgcolor="#FFFFFF">

              <table width="100%" border="0" cellspacing="0" cellpadding="0">

                  <tr>

                    <td class="heading2">&nbsp;Information Details</td>

                  </tr>

                  <tr>

                    <td><table width="100%" border="0" cellspacing="1" cellpadding="4">

                      <tr><td><strong>Sender:</strong></td>

                        <td>

              <? $sender=$cdetail['userId']; $s=mysql_query("select name from usergroups where id='$sender'");

              $sGet=mysql_fetch_array($s); echo $sGet['name']; //$cdetail['sender'];

              ?>

                        </td>

                      </tr>

                      <tr>

                        

                        <td><strong>Info Title</strong> :</td>

            <td><?=$cdetail['name']?></td>

                        <?php if(file_exists("../" . CMS_TESTIMONIALS_DIR . $cdetail['image']) && !empty($cdetail['image'])){ ?>

            <td rowspan="3" align="right">                        

                        <img src="<?php echo "../".CMS_TESTIMONIALS_DIR . $cdetail['image']; ?>" width="100">                        

                        </td>



                        <?php } ?>



                      </tr>



          <tr>

                      <td><strong>Info Detail</strong> :</td>

            <td><?=$cdetail['contents'];?></td>

          </tr>

                    

                  <tr>

                      <td width="10%" valign="top"><strong>Districts : </strong></td>

                        <td valign="top">

              <? $dis=$cdetail['districtIds']; $dis=mysql_query("select name from district where id in ($dis)");

              //$disGet=mysql_fetch_array($dis);

              if(mysql_num_rows($dis)==75){ echo "सबै जिल्लाहरु";}

              else

              {

                $i=1;

                while($disGet=mysql_fetch_array($dis))

                {

                  if($i<>mysql_num_rows($dis)) echo $disGet['name'].", ";

                  else echo $disGet['name'];

                  $i++;

                }

              } //nl2br($cdetail['information_type']);

              ?>

                        </td>

                  </tr>

                    

                    <tr>

                      <td width="10%" valign="top"><strong>Info About : </strong></td>

                        <td valign="top">

              

              <? $info=$cdetail['cropId']; $s=mysql_query("select name from crop where id='$info'");

              if(mysql_num_rows($s)>0)

              {

                $infoGet=mysql_fetch_array($s);

              }

              else

              {

                $s=mysql_query("select name from groups where id='$info'");

                $infoGet=mysql_fetch_array($s);

              }

              echo $infoGet['name'];

              ?>

                        </td>

                  </tr>

                    

                    </table></td>



                  </tr>



              </table></td>



            </tr>



          </table></td>



        </tr>



        <tr>



          <td height="5"></td>



        </tr>



  <? }

  else if(isset($_GET['type']) && $_GET['type'] == "edit")

  {?>

      

        <tr>

          <td class="bgborder">

          <form action="" method="post" enctype="multipart/form-data">

          

          <table width="100%" border="0" cellspacing="1" cellpadding="0">

            <tr>

              <td bgcolor="#FFFFFF">

              <table width="100%" border="0" cellspacing="0" cellpadding="0">

                  <tr>

                    <td class="heading2">&nbsp;Edit Information</td>

                  </tr>

                  <tr>

                    <td>

                      <? $eid=$_GET['id']; $editGet=$information->getById($eid); //$editGet=$conn->fetchArray($edit); ?>

                      <table width="100%" border="0" cellspacing="1" cellpadding="4">

                      <tr><td><strong>Sender:</strong></td>

                        <td>

              <? $sender=$editGet['userId']; $s=mysql_query("select name from usergroups where id='$sender'");

              $sGet=mysql_fetch_array($s); echo $sGet['name']; //$cdetail['sender'];

              ?>

                        </td>

                      </tr>

                      <tr>

                        

                        <td><strong>Info Title</strong> :</td>

            <td><?=$editGet['name']?></td>

                      </tr>



          <tr>

                      <td><strong>Info Detail</strong> :</td>

            <td colspan="2" style="width:200px">

              <?php

                                include ("../fckeditor/fckeditor.php");

                                $sBasePath="../fckeditor/";                 

                                $oFCKeditor = new FCKeditor('contents');

                                $oFCKeditor->BasePath = $sBasePath ;

                                $oFCKeditor->Value    = $editGet['contents'];

                                $oFCKeditor->Height   = "400";

                                $oFCKeditor->ToolbarSet = "Rupens"; 

                                $oFCKeditor->Create();

                            ?>

                          </td>

          </tr>

                    

                  <tr>

                      <td width="10%" valign="top"><strong>Districts : </strong></td>

                        <td valign="top">

              <? $dis=$editGet['districtIds']; $dis=mysql_query("select name from district where id in ($dis)");

              //$disGet=mysql_fetch_array($dis);

              if(mysql_num_rows($dis)==75){ echo "सबै जिल्लाहरु";}

              else

              {

                $i=1; $rows=mysql_num_rows($dis);

                while($disGet=mysql_fetch_array($dis))

                {

                  if($i<$rows) echo $disGet['name'].", ";

                  else echo $disGet['name'];

                  $i++;

                }

              } //nl2br($cdetail['information_type']);

              ?>

                        </td>

                  </tr>

                    

                    <tr>

                      <td width="10%" valign="top"><strong>Info About : </strong></td>

                        <td valign="top">

              <? $info=$editGet['cropId']; $s=mysql_query("select name from crop where id='$info'");

              if(mysql_num_rows($s)>0)

              {

                $infoGet=mysql_fetch_array($s);

              }

              else

              {

                $s=mysql_query("select name from groups where id='$info'");

                $infoGet=mysql_fetch_array($s);

              }

              echo $infoGet['name'];

              ?>

                        </td>

                  </tr>

                    

                    </table>

                    </td>



                  </tr>



              </table></td>



            </tr>

          </table>

          

          <table width="100%" bgcolor="#FFF" border="1" bordercolor="#006193">

              <tr>

                  <td><input name="type" type="submit" class="button" id="button" value="Update" /></td>

                    <?php if($_GET['type'] == "edit"){?>

                    <input type="hidden" value="<?= $id?>" name="id" id="id" />

                    <?php }else{ ?>                                

                    <input name="reset" type="reset" class="button" id="button2" value="Clear" />

                    <?php } ?>

                </tr>

         </table>

          

          </form>

          </td>

        </tr>

            

        <tr>



          <td height="5"></td>



        </tr>

        

    <? }?>



        <tr>



          <td class="bgborder"><table width="100%" border="0" cellspacing="1" cellpadding="0">



              <tr>



                <td bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">



                    <tr>



                      <td class="heading2">&nbsp;Informations</td>



                    </tr>



                    <tr>



                      <td><table width="100%"  border="0" cellpadding="4" cellspacing="0">



                          <tr bgcolor="#F1F1F1" class="tahomabold11">



                            <td width="1">&nbsp;</td>



                            <td><strong>SN</strong></td>



                            <td><strong>Title</strong></td>



                            <td><strong>Information Sender</strong></td>



                            <td width="95"><strong>Status</strong></td>



                            <td width="70"><strong>Date</strong></td>



                            <td width="120"><strong>Action</strong></td>



                          </tr>



                          <?php



                          $counter = 0;



                          $pagename = "index.php?";



                          $sql = "SELECT * FROM information ORDER BY id DESC, onDate Desc";

                          //echo $sql;



                          $limit = 40;



                          include("../includes/paging.php");



                          while($row = $conn -> fetchArray($result))



                          {



                          ?>



                          <tr <?php if($counter%2 != 0) echo 'bgcolor="#F7F7F7"'; else echo 'bgcolor="#FFFFFF"'; ?>>



                            <td valign="top">&nbsp;</td>



                            <td valign="top"><?= ++$counter; ?></td>



                            <td valign="top"><?= $row['name'] ?></td>



                            <td valign="top">

                <? $userId=$row['userId']; $s=mysql_query("select * from usergroups where id='$userId'");

                $sGet=mysql_fetch_array($s); echo $sGet['name']; ?>

                          </td>



                            <td valign="top">



                            <?php



                            if($row['publish']=="No")



                            {



                              echo "Inactive";



                            ?>



                            <a href="index.php?type=status&id=<?=$row['id']?>">[Enable]</a>



                            <?php



                            }



                            else



                            {



                              echo "Active";



                            ?>



                            <a href="index.php?type=status&id=<?=$row['id']?>">[Disable]</a> 



                            <?php



                            }



                            ?>     



                            &nbsp;</td>



                            <td valign="top">



                            <?php 



                            $arrDate = explode(' ',$row['onDate']); 



                            $arrDate1 = explode('-',$arrDate[0]);



                            echo date("M j, Y",mktime(0,0,0,$arrDate1[1],$arrDate1[2],$arrDate1[0]));



                            ?>                            </td>



                            <td valign="top">



                            [<a href="index.php?type=show&id=<?php echo $row['id']; ?>">Details</a>]

                            [<a href="index.php?type=edit&id=<?php echo $row['id']; ?>">Edit</a>]
                            
                                                        </td>



                          </tr>



                          <?



                          }



                          ?>



                        </table>



                        <?php include("../includes/paging_show.php"); ?>



                        </td>



                    </tr>



                  </table></td>



              </tr>



            </table></td>



        </tr>



      </table></td>



  </tr>



  <tr>



    <td colspan="2"><?php include("../admin/footer.php"); ?></td>



  </tr>



</table>



</body>



</html>