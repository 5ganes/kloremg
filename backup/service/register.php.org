<?
	if (isset($_SERVER['HTTP_ORIGIN'])) {
        header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Max-Age: 86400');    // cache for 1 day
    }

    // Access-Control headers are received during OPTIONS requests
    if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
            header("Access-Control-Allow-Methods: GET, POST, OPTIONS");         

        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
            header("Access-Control-Allow-Headers:        
            {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

        exit(0);
    }
	//header("Content-Type: application/json");

require_once("../data/conn1.php");

require_once("appclass.php");

require_once("../data/sqlinjection.php");

$conn = new Dbconn();		

$app = new App();


//for registraiton
$msg=array();
$postdata = file_get_contents("php://input");
//$sql=mysql_query("insert into test set name='$postdata'");
if (isset($postdata))
{
	$request = json_decode($postdata);
	
	$device_id = $request->device_id;
	$registration_id = $request->registration_id;
	$district_id = $request->district_id;
	$crops_id = $request->crops_id;
	$contacts = $request->contacts;

	if($device_id!="" and $registration_id!="" and $district_id!="" and $crops_id!="" and $post=$app->saveFarmerInfo($device_id,$registration_id,$district_id,$crops_id,$contacts))
		$msg=' [ { "message":"success" } ] ';
	else
		$msg=' [ { "message":"fail" } ]';
}
else
{
	$msg=' [ { "message":"not called properly" } ]';
}
echo $msg;

?>