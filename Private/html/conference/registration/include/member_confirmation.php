
<table width="500"  id=confirm  cellpadding="3" cellspacing="0">
 
 <?php if ($SEND_EMAIL) { ?>
 	 <tr>
    <td  colspan=3 style=" padding:5px;">
    	<strong>Registration Complete</strong>: <br/>
      Thank you for registering for the Sakai Amsterdam conference.
 	 You will receive a confirmation email shortly.
   
    </td>
</tr> <?php } ?>
<tr>
		<td valign=top colspan=3 style="border-bottom: 0px solid #cccccc; width:100%; font-size:12px;"><br/>
		<span style="font-weight:bold; font-size:1.2em">Your Registration Details <br/><br/></span></td>
	</tr>
	<tr>
		<td width="10%" valign=top style="padding-right:10px;border-right: 1px dotted #cccccc;" ><strong>Contact Information</strong></td>
		<td valign=top width="30%" style="padding-left:10px">
			<?= $User->firstname."&nbsp;".$User->lastname ?><br/> 
			<?= $User->institution ?><br/>
			<?= nl2br($User->address) ?><br/>
			<?= $User->city ." ". $User->state .", ". $User->zipcode ?><br/>
			<?= $User->country ?><br/>
			<br />
		</td>
		<td valign=top >	<strong>email: </strong> <?= $User->email ?><br/>
			<strong>phone: </strong>  <?= $User->phone ?>
		<?php if ($User->fax) { ?>
		<strong>fax: </strong> <?= $User->fax ?><br/>
		<?php } ?>
	
		</td>
	</tr>
	<tr><td>&nbsp;</td></tr>
	<tr>
		<td valign=top style="border-right: 1px dotted #cccccc; padding-right:10px;"><strong>Registration Information</strong></td>
		<td colspan=2 style="padding-left:10px;">
				<strong>Date Registered: </strong> &nbsp;&nbsp;&nbsp;&nbsp; <?= $CONF['date_created'] ?><br/>
				<strong>T-shirt size:</strong> &nbsp;&nbsp;&nbsp;&nbsp; <?= $CONF['shirt'] ?><br/>
				
					<?php if ($CONF['jasig']) { ?>
						<strong>Attending Jasig:</strong> &nbsp; &nbsp;&nbsp;&nbsp;<?= $CONF['jasig'] ?><br/>
					
					<?php }?>
					
						<strong>Staying at conference hotel:</strong> &nbsp;&nbsp;&nbsp;&nbsp; <?= $CONF['confHotel'] ?><br/>
					 
					
						<strong>Name on publidhed attendee list:</strong> &nbsp;&nbsp;&nbsp;&nbsp; <?= $CONF['publishInfo'] ?><br/>
					
					<?php if ($CONF['special']) { ?>
					<strong>Special needs: </strong>&nbsp;&nbsp;&nbsp;&nbsp;<?=$CONF['special']?><br/>
					<?php } ?>
						<?php if ($CONF['expectations']) { ?>
						<strong>Expectations:</strong>&nbsp;&nbsp;&nbsp;&nbsp;<?=$CONF['expectations']?><br/>
					<?php } ?>	<?php if ($CONF['attending']) { ?>
					<strong>Dates Attending: </strong> &nbsp;&nbsp;&nbsp;&nbsp;<?=$CONF['attending']?><br/>
					<?php } ?>		
				
					
				
					
  	</tr>
  	
	<tr><td>&nbsp;</td></tr>
	<tr>
		<td valign=top style="border-right: 1px dotted #cccccc; padding-right:10px;"><br/><strong>Payment Information</strong><br/><br/><br/></td>
		<td colspan=2 style="padding-left:10px;"><br/>
		<strong>Registration Fee</strong>:  &nbsp;&nbsp;&nbsp;&nbsp;
						<?php if (!$fee) {
							$fee="Member Organization:  No Fee Required ";  echo $fee; } 
						else { 
							echo "$" .$fee;  ?><br/>
						<strong>Amount Paid</strong>:  &nbsp;&nbsp;&nbsp;&nbsp; $<?=$fee?>
						<?php } ?>					

</td></tr>
  	<tr><td><div class="padding50"> </div>
	</table>