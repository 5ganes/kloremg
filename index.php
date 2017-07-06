<? include('clientobjects.php'); ?>

<? include "count.php"; ?>

<!DOCTYPE html>

<!-- saved from url=(0022)http://krishighar.com/ -->

<html>

<head>

	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

	<meta charset="utf-8">

		<title>

			Krishi Ghar-

    		<?php if($pageName!=""){ echo $pageName;}else if(isset($_GET['action'])){ echo $_GET['action'];}else{ echo "Home";}?>

		</title>

        <? include('baselocation.php'); ?>

       	<link rel="shortcut icon" type="image/png" href="images/agri.png">

		<link href="css/stylesheet.css" rel="stylesheet" type="text/css">

		<link href="css/default.css" rel="stylesheet" type="text/css">

        <link rel="shortcut icon" type="image/x-icon" href="images/krishighartitle.png" />

</head>

	

<body>

	<?php include_once("analyticstracking.php") ?>

	<div id="container">

		

        <div id="wrapper">

			

            <? include("header.php");?>

			<!--- Main Content Starts here-->

			

            <div id="content"> 

				

				<?php 

					if(isset($_GET['action']))

					{

						//echo "dildo"; die();

						$action = $_GET['action'];

						$action = str_replace(".","", $action);

						include("includes/".$action.".php");			

					}				

					else if(isset($pageLinkType))

					{

						//echo "dildo"; die();

						if ($pageLinkType == ""){}

						else{ include("includes/cmspage.php"); }

					}

					else{ include("includes/main.php"); }

				?>

			

			</div>

          

			<!-- Wrapper-->

			

            <div class="footer">

            <div id="footer">

                <div class="footer-social-icon">

            		<h4> हाम्रो अनलाईन सम्पर्क </h4>

            		<ul>

                		<li><iframe src="//www.facebook.com/plugins/like.php?href=https%3A%2F%2Ffacebook.com%2Fkrishighar&amp;width&amp;layout=standard&amp;action=like&amp;show_faces=false&amp;share=true&amp;height=35" scrolling="no" frameborder="0" style="border:none; overflow:hidden; height:35px;" allowTransparency="true"></iframe></li>

                		<? 			
							if (file_exists('../count_file.txt')) 
							{
								$fil = fopen('../count_file.txt', r);
								$dat = fread($fil, filesize('../count_file.txt')); 
								//echo $dat;
								fclose($fil);
							}
								
						?>
                		<li style="margin-top: 10%"><b>Visitors: <?=$dat;?></b></li>

            		</ul>

            

            	</div>

                <div class="last-footer">

            		<p class="footer-text" style="font-weight:bold; font-size:16px; margin-top:10px;"> Collaborative Partners</p>
            			<img src="images/moad doa.png" title="MOAD DOA" />
            			<img src="images/moad aicc.png" title="MOAD AICC" />
            			<img src="images/moap.png" title="MOAP" />
            			<img src="images/ictan.png" title="ICT in Agricluture Nepal" /> 
                        <img src="images/undp.png" title="UNDP" /> 
                        
            	</div>

            </div> <!-- Footer-->

            <div class="copyright">

            	Copyright @Krishi Ghar 20<?=date("y");?>. All rights reserved.

            </div>

            </div>

		</div><!---Container--->

	</div>

</body>

</html>

<? echo die();?>