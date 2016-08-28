<?php
 header("content-type: application/json");
 $array = array(
    'district_id' => '2',
    'district_name' => 'Kathmandu'
);
echo $_GET['callback']."(".json_encode($array).")";
?>

