<?php
/**
* @version $Id: registration.php,v 1.2 2005/08/08 00:40:48 eddieajau Exp $
* @package Mambo
* @copyright (C) 2000 - 2005 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

$task = mosGetParam( $_REQUEST, 'task', "" );
require_once( $mainframe->getPath( 'front_html' ) );

switch( $task ) {
	case "lostPassword":
	lostPassForm( $option );
	break;

	case "sendNewPass":
	sendNewPass( $option );
	break;

	case "register":
	registerForm( $option, $mosConfig_useractivation );
	break;

	case "saveRegistration":
	saveRegistration( $option );
	break;

	case "activate":
	activate( $option );
	break;
}

function lostPassForm( $option ) {
	global $mainframe;
	$mainframe->SetPageTitle(_PROMPT_PASSWORD);
	HTML_registration::lostPassForm($option);
}

function sendNewPass( $option ) {
	global $database, $Itemid;
	global $mosConfig_live_site, $mosConfig_sitename;

	$_live_site = $mosConfig_live_site;
	$_sitename = $mosConfig_sitename;

	// ensure no malicous sql gets past
	$checkusername = trim( mosGetParam( $_POST, 'checkusername', '') );
	$checkusername = $database->getEscaped( $checkusername );
	$confirmEmail = trim( mosGetParam( $_POST, 'confirmEmail', '') );
	$confirmEmail = $database->getEscaped( $confirmEmail );

	$database->setQuery( "SELECT id FROM #__users"
	. "\nWHERE username='$checkusername' AND email='$confirmEmail'"
	);

	if (!($user_id = $database->loadResult()) || !$checkusername || !$confirmEmail) {
		mosRedirect( "index.php?option=$option&task=lostPassword&mosmsg="._ERROR_PASS );
	}

	$database->setQuery( "SELECT name, email FROM #__users"
	. "\n WHERE usertype='superadministrator'" );
	$rows = $database->loadObjectList();
	foreach ($rows AS $row) {
		$adminName = $row->name;
		$adminEmail = $row->email;
	}

	$newpass = mosMakePassword();
	$message = _NEWPASS_MSG;
	eval ("\$message = \"$message\";");
	$subject = _NEWPASS_SUB;
	eval ("\$subject = \"$subject\";");

	mosMail($mosConfig_mailfrom, $mosConfig_fromname, $confirmEmail, $subject, $message);

	$newpass = md5( $newpass );
	$sql = "UPDATE #__users SET password='$newpass' WHERE id='$user_id'";
	$database->setQuery( $sql );
	if (!$database->query()) {
		die("SQL error" . $database->stderr(true));
	}

	mosRedirect( "index.php?Itemid=$Itemid&mosmsg="._NEWPASS_SENT );
}

function registerForm( $option, $useractivation ) {
	global $mainframe, $database, $my, $acl;

	if (!$mainframe->getCfg( 'allowUserRegistration' )) {
		mosNotAuth();
		return;
	}


  $mainframe->SetPageTitle(_REGISTER_TITLE);
	HTML_registration::registerForm($option, $useractivation);
}

function saveRegistration( $option ) {
	global $database, $my, $acl;
	global $mosConfig_sitename, $mosConfig_live_site, $mosConfig_useractivation, $mosConfig_allowUserRegistration;
	global $mosConfig_mailfrom, $mosConfig_fromname, $mosConfig_mailfrom, $mosConfig_fromname;

	if ($mosConfig_allowUserRegistration=='0') {
		mosNotAuth();
		return;
	}

	$row = new mosUser( $database );

	if (!$row->bind( $_POST, 'usertype' )) {
		echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
		exit();
	}

	mosMakeHtmlSafe($row);

	$row->id = 0;
	$row->usertype = '';
	$row->gid = $acl->get_group_id( 'Registered', 'ARO' );

	if ($mosConfig_useractivation == '1') {
		$row->activation = md5( mosMakePassword() );
		$row->block = '1';
	}

	if (!$row->check()) {
		echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
		exit();
	}

	$pwd = $row->password;
	$row->password = md5( $row->password );
	$row->registerDate = date("Y-m-d H:i:s");

	if (!$row->store()) {
		echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
		exit();
	}
	$row->checkin();

	$name = $row->name;
	$email = $row->email;
	$username = $row->username;

	$subject = sprintf (_SEND_SUB, $name, $mosConfig_sitename);
	$subject = html_entity_decode($subject, ENT_QUOTES);
	if ($mosConfig_useractivation=="1"){
		$message = sprintf (_USEND_MSG_ACTIVATE, $name, $mosConfig_sitename, $mosConfig_live_site."/index.php?option=com_registration&task=activate&activation=".$row->activation, $mosConfig_live_site, $username, $pwd);
	} else {
		$message = sprintf (_USEND_MSG, $name, $mosConfig_sitename, $mosConfig_live_site);
	}

	$message = html_entity_decode($message, ENT_QUOTES);
	// Send email to user
	if ($mosConfig_mailfrom != "" && $mosConfig_fromname != "") {
		$adminName2 = $mosConfig_fromname;
		$adminEmail2 = $mosConfig_mailfrom;
	} else {
		$database->setQuery( "SELECT name, email FROM #__users"
		."\n WHERE usertype='superadministrator'" );
		$rows = $database->loadObjectList();
		$row2 = $rows[0];
		$adminName2 = $row2->name;
		$adminEmail2 = $row2->email;
	}

	mosMail($adminEmail2, $adminName2, $email, $subject, $message);

	// Send notification to all administrators
	$subject2 = sprintf (_SEND_SUB, $name, $mosConfig_sitename);
	$message2 = sprintf (_ASEND_MSG, $adminName2, $mosConfig_sitename, $row->name, $email, $username);
	$subject2 = html_entity_decode($subject2, ENT_QUOTES);
	$message2 = html_entity_decode($message2, ENT_QUOTES);

	// get superadministrators id
	$admins = $acl->get_group_objects( 25, 'ARO' );

	foreach ( $admins['users'] AS $id ) {
		$database->setQuery( "SELECT email, sendEmail FROM #__users"
			."\n WHERE id='$id'" );
		$rows = $database->loadObjectList();

		$row = $rows[0];

		if ($row->sendEmail) {
			mosMail($adminEmail2, $adminName2, $row->email, $subject2, $message2);
		}
	}

	if ( $mosConfig_useractivation == "1" ){
		echo _REG_COMPLETE_ACTIVATE;
	} else {
		echo _REG_COMPLETE;
	}

}

function activate( $option ) {
	global $database;
	global $mosConfig_useractivation, $mosConfig_allowUserRegistration;

	if ($mosConfig_allowUserRegistration == '0' || $mosConfig_useractivation == '0') {
		mosNotAuth();
		return;
	}

	$activation = mosGetParam( $_REQUEST, 'activation', '' );
	$activation = $database->getEscaped( $activation );

	if (empty( $activation )) {
		echo _REG_ACTIVATE_NOT_FOUND;
		return;
	}

	$database->setQuery( "SELECT id FROM #__users"
	."\n WHERE activation='$activation' AND block='1'" );
	$result = $database->loadResult();

	if ($result) {
		$database->setQuery( "UPDATE #__users SET block='0', activation='' WHERE activation='$activation' AND block='1'" );
		if (!$database->query()) {
			echo "SQL error" . $database->stderr(true);
		}
		echo _REG_ACTIVATE_COMPLETE;
	} else {
		echo _REG_ACTIVATE_NOT_FOUND;
	}
}

function is_email($email){
	$rBool=false;

	if(preg_match("/[\w\.\-]+@\w+[\w\.\-]*?\.\w{1,4}/", $email)){
		$rBool=true;
	}
	return $rBool;
}
?>
