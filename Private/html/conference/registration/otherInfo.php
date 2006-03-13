<form name="<?php echo $formID; ?>" id=form1 method="post" action="<?php echo $_SERVER[PHP_SELF] . "?formid=$formID"; ?>">
  <table width="500px"  cellpadding="0" cellspacing="0">
    <tr>
      <td valign="top" colspan="2" style="padding:0px;"><span class="small"> * = Required fields</span> </td>
    </tr>
    <?php 
if ($message) {
	echo "<tr><td colspan=2><div class=\"errors\" align=\"left\"><font color=red><strong>Please provide the following information:</strong></font>
	<ul class=small style=\"padding:0px 10px;\">";	
	foreach ($message as $key => $value) {
		echo $value;	
	}
	echo "</ul></div></td></tr> ";
}


?>
    <?php

?>
    <tr>
      <td colspan=2><strong>* Hotel Information</strong><br />
        <br />
        <div style="padding-left: 40px;"> Will you be staying at the conference hotel, the Sheraton Vancouver Wall Centre, where the conference is being held?<br />
          <input type="radio" name="hotelInfo" value="Y" <?php if ($_POST['hotelInfo']=="Y") echo "checked" ?>/>
          <strong>Yes </strong>
          <input type="radio" name="hotelInfo" value="N" <?php if ($_POST['hotelInfo']=="N") echo "checked" ?>/>
          <strong>No</strong> </div></td>
    </tr>
    <tr>
      <td colspan=2><strong>* Community Source Week Conferences:</strong><br />
        <br />
        <div style="padding-left: 40px;"> Will you also be attending the JA-SIG/uPortal conference in Vancouver June 4-6, 2005?<br />
          <input type="radio" name="jasig" value="Y" <?php if ($_POST['jasig']=="Y") echo "checked" ?> />
          <strong>Yes </strong>
          <input type="radio" name="jasig" value="N" <?php if ($_POST['jasig']=="N") echo "checked" ?>/>
          <strong>No </strong> </div></td>
    </tr>
    <tr>
      <td colspan=2><br />
        <br />
        <div style="padding:0px 20px;"><strong>Special Needs:</strong> We are committed to making our conference activities accessible and enjoyable for everyone.&nbsp; If you have any type of special needs (i.e. dietary or accessibility), please provide that information here.<br />
        </div>
        <div style="padding-left: 40px;">
          <textarea name="special" cols=60 rows=3><?php echo $_POST['special'];?></textarea>
        </div></td>
    </tr>
    <tr>
    <tr>
      <td colspan=2 valign=top><strong> * Conference T-Shirt : </strong><br />
        <br />
        <div style="padding-left: 40px;">Please select your t-shirt size
          <?php                                  
$shirt = $_POST['shirt'];
?>
          <select name="shirt">
            <?php if (!$shirt==""){
echo "
 <option value=\"$shirt\" SELECTED>$shirt</option>";
 }  ?>
            <option value="">-- Select Size --</option>
            <option value="Small">Small</option>
            <option value="Medium">Medium</option>
            <option value="Large">Large</option>
            <option value="X-Large">X-Large</option>
            <option value="XX-Large">XX-Large</option>
            <option value="XXX-Large">XXX-Large</option>
          </select>
        </div></td>
    </tr>
    <tr>
      <td colspan=2><strong> Attendance Lists:</strong><br />
        <div style="padding-left: 40px;">We may publish a list of conference attendees both on the website and in printed programs (Names/Institutions only, no email addresses will be published). Check the box below to request your name not be published on this lists. <br />
          <div style="padding-left: 40px;">
            <input type="checkbox" name="publish" value="N" <?php if ($_POST['publish']=="N") echo "checked" ?> />
            Do <strong>NOT</strong> publish my name </div>
        </div></td>
    </tr>
    <?php



if ($_SESSION['memberType']=="1") {
?>
    <tr>
      <td colspan=2><div align=center>
          <input id="submitbutton" type="submit" name="submit_MemberReg" value="Submit my registration" />
        </div></td>
    </tr>
    <?php  }   
                        else {
                        
                        ?>
    <tr>
      <td colspan=2><div align=center>
          <input id="submitbutton" type="submit" name="submit_NonMemberReg" value="continue" />
        </div></td>
    </tr>
    <?php  } 
                       
                       
                        
                        ?>
  </table>
</form>