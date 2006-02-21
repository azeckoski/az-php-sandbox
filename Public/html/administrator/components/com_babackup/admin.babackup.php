<?php
/**
* bigAPE Site Backup 0.1 for Mambo CMS
* @version $Id: toolbar.babackup.php,v 0.1 2005/03/28 17:32:00 bigAPE Exp $
* @package baBackup
* @copyright (C) 1998 - 2005 bigAPE Development Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Oficial website: http://www.bigape.co.uk.com/
* -------------------------------------------
* Admin Business Layer
* Creator: Alex Maddern
* Email: mambo@bigape.co.uk
* Revision: 0.1
* Date: April 2005
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

# load language
if (file_exists( "components/com_babackup/language/".$mosConfig_lang.".php" )) {
    include_once( "components/com_babackup/language/".$mosConfig_lang.".php" );
} else {
    include_once( "components/com_babackup/language/english.php" );
}

# ensure user has access to this function
if (!($acl->acl_check( 'administration', 'edit', 'users', $my->usertype, 'components', 'all' )
    | $acl->acl_check( 'administration', 'edit', 'users', $my->usertype, 'components', 'com_babackup' ))) {
    mosRedirect( 'index2.php', _NOT_AUTH );
}

# assign global folder paths
$baBackupPath   = $GLOBALS['mosConfig_absolute_path'] . '/administrator/components/com_babackup/backups';
$baDownloadPath = $GLOBALS['mosConfig_live_site'] . '/administrator/components/com_babackup/backups';

# load additional components
require_once( $mosConfig_absolute_path.'/administrator/includes/pcl/pclzip.lib.php' );
require_once( $mainframe->getPath( 'admin_html' ) );

# retrieve row selection from forms
$cid   = mosGetParam( $_REQUEST, 'cid', array(0) );
if (!is_array( $cid )) {
    $cid = array(0);
}

# process the workflow selection
switch ($task) {
    case 'generate':
        generateBackup( $cid, $option );
        break;

    case 'confirm':
        confirmBackup( $option );
        break;

    case 'credits':
        showHelp( $option );
        break;

    case 'remove':
        deleteBackups( $cid, $option );
        break;

    case 'cancel':
        mosRedirect( 'index2.php' );
        break;

    case 'show':
    default:
        showBackups( $option );
        break;
}


function showBackups( $option ) {
    // ----------------------------------------------------------
    // Generate a selectable list of the files in Backup Folder
    // ----------------------------------------------------------
    global $baBackupPath;

    # initialise list arrays, directories and files separately and array counters for them
    $d_arr = array(); $d = 0;
    $f_arr = array(); $f = 0;
    $s_arr = array(); $s = 0;

    # obtain the list of backup archive files
    getBackupFiles($d_arr, $f_arr, $s_arr, $d, $f);

    # load presentation layer
    HTML_babackup::showBackups( $f_arr, $s_arr, $baBackupPath, $option );
}


function confirmBackup( $option ) {
    // ----------------------------------------------------------
    // Routine to display a confirmation screen prior to backup
    // containing the selectable folders and a confirmation for
    // backing up the database
    // ----------------------------------------------------------
    global $baBackupPath, $mosConfig_absolute_path;

    # Initialise list arrays, directories and files separately and array counters for them
    $excludedFolders = array();
    $d_arr = array(); $d = 0;
    $ds_arr = array();
    $f_arr = array(); $f = 0;
    $s_arr = array(); $s = 0;
    $d_arr[$d] = $mosConfig_absolute_path;

    # obtain the list of folders by recursing the mambo file store
    recurseFiles($d_arr, $ds_arr, $f_arr, $s_arr, $d, $f, $s, $excludedFolders, '');

    # load presentation layer
    HTML_babackup::confirmBackups( $d_arr, $ds_arr, $baBackupPath, $option );
}


function deleteBackups( $cid, $option ) {
    // ----------------------------------------------------------
    // Routine to delete the Backup Sets selected in the list
    // backup sets screen
    // ----------------------------------------------------------
    global $baBackupPath;

    # Cycle through all the selected Backups and Deleted them
    for ($i=0, $n=count($cid); $i < $n; $i++) {
        if ( unlink( $baBackupPath.'/'.mosGetParam( $_REQUEST, 'f'.$cid[$i], 'FAILED' ) ) ) {
            //$msg .= mosGetParam( $_REQUEST, 'f'.$cid[$i], 'FAILED' ).' - '._DELETE_FILE_SUCCESS.'<br/>';
        } else {
            //$msg .= mosGetParam( $_REQUEST, 'f'.$cid[$i], 'FAILED' ).' - '._DELETE_FILE_FAILED.'<br/>';
        }
    }

    # redirect to list screen
    $msg = _DELETE_FILE_SUCCESS;
    mosRedirect( 'index2.php?option='.$option , $msg );
}


function generateBackup( $cid, $option ) {
    // ----------------------------------------------------------
    // Routine to generate recurse a folder structure and record
    // the files, their sizes and parent folders
    // ----------------------------------------------------------
    global $baBackupPath, $mosConfig_absolute_path;

    # load compression related classes
    require_once ($mosConfig_absolute_path."/includes/Archive/Tar.php");
    require_once ($mosConfig_absolute_path."/administrator/includes/pcl/pclzip.lib.php");

    # generate database backup if required
    $backupDatabase = mosGetParam( $_REQUEST, 'dbbackup', 'unknown' );
    if ($backupDatabase == 1) {
        $tables = array(); $tables[0] = 'all';
        doBackup($tables, 'gzip', 'local', 'both', $_SERVER['HTTP_USER_AGENT'], $mosConfig_absolute_path."/administrator/backups", $databaseResult );
    } else {
        $databaseResult = _DATABASE_EXCLUDED;
    }

    # obtain list of folders included in the backup
    $includedFolders = array();
    for ($i=0, $n=count($cid); $i < $n; $i++) {
        $includedFolders[] = mosGetParam( $_REQUEST, 'f'.$cid[$i], 'FAILED' );
    }

    # initialise list arrays, directories and files separately and array counters for them
    $d_arr  = array(); $d = 0;
    $ds_arr = array();
    $f_arr  = array(); $f = 0;
    $s_arr  = array(); $s = 0;

    # obtain the list of files by recursing the mambo file store
    recurseFiles($d_arr, $ds_arr, $f_arr, $s_arr, $d, $f, $s, $includedFolders, '');

    # format total archive size
    $originalSize = getFileSizeText($s);

    # extend the file locations to include the full path
    for( $i=0; $i < count( $f_arr ); $i++ ) {
        $f_arr[$i] = $mosConfig_absolute_path.'/'.$f_arr[$i];
    }

    # generate the backup set filename
    $domainname = strtolower(str_replace('.','_',$_SERVER['HTTP_HOST']));
    $filename1  = date("Ymdhis").'_backup_'.$domainname.'.tar.gz';
    $filename   = $baBackupPath.'/'.$filename1;

    # create the Tar file from the fileset array
    $tarArchive = new Archive_Tar($filename, "gz");
    $tarArchive->addModify($f_arr, '', $mosConfig_absolute_path) or die("Could not create archive!");

    # format the compressed size of the fileset
    $archiveSize = getFileSizeText(filesize($filename));

    # load presentation layer
    HTML_babackup::generateBackup($filename1, $archiveSize, $originalSize, count($includedFolders), $f, $databaseResult, $option );

}

function showHelp( $option ) {
    // ----------------------------------------------------------
    // Display the Help Screen
    // ----------------------------------------------------------

    # load presentation layer
    HTML_babackup::showHelp( $option );
}


function recurseFiles(&$d_arr, &$ds_arr, &$f_arr, &$s_arr, &$d, &$f, &$s, &$includedFolders, $path) {
    // ----------------------------------------------------------
    // Routine to recurse a folder structure and record the files
    // their sizes and parent folders
    // ----------------------------------------------------------
    global $mosConfig_absolute_path, $baBackupPath;

    $currentfullpath = $mosConfig_absolute_path.$path;
    # Open possibly available directory
    if( is_dir( $currentfullpath ) ) {
        if( $handle = opendir( $currentfullpath ) ) {
            while( false !== ( $file = readdir( $handle ) ) ) {
                # Make sure we don't push parental directories or dotfiles (unix) into the arrays
                if( $file != "." && $file != ".." && $file[0] != "." ) {
                    if( is_dir( $currentfullpath . "/" . $file ) ) {
                        # Create array for directories
                        $d_arr[++$d] = $currentfullpath . "/" . $file;
                        recurseFiles($d_arr, $ds_arr, $f_arr, $s_arr, $d, $f, $s, $includedFolders, $path . "/" . $file);
                    } else {
                        if ( in_array($currentfullpath, $includedFolders) ) {
                            # Create array for files
                            $s_arr[$f] = filesize($currentfullpath.'/'.$file);
                            $f_arr[$f++] = str_replace($mosConfig_absolute_path.'/', '', $currentfullpath.'/').$file;
                            $s += filesize($currentfullpath.'/'.$file);
                        }
                    }
                }
            }
        }
        # Wrap things up if we're in a directory
        if( is_dir( $handle ) )
            closedir( $handle );
    }
}


function getBackupFiles(&$d_arr, &$f_arr, &$s_arr, &$d, &$f) {
    // ----------------------------------------------------------
    // Routine to list the existing backup files in the Component
    // Backup folder
    // ----------------------------------------------------------
    global $baBackupPath;

    $path = $baBackupPath;
    # Open possibly available directory
    if( is_dir( $path ) ) {
        if( $handle = opendir( $path ) ) {
            while( false !== ( $file = readdir( $handle ) ) ) {
                # Make sure we don't push parental directories or dotfiles (unix) into the arrays
                if( $file != "." && $file != ".." && $file[0] != "." ) {
                    if( is_dir( $path . "/" . $file ) )
                        # Create array for directories
                        $d_arr[$d++] = $file;
                    else
                        if ($file != 'index.html') {
                            # Create array for files
                            $f_arr[$f++] = $file;
                        }
                }
            }
        }
    }

    # Wrap things up if we're in a directory
    if( is_dir( $handle ) )
        closedir( $handle );

    # Print file list
    for( $i=0; $i < count( $f_arr ); $i++ ) {
        $s_arr[$i] = getFileSizeText(filesize( $path . "/" . $f_arr[$i] ));
    }
}


function getFileSizeText($filesize) {
    // ----------------------------------------------------------
    // Routine to display a formatted version of a filesize
    // ----------------------------------------------------------

    if( $filesize >= 1024 && $filesize < 1048576) {
        # Size in kilobytes
        return round( $filesize / 1024, 2 ) . " KB";
    } elseif( $filesize >= 1048576 ) {
        # Size in megabytes
        return round( $filesize / 1024 / 1024, 2 ) . " MB";
    } else {
        # Size in bytes
        return $filesize . " bytes";
    }
}

function doBackup( $tables, $OutType, $OutDest, $toBackUp, $UserAgent, $local_backup_path, &$databaseResult) {
    // ----------------------------------------------------------
    // Backup Routine for Mambo mySQL database
    // Recovered from the AdvInstall Component by Jilin Fima
    // <JFima> fima@nm.ru Which we believe was based on the
    // original backup source from MOS 4.5
    // ----------------------------------------------------------
    global $database, $mosConfig_db, $mosConfig_sitename, $version,$option,$task;

    if (!$tables[0])
    {
        $databaseResult = _DATABASE_MISSING_TABLES;
        return;
    }

    /* Need to know what browser the user has to accomodate nonstandard headers */

    if (ereg('Opera(/| )([0-9].[0-9]{1,2})', $UserAgent)) {
        $UserBrowser = "Opera";
    }
    elseif (ereg('MSIE ([0-9].[0-9]{1,2})', $UserAgent)) {
        $UserBrowser = "IE";
    } else {
        $UserBrowser = '';
    }

    /* Determine the mime type and file extension for the output file */

    if ($OutType == "bzip") {
        $filename = $mosConfig_db . "_" . date("jmYHis") . ".bz2";
        $mime_type = 'application/x-bzip';
    } elseif ($OutType == "gzip") {
        $filename = $mosConfig_db . "_" . date("jmYHis") . ".sql.gz";
        $mime_type = 'application/x-gzip';
    } elseif ($OutType == "zip") {
        $filename = $mosConfig_db . "_" . date("jmYHis") . ".zip";
        $mime_type = 'application/x-zip';
    } elseif ($OutType == "html") {
        $filename = $mosConfig_db . "_" . date("jmYHis") . ".html";
        $mime_type = ($UserBrowser == 'IE' || $UserBrowser == 'Opera') ? 'application/octetstream' : 'application/octet-stream';
    } else {
        $filename = $mosConfig_db . "_" . date("jmYHis") . ".sql";
        $mime_type = ($UserBrowser == 'IE' || $UserBrowser == 'Opera') ? 'application/octetstream' : 'application/octet-stream';
    };

    /* Store all the tables we want to back-up in variable $tables[] */

    if ($tables[0] == "all") {
        array_pop($tables);
        $database->setQuery("SHOW tables");
        $database->query();
        $tables = array_merge($tables, $database->loadResultArray());
    }

    /* Store the "Create Tables" SQL in variable $CreateTable[$tblval] */
    if ($toBackUp!="data")
    {
        foreach ($tables as $tblval)
        {
            $database->setQuery("SHOW CREATE table $tblval");
            $database->query();
            $CreateTable[$tblval] = $database->loadResultArray(1);
        }
    }

    /* Store all the FIELD TYPES being backed-up (text fields need to be delimited) in variable $FieldType*/
    if ($toBackUp!="structure")
    {
        foreach ($tables as $tblval)
        {
            $database->setQuery("SHOW FIELDS FROM $tblval");
            $database->query();
            $fields = $database->loadObjectList();
            foreach($fields as $field)
            {
                $FieldType[$tblval][$field->Field] = preg_replace("/[(0-9)]/",'', $field->Type);
            }
        }
    }

    /* Build the fancy header on the dump file */
    $OutBuffer = "";
    if ($OutType == 'html') {
    } else {
        $OutBuffer .= "#\n";
        $OutBuffer .= "# Mambo Open Source MySQL-Dump\n";
        $OutBuffer .= "# http://www.mamboserver.com\n";
        $OutBuffer .= "#\n";
        $OutBuffer .= "# Host: $mosConfig_sitename\n";
        $OutBuffer .= "# Generation Time: " . date("M j, Y \a\\t H:i") . "\n";
        $OutBuffer .= "# Server version: " . $database->getVersion() . "\n";
        $OutBuffer .= "# PHP Version: " . phpversion() . "\n";
        $OutBuffer .= "# Database : `" . $mosConfig_db . "`\n# --------------------------------------------------------\n";
    }

    /* Okay, here's the meat & potatoes */
    foreach ($tables as $tblval) {
        if ($toBackUp != "data") {
            if ($OutType == 'html') {
            } else {
                $OutBuffer .= "#\n# Table structure for table `$tblval`\n";
                $OutBuffer .= "#\nDROP table IF EXISTS $tblval;\n";
                $OutBuffer .= $CreateTable[$tblval][0].";\r\n";
            }
        }
        if ($toBackUp != "structure") {
            if ($OutType == 'html') {
                $OutBuffer .= "<div align=\"left\">";
                $OutBuffer .= "<table cellspacing=\"0\" cellpadding=\"2\" border=\"1\">";
                $database->setQuery("SELECT * FROM $tblval");
                $rows = $database->loadObjectList();

                $OutBuffer .= "<tr><th colspan=\"".count( @array_keys( @$rows[0] ) )."\">`$tblval`</th></tr>";
                if (count( $rows )) {
                    $OutBuffer .= "<tr>";
                    foreach($rows[0] as $key => $value) {
                        $OutBuffer .= "<th>$key</th>";
                    }
                    $OutBuffer .= "</tr>";
                }

                foreach($rows as $row)
                {
                    $OutBuffer .= "<tr>";
                    $arr = mosObjectToArray($row);
                    foreach($arr as $key => $value)
                    {
                        $value = addslashes( $value );
                        $value = str_replace( "\n", '\r\n', $value );
                        $value = str_replace( "\r", '', $value );

                        $value = htmlspecialchars( $value );

                        if (preg_match ("/\b" . $FieldType[$tblval][$key] . "\b/i", "DATE TIME DATETIME CHAR VARCHAR TEXT TINYTEXT MEDIUMTEXT LONGTEXT BLOB TINYBLOB MEDIUMBLOB LONGBLOB ENUM SET"))
                        {
                            $OutBuffer .= "<td>'$value'</td>";
                        }
                        else
                        {
                            $OutBuffer .= "<td>$value</td>";
                        }
                    }
                    $OutBuffer .= "</tr>";
                }
                $OutBuffer .= "</table></div><br />";
            } else {
                $OutBuffer .= "#\n# Dumping data for table `$tblval`\n#\n";
                $database->setQuery("SELECT * FROM $tblval");
                $rows = $database->loadObjectList();
                foreach($rows as $row)
                {
                    $InsertDump = "INSERT INTO $tblval VALUES (";
                    $arr = mosObjectToArray($row);
                    foreach($arr as $key => $value)
                    {
                        $value = addslashes( $value );
                        $value = str_replace( "\n", '\r\n', $value );
                        $value = str_replace( "\r", '', $value );
                        if (preg_match ("/\b" . $FieldType[$tblval][$key] . "\b/i", "DATE TIME DATETIME CHAR VARCHAR TEXT TINYTEXT MEDIUMTEXT LONGTEXT BLOB TINYBLOB MEDIUMBLOB LONGBLOB ENUM SET"))
                        {
                            $InsertDump .= "'$value',";
                        }
                        else
                        {
                            $InsertDump .= "$value,";
                        }
                    }
                    $OutBuffer .= rtrim($InsertDump,',') . ");\n";
                }
            }
        }
    }

    /* Send the HTML headers */
    if ($OutDest == "remote") {
        // dump anything in the buffer
        @ob_end_clean();
        ob_start();
        header('Content-Type: ' . $mime_type);
        header('Expires: ' . gmdate('D, d M Y H:i:s') . ' GMT');

        if ($UserBrowser == 'IE') {
            header('Content-Disposition: inline; filename="' . $filename . '"');
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Pragma: public');
        } else {
            header('Content-Disposition: attachment; filename="' . $filename . '"');
            header('Pragma: no-cache');
        }
    }

    if ($OutDest == "screen" || $OutType == "html" ) {
        if ($OutType == "html") {
                echo $OutBuffer;
        } else {
            $OutBuffer = str_replace("<","&lt;",$OutBuffer);
            $OutBuffer = str_replace(">","&gt;",$OutBuffer);
            ?>
            <form>
                <textarea rows="20" cols="80" name="sqldump"  style="background-color:#e0e0e0"><?php echo $OutBuffer;?></textarea>
                <br />
                <input type="button" onClick="javascript:this.form.sqldump.focus();this.form.sqldump.select();" class="button" value="Select All" />
            </form>
            <?php
        }
        exit();
    }

    switch ($OutType) {
        case "sql" :
            if ($OutDest == "local") {
                $fp = fopen("$local_backup_path/$filename", "w");
                if (!$fp) {
                    $databaseResult = _DATABASE_BACKUP_FAILED;
                    return;
                } else {
                    fwrite($fp, $OutBuffer);
                    fclose($fp);
                    $databaseResult = _DATABASE_BACKUP_COMPLETED.' ( '.getFileSizeText(filesize($local_backup_path.'/'.$filename)).' )';
                    return;
                }
            } else {
                echo $OutBuffer;
                ob_end_flush();
                ob_start();
                // do no more
                exit();
            }
            break;
        case "bzip" :
            if (function_exists('bzcompress')) {
                if ($OutDest == "local") {
                    $fp = fopen("$local_backup_path/$filename", "wb");
                    if (!$fp) {
                        $databaseResult = _DATABASE_BACKUP_FAILED;
                    } else {
                        fwrite($fp, bzcompress($OutBuffer));
                        fclose($fp);
                        $databaseResult = _DATABASE_BACKUP_COMPLETED.' ( '.getFileSizeText(filesize($local_backup_path.'/'.$filename)).' )';
                        return;
                    }
                } else {
                    echo bzcompress($OutBuffer);
                    ob_end_flush();
                    ob_start();
                    // do no more
                    exit();
                }
            } else {
                echo $OutBuffer;
            }
            break;
        case "gzip" :
            if (function_exists('gzencode')) {
                if ($OutDest == "local") {
                    $fp = gzopen("$local_backup_path/$filename", "wb");
                    if (!$fp) {
                        $databaseResult = _DATABASE_BACKUP_FAILED;
                        return;
                    } else {
                        gzwrite($fp,$OutBuffer);
                        gzclose($fp);
                        $databaseResult = _DATABASE_BACKUP_COMPLETED.' ( '.getFileSizeText(filesize($local_backup_path.'/'.$filename)).' )';
                        return;
                    }
                } else {
                    echo gzencode($OutBuffer);
                    ob_end_flush();
                    ob_start();
                    // do no more
                    exit();
                }
            } else {
                echo $OutBuffer;
            }
            break;
        case "zip" :
            if (function_exists('gzcompress')) {
                global $mosConfig_absolute_path;
                include $mosConfig_absolute_path.'/administrator/classes/zip.lib.php';
                $zipfile = new zipfile();
                $zipfile -> addFile($OutBuffer, $filename . ".sql");
                }
            switch ($OutDest) {
                case "local" :
                    $fp = fopen("$local_backup_path/$filename", "wb");
                    if (!$fp) {
                        $databaseResult = _DATABASE_BACKUP_FAILED;
                        return;
                    } else {
                        fwrite($fp, $zipfile->file());
                        fclose($fp);
                        $databaseResult = _DATABASE_BACKUP_COMPLETED.' ( '.getFileSizeText(filesize($local_backup_path.'/'.$filename)).' )';
                        return;
                    }
                    break;
                case "remote" :
                    echo $zipfile->file();
                    ob_end_flush();
                    ob_start();
                    // do no more
                    exit();
                    break;
                default :
                    echo $OutBuffer;
                    break;
            }
            break;
    }
}


?>
