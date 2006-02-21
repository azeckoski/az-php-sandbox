<?php
function com_install()
{
  //file operations
  chdir("../");

  @chmod("administrator/components/com_babackup/backups", 0777);

  global $database;
  $database->setQuery( "SELECT id FROM #__components WHERE admin_menu_link = 'option=com_babackup'" );
  $id = $database->loadResult();

  //add new admin menu images
  $database->setQuery( "UPDATE #__components SET admin_menu_img = 'js/ThemeOffice/config.png', admin_menu_link = '' WHERE id='$id'");
  $database->query();
  $database->setQuery( "UPDATE #__components SET admin_menu_img = 'js/ThemeOffice/preview.png' WHERE parent='$id' AND admin_menu_link = 'option=com_babackup&task=show'");
  $database->query();
  $database->setQuery( "UPDATE #__components SET admin_menu_img = 'js/ThemeOffice/backup.png' WHERE parent='$id' AND admin_menu_link = 'option=com_babackup&task=confirm'");
  $database->query();
  $database->setQuery( "UPDATE #__components SET admin_menu_img = 'js/ThemeOffice/users.png' WHERE parent='$id' AND admin_menu_link = 'option=com_babackup&task=credits'");
  $database->query();
}

?>

license