<table width="100%" border="0" cellpadding="0" cellspacing="4">
<tr>
  <td></td>
  <td><strong> Images :</strong></td>
  <td>&nbsp;</td>
</tr>
<tr>
  <td></td>
  <td colspan="2"><div align="right" style="cursor: pointer;" onclick="addImage();">+ Add Image +</div>
<div id="uploadImageHolder">
<div style="width:100px; float: left;">Image : </div>
<div style="float:left;">
<input type="file" name="image[]" class="file" />
</div>
<br style="clear: both;">
<div style="width:100px; float: left;">Caption : </div>
<div style="float:left;">
<input type="text" name="imageCaption[]" class="text" />
</div>
<hr style="clear: both;">
</div>
<?php
if (isset($_GET['id']))
{
?>
<div>Existing Images</div>
<div>
	<?php
  $imagesResult = $groups->getByParentIdAndLinkType($_GET['id'], "PackageCMSGallery");
  while ($imageRow = $conn->fetchArray($imagesResult))
  {
  ?>
    <div style="float: left; width: 168px; height: 168px; border: 1px solid; overflow:hidden;">
    <div align="right">
    <div style="cursor: pointer;" onclick="delete_confirmation('packagecms.php?category=<?= $_GET['category']?>&package=<?= $_GET['package']?>&parentId=<?= $pid ?>&id=<?= $_GET['id']?>&imageId=<?php echo $imageRow['id']; ?>&deleteImage');">[x]&nbsp;</div>
    </div>
    <div align="center" style="width: 100%; height: 130px;"> <img src="../data/imager.php?file=../<?php echo CMS_PACKAGE_IMAGES_DIR . $imageRow['id'] . "." .$imageRow['ext'] ?>&mw=120&mh=120&fix"> </div>
    <div align="center">
    <input type="hidden" name="oldCaptionIds[]" value="<?php echo $imageRow['id'] ?>" />
    <input type="text" name="oldCaptions[]" value="<?php echo $imageRow['caption'] ?>" class="text" style="width:155px;" />
    </div>
 	 </div>
  <?php
  }
  ?>
  </div>
  <?php
  }
  ?>
  </td>
</tr>
</table>