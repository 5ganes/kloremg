<?php
	//echo $_GET['token'];
 	if(isset($_POST['reset']))
	{
		$newpass=trim($_POST['newpass']);
		$confpass=trim($_POST['confpass']);
		if($newpass==$confpass)
		{
			$token=$_POST['token']; //$sql="select email from resetpassword where tonen='$token'"; echo $sql; die();
			$userEmail=mysql_fetch_assoc(mysql_query("select email from resetpassword where token='$token'"));
			$mail=$userEmail['email']; //$mail; die();
			mysql_query("delete from resetpassword where token='$token'");
			
			$password=md5($newpass);
			mysql_query("update usergroups set password='$password' where email='$mail'");
			$errMsg="Your password has been successfully reset.";
		}
		else
		{
			$errMsg="Password didn't match";
		}
	}
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
<script>
	function validate(fm){
		$('#newpass').html('');
		$('#confpass').html('');
		if(fm.newpass.value==''){
			$('#newpass').html('[ password can not be empty ]');
			fm.newpass.focus();
			return false;
		}
		if(fm.confpass.value==''){
			$('#confpass').html('[ password can not be empty ]');
			fm.confpass.focus();
			return false;
		}
	}
</script>
<link href="css/user.css" rel="stylesheet" type="text/css">
<?php //include("includes/breadcrumb.php"); ?>
<style> #newpass, #confpass{color:red;} </style>
<div class="contentHdr">
	<h2>Reset your password</h2>
</div>
<div class="content">
	<table style="box-shadow:none" width="" border="0" cellpadding="0" cellspacing="5" bgcolor="#FFFFFF">
  <tr>
    <td width="100%" height="100" align="left" valign="middle">
    <table style="box-shadow:none" width="100%"  border="0" align="center" cellpadding="0" cellspacing="3">
      <tr>
        <td>
        <table style="box-shadow:none" width="100%"  border="0" cellpadding="4" cellspacing="0" class="">
              <form action="" method="post" name="frmUserLogin" onsubmit="return validate(this)">
              <?php if(!empty($errMsg)){ ?>
              <tr align="center">
                <td colspan="3" class="warning" style="color:red"><?php echo $errMsg; ?></td>
              </tr>
              <?php } ?>
              <tr>
                  <td width="30%" align="left">New password:</td>
                <td width="59%" align="left"><input name="newpass" type="text" class="text">
                <br /><span id="newpass"></span></td>
              </tr>
              <tr>
                
                  <td width="30%" align="left">Confirm password:</td>
                <td width="59%" align="left"><input name="confpass" type="text" class="text">
                <br /><span id="confpass"></span></td>
              </tr>
              <input type="hidden" name="token" value="<?=$_GET['token'];?>" />
              <tr>
                <td>&nbsp;</td>
                <td align="left">
                	<input name="reset" type="submit" class="button" value="Reset">
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