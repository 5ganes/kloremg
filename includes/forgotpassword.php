<?php 
 	if(isset($_POST['forgot']))
	{
		//echo "die"; die();
		$email=$_POST['email']; //echo $email; die();
		$userExists=mysql_query("select id from usergroups where email='$email'");
		if(mysql_num_rows($userExists)==1)
		{
			//echo "exists"; die();
			//echo $email; die();
			$token = md5($email.time()); //echo $email.", ".$token; die();
			$sql="insert into resetpassword set email='$email', token='$token'";	
			mysql_query($sql);
			$to=$email;
			$subject="Reset Password";
			$msg='<div>
			Somebody(hopefully you) requested a new password for the krishighar account for '.$email.'<br>
			No changes have been made to your acount yet.<br>You can reset your password by clicking the link below:<br>
			http://www.krishighar.com/resetpswd.html/'.$token.'
			<br> If you did not request a new password, please let us know immediately by replying to this email.<br><br>
			Yours,
			<br>
			The KrishiGhar Team</div>';
			$headers  = "";
			$headers .= "MIME-Version: 1.0 \r\n";
			$headers .= "Content-type: text/html; charset=iso-8859-1 \r\n";
			$headers .= "X-Priority: 1\r\n";
			$headers .= "From: "."info@krishighar.com";
			mail($to,$subject,$msg,$headers);
			$msg="Password reset link has been sent to your mail. Please check your mail. Thank you.";	
		}
	}
?>
<link href="css/user.css" rel="stylesheet" type="text/css">
<?php //include("includes/breadcrumb.php"); ?>
<?
if(isset($msg)){?>
	<div style="color:red;; font-size:14px;">
		<?=$msg;?>
	</div>
<? }
else{
?>
	<div class="contentHdr">
		<h2>Enter Your Email ID</h2>
	</div>
    <div class="content">
        <table style="box-shadow:none" width="" border="0" cellpadding="0" cellspacing="5" bgcolor="#FFFFFF">
      <tr>
        <td width="100%" height="100" align="left" valign="middle">
        <table style="box-shadow:none" width="100%"  border="0" align="center" cellpadding="0" cellspacing="3">
          <tr>
            <td>
            <table style="box-shadow:none" width="100%"  border="0" cellpadding="4" cellspacing="0" class="tahomabold11">
                  <form action="" method="post" name="frmUserLogin">
                  <?php if(!empty($errMsg)){ ?>
                  <tr align="center">
                    <td colspan="3" class="warning"><?php echo $errMsg; ?></td>
                  </tr>
                  <?php } ?>
                  <tr>
                    <td width="11%">&nbsp;</td>
                      <td width="30%" align="left">Email:</td>
                    <td width="59%" align="left"><input name="email" type="text" class="text"></td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td align="left">
                        <input name="forgot" type="submit" class="button" value="Reset">
                    </td>
                  </tr>
                </form>
            </table>
            
          </tr>
        </table>
       
        <br></td>
      </tr>
    </table>
    </div>

<? }?>