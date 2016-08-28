<table width="100%" border="0" cellpadding="0" cellspacing="4">
  <tr>
      <td></td>
      <td><strong> Description :</strong></td>
      <td>&nbsp;</td>
</tr>
<tr>
      <td></td>
      <td colspan="2">
        <?
        include ("../fckeditor/fckeditor.php");
        $sBasePath="../fckeditor/";
        
        $oFCKeditor = new FCKeditor('contents');
        $oFCKeditor->BasePath	= $sBasePath ;
        $oFCKeditor->Value		= $contents;
        $oFCKeditor->Height		= "300";
        $oFCKeditor->ToolbarSet	= "Rupens";	
        $oFCKeditor->Create();
        ?>
      </td>
</tr>
</table>
							