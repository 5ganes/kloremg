<?php
// API access key from Google API's Console
define( 'API_ACCESS_KEY', 'AIzaSyBvG5kDXkFX6uzMpyJA4yaQVZjZltaYNi4' ); 

require_once("../data/conn1.php");
$conn = new Dbconn();
$sql=mysql_fetch_array(mysql_query("select count(id) as maxx from farmer")); $count=$sql['maxx'];
$limit=1000; $i=1;
while($count>0)
{
	$lower=($i-1)*$limit;
	$sql=mysql_query("select registration_id from farmer limit $lower,$limit"); $i++; $count-=$limit;
	
	$registrationIds=array();
	$j=0;
	while($rId=mysql_fetch_array($sql))
	{
		$registrationIds[$j]=$rId['registration_id']; $j++;
	}
	//$registrationIds = array( $sql['registrationId'] );
	//echo print_r($registrationIds); die();
	//registration Id: APA91bHc0yu1JMO74RzSm6IrccQ0Rd-1Ndb90VHU2VZFlLvCFEPZSi1Nk8k8OB-NZ5KLqhdOHkBS3hMVsWurdZg3ui7TIJQ84y7wGvnIMWYBgiFhbbt-NIo
	
	// prep the bundle
	$msg = array
	(
		'message' 	=> 'New Information Available',
		'title'		=> 'Title',
		'subtitle'	=> 'Subtitle',
		'tickerText'	=> 'Ticker Text',
		'vibrate'	=> 1,
		'sound'		=> 1,
		'largeIcon'	=> 'large_icon',
		'smallIcon'	=> 'small_icon'
	);
	
	$fields = array
	(
		'registration_ids' 	=> $registrationIds,
		'data'			=> $msg
	);
	 
	$headers = array
	(
		'Authorization: key=' . API_ACCESS_KEY,
		'Content-Type: application/json'
	);
	 
	$ch = curl_init();
	curl_setopt( $ch,CURLOPT_URL, 'https://android.googleapis.com/gcm/send' );
	curl_setopt( $ch,CURLOPT_POST, true );
	curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
	curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
	curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
	curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
	$result = curl_exec($ch );
	curl_close( $ch );
	
	echo $result;
	//echo "<br><br><br>";
}
?>