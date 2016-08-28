<?php //include("includes/breadcrumb.php"); ?>

<div class="contentHdr">
	<h2><?php echo $pageName; ?></h2>
</div>

<div class="content">
<?php
$pagename = "index.php?id=". $pageId ."&";
include("includes/pagination.php");

echo Pagination($pageContents, "content");
?>
</div>