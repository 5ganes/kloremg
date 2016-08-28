<?php
include("../data/constants.php");
session_start();

session_unset();

session_destroy();?>
	<script>
		window.location.href = "<?=SITE_URL?>info-login.html";
	</script> 
<? //header("Location:login.php");

exit();