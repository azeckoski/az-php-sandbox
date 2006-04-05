<?php
/**
* @version $Id: user.php,v 1.1 2005/07/22 01:54:57 eddieajau Exp $
* @package Mambo
* @subpackage Users
* @copyright (C) 2000 - 2005 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

// Editor usertype check
//$is_editor = (strtolower($my->usertype) == 'author' || strtolower($my->usertype) == 'editor' || strtolower($my->usertype) == 'administrator' || strtolower($my->usertype) == 'super administrator' );
$access = new stdClass();
$access->canEdit = $acl->acl_check( 'action', 'edit', 'users', $my->usertype, 'content', 'all' );
$access->canEditOwn = $acl->acl_check( 'action', 'edit', 'users', $my->usertype, 'content', 'own' );

require_once ( $mainframe->getPath( 'front_html' ) );
$task = mosGetParam( $_REQUEST, 'task' );

switch( $task ) {
	case "saveUpload":
	saveUpload( $mosConfig_dbprefix, $uid, $option, $userfile, $userfile_name, $type, $existingImage);
	break;

	case "UserDetails":
	userEdit( $option, $my->id, _UPDATE );
	break;

	case "saveUserEdit":
	userSave( $option, $my->id );
	break;

	case "CheckIn":
	CheckIn( $my->id, $access, $option );
	break;

	default:
	HTML_user::frontpage();
	break;
}

function saveUpload($database, $_dbprefix, $uid, $option, $userfile, $userfile_name, $type, $existingImage) {
	global $database;

	if ($uid == 0) {
		mosNotAuth();
		return;
	}

	$base_Dir = "images/stories/";
	$checksize=filesize($userfile);
	if ($checksize > 50000) {
		echo "<script> alert(\""._UP_SIZE."\"); window.history.go(-1); </script>\n";
	} else {
		if (file_exists($base_Dir.$userfile_name)) {
			$message=_UP_EXISTS;
			eval ("\$message = \"$message\";");
			print "<script> alert('$message'); window.history.go(-1);</script>\n";
		} else {
			if ((!strcasecmp(substr($userfile_name,-4),".gif")) || (!strcasecmp(substr($userfile_name,-4),".jpg"))) {
				if (!move_uploaded_file($userfile, $base_Dir.$userfile_name))
				{
					echo _UP_COPY_FAIL." $userfile_name";
				} else {
					echo "<script>window.opener.focus;</script>";
					if ($type=="news") {
						$op="UserNews";
					} elseif ($type=="articles") {
						$op="UserArticle";
					}

					if ($existingImage!="") {
						if (file_exists($base_Dir.$existingImage)) {
							//delete the exisiting file
							unlink($base_Dir.$existingImage);
						}
					}
					echo "<script>window.opener.document.adminForm.ImageName.value='$userfile_name';</script>";
					echo "<script>window.opener.document.adminForm.ImageName2.value='$userfile_name';</script>";
					echo "<script>window.opener.document.adminForm.imagelib.src=null;</script>";
					echo "<script>window.opener.document.adminForm.imagelib.src='images/stories/$userfile_name';</script>";
					echo "<script>window.close(); </script>";
				}
			} else {
				echo "<script> alert(\""._UP_TYPE_WARN."\"); window.history.go(-1); </script>\n";
			}
		}
	}
}

function userEdit( $option, $uid, $submitvalue) {
	global $database;
	if ($uid == 0) {
		mosNotAuth();
		return;
	}
	$row = new mosUser( $database );
	$row->load( $uid );
	$row->orig_password = $row->password;
	HTML_user::userEdit( $row, $option, $submitvalue );
}

function userSave( $option, $uid) {
	global $database;

	$user_id = intval( mosGetParam( $_POST, 'id', 0 ));

	// do some security checks
	if ($uid == 0 || $user_id == 0 || $user_id <> $uid) {
		mosNotAuth();
		return;
	}
	$row = new mosUser( $database );
	$row->load( $user_id );
	$row->orig_password = $row->password;

	if (!$row->bind( $_POST, "gid usertype" )) {
		echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
		exit();
	}
	mosMakeHtmlSafe($row);

	if(isset($_POST["password"]) && $_POST["password"] != "") {
		if(isset($_POST["verifyPass"]) && ($_POST["verifyPass"] == $_POST["password"])) {
			$row->password = md5($_POST["password"]);
		} else {
			echo "<script> alert(\""._PASS_MATCH."\"); window.history.go(-1); </script>\n";
			exit();
		}
	} else {
		// Restore 'original password'
		$row->password = $row->orig_password;
	}
	if (!$row->check()) {
		echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
		exit();
	}

	unset($row->orig_password); // prevent DB error!!

	if (!$row->store()) {
		echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
		exit();
	}

	mosRedirect ("index.php?option=$option", _USER_DETAILS_SAVE);
}

function CheckIn( $userid, $access, $option ){
	global $database;
	global $mosConfig_db;

	if (!($access->canEdit || $access->canEditOwn || $userid > 0)) {
		mosNotAuth();
		return;
	}

	$lt = mysql_list_tables($mosConfig_db);
	$k = 0;
	echo "<table cellpadding=\"0\" cellspacing=\"0\" border=\"0\">";
	while (list($tn) = mysql_fetch_array($lt)) {
		// only check in the mos_* tables
		if (strpos( $tn, $database->_table_prefix ) !== 0) {
			continue;
		}
		$lf = mysql_list_fields($mosConfig_db, "$tn");
		$nf = mysql_num_fields($lf);

		$checked_out = false;
		$editor = false;

		for ($i = 0; $i < $nf; $i++) {
			$fname = mysql_field_name($lf, $i);
			if ( $fname == "checked_out") {
				$checked_out = true;
			} else if ( $fname == "editor") {
				$editor = true;
			}
		}

		if ($checked_out) {
			if ($editor) {
				$database->setQuery( "SELECT checked_out, editor FROM $tn WHERE checked_out > 0 AND checked_out=$userid" );
			} else {
				$database->setQuery( "SELECT checked_out FROM $tn WHERE checked_out > 0 AND checked_out=$userid" );
			}
			$res = $database->query();
			$num = $database->getNumRows( $res );

			if ($editor) {
				$database->setQuery( "UPDATE $tn SET checked_out=0, checked_out_time='00:00:00', editor=NULL WHERE checked_out > 0" );
			} else {
				$database->setQuery( "UPDATE $tn SET checked_out=0, checked_out_time='0000-00-00 00:00:00' WHERE checked_out > 0" );
			}
			$res = $database->query();

			if ($res == 1) {

				if ($num > 0) {
					echo "\n<tr class=\"row$k\">";
					echo "\n	<td width=\"250\">";
					echo _CHECK_TABLE;
					echo " - $tn</td>";
					echo "\n	<td>";
					echo _CHECKED_IN;
					echo "<b>$num</b>";
					echo _CHECKED_IN_ITEMS;
					echo "</td>";
					echo "\n</tr>";
				}
				$k = 1 - $k;
			}
		}
	}
?>
<tr>
	<td colspan="2"><b><?php echo _CONF_CHECKED_IN; ?></b></td>
</tr>
</table>
<?php
}
?>
