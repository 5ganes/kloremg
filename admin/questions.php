<?php

include("init.php");

if(!isset($_SESSION['sessUserId']))//User authentication

{

 header("Location: login.php");

 exit();

}

$id=$_GET['id'];	

if($_POST['reply'] == "reply")

{

	$errMsg="";

	extract($_POST);

	if(strip_tags($answer)=="")

	{

		$errMsg="Please Write the reply for this question";	

	}

	if(empty($errMsg))

	{

		$pid = $question -> save($id,$answer,$questionId,$providerId,$publish);

		if($id>0)

			header("Location: questions.php?msg=Reply Updated Successfully");

		else

			header("Location: questions.php?msg=Replied Successfully");

	}

}

if($_GET['type']=="status")

{ 

	$cdetail = $question -> updateStatus($id);

	header("Location: questions.php?msg=Question status changed successfully");

	exit();

}

elseif($_GET['type']=="del")

{

	$question -> delete($id);

	header("Location: questions.php?msg=Question deleted successfully");

	exit();

}

elseif($_GET['type']=="show" )

{ 

	$cdetail = $question -> getById($id);

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

    <td colspan="2"><?php include("header.php"); ?></td>

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

                    <td class="heading2">&nbsp;Question Detail</td>

                  </tr>

                  <tr>

                    <td><table width="100%" border="0" cellspacing="1" cellpadding="4">

                      <tr><td><strong>Question:</strong></td>

                        <td>

							<?=$cdetail['question'];?>

                       	</td>

                      </tr>

                      <tr>

                      	

                        <td><strong>Farmer:</strong> :</td>

						<td><?=$cdetail['name']?></td>

                        

                      </tr>

					<tr>

                   		<td><strong>Phone: </strong> :</td>

						<td><?=$cdetail['phone'];?></td>

					</tr>

                    <tr>

                   		<td><strong>Email: </strong> :</td>

						<td><?=$cdetail['email'];?></td>

					</tr>

                    <tr>

                   		<td><strong>Status: </strong> :</td>

						<td><?=$cdetail['publish'];?></td>

					</tr>

                    <tr>

                    	<td></td>

                   		<td><strong><a href="questions.php?type=reply&qid=<?=$cdetail['id'];?>">Reply to this Question</strong></a></td>

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

	else if(isset($_GET['type']) && $_GET['type'] == "reply")
	{?>
    	<?
		$qid=$_GET['qid'];
		$ans=mysql_query("select * from reply where questionId='$qid'");
		if(mysql_num_rows($ans)==1)
		{
			extract(mysql_fetch_array($ans));	
		}
		?>
        <tr>
          <td class="bgborder">
          <form action="questions.php" method="post" enctype="multipart/form-data">
          <table width="100%" border="0" cellspacing="1" cellpadding="0">
            <tr>
              <td bgcolor="#FFFFFF">
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>

                    <td class="heading2">&nbsp;Reply</td>

                  </tr>

                  <tr>

                    <td>

                    	

                    	<table width="100%" border="0" cellspacing="1" cellpadding="4">

                      <tr><td><strong>Question:</strong></td>

                        <td>

                        	<? $questionGet=$question->getById($qid);?>

							<?=$questionGet['question'];?>

                       	</td>

                      </tr>

						<input type="hidden" name="questionId" value="<?=$_GET['qid'];?>" />

                        <input type="hidden" name="providerId" value="<?=$_SESSION['sessUserId'];?>" />

                      <tr>

                   		<td><strong>Reply Answer</strong> :</td>

						<td colspan="2" style="width:200px">

							<?php

                                include ("../fckeditor/fckeditor.php");

                                $sBasePath="../fckeditor/";									

                                $oFCKeditor = new FCKeditor('answer');

                                $oFCKeditor->BasePath	= $sBasePath ;

                                $oFCKeditor->Value		= $answer;

                                $oFCKeditor->Height		= "200";

                                $oFCKeditor->ToolbarSet	= "Rupens";	

                                $oFCKeditor->Create();

                            ?>

                          </td>

					</tr>

                    <tr>

                          <td><strong>Publish :</strong></td>

                          <td>

                            <label>

                              <input name="publish" type="radio" id="featured_0" value="No" checked="checked" />

                              No</label>

                            <label>

                              <input type="radio" name="publish" value="Yes" id="featured_1" <? if($publish == 'Yes') echo 'checked="checked"';?> />

                              Yes</label>

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

                	<td>

						<? if(isset($id))

                        {?>

                            <input type="hidden" value="<?= $id?>" name="id" id="id" />

                        <? }?>

                        <input name="reply" type="submit" class="button" id="button" value="reply" />

               		</td>

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

                      <td class="heading2">&nbsp;Questions</td>

                    </tr>

                    <tr>

                      <td><table width="100%"  border="0" cellpadding="4" cellspacing="0">

                          <tr bgcolor="#F1F1F1" class="tahomabold11">

                            <td width="1">&nbsp;</td>

                            <td><strong>SN</strong></td>

                            <td width="200"><strong>Question</strong></td>

                            <td width="120"><strong>Farmer</strong></td>

                            <td width="70"><strong>Phone</strong></td>

                            

                            <td width="94">Status</td>

                            <td width="80">OnDate</td>

                            <td width="120"><strong>Action</strong></td>

                          </tr>

							<?php

                            $counter = 0;

                            $pagename = "questions.php?";

                            $sql = "SELECT * FROM questions ORDER BY id DESC, onDate Desc";

                            //echo $sql;

                            $limit = 40;

                            include("../includes/paging.php");

                            while($row = $conn -> fetchArray($result))

                            {

                            ?>

                          	  	<tr <?php if($counter%2 != 0) echo 'bgcolor="#F7F7F7"'; else 

								echo 'bgcolor="#FFFFFF"'; ?>>

                                    <td valign="top">&nbsp;</td>

                                    <td valign="top"><?= ++$counter; ?></td>

                                    <td valign="top"><?= substr($row['question'],0,50) ?>...</td>

                                    <td valign="top"><?= $row['name'] ?></td>

                                    <td valign="top"><?= $row['phone'] ?></td>

                                    

                                    <td valign="top">

										<?php

                                        if($row['publish']=="No")

                                        {

                                            echo "Inactive";

                                        ?>

                                        <a href="questions.php?type=status&id=<?=$row['id']?>">[Enable]</a>

                                        <?php

                                        }

                                        else

                                        {

                                            echo "Active";

                                        ?>

                                        <a href="questions.php?type=status&id=<?=$row['id']?>">[Disable]</a> 

                                        <?php

                                        }

                                        ?>     

                                        &nbsp;

                                	</td>

                                    <td valign="top">

                                        <?php

                                        $arrDate = explode(' ',$row['onDate']); 

                                        $arrDate1 = explode('-',$arrDate[0]);

                                        echo date("M j, Y",mktime(0,0,0,$arrDate1[1],$arrDate1[2],$arrDate1[0]));

                                        ?>

                                   	</td>

                                    <td valign="top">

                                      [<a href="questions.php?type=show&id=<?php echo $row['id']; ?>">Details</a>]

                                      [<a href="questions.php?type=reply&qid=<?php echo $row['id']; ?>">Reply</a>]

                                      

                                      <a href="#" onClick="javascript: if(confirm('This will permanently remove this Question from database. Continue?')){ document.location='questions.php?type=del&id=<?php echo $row['id']; ?>'; }">Delete</a>

                     

                                 	</td>

                          		</tr>

                          	<? }?>

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

    <td colspan="2"><?php include("footer.php"); ?></td>

  </tr>

</table>

</body>

</html>