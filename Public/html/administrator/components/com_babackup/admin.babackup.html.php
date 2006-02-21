<?php
/**
* bigAPE Site Backup 0.1 for Mambo CMS
* @version $Id: toolbar.babackup.php,v 0.1 2005/03/28 17:32:00 bigAPE Exp $
* @package baBackup
* @copyright (C) 1998 - 2005 bigAPE Development Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Oficial website: http://www.bigape.co.uk.com/
* -------------------------------------------
* Admin Presentation Layer
* Creator: Alex Maddern
* Email: mambo@bigape.co.uk
* Revision: 0.1
* Date: April 2005
*/


/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

/**
* @package Mambo
* @subpackage baBackup
*/
class HTML_babackup {


  function showBackups( &$files, &$sizes, $path, $option ) {
    // ----------------------------------------------------------
    // Presentation of the backup set list screen
    // ----------------------------------------------------------
    global $baDownloadPath;

    ?>
    <form action="index2.php" method="post" name="adminForm">
    <table cellpadding="4" cellspacing="0" border="0" width="100%">
    <tr>
      <td width="100%" class="sectionname"><img src="images/backup.png" align="middle">&nbsp;<?php echo _COM_TITLE; ?></td>
    </tr>
    </table>
    <table class="adminlist">
    <tr>
      <th width="5">#</th>
      <th width="5">
      <input type="checkbox" name="toggle" value="" onClick="checkAll(<?php echo count( $files ); ?>);" />
      </th>
      <th width="33%" class="title">
      <?php echo _COL_FILENAME ?>
      </th>
      <th align="left" width="10%">
      <?php echo _COL_DOWNLOAD ?>
      </th>
      <th align="left" width="10%">
      <?php echo _COL_SIZE ?>
      </th>
      <th align="left" width="43%">
      <?php echo _COL_DATE ?>
      </th>
      </tr>
    <?php
    $k = 0;
    for ($i=0; $i <= (count( $files )-1); $i++) {
      $date = date ("D jS M Y H:i:s (\G\M\T O)", filemtime($path.'/'.$files[$i]));
      ?>
      <tr class="<?php echo "row$k"; ?>">
        <td>
        <?php echo $i+1; ?>
        </td>
        <td align="center">
        <input type="checkbox" id="cb<?php echo $i ?>" name="cid[]" value="<?php echo $i ?>" onclick="isChecked(this.checked);" />
        </td>
        <td >
        <a href="<?php echo $baDownloadPath.'/'.$files[$i]; ?>"><?php echo $files[$i]; ?></a><input type="hidden" id="f<?php echo $i ?>" name="f<?php echo $i ?>" value="<?php echo $files[$i]; ?>" >
        </td>
        <td align="left">
        <a href="<?php echo $baDownloadPath.'/'.$files[$i]; ?>"><img src="images/filesave.png" border="0" alt="<?php echo _DOWNLOAD_TITLE ?>" title="<?php echo _DOWNLOAD_TITLE ?>"></a></td >
        <td align="left">
        <?php echo $sizes[$i]; ?>
        </td >
        <td align="left">
        <?php echo $date; ?>
        </td>
      </tr>
      <?php
      $k = 1 - $k;
    }
    ?>
    </table>

    <input type="hidden" name="option" value="com_babackup" />
    <input type="hidden" name="task" value="" />
    <input type="hidden" name="boxchecked" value="0" />
    <input type="hidden" name="hidemainmenu" value="0" />
    </form>
    <br/>&nbsp;
    <?php
  }


