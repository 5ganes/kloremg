<?php
function createMenu($parentId, $groupType)
{
	global $groups;
	global $conn;

	if ($parentId == 0)
		$groupResult = $groups->getByParentIdAndType($parentId, $groupType);	
	else
		$groupResult = $groups->getByParentId($parentId);
	
	if ($conn->numRows($groupResult) > 0)
		echo '<ul>';		

	while($groupRow = $conn->fetchArray($groupResult))
	{	
		echo '<li>';
		?>
    	<a href="<? if($groupRow['id']==1 or $groupRow['id']==296){ echo "#";}else{ echo $groupRow['urlname'];}?>"><?=$groupRow['name'];?></a>
		<?
		
		if($groupRow['id']==2 or $groupRow['id']==3)
			createByBlock($groupRow['id']);
		else if($groupRow['linkType']=="Normal Group")
			createMenu($groupRow['id'], $groupType);
		echo '</li>';
	}
	if ($conn->numRows($groupResult) > 0)
		echo '</ul>';
}
?>


<?
	function createByBlock($id)
	{
		//echo "hello";
		//die();
		global $groups;
		global $conn;
		if($id==2)
			$block="Category Submenu";
		else if($id==3)
			$block="Destination Submenu";
		$act=$groups->getByBlock($block);
		echo '<ul>';
		while($actGet=$conn->fetchArray($act))
		{?>
        	<li><a href="<? if($block=="Activity Submenu"){?>activity<? }else{?>destination<? }?>-<?=$actGet['urlname'];?>.html"><?=$actGet['name'];?></a></li>		
		<? }
		echo '</ul>';
	}
