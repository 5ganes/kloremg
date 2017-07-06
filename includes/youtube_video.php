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
}
</style>

<link rel="stylesheet" type="text/css" href="css/detail.css"/>
<style type="text/css"> .trip-box {
    min-height: 210px; </style>
<div class="content">
	<div class="leftnav">
		<h2>CROPS</h2>
		<ul>
			<?
			$cat=$crop->getCrops();
			while($catGet=$conn->fetchArray($cat)){?>
        		<li><a href="<?=SITE_URL.'our-videos/'.$catGet['id'];?>"><?=$catGet['name'];?></a></li>
        	<? }?>
        </ul>
	</div>
	<div class="rightnav">
    
	    <div class="contentHdr" style="margin-bottom:8px;">
	    	<h2>Our Videos</h2>
	  	</div>
	    
	    <div id="bodydetail">
	  
	    	<div id="trip-box" style="width: 100%">
	        	<div id="trip-box-in">
	        		<? if(!isset($_GET['crop'])){
	        			//$crop=$_GET['crop'];
	        			$vdo="select * from video where publish='Yes' order by id";
	        			//echo "sdf";
	        		}
	        		else{
	        			$url=$_GET['crop'];
	        			$vdo="select * from video where cropId='$url' and publish='Yes' order by weight";
		            }?>
	                <?
	                $vdo.=" limit 0,18";
	                $vdo=$conn->exec($vdo);
	                if($conn->numRows($vdo)==0){ echo "No Videos Available";}
	                while($videoGet=$conn->fetchArray($vdo))
					{?>
	                	<div class="trip-box">
							<h4>
								<iframe id="video" src="<?=$videoGet['url'];?>" frameborder="0" allowfullscreen width="224" height="155"></iframe>
							</h4>	                            
							<p class="enq"><?=$videoGet['name'];?></p>
                            	                            
						</div>
	                <? }?>

	                <div style="clear:both"></div>
	                
	        	</div>
	        </div>
		</div>
	</div>
	<div style="clear: both;"></div>
</div>