  function confirmBackups( &$folders, &$sizes, $path, $option ) {
    // ----------------------------------------------------------
    // Presentation of the confirmation screen
    // ----------------------------------------------------------
    global $baDownloadPath, $mosConfig_absolute_path, $baBackupPath;

    ?>
    <form action="index2.php" method="post" name="adminForm">
    <table cellpadding="4" cellspacing="0" border="0" width="100%">
    <tr>
      <td width="100%" class="sectionname"><img src="images/backup.png" align="middle">&nbsp;<?php echo _COM_TITLE; ?></td>
    </tr>
    </table>
    <table class="adminform">
    <tr>
        <td width="50%"><?php echo _CONFIRM_INSTRUCTIONS ?></td>
        <td><b><?php echo _DATABASE_ARCHIVE; ?></b><br/><input type="checkbox" id="dbbackup" name="dbbackup" checked value="1" />&nbsp;<?php echo _CONFIRM_DATABASE; ?></td>
    </tr>
    </table>
    <table class="adminlist">
    <tr>
      <th width="5">
      #
      </th>
      <th width="5">
      <input type="checkbox" name="toggle" value="" checked onClick="checkAll(<?php echo count( $folders ); ?>);" />
      </th>
      <th width="99%" class="title">
      <?php echo _COL_FOLDER ?>
      </th>
      </th>
      </tr>
    <?php
    $k = 0;

    for ($i=0; $i <= (count( $folders )-1); $i++) {
      ?>
      <tr class="<?php echo "row$k"; ?>">
        <td>
        <?php echo $i+1; ?>
        </td>
        <td align="center">
        <input type="checkbox" id="cb<?php echo $i ?>" <?php if ($folders[$i] != $baBackupPath) echo 'checked';?> name="cid[]" value="<?php echo $i ?>" onclick="isChecked(this.checked);" />
        </td>
        <td <?php if ($folders[$i] == $baBackupPath) echo 'style="color:red;"';?>>
        <?php $currentFolder = str_replace($mosConfig_absolute_path, '', $folders[$i]); if ($currentFolder == '') echo "-- Mambo Root --"; else echo $currentFolder; ?><input type="hidden" id="f<?php echo $i ?>" name="f<?php echo $i ?>" value="<?php echo $folders[$i]; ?>" >
        </td>
      </tr>
      <?php
      $k = 1 - $k;
    }
    ?>
    </table>

    <input type="hidden" name="option" value="com_babackup" />
    <input type="hidden" name="task" value="" />
    <input type="hidden" name="boxchecked" value="0" />
    <input type="hidden" name="hidemainmenu" value="0" />
    </form>
    <br/>&nbsp;
    <?php
  }


  function generateBackup( $archiveName, $archiveSize, $originalSize, $d, $f, $databaseResult, $option ) {
    // ----------------------------------------------------------
    // Presentation of the final report screen
    // ----------------------------------------------------------

    ?>
    <table cellpadding="4" cellspacing="0" border="0" width="100%">
    <tr>
      <td width="100%" class="sectionname"><img src="images/backup.png" align="middle">&nbsp;<?php echo _COM_TITLE; ?></td>
    </tr>
    </table>
    <table border="0" align="center" cellspacing="0" cellpadding="2" width="100%" class="adminform">
    </tr>
    <tr>
      <td width="20%"><strong>&nbsp;</strong></td><td>&nbsp;</td>
    </tr>
    <tr>
      <td><strong>&nbsp;<?php echo _ARCHIVE_NAME; ?></strong></td><td><?php echo $archiveName; ?></td>
    </tr>
    <tr>
      <td><strong>&nbsp;<?php echo _NUMBER_FOLDERS; ?></strong></td><td><?php echo $d; ?></td>
    </tr>
    <tr>
      <td><strong>&nbsp;<?php echo _NUMBER_FILES; ?></strong></td><td><?php echo $f; ?></td>
    </tr>
    <tr>
      <td><strong>&nbsp;<?php echo _SIZE_ORIGINAL; ?></strong></td><td><?php echo $originalSize; ?></td>
    </tr>
    <tr>
      <td><strong>&nbsp;<?php echo _SIZE_ARCHIVE; ?></strong></td><td><?php echo $archiveSize; ?></td>
    </tr>
    <tr>
      <td><strong>&nbsp;<?php echo _DATABASE_ARCHIVE; ?></strong></td><td><?php echo $databaseResult; ?></td>
    </tr>


    <tr>
      <td><strong>&nbsp;</strong></td><td>&nbsp;</td>
    </tr>
    </table>
    <form action="index2.php" name="adminForm" method="post">
    <input type="hidden" name="option" value="<?php echo $option; ?>"/>
    <input type="hidden" name="task" value=""/>
    </form>
    <?php
  }


