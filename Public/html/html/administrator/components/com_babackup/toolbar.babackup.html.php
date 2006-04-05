<?php
/**
* bigAPE Site Backup 0.1 for Mambo CMS
* @version $Id: toolbar.babackup.php,v 0.1 2005/03/28 17:32:00 bigAPE Exp $
* @package baBackup
* @copyright (C) 1998 - 2005 bigAPE Development Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Oficial website: http://www.bigape.co.uk.com/
* -------------------------------------------
* Toolbar Presentation Layer
* Creator: Alex Maddern
* Email: mambo@bigape.co.uk
* Revision: 0.1
* Date: April 2005
*/


/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

class TOOLBAR_babackup {

  function _GENERATE() {
    mosMenuBar::startTable();
    mosMenuBar::custom('show','restore.png','restore_f2.png','Back',false);
    mosMenuBar::endTable();
  }

  function _CONFIRM() {
    mosMenuBar::startTable();
    mosMenuBar::custom('generate','next.png','next_f2.png','Continue',false);
    mosMenuBar::spacer();
    mosMenuBar::custom('show','cancel.png','cancel_f2.png','Cancel',false);
    mosMenuBar::endTable();
  }

  function _DEFAULT() {
    mosMenuBar::startTable();
    mosMenuBar::custom('confirm','new.png','new_f2.png','Generate Backup',false);
    mosMenuBar::spacer();
    mosMenuBar::deleteList();
    mosMenuBar::spacer();
    mosMenuBar::cancel();
    mosMenuBar::endTable();
  }
}
?>
