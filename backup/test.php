<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<?
	include('data/conn.php');
	$conn = new Dbconn();	
	$sql=mysqli_query($GLOBALS["___mysqli_ston"], "select * from groups where linkType='Activity'");
	while($gets=mysqli_fetch_array($sql))
	{
		echo $gets['name']." ";	
	}	
?>