  function showHelp( $option ) {
    // ----------------------------------------------------------
    // Presentation of the Help Screem
    // ----------------------------------------------------------

    ?>
    <table cellpadding="4" cellspacing="0" border="0" width="100%">
    <tr>
      <td width="100%" class="sectionname"><img src="images/backup.png" align="middle">&nbsp;<?php echo _COM_TITLE; ?></td>
    </tr>
    </table>
    <table border="0" align="center" cellspacing="0" cellpadding="2" width="100%" class="adminform">
    </tr>
    <tr>
      <td>
      <a href="http://www.bigape.co.uk"><img src="http://bigape.co.uk/images/stories/banners/banner-backup-component.jpg" border=0></a><br>
      <h2>bigAPE Backup</h2>
      <b>Background</b><br/>
      During the management of several Mambo sites we came across the need to archive the entire Mambo file system and database archive into a single compressed archive.
      <br/><br/>
      <b>Solution</b><br/>
      We have attempted to use existing Mambo API features where possible and have implemented a basic full site backup system.<br/>
      The component does not have a client facing interface and all functionality is managed through the administration screens.<br/>
      The component has been developed to be as simple to use as possible.
      <br/><br/>
      <b>Compatibility</b><br/>
      We have tested this component against the following Mambo configurations:<ul>
      <li>Linux, Apache, MySQL</li>
      <li>Windows XP/2003, Apache, MySQL</li>
      <li>Windows XP/2003, IIS, MySQL</li>
      </ul>
      <b>Features</b><br/>
      The Component provides a basic site backup feature set. The following features are currently offered:<ul>
      <li>Ability to backup entire Mambo file system to a compressed file.</li>
      <li>Ability to select which folders to include and exclude from the backup</li>
      <li>Ability to generate a backup of the Mambo mySQL database and include it in the backup set</li>
      <li>Ability to download or delete old backup sets</li>
      <li>Backup excludes existing backup sets to conserve space</li>
      </ul>
      bigAPE Development Ltd &copy; 1998-2005 | <a href="http://www.bigape.co.uk">www.bigape.co.uk</a>
      <br/><p/><br/>
      <table border=0>
      <tr><th>&nbsp;</th><th>&nbsp;</th></tr>
      <tr><td>&nbsp;</td><td>&nbsp;</td></tr>
      </table>
    </tr>
    </table>
    <form action="index2.php" name="adminForm" method="post">
    <input type="hidden" name="option" value="<?php echo $option; ?>"/>
    <input type="hidden" name="task" value=""/>
    </form>
    <?php
  }


  function showCredits( $option ) {
    // ----------------------------------------------------------
    // Presentation of the Help Screem
    // ----------------------------------------------------------

    ?>
    <table cellpadding="4" cellspacing="0" border="0" width="100%">
    <tr>
      <td width="100%" class="sectionname"><img src="images/backup.png" align="middle">&nbsp;<?php echo _COM_TITLE; ?></td>
    </tr>
    </table>
    <table border="0" align="center" cellspacing="0" cellpadding="2" width="100%" class="adminform">
    </tr>
    <tr>
      <td>
      <h2>Credits</h2>
      thish is odih dsoaihd saoidh asoidh sadiohas dioash doiash doihd asoihd as
      </td>
    </tr>
    </table>
    <form action="index2.php" name="adminForm" method="post">
    <input type="hidden" name="option" value="<?php echo $option; ?>"/>
    <input type="hidden" name="task" value=""/>
    </form>
    <?php
  }

}
?>
