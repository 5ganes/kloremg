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
	
	
require_once("../data/conn1.php");
require_once("appclass.php");
require_once("../data/sqlinjection.php");
$conn = new Dbconn();		
$app = new App();

$qtype="question";
//echo "hello";
if($qtype=="question")
{
	$msg=array();
	$postdata = file_get_contents("php://input");
	if (isset($postdata))
	{
		$request = json_decode($postdata);
		$name = $request->name;
		$phone = $request->phone;
		$email = $request->email;
		$question = $request->question;
		$deviceId = $request->deviceId;
		$infoId = $request->infoId;

		if($name!="" and $phone!="" and $email!="" and $question!="" and $post=$app->saveQuestion($name,$phone,$email,$question,$deviceId,$infoId))
			$msg=' [ { "message":"success" } ] ';
		else
			$msg=' [ { "message":"fail" } ]';
	}
	else
	{
		$msg=' [ { "message":"not called properly" } ]';
	}
	echo $msg;
}
?>