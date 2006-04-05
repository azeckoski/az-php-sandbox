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

	class menu_tfsformambo 
	{
		/**
		* Draws the menu for configuration of TFSforMAMBO
		*/
		function CONFIG_MENU()
		{
			mosMenuBar::startTable();
			mosMenuBar::save('saveconf');
			mosMenuBar::back();
			mosMenuBar::spacer();
			mosMenuBar::endTable();
		}
		function UNINSTALL_MENU()
		{
			mosMenuBar::startTable();
			mosMenuBar::custom('uninstalltask','delete.png','delete_f2.png','delete tables',false);
			mosMenuBar::back();
			mosMenuBar::spacer();
			mosMenuBar::endTable();
		}
		function SUMMARISE_MENU()
		{
			mosMenuBar::startTable();
			mosMenuBar::custom('summtask','archive.png','archive_f2.png','summarise',false);
			mosMenuBar::back();
			mosMenuBar::spacer();
			mosMenuBar::endTable();
		}

	}
	
?>