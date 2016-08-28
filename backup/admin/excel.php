<?php 
define ("DB_HOST", "localhost");
define ("DB_USER", "root");
define ("DB_PASS","");
define ("DB_NAME","krishinew");

$link = ($GLOBALS["___mysqli_ston"] = mysqli_connect(DB_HOST,  DB_USER,  DB_PASS)) or die("Couldn't make connection.");
$db = ((bool)mysqli_query( $link, "USE " . constant('DB_NAME'))) or die("Couldn't select database");

mysqli_query($GLOBALS["___mysqli_ston"], "SET NAMES 'utf8'");
$setExcelName = "districtStatistics";
$setSql="select * from district order by weight";

$setCounter = 0;
$setRec = mysqli_query($GLOBALS["___mysqli_ston"], $setSql);
$setCounter = (($___mysqli_tmp = mysqli_num_fields($setRec)) ? $___mysqli_tmp : false);

for ($i = 0; $i < $setCounter; $i++) {
    $setMainHeader .= ((($___mysqli_tmp = mysqli_fetch_field_direct($setRec,  $i)->name) && (!is_null($___mysqli_tmp))) ? $___mysqli_tmp : false)."\t";
}

while($rec = mysqli_fetch_row($setRec))  {
  $rowLine = '';
  foreach($rec as $value)       {
    if(!isset($value) || $value == "")  {
      $value = "\t";
    }   else  {
//It escape all the special charactor, quotes from the data.
      $value = strip_tags(str_replace('"', '""', $value));
      $value = '"' . $value . '"' . "\t";
    }
    $rowLine .= $value;
  }
  $setData .= trim($rowLine)."\n";
}
  $setData = str_replace("\r", "", $setData);

if ($setData == "") {
  $setData = "\nno matching records found\n";
}

$setCounter = (($___mysqli_tmp = mysqli_num_fields($setRec)) ? $___mysqli_tmp : false);



//This Header is used to make data download instead of display the data
 header("Content-type: application/octet-stream");

header("Content-Disposition: attachment; filename=".$setExcelName."_Reoprt.xls");

header("Pragma: no-cache");
header("Expires: 0");

//It will print all the Table row as Excel file row with selected column name as header.
echo ucwords($setMainHeader)."\n".$setData."\n";
?>