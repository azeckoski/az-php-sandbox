<?php
/**
* bigAPE Site Backup 0.1 for Mambo CMS
* @version $Id: toolbar.babackup.php,v 0.1 2005/03/28 17:32:00 bigAPE Exp $
* @package baBackup
* @copyright (C) 1998 - 2005 bigAPE Development Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Oficial website: http://www.bigape.co.uk.com/
* -------------------------------------------
* Toolbar Business Layer
* Creator: Alex Maddern
* Email: mambo@bigape.co.uk
* Revision: 0.1
* Date: April 2005
*/


/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

require_once( $mainframe->getPath( 'toolbar_html' ) );

switch ( $task ) {
  case 'help':
  case 'credits':
  case 'generate':
    TOOLBAR_babackup::_GENERATE();
    break;

  case 'confirm':
    TOOLBAR_babackup::_CONFIRM();
    break;

  default:
    TOOLBAR_babackup::_DEFAULT();
    break;
}
?>
