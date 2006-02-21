<?PHP /* $Id$ */

	/**
	* TFS for MAMBO Class
	* @package TFSforMAMBO
	* @copyright 2004 PJH Diender
	* @license http://www.gnu.org/copyleft/gpl.html. GNU Public License
	* @version $Revision: 2.0-RC1 $
	* @author Patrick Diender <caffeincoder@oplossing.net>
	*/
	
	//ensure this file is being included by a parent file
	defined('_VALID_MOS') or die ('Direct Access to this location is not allowed.');

	require_once($mainframe->getPath('toolbar_html'));
		
	switch ($task)
	{
		case "getconf":
			menu_tfsformambo::CONFIG_MENU();
			break;
		case "uninstall":
			menu_tfsformambo::UNINSTALL_MENU();
			break;
		case "summinfo":
			menu_tfsformambo::SUMMARISE_MENU();
			break;
	}	
?>