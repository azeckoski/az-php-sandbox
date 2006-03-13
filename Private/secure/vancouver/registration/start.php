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
    <tr>
      <td colspan=2><strong>* Select Registration type: </strong><br />
        <br />
        <input type="radio" name="memberType" value="1" <?php if ($_POST['memberType']=="1") echo "checked" ?>/>
&nbsp; <strong>My organization is a Sakai Partner Organization</strong> (registration is waived)<br />
        <br />
        <div style="padding-left: 40px;">
          <?php

require('./includes/sakaiPartners.php');
?>
        </div>
        <br />
        <br />
        <input type="radio" name="memberType" value="2" <?php if ($_POST['memberType']=="2") echo "checked" ?>/>
&nbsp;<strong>My organization is not a Sakai Partner Organization</strong>&nbsp;
        <div style="padding-left: 40px;"><br />
          <strong>Registration Fee:</strong> $395 per person. <br />
          If you are also attending the uPortal conference, your fee will be discounted to $345<br /><br />
          Visa, Mastercard and American express accepted<br /><img src="../../templates/vancouver/images/ccards.jpg" width="121px" height="30px"> </div></td>
    </tr>
    <tr>
      <td colspan=2><strong>* Is this conference registration for yourself, or for someone else? </strong><br />
        <div style=padding-left:40px;"><br />
          <input type="radio" name="regType" value="1" <?php if ($_POST['regType']=="1") echo "checked" ?>/>
          Myself &nbsp; &nbsp;
          <input type="radio" name="regType" value="2" <?php if ($_POST['regType']=="2") echo "checked" ?>/>
&nbsp;Someone else &nbsp;</div></td>
    </tr>
    <tr>
      <td></td>
      <td align=right><input id= submitbutton type="submit" name="submit_start" value="Continue" />
        <br />
      </td>
    </tr>
  </table>
</form>
<?php ?>