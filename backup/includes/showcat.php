<style>
	#trip-box {
    margin:5px 0;
  padding:2px;
}
#trip-box-in {
    background:none 0 0 repeat scroll #FFFFFF;
  border:1px solid #D9D9D9;
  margin:5px;
  padding:0 0 8px;
}
#trip-box-in h3 {
    background: none repeat scroll 0 0 #efece6;
    font: bold 16px Arial,Helvetica,sans-serif;
    margin: 0;
    padding: 5px 10px;
    text-shadow: 0 1px 1px #ffffff;
}
.trip-box {
    color:#666666;
  float:left;
  font-family:Arial, Helvetica, sans-serif;
  font-size:12px;
  font-stretch:normal;
  font-style:normal;
  font-variant:normal;
  font-weight:normal;
  height:auto;
  line-height:1.5;
  padding:10px 7px;
  width:230px; text-align:justify;
}
.trip-box h4 {
    color: #881a05;
    font: bold 12px Arial,Helvetica,sans-serif;
    margin: 0;
    padding: 0;
}
.trip-box h4 a {
    color: #0033aa;
    font-size: 14px;
    text-decoration: none;
}
.trip-box img {
    background: none repeat scroll 0 0 #ffffff;
    border: 0 none;
    float: left;
    margin: 0 10px 5px 0;
    padding: 0;
}
.trip-box h4 span {
    font: bold 12px Arial,Helvetica,sans-serif !important;
}
.view {
    background: none repeat scroll 0 0 #2874ec;
    border-radius: 6px;
    color: #ffffff;
    float: left;
    font-family: tahoma;
    font-size: 12px;
    font-weight: bold;
    padding: 3px 10px;
}
.enquiry {
    background: none repeat scroll 0 0 #930000;
    border-radius: 6px;
    color: #ffffff;
    float: right;
    font-family: tahoma;
    font-size: 12px;
    font-weight: bold;
    padding: 3px 10px;
}
</style>

<?php //include("includes/breadcrumb.php"); ?>
<div class="contentHdr">
	<h2> <?php echo $pageName; ?></h2>
</div>
<div class="content">

	<div style="margin-left:0px;" id="trip-box">
            
     	<div id="trip-box-in">
            
            <?
            $prod=$groups->getProductByActivity($pageName);
			while($prodGet=$conn->fetchArray($prod))
			{?>
				<div class="trip-box">
                    <h4 style="height:167px">
                        <a title="" href="<?=$prodGet['urlname'];?>.html">
                            <img width="238" height="140" style="border-radius:4px;" title="" alt="" src="<?=CMS_GROUPS_DIR.$prodGet['image'];?>">
                                <?=$prodGet['name'];?><span></span>
                        </a>
                    </h4>
                    <p class="enq"><?=substr($prodGet['shortcontents'],0,100);?> ...</p>
                    <div style="margin-top:4px;">
                        <a class="view" href="<?=$prodGet['urlname'];?>.html">View Details</a>
                        <!--<a class="enquiry" href="">Enqiury</a>-->
                    </div>
            	</div>
			<? }?>        				
            
       		<div style="clear:both"></div>
  		</div>		  
            
  	</div>
    
    <div class="contentHdr" style="margin-top:30px"><h2>बाकी बाली समुहहरु </h2></div>
    <div style="margin-left:0px;" id="trip-box">
            
     	<div id="trip-box-in">
            
            <?
			$cat=$groups->getById($pageId); $catGet=$conn->fetchArray($cat); $catName=$catGet['activity'];
            $t=mysqli_query($GLOBALS["___mysqli_ston"], "select * from groups where linkType='Activity' and activity='$catName' order by weight");
			while($catGet=$conn->fetchArray($t))
			{?>
				<div class="trip-box">
                    <h4 style="height:167px">
                        <a title="" href="<?=$catGet['urlname'];?>.html">
                            <img width="238" height="140" style="border-radius:4px;" title="" alt="" src="<?=CMS_GROUPS_DIR.$catGet['image'];?>">
                                <?=$catGet['name'];?><span></span>
                        </a>
                    </h4>
                    <p class="enq"><?=substr($catGet['shortcontents'],0,100);?> ...</p>
                    <div style="margin-top:4px;">
                        <a class="view" href="<?=$catGet['urlname'];?>.html">View Details</a>
                        <!--<a class="enquiry" href="">Enqiury</a>-->
                    </div>
            	</div>
			<? }?>        				
            
       		<div style="clear:both"></div>
  		</div>		  
            
  	</div>

</div>