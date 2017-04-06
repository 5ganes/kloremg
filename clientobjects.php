<?php

session_start();

error_reporting(E_ERROR);

ini_set("register_globals", "off");

ini_set("upload_max_filesize", "20M");

ini_set("post_max_size", "40M");

ini_set("memory_limit", "80M");



require_once("data/conn.php");

require_once("data/users.php");

require_once("data/groups.php");

require_once("data/listingfiles.php");

require_once("data/district.php");

require_once("data/crop.php");

require_once("data/information.php");

$conn 					= new Dbconn();		

$users	 				= new Users();

$groups					= new Groups();

$listingFiles		    = new ListingFiles();

$district			    = new District();

$crop 					= new Crop();

$information 			= new Information();

require_once("data/question.php");
$question			= new Question();




require_once("data/constants.php");

require_once("data/sqlinjection.php");



///////////////////////////////////////////////



$query = "";

if (isset($_GET['query']))

	$query = $_GET['query'];

	

if (!empty($query)) {

	//echo "die"; die();

	$pageRow = $groups->getByURLName($query);

	if ($pageRow) {

		

		$pageId = $pageRow['id'];

		$pageName = $pageRow['name'];

		$pageUrlName = $pageRow['urlname'];

		$pageType = $pageRow['type'];

		$pageParentId = $pageRow['parentId'];

		$pageShortContents = $pageRow['shortcontents'];

		$pageContents = $pageRow['contents'];

		$pageLinkType = $pageRow['linkType'];

		$pageWeight = $pageRow['weight'];

		$pageDate = $pageRow['onDate'];

		$pageImage = $pageRow['image'];

		$pageFeatured = $pageRow['featured'];

		$pageCode = $pageRow['code'];

		$pagePrice = $pageRow['price'];

		$pagePageTitle = $pageRow['pageTitle'];

		$pagePageKeyword = $pageRow['pageKeyword'];

		$pageDisplay = $pageRow['display'];

		

		if ($pageLinkType == "Link") {

			header("Location: " . $pageRow['contents']);

			exit();

		} elseif ($pageLinkType == "File") {

			header("Location: " . CMS_FILES_DIR . $pageRow['contents']);

			exit();

		}		

	}

}



include("menufunction.php");





///////////////IMAGE CALL IMAGER FUNCTION //////////////////////////////





function imager($source, $width, $height, $fix="")

{

	$str = 'data/imager.php?file=../' . CMS_GROUPS_DIR . $source . '&amp;mw=' . $width . '&amp;mh=' . $height;

	if(!empty($fix))

		$str .= '&amp;fix';		

	return $str;

}