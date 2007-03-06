<?php
/**
* @version $Id: weblinks.class.php,v 1.2 2005/07/22 03:30:09 eddieajau Exp $
* @package Mambo
* @subpackage Weblinks
* @copyright (C) 2000 - 2005 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

/**
* Category database table class
* @package Mambo
* @subpackage Weblinks
*/
class mosWeblink extends mosDBTable {
	/** @var int Primary key */
	var $id=null;
	/** @var int */
	var $catid=null;
	/** @var int */
	var $sid=null;
	/** @var string */
	var $title=null;
	/** @var string */
	var $url=null;
	/** @var string */
	var $description=null;
	/** @var datetime */
	var $date=null;
	/** @var int */
	var $hits=null;
	/** @var int */
	var $published=null;
	/** @var boolean */
	var $checked_out=null;
	/** @var time */
	var $checked_out_time=null;
	/** @var int */
	var $ordering=null;
	/** @var int */
	var $archived=null;
	/** @var int */
	var $approved=null;
	/** @var string */
	var $params=null;

	/**
	* @param database A database connector object
	*/
	function mosWeblink( &$db ) {
		$this->mosDBTable( '#__weblinks', 'id', $db );
	}
	/** overloaded check function */
	function check() {
		// filter malicious code
		$ignoreList = array( 'params' );
		$this->filter( $ignoreList );

		// specific filters		
		$iFilter = new InputFilter();
		
		if ($iFilter->badAttributeValue( array( 'href', $this->url ))) {
			$this->_error = 'Please provide a valid URL';
			return false;
		}

		/** check for valid name */
		if (trim( $this->title ) == '') {
			$this->_error = _WEBLINK_TITLE;
			return false;
		}

		if ( !( eregi( 'http://', $this->url ) || ( eregi( 'https://',$this->url ) )  || ( eregi( 'ftp://',$this->url ) ) ) ) {
			$this->url = 'http://'.$this->url;
		}


	   /** check for existing name */
       $this->title = $this->_db->getEscaped($this->title);
       $this->catid = $this->_db->getEscaped($this->catid);
       $this->_db->setQuery( "SELECT id FROM #__weblinks "
       . "\nWHERE title='$this->title' AND catid='$this->catid'"
       );

       $xid = intval( $this->_db->loadResult() );
       if ($xid && $xid != intval( $this->id )) {
           $this->_error = _WEBLINK_EXIST;
           return false;
       }
       return true;
   }
}
?>
