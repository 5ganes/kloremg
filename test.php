<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<?
	include('data/conn.php');
	$conn = new Dbconn();	
	$sql=mysql_query("select * from groups where linkType='Activity'");
	while($gets=mysql_fetch_array($sql))
	{
		echo $gets['name']." ";	
	}	
?>