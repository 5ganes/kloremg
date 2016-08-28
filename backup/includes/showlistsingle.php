<?php include("includes/breadcrumb.php"); ?>

<?php
	$listResult = $groups->getById($pageId);
	$listRow = $conn->fetchArray($listResult);
	
	$pageResult = $groups->getById($pageParentId);
	$pageRow = $conn->fetchArray($pageResult);
	
	?>
<div class="contentHdr">
<h1><?php echo $pageName; ?></h1></div>
<div class="content">
<div style="margin-bottom:5px;"> 
  <!-- for navigation -->
  <?
		$navNextResult = $groups->getNextResult($pageId);
		$navNextRow = $conn->fetchArray($navNextResult);

		$navPreviousResult = $groups->getPreviousResult($pageId);
		$navPreviousRow = $conn->fetchArray($navPreviousResult);
	?>
  <div style="float: left;" > <a href="<?= $navPreviousRow['urlname']; ?>" class="paging">&laquo; Previous</a> </div>
  <div style="float: right;"> <a href="<?php echo $navNextRow['urlname']; ?>" class="paging">Next &raquo;</a> </div>
  <div style="clear:both"></div>
</div>
<div class="listRow">
  <div class="listTitle"> <?= $pageName; ?>
  </div>
  <? if(file_exists(CMS_GROUPS_DIR . $listRow['image']) && !empty($listRow['image'])){?>
  <div align="center" style="text-align:center; padding-top:10px;"><img src="<?php echo imager($listRow['image'], 500, 500, ""); ?>" />  <div style="clear:both"></div>
  </div>
  <? }?>
  <br />
  <div>
    <?= $listRow['contents']; ?>
  </div>
</div>
<br />
<div><u>Attachments#</u></div>
<?
	$lfResult = $listingFiles->getByListingId($pageId);
	if ($conn->numRows($lfResult) == 0)
	{
		echo "<div class='attach'>No files</div>";
	}
	else
	{
	?>
<div class="attach">
  <table width="100%">
    <?
			}
			while ($lfRow = $conn->fetchArray($lfResult))
			{
			$file = CMS_LISTING_FILES_DIR . $lfRow['filename'];
			?>
    <tr>
      <td><?= $lfRow['filename'] . " (" . round((filesize($file)/1024),0) ." KB)"; ?></td>
      <td><?= $lfRow['caption']; ?></td>
      <td><a href="<?= CMS_LISTING_FILES_DIR . $lfRow['filename']; ?>">Download</a></td>
    </tr>
    <?
			}
			
			if ($conn->numRows($lfResult) > 0)
			{
			?>
  </table>
</div>
<?
	}
	?>
</div>