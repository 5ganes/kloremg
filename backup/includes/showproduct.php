<style>

	.related{ margin-top:1px}
	.features{ margin:0}
	.features ol{ margin:0}
	.features ol li{ }
	.trips{}

</style>

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


<div class="contentHdr">

<h2><?php echo $pageName; ?></h2>

</div>

<? $trip=$groups->getById($pageId); $tripGet=$conn->fetchArray($trip);?>

<div class="content">

    <div class="">

    	<p style="margin:7px 9px 0 0; float:left">

        	<a href="<?=CMS_GROUPS_DIR.$tripGet['image'];?>" target="_blank">

        		<img src="<?=CMS_GROUPS_DIR.$tripGet['image'];?>" width="420" height="340" />

        	</a>

      	</p>
		<!--<p style="margin:2px 0 4px 0"><b>Product Code: </b><?=$tripGet['code'];?></p>-->
		<div class="features"><?php echo $tripGet['contents'];?></div>
        
        <div style="margin-top:6px;">

           
            <div style="clear:both"></div>

        </div>

        <div style="clear:both"></div>

        

		<? if(!empty($tripGet['itineraryy']))

		{?>

        	<p style="font-weight:bold; margin:8px 0; font-size:14px">Trip Itinerary</p>

            <?=$tripGet['itinerary'];?>

		<? }?>

    	

        

    </div>

    <div class="contentHdr" style="margin-top:30px"><h2>सम्वन्धित रोगहरु </h2></div>
    <div id="bodydetail">
    	<div id="trip-box">
        	<div id="trip-box-in">
        		<? $act=$tripGet['name'];?>
				<? $t=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM groups WHERE linkType =  'Disease' AND activity =  '$act' ORDER BY weight");
				while($tGet=mysqli_fetch_array($t))
				{?>
                	<div class="trip-box" style="float:none">
							<h4><a title="" href="<?=$tGet['urlname'];?>.html"><?=$tGet['name'];?></a></h4>
					</div>
                <? }?>
                <div style="clear:both"></div>
        	</div>
        </div>
	</div>
    
    <div class="contentHdr" style="margin-top:30px"><h2>सम्वन्धित भिडियोहरु </h2></div>
    <div id="bodydetail">
    	<div id="trip-box">
        	<div id="trip-box-in">
        		<? $act=$tripGet['name'];?>
				<? $t=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM groups WHERE linkType =  'Video' AND activity =  '$act' ORDER BY weight");
				while($tGet=mysqli_fetch_array($t))
				{?>
                	<div class="trip-box" style="">
                        <h4>
                            
                                <iframe width="238" height="140" src="<?=$tGet['shortcontents'];?>" frameborder="0" allowfullscreen></iframe>
                                <?=$tGet['name']?>
                                
                            
                        </h4>
					</div>
                <? }?>
                <div style="clear:both"></div>
        	</div>
        </div>
	</div>

    <div class="contentHdr" style="margin-top:30px"><h2>सम्वन्धित वालीहरु </h2></div>

    <div id="bodydetail">

    	<div id="trip-box">

        	<div id="trip-box-in">

        		<? $act=$tripGet['activity']; ?>

				<? $t=mysqli_query($GLOBALS["___mysqli_ston"], "select * from groups where linkType='Product' and activity='$act' order by weight");

				while($tGet=mysqli_fetch_assoc($t))

				{?>

                	<div class="trip-box">

							<h4>

								<a title="" href="<?=$tGet['urlname'];?>.html">

									<img src="<?=CMS_GROUPS_DIR.$tGet['image'];?>" width="238" height="140" style="border-radius:4px;" />

									<?=$tGet['name'];?>

								</a>

							</h4>

							<p style="margin-top:3px;"><b>Product Code:</b> <?=$tGet['code'];?></p>

                            <?php /*?><p><b>Product Price:</b> <?=$tGet['price'];?></p><?php */?>

							<p class="enq"><?=substr(strip_tags($tGet['shortcontents']), 0, 100);?>...</p>

                            

                            <div style="margin-top:10px;">

                            	<a class="view" href="<?=$tGet['urlname'];?>.html">View Detail</a>

                                <!--<a class="enquiry" href="order-<?=$tGet['urlname'];?>">Order Now</a>-->
                                <div style="clear:both"></div>

                            </div>

                            

						</div>

                <? }?>

                <div style="clear:both"></div>

                

        	</div>

        </div>

    

	</div>
    
</div>

