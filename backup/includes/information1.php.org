<link href="css/user.css" rel="stylesheet" type="text/css">
<?php //include("includes/breadcrumb.php"); ?>

<div class="contentHdr">
	<div style="float:left"><h2>Send Information</h2></div><div style="float:right"><a href="includes/logoutUser.php">Logout</a></div>
    <div style="clear:both"></div>
</div>

<div class="content">

	
    <table width="<?php echo ADMIN_PAGE_WIDTH; ?>" border="0" align="center" cellpadding="0"
	cellspacing="5" bgcolor="#FFFFFF">
      	
      	<tr>
        
        	<td width="<?php echo ADMIN_LEFT_WIDTH; ?>" valign="top">
            	
                <ul class="menu">
              		<li>
                		<p>Manage Account</p>
                    	<ul>
                        	<li><a href="">Home Page</a></li>
                      		<li><a href="includes/changepswdUser.php">Change Password</a></li>
                      		<li><a href="includes/logoutUser.php">Logout</a></li>
                    	</ul>
                  	</li>
                  	<li>
                    	<p>Manage Information</p>
                    	<ul>
                        	<li><a href="/krishighar/information-provider.html">Send New Information</a></li>
                        	<li><a href="/krishighar/sent-information.html">Sent Informations</a></li>
                        	<li><a href="/krishighar/user-questions.html">Manage Questions</a></li>
    					</ul>
  					</li>
				</ul>
                
            </td>
            
        	<td width="<?php echo ADMIN_BODY_WIDTH; ?>" valign="top"><table width="100%" border="0" cellspacing="1" cellpadding="0">
    
            <tr>
    
              <td class="bgborder"><table width="100%" border="0" cellspacing="1" cellpadding="0">
    
                  <tr>
    
                    <td bgcolor="#fff"><table width="100%" border="0" cellspacing="0" cellpadding="0">
    
                        <tr>
    
                          <td class="heading2">&nbsp; Manage Information
    
                            <div style="float: right;">
    
                              <?
    
                                                            $addNewLink = "information-provider.html";
    
                                                        if(isset($_GET['category']) && !empty($_GET['category']))
    
                                                            $addNewLink .= "?category=".$_GET['category'];
    
                                                        ?>
    
                              <a href="<?= $addNewLink?>" class="headLink">Add New</a></div></td>
    
                        </tr>
    
                        <tr>
    
                          <td>
    
                          <form action="<?= $_REQUEST['uri']?>" method="post" enctype="multipart/form-data">
    
                          <table width="100%" border="0" cellpadding="2" cellspacing="0">
    
                              <?php if(!empty($errMsg)){ ?>
    
                              <tr align="left">
    
                                <td colspan="3" class="err_msg"><?php echo $errMsg; ?></td>
    
                              </tr>
    
                              <?php } ?>                          
    
                                <tr>
    
                                  <td>&nbsp;</td>
    
                                  <td class="tahomabold11"><strong> Info Title : <span class="asterisk">*</span></strong></td>
    
                                  <td><label for="title"></label>
    
                                    <input name="name" type="text" class="text" id="title" value="<?= $name; ?>" onChange="" /></td>
    
                                </tr>
                                
                                <tr><td></td></tr>
                                
                                <tr>
                                  <td></td>
                                  <td class="tahomabold11"><strong>Information Content :</strong></td>

                                  <td>&nbsp;</td>
                                </tr>
                                <tr><td></td></tr>
                                <tr>
                                  <td></td>
                                  <td colspan="2" style="width:400px">
                                    <?php
                                        include ("fckeditor/fckeditor.php");
                                        $sBasePath="fckeditor/";									
                                        $oFCKeditor = new FCKeditor('information');
                                        $oFCKeditor->BasePath	= $sBasePath ;
                                        $oFCKeditor->Value		= $shortcontents;
                                        $oFCKeditor->Height		= "200";
                                        $oFCKeditor->ToolbarSet	= "Rupens";	
                                        $oFCKeditor->Create();
                                    ?>
                                  </td>
    
                                </tr>
    
                                <tr><td></td></tr>
                                
                                <tr>
                                  <td>&nbsp;</td>
                                  <td class="tahomabold11"><strong> Select Location to Send : <span class="asterisk">*</span></strong></td>
                                  <td><label for="title"></label>
                                    <input name="name" type="text" class="text" id="title" value="<?= $name; ?>" onChange="" /></td>
                                </tr>
                                <tr><td></td></tr>
                                                        
                                <tr>
                                  <td></td>
                                  <td class="tahomabold11"><strong>Publish :</strong></td>
                                  <td>
                                    <label>
                                      <input name="publish" type="radio" id="featured_0" value="No" checked="checked" />
                                      No</label>
                                    <label>
                                      <input type="radio" name="publish" value="Yes" id="featured_1" <? if($publish == 'Yes') echo 'checked="checked"';?> />
                                      Yes</label>
                                  </td>
                                </tr>
                                
                                <tr><td></td></tr>
                                
                                <tr>
                                  <td></td>
                                  <td class="tahomabold11"><strong>Weight :</strong></td>
                                  <td><input name="weight" type="text" class="text" id="weight" value="<?php echo $weight; ?>" style="width:25px;" /></td>
    
                                </tr>
    
                                <tr><td></td></tr>
    
                                <? if(file_exists("../".CMS_GROUPS_DIR.$editRow['image']) and $editRow['image']!='' && $_GET['type'] == 'edit')
                                {?>
                                    <tr>
                                      <td></td>
                                      <td class="tahomabold11"><strong>Current Image : </strong></td>
                                      <td><img src="data/imager.php?file=../<?= CMS_GROUPS_DIR.$editRow['image']; ?>&amp;mw=150&amp;mh=150" />
                                      [ <a href="information-provider.html?type=removeImage&id=<?= $id?>">Remove Image</a>]</td>
                                    </tr>
                                <? }?>
                                <tr><td></td></tr>
                                <tr>
                                  <td></td>
                                  <td class="tahomabold11"><strong>Image :</strong></td>
                                  <td><label for="image"></label>

                                    <input type="file" name="image" id="image" /></td>
                                </tr>
                                <tr><td></td></tr>
                             
                                <tr>
                                  <td></td>
                                  <td></td>
                                  <td>
                                    <input name="type" type="submit" class="button" id="button" value="Save" />
                                    <?php if($_GET['type'] == "edit"){?>
                                    <input type="hidden" value="<?= $id?>" name="id" id="id" />
                                    <?php }else{ ?>                                
                                    <input name="reset" type="reset" class="button" id="button2" value="Clear" />
                                    <?php } ?>
                                    </td>
                                </tr>                        
                            </table>
                            </form></td>
                        </tr>
                      </table></td>
                  </tr>
                </table></td>
    
            </tr>
    
            <tr height="5"><td></td></tr>
    
            <tr>
    
              <td class="bgborder"><table width="100%" border="0" cellspacing="1" cellpadding="0">
    
                  <tr>
    
                    <td bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
    
                        <tr>
    
                          <td class="heading2">&nbsp;User List</td>
    
                        </tr>
    
                        <tr>
    
                          <td><table width="100%"  border="0" cellpadding="4" cellspacing="0">
    
                              <tr bgcolor="#F1F1F1" class="tahomabold11">
    
                                <td width="1">&nbsp;</td>
    
                                <td style="width:20px"><strong>Image</strong></td>
    
                                <td style="width:155px"> Name </td>
    
                                <td style="width:75px">Username</td>
    
                                <td style="width:100px">Password</td>
                                
                                <td style="width:10px;">Show</td>
    
                                <td style="width:10px">Weight</td>
    
                                <td style="width:73px"><strong>Action</strong></td>
    
                              </tr>
    
                              <?php
    
                                $counter = 0;
    
                                $pagename = "information-provider.html?";
    
                                $sql = "SELECT * FROM usergroups WHERE publish='Yes'";
    
                                $sql .= " ORDER BY weight";
    
                                //echo $sql;
    
                                $limit = 50;
    
                                include("paging.php");
    
                                while($row = $conn -> fetchArray($result))
    
                                {?>
    
                                    <tr <?php if($counter%2 != 0) echo 'bgcolor="#F7F7F7"'; else echo 'bgcolor="#FFFFFF"'; ?>>
    
                                        <td valign="top">&nbsp;</td>
    
                                        <td valign="top"><img src="../<?= CMS_GROUPS_DIR.$row['image']; ?>" width="40" height="30" /></td>
    
                                        <td valign="top"><?= $row['name'] ?></td>
    
                                        
    
                                        <td valign="top"><?=$row['username'];?></td>
    
                                        <td valign="top"><?=$row['password'];?></td>
    
                                        <td valign="top">
    
                                        <?
    
                                        $changeTo = 'Yes';
    
                                        if ($row['publish'] == 'Yes')
    
                                            $changeTo = 'No';
    
                                        ?>
    
                                        (<?=$row['publish'];?>)</td>
    
                                        <td valign="top"><?= $row['weight'] ?></td>
    
                                        <td valign="top"> [ <a href="information-provider.html?type=edit&id=<?= $row['id']?>">Edit</a> | <a href="#" onClick="javascript: if(confirm('This will permanently remove this User from database. Continue?')){ document.location='users.php?type=del&id=<?php echo $row['id']; ?>'; }">Delete</a> ]</td>
    
                              </tr>
    
                              <?
    
                                                        }
    
                                                        ?>
    
                            </table>
    
                          <?php include("paging_show.php"); ?></td>
    
                        </tr>
    
                      </table></td>
    
                  </tr>
    
                </table></td>
    
            </tr>
    
          </table></td>
          
      	</tr>
      
    </table>

</div>