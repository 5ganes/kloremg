<style>
	.related{ margin-top:1px}
	.trips{}
	.leftnav{width: 24%; float: left; background-color: #CFEFCE}
	.rightnav{width: 75%; float: right;}

	.leftnav h2{
		font-family: Verdana, Geneva, sans-serif;
    	font-size: 14px;
   	 	color: #fff;
    	line-height: 40px;
    	text-align: center; background-color: #056a00
   	}
    .leftnav ul{padding: 0px 7px}
    .leftnav ul li {
    	list-style: none;
    	height: auto;
    	border-bottom: 1px #3399FF solid;
	}
	.leftnav ul li:hover{background-color: #b7ffb3}
	.leftnav ul li a{    
		font-family: Verdana, Geneva, sans-serif;
	    font-size: 12px;
	    font-weight: normal;
	    color: #241A11;
	    line-height: 30px;
	    text-decoration: none;
	    background: url(images/common_midCtnr_listArrow.png) no-repeat 0px 1px;
	    /* height: 30px; */
	    width: 100%;
	    display: block;
	    padding: 0 0 0 12px;
	}
</style>

<link rel="stylesheet" type="text/css" href="css/detail.css"/>

<?php //include("includes/breadcrumb.php"); ?>
<? $url=$_GET['url'];
$crop=$conn->exec("select crop.id as id,crop.name as name,crop.code as code,crop.shortcontents as shortcontents,crop.contents as contents,crop.publish as publish,crop.weight as weight,crop.image as image,crop.onDate as onDate,groups.id as categoryId,groups.name as categoryName
	from crop
	inner join groups on crop.categoryId=groups.id
	where crop.urlname='$url'");
	$cropGet=$conn->fetchArray($crop);
?>
<div class="content">
	<div class="leftnav">
		<h2>CATEGORIES</h2>
		<ul>
			<?
			$cat=$groups->getByLinkType("Activity");
			while($catGet=$conn->fetchArray($cat)){?>
        		<li><a href="category-<?=$catGet['urlname'];?>.html"><?=$catGet['name'];?></a></li>
        	<? }?>
        </ul>
	</div>
	<div class="rightnav">
    	<h2 style="margin: 0; margin-top: -7px; margin-left: 1%; margin-bottom: 1%">
    		<?php echo $cropGet['name']; ?>
   		</h2>
    	<div class="">
    		<div style="margin:0; text-align: justify;line-height: 24px">
    			<a href="<?=SITE_URL.CMS_GROUPS_DIR.$cropGet['image'];?>" target="_blank">
    				<img style="float: left; margin:3px 12px 0 0" src="<?=CMS_GROUPS_DIR.$cropGet['image'];?>" width="360" height="250" />
    			</a>
    			<?php
					echo $cropGet['contents'];
				?>
   			</div>
   			<div style="clear: both;"></div>
		</div>
    
	    <div class="contentHdr" style="margin-top:20px;">
	    	<h2><?php echo $cropGet['categoryName']; ?></h2>
	  	</div>
	    
	    <div id="bodydetail">
	  
	    	<div id="trip-box">
	        	<div id="trip-box-in">
	        		<? $categoryId=$cropGet['categoryId']; ?>
					<? $tri="select * from crop where categoryId='$categoryId' order by weight"; 
					$trip=$conn->exec($tri);
					while($tripsGet=$conn->fetchArray($trip))
					{?>
	                	<div class="trip-box">
								<h4>
									<a title="" href="crop-<?=$tripsGet['urlname'];?>.html">
										<img src="<?=CMS_GROUPS_DIR.$tripsGet['image'];?>" width="224" height="150" style="border-radius:4px;">
										<?=$tripsGet['name'];?>
									</a>
								</h4>
	                            
								<p class="enq"><?=substr(strip_tags($tripsGet['shortcontents']), 0, 100);?>...</p>
	                            
	                            <div style="margin-top:4px;">
	                            	<a class="view" href="crop-<?=$tripsGet['urlname'];?>.html">View Detail</a>
	                                <!-- <a class="enquiry" href="order-<?=$tripsGet['urlname'];?>">
	                                	Order Now
	                                </a> -->
	                            </div>
	                            
							</div>
	                <? }?>
	                <div style="clear:both"></div>
	                
	        	</div>
	        </div>
		</div>
	</div>
	<div style="clear: both;"></div>
</div>
