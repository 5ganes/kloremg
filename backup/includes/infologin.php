<?php 
	include("infologinprocess.php"); 
?>
<link href="css/user.css" rel="stylesheet" type="text/css">
<?php //include("includes/breadcrumb.php"); ?>

<div class="contentHdr">

	<h2>Login Here</h2>

</div>

<div class="content">



	<table style="box-shadow:none" width="" border="0" align="center" cellpadding="0" cellspacing="5" bgcolor="#FFFFFF">



  <tr>



    <td width="100%" height="300" align="center" valign="middle"><table style="box-shadow:none" width="42%"  border="0" align="center" cellpadding="0" cellspacing="3">



      <tr>



        <td>

        <table style="box-shadow:none" width="100%"  border="0" cellpadding="4" cellspacing="0" class="tahomabold11">



              <form action="<?php echo $PHP_SELF; ?>" method="post" name="frmUserLogin">



              <?php if(!empty($errMsg)){ ?>



              <tr align="center">



                <td colspan="3" class="warning"><?php echo $errMsg; ?></td>



              </tr>



              <?php } ?>



              <tr>



                <td width="11%">&nbsp;</td>



                  <td width="30%" align="left">Username:</td>



                <td width="59%" align="left"><input name="uname" type="text" class="text"></td>



              </tr>



              <tr>



                <td>&nbsp;</td>



                  <td align="left">Password:</td>



                <td align="left"><input name="pswd" type="password" class="text"></td>



              </tr>



              <tr>



                <td>&nbsp;</td>



                <td>&nbsp;</td>



                <td align="left"><input name="btnUserLogin" type="submit" class="button" value=" Login "></td>



              </tr>



            </form>



        </table>

        <style>

			.register{ margin-top:20px; font-size:14px;}

        	.register a{color:red}

			.register a:hover{color:#088c02}

        </style>

        <div class="register">

        	[ <a href="forgotpassword.html">Forgot Password ?</a> ]

        </div>



      </tr>



    </table>



   



    <br></td>



  </tr>



</table>



</div>