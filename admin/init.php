<?php
session_start();
//echo "kj";

ini_set("register_globals", "off");
ini_set("upload_max_filesize", "20M");
ini_set("post_max_size", "40M");
ini_set("memory_limit", "80M");

require_once("../data/conn.php");
require_once("../data/users.php");
require_once("../data/groups.php");
require_once("../data/listingfiles.php");
require_once("../data/enewsletters.php");
require_once("../data/testimonials.php");
require_once("../data/information.php");
require_once("../data/feedbacks.php");
require_once("../data/district.php");
require_once("../data/cropvariety.php");
require_once("../data/crop.php");
require_once("../data/disease.php");
require_once("../data/video.php");
require_once("../data/diseaseimage.php");
require_once("../data/question.php");

$conn 					= new Dbconn();		
$users	 				= new Users();	
$groups					= new Groups();
$listingFiles		= new ListingFiles();
$enewsletters			= new Enewsletters();
$testimonials		= new Testimonials();
$information 		= new Information();
$feedbacks			= new Feedbacks();
$district			= new District();
$cropvariety 		= new Cropvariety();
$crop				= new Crop();
$disease			= new Disease();
$video				= new Video();
$diseaseimage		= new Diseaseimage();
$question			= new Question();

require_once("../data/diarycat.php");
$diarycat 			= new Diarycat();

require_once("../data/diary.php");
$diary 			= new Diary();

require_once("../data/undp.php");
$undp 			= new Undp();

require_once("../data/croptechnology.php");
$croptechnology = new Croptechnology();

require_once("../data/newtechnology.php");
$newtechnology = new Newtechnology();

define (ADMIN_GALLERY_LIMIT,20);

require_once("../data/constants.php");
require_once("../data/sqlinjection.php");
require_once("../data/youtubeimagegrabber.php");

//include html entity script
//require_once("../js/htmlentity.js");
?>