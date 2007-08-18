<?php
/*
 * Modified on April 01, 2006 by @author aaronz
 * Aaron Zeckoski (aaronz@vt.edu) - Virginia Tech (http://www.vt.edu/)
 * Created by Susan Hardin (shardin@umich.edu)
 */
?>
<?php
// get all the information that is needed into the correct variables for the email confirmation
$shirt=$CONF["shirt"];
$special=$CONF["special"];
$hotel=$CONF["confHotel"];
$jasig=$CONF["jasig"];
$publish=$CONF["publishInfo"];
$fee=$CONF["fee"];
$title=$CONF["title"];
$co_registrant=$CONF["delegate"];
$attending=$CONF["attending"];

$today = date("F j, Y"); 

//set up cleaner mail message -AZ
$msg ="Thank you for your registration to the Sakai Amsterdam Conference, scheduled for June 12-14, 2007 in Amsterdam, The Netherlands (with pre-conference sessions on June 11th, and post-conference session on June 15th). \r\n";
$msg.="\r\n \r\nIf you have any questions about your registration information please contact shardin@umich.edu. \r\n \r\nThank You\r\n      Sakai Staff\r";
$msg.="-------------------------------------------- \r\n\r\n";
$msg.="Date Submitted: $today \r\n\r\n";
$msg.="Attendee:  $User->firstname $User->lastname ($User->email)\r\n\r\n";
$msg.="Organization:\r\n$User->institution \r\n";
// $msg.="Address:\r\n";
$msg.="$User->address \r\n";
$msg.="$User->city, $User->state, $User->zip,    $User->country \r\n\r\n";
$msg.="Phone:  $User->phone  \r\n\r\n";
if ($User->fax) {
	$msg.="Fax:   $User->fax \r\n\r\n";
}
$msg.="T-Shirt size:  $shirt \r\n\r\n";
if ($special) {
	$msg.="Special needs:   $special \r\n\r\n";
} else {
	$msg.="Special needs:  none \r\n\r\n";
}
//$msg.="Attending JA-SIG:   $jasig \r\n\r\n";
$msg.="Staying at Conf. Hotel:   $hotel \r\n\r\n";
$msg.="Dates Attending Conference:   $attending \r\n\r\n";

if ($publish){
	$msg.="Publish name on Attendee list:  $publish ";
}
if ($co_registrant){
	$msg.="\r\n----------------------------------------------------------\r\n" .
			"Your Registration was submitted by: \r\n\r\n$co_registrant \r\n" .
			"----------------------------------------------------------";
}
if ($fee > 0){
	$msg.="\r\n----------------------------------------------------------\r\n" .
			"Payment Information: \r\n\r\n " .
			"Paid by:\r\n$payeeInfo \r\n\r\n " .
			"Transaction ID: $transID\r\n\r\n " .
			"Amount Paid: $transAmount \r\n" .
			"----------------------------------------------------------";
}

// This is a better set of mail headers -AZ
ini_set(SMTP, $MAIL_SERVER);
$headers  = 'From: ' . $HELP_EMAIL . "\n";
$headers .= 'Return-Path: ' . $HELP_EMAIL . "\n";
$headers .= 'Reply-To: ' . $User->email . "\n";
$headers .= 'MIME-Version: 1.0' ."\n";
$headers .= 'Content-type: text/plain; charset=ISO-8859-1' ."\n";
$headers .= 'X-Mailer: PHP/' . phpversion() ."\n";

//set up mail for Susan
$recipient = "shardin@umich.edu";
$subject= "COPY-Amsterdam Reg-$User->firstname $User->lastname";
//send the mail to susan
@mail($recipient, $subject, $msg, $headers);


//set up mail for registrant
$headers  = 'From: ' . $HELP_EMAIL . "\n";
$headers .= 'Return-Path: ' . $HELP_EMAIL . "\n";
$headers .= 'Reply-To: ' . "shardin@umich.edu" . "\n";
$headers .= 'MIME-Version: 1.0' ."\n";
$headers .= 'Content-type: text/plain; charset=ISO-8859-1' ."\n";
$headers .= 'X-Mailer: PHP/' . phpversion() ."\n";

$recipient = $User->email;
$subject= "Sakai Amsterdam Conference Registration";
//send the mail to registrant
@mail($recipient, $subject, $msg, $headers);
?>