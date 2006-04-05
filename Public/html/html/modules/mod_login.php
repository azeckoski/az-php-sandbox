<?php
/**
* @version $Id: mod_login.php,v 1.1 2005/07/22 01:58:29 eddieajau Exp $
* @package Mambo
* @copyright (C) 2000 - 2005 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

$return = mosGetParam( $_SERVER, 'REQUEST_URI', null );
// converts & to &amp; for xtml compliance
$return = str_replace( '&', '&amp;', $return );

$registration_enabled 	= $mainframe->getCfg( 'allowUserRegistration' );
$message_login 			= $params->def( 'login_message', 0 );
$message_logout 		= $params->def( 'logout_message', 0 );
$pretext 	= $params->get( 'pretext' );
$posttext 	= $params->get( 'posttext' );
$login 		= $params->def( 'login', $return );
$logout 	= $params->def( 'logout', $return );
$name 		= $params->def( 'name', 1 );
$greeting 	= $params->def( 'greeting', 1 );

if ( $name ) {
	$query = "SELECT name FROM #__users WHERE id = ". $my->id;
	$database->setQuery( $query );
	$name = $database->loadResult();
} else {
	$name = $my->username;
}

if ( $my->id ) {
	?>
	<form action="<?php echo sefRelToAbs( 'index.php?option=logout' ); ?>" method="post" name="login" >
	<?php
	if ( $greeting ) {
		echo _HI;
		echo $name;
	}
	?>
	<br />
	<div align="center">
	<input type="submit" name="Submit" class="button" value="<?php echo _BUTTON_LOGOUT; ?>" />
	</div>

	<input type="hidden" name="op2" value="logout" />
	<input type="hidden" name="lang" value="<?php echo $mosConfig_lang; ?>" />
	<input type="hidden" name="return" value="<?php echo sefRelToAbs( $logout ); ?>" />
	<input type="hidden" name="message" value="<?php echo $message_logout; ?>" />
	</form>
	<?php
} else {
	?>
	<form action="<?php echo sefRelToAbs( 'index.php' ); ?>" method="post" name="login" >
	<?php
	echo $pretext;
	?>
	<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
	<tr>
		<td>
		<?php echo _USERNAME; ?>
		<br />
		<input name="username" type="text" class="inputbox" alt="username" size="10" />
		<br />
		<?php echo _PASSWORD; ?>
		<br />
		<input type="password" name="passwd" class="inputbox" size="10" alt="password" />
		<br />
		<input type="checkbox" name="remember" class="inputbox" value="yes" alt="Remember Me" /> 
		<?php echo _REMEMBER_ME; ?>
		<br />
		<input type="hidden" name="option" value="login" />
		<input type="submit" name="Submit" class="button" value="<?php echo _BUTTON_LOGIN; ?>" />
		</td>
	</tr>
	<tr>
		<td>
		<a href="<?php echo sefRelToAbs( 'index.php?option=com_registration&amp;task=lostPassword' ); ?>">
		<?php echo _LOST_PASSWORD; ?>
		</a>
		</td>
	</tr>
	<?php
	if ( $registration_enabled ) {
		?>
		<tr>
			<td>
			<?php echo _NO_ACCOUNT; ?>
			<a href="<?php echo sefRelToAbs( 'index.php?option=com_registration&amp;task=register' ); ?>">
			<?php echo _CREATE_ACCOUNT; ?>
			</a>
			</td>
		</tr>
		<?php
	}
	?>
	</table>
	<?php
	echo $posttext;
	?>
	
	<input type="hidden" name="op2" value="login" />
	<input type="hidden" name="lang" value="<?php echo $mosConfig_lang; ?>" />
	<input type="hidden" name="return" value="<?php echo sefRelToAbs( $login ); ?>" />
	<input type="hidden" name="message" value="<?php echo $message_login; ?>" />
	</form>
	<?php
}
?>
