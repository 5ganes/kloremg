<div align="right" style="cursor: pointer;" onclick="addDiseaseImage();">+ Add Image +</div>
<div id="uploadImageHolder">
  <div style="width:100px; float: left;">Image : </div>
  <div style="float:left;">
    <input type="file" name="image[]" class="file" />
  </div>
  <br style="clear: both;">
  <div style="width:100px; float: left;">Caption : </div>
  <div style="float:left;">
    <input type="text" name="contents[]" class="text" />
  </div>
  <hr style="clear: both;">
</div>
<? if(isset($_GET['cropId']) and isset($_GET['diseaseId']) and $_GET['cropId']!="select" and $_GET['diseaseId']!="select")
{?>
	
    <div>Existing Images</div>
	<div>
  		<?php
		//$pagename = "cms.php?id=" . $_GET['id'] . "&parentId=" . $_GET['parentId'] . "&groupType=" . urlencode($_GET['groupType']) . "&";	
		$sql = "SELECT * FROM diseaseimage WHERE cropId = '". $_GET['cropId'] . "' and diseaseId='".$_GET['diseaseId']."' ORDER BY id DESC";
		$limit = ADMIN_GALLERY_LIMIT;
		include("../includes/paging.php");
	
		$imagesResult = $result;
	
		//$imagesResult = $galleries->getByGroupId($_GET['id']);
		while($imageRow = $conn->fetchArray($imagesResult))
		{?>
  			<div style="float: left; width: 168px; height: 168px; border: 1px solid; overflow:hidden;">
    			<div align="right">
      				<div style="cursor: pointer;" onclick="delete_confirmation('diseaseimage.php?cropId=<?=$_GET['cropId']?>&diseaseId=<?=$_GET['diseaseId']?>&imageId=<?php echo $imageRow['id']; ?>&deleteImage');">[x]&nbsp;
                 	</div>
    			</div>
    			<div align="center" style="width: 100%; height: 130px;"> <img src="../data/imager.php?file=../<?php echo CMS_GROUPS_DIR . $imageRow['image']; 
				?>&mw=120&mh=120&fix">
                </div>
    			<div align="center">
      				<input type="hidden" name="oldcontentids[]" value="<?php echo $imageRow['id'] ?>" />
      				<input type="text" name="oldcontents[]" value="<?php echo $imageRow['contents'] ?>" class="text" style="width:155px;" />
    			</div>
  			</div>
  		<? }
		include("../includes/paging_show.php");
		?>
	</div>

<? }?>