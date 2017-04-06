<?php //include("includes/breadcrumb.php"); ?>
<div class="contentHdr">
<h2><?php echo $pageName; ?></h2></div>
<div class="content">
	<?php
		$pagename = "index.php?id=". $pageId ."&";
		include("includes/pagination.php");
		echo Pagination($pageContents, "content");
	?>
	<br><br>
	<?php
	$sub=$groups->getByParentId($pageId);
	if($conn->numRows($sub)>0)
	{?>
		<div class="table-responsive">
	    	<table class="table table-boxed" cellpadding="10">
	            <thead>
	                <tr>
	                	<th width="10%">SN</th>
			            <th width="90%">Submenu</th>
	               	</tr>
	            </thead>
	            <tbody>
	            	<?php $sn = 1; 
	            	while($row=$conn->fetchArray($sub)){?>
						<tr>
			                    <td><?php echo $sn++; ?></td>
			                    <td><a href="<?php echo $row['urlname']; ?>"><?php echo $row['name']; ?></a></td>
			                </tr>
						<tr>
			    	<?php }?>
			    </tbody>
	        </table>
		</div>
	<?php }?>
</div>