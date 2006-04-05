<?php
/**
* @version $Id: messages.class.php,v 1.2 2005/10/21 17:33:55 lang3 Exp $
* @package Mambo
* @subpackage Messages
* @copyright (C) 2000 - 2005 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

/**
* @package Mambo
* @subpackage Messages
*/
class mosMessage extends mosDBTable {
	/** @var int Primary key */
	var $message_id=null;
	/** @var int */
	var $user_id_from=null;
	/** @var int */
	var $user_id_to=null;
	/** @var int */
	var $folder_id=null;
	/** @var datetime */
	var $date_time=null;
	/** @var int */
	var $state=null;
	/** @var int */
	var $priority=null;
	/** @var string */
	var $subject=null;
	/** @var text */
	var $message=null;
	
	/**
	* @param database A database connector object
	*/
	function mosMessage( &$db ) {
		$this->mosDBTable( '#__messages', 'message_id', $db );
	}
	
	function send( $from_id=null, $to_id=null, $subject=null, $message=null ) {
		global $database;
		global $mosConfig_site_name;
		
		if (is_object( $this )) {
			$from_id = $from_id ? $from_id : $this->user_id_from;
			$to_id = $to_id ? $to_id : $this->user_id_to;
			$subject = $subject ? $subject : $this->subject;
			$message = $message ? $message : $this->message;
		}
		
		$database->setQuery( "SELECT cfg_name, cfg_value"
		. "\nFROM #__messages_cfg"
		. "\nWHERE user_id='$to_id'"
		);
		$config = $database->loadObjectList( 'cfg_name' );
		$locked = @$config['lock']->cfg_value;
		$domail = @$config['mail_on_new']->cfg_value;
		
		if (!$locked) {
			
			$this->user_id_from = $from_id;
			$this->user_id_to = $to_id;
			$this->subject = $subject;
			$this->message = $message;
			$this->date_time = date( "Y-m-d H:i:s" );

			if ($this->store()) {
				if ($domail) {
					$database->setQuery( "SELECT email FROM #__users WHERE id='$to_id'" );
					$recipient = $database->loadResult();
					$subject = _NEW_MESSAGE;
					$msg = _NEW_MESSAGE;
					mosMail($mosConfig_mailfrom, $mosConfig_fromname, $recipient, $subject, $msg);
				}
				return true;
			}
		} else {
			if (is_object( $this )) {
				$this->_error = _MESSAGE_FAILED;
			}
		}
		return false;
	}
}
?>
