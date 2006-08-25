
<table width="500"  id=confirm  cellpadding="3" cellspacing="0">
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td  colspan=2 style=" padding:5px;">
    	<strong>Registration Complete</strong>: <br/>
      Thank you for registering for the Sakai Vancouver conference.
<?php if ($SEND_EMAIL) { echo "You will receive a confirmation email shortly."; } ?>
      We look forward to seeing you in Vancouver! <br/>
      <br/>
      -- Sakai Conference Committee
    </td>
</tr>
<tr>
	<td valign="top" align="left">
		<strong>Registrant's Information: </strong>
		<br/>
		<strong>name:</strong> <?= $User->firstname."&nbsp;".$User->lastname ?><br/> 
		<strong>email: </strong> <?= $User->email ?><br/>
		<strong>institution: </strong> <?= $User->institution ?><br/>
		<strong>address:</strong><br/>
		<?= nl2br($User->address) ?><br/>
		<?= $User->city ." ". $User->state .", ". $User->zipcode ?><br/>
		<?= $User->country ?><br/>
		<br />
		<strong>phone:</strong> <?= $User->phone ?><br/>
		<?php if ($User->fax) { ?>
		<strong>fax:</strong> <?= $User->fax ?><br/>
		<?php } ?>
		<br/>
		<strong>shirt size:</strong> <?= $CONF['shirt'] ?><br/>
		<strong>attending jasig:</strong> <?= $CONF['jasig'] ?><br/>
		<strong>staying at conference hotel:</strong> <?= $CONF['confHotel'] ?><br/>
		<strong>publish name on attendee list:</strong> <?= $CONF['publishInfo'] ?><br/>
		<?php if ($CONF['special']) { echo "<strong>Special needs: </strong> $CONF[special]<br/>"; } ?>
		<?php if ($CONF['expectations']) { echo "<strong>Expectations:</strong> $CONF[expectations]<br/>"; } ?>
		<?php if ($CONF['attending']) { echo "<strong>Attending: </strong> $CONF[attending]<br/>"; } ?>
		<br/>
	</td>
</tr>
<!-- <tr>
    <td colspan=2><blockquote style="background:#fff; border: 1px solid #ffcc33; padding: 5px;">
    <strong>Special announcements and reminders:</strong>
        <ul>
          <li><strong>Visit the Sakai Conference Facebook</strong> to see who else is attending,  and add your photo while you're there! (see sidebar for more information)</li>
          <li><strong>Call for Proposals Deadline is March 31st.</strong> [ <a href="http://www.sakaiproject.org/index.php?option=com_content&amp;task=blogcategory&amp;id=170&amp;Itemid=519">more information</a> ]</li>
        </ul>
      </blockquote></td>
  </tr> -->
</table>