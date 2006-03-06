<?php
/*
 * file: edit_user.php
 * Created on Mar 3, 2006 11:07:11 PM by @author aaronz
 * 
 * Aaron Zeckoski (aaronz@vt.edu) - Virginia Tech (http://www.vt.edu/)
 */
?>

<?php
	require_once ("tool_vars.php");

	// Form to allow admin user editing
	$PAGE_NAME = "Admin User Edit";

	// connect to database
	require "mysqlconnect.php";

	// get the passkey from the cookie if it exists
	$PASSKEY = $_COOKIE["SESSION_ID"];

	// check the passkey
	$USER_PK = 0;
	if (isset($PASSKEY)) {
		$sql1 = "SELECT users_pk FROM sessions WHERE passkey = '$PASSKEY'";
		$result = mysql_query($sql1) or die('Query failed: ' . mysql_error());
		$row = mysql_fetch_assoc($result);

		if( !$result ) {
			// no valid key exists, user not authenticated
			$USER_PK = -1;
		} else {
			// authenticated user
			$USER_PK = $row["users_pk"];
		}
		mysql_free_result($result);
	}

	if( $USER_PK <= 0 ) {
		// no user_pk, user not authenticated
		// redirect to the login page
		header('location:'.$ACCOUNTS_PATH.'login.php?ref='.$_SERVER['PHP_SELF']);
		exit;
	}

	// if we get here, user should be authenticated
	// get the authenticated user information
	$authsql = "SELECT * FROM users WHERE pk = '$USER_PK'";
	$result = mysql_query($authsql) or die('Query failed: ' . mysql_error());
	$USER = mysql_fetch_assoc($result);

	// Make sure user is authorized
	$allowed = 0; // assume user is NOT allowed unless otherwise shown
	$Message = "";
	if (!$USER["admin_accounts"]) {
		$allowed = 0;
		$Message = "Only admins with <b>admin_accounts</b> may view this page.<br/>" .
			"Try out this one instead: <a href='$TOOL_PATH/'>$TOOL_NAME</a>";
	} else {
		$allowed = 1;
	}
	
	$EXTRA_LINKS = "<br><span style='font-size:9pt;'><a href='admin.php'>Users admin</a> - " .
		"<a href='admin_insts.php'>Institutions admin</a></span>";
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title><?= $TOOL_NAME ?> - <?= $PAGE_NAME ?></title>
<link href="<?= $CSS_FILE ?>" rel="stylesheet" type="text/css">

<script>
<!--
function focus(){document.adminform.searchtext.focus();}

function orderBy(newOrder) {
	if (document.adminform.sortorder.value == newOrder) {
		document.adminform.sortorder.value = newOrder + " desc";
	} else {
		document.adminform.sortorder.value = newOrder;
	}
	document.adminform.submit();
	return false;
}

// -->
</script>

</head>
<body onLoad="focus()">

<? // Include the HEADER -AZ
include 'header.php'; ?>

<?= $Message ?>

<?php
	// Put in footer and stop the rest of the page from loading if not allowed -AZ
	if (!$allowed) {
		include 'footer.php';
		exit;
	}
?>

<?php
	$PK = $_REQUEST["pk"];
	if (!$PK) {
		print "You cannot come here without a user pk set!<br/>";
		print "<a href='admin.php'>Go back</a>";
		exit;
	}

	$SAVE = $_POST["saving"];

	$USERNAME = $_POST["username"];
	$EMAIL = $_POST["email"];
	$PASS1 = $_POST["password1"];
	$PASS2 = $_POST["password2"];
	$FIRSTNAME = $_POST["firstname"];
	$LASTNAME = $_POST["lastname"];
	$INSTITUTION_PK = $_POST["institution_pk"];
	$ACTIVATED = $_POST["activated"];
	if (!$ACTIVATED) { $ACTIVATED = 0; }

	$Message = "";

	// this matters when the form is submitted
	if ($SAVE) {
		// Check for form completeness
		$errors = 0;
		if (!strlen($USERNAME)) {
			$Message .= "<span class='error'>Error: Username cannot be blank</span><br/>";
			$errors++;
		}
		if (!strlen($EMAIL)) {
			$Message .= "<span class='error'>Error: Email cannot be blank</span><br/>";
			$errors++;
		}
		if (!strlen($FIRSTNAME)) {
			$Message .= "<span class='error'>Error: First name cannot be blank</span><br/>";
			$errors++;
		}
		if (!strlen($LASTNAME)) {
			$Message .= "<span class='error'>Error: Last name cannot be blank</span><br/>";
			$errors++;
		}

		if ((strlen($PASS1) > 0 || strlen($PASS2) > 0) && ($PASS1 != $PASS2)) {
			$Message .= "<span class='error'>Error: Passwords do not match</span><br/>";
			$errors++;
		}

		// verify that the email address is valid
		if(!eregi('^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$', $EMAIL)) {
			$Message .= "<span class='error'>Error: You have entered an invalid email address!</span><br/>";
			$errors++;
	        unset($EMAIL);
		}

		// check if the username is unique
		$sql_username_check = mysql_query("SELECT pk FROM users WHERE username='$USERNAME' and pk != '$PK'");
		$username_check = mysql_num_rows($sql_username_check);
		if ($username_check > 0) {
			$Message .= "<span class='error'>Error: This username ($USERNAME) is already in use.</span><br/>";
			$errors++;
		}
		mysql_free_result($sql_username_check);
		
		// check if the email is unique
		$sql_email_check = mysql_query("SELECT pk FROM users WHERE email='$EMAIL' and pk != '$PK'");
		$email_check = mysql_num_rows($sql_email_check);
		if ($email_check > 0) {
			$Message .= "<span class='error'>Error: This email address ($EMAIL) is already in use.</span><br/>";
			$errors++;
		}
		mysql_free_result($sql_email_check);

		if ($errors == 0) {
			// write the new values to the DB
			$Message = "Edit the information below to adjust your account.<br/>";
			$passChange = "";
			if (strlen($PASS1) > 0) {
				$passChange = " password=PASSWORD('$PASS1'), ";
			}

			$permsSql = "";
			if ($_REQUEST["admin_accounts"]) {
				$permsSql .= " admin_accounts = '1', ";
			} else {
				$permsSql .= " admin_accounts = null, ";
			}
			if ($_REQUEST["admin_insts"]) {
				$permsSql .= " admin_insts = '1', ";
			} else {
				$permsSql .= " admin_insts = null, ";
			}
			if ($_REQUEST["admin_reqs"]) {
				$permsSql .= " admin_reqs = '1', ";
			} else {
				$permsSql .= " admin_reqs = null, ";
			}

			$sqledit = "UPDATE users set username='$USERNAME', email='$EMAIL', " .
					"firstname='$FIRSTNAME', " . $passChange . $permsSql .
					"lastname='$LASTNAME', institution_pk='$INSTITUTION_PK', " .
					"activated='$ACTIVATED' where pk='$PK'";

			$result = mysql_query($sqledit) or die('User update query failed: ' . mysql_error());
			$Message = "<b>Updated user information</b><br/>";

			// write the inst rep if needed
			if ($_REQUEST["setrep"]) {
				// set this user as the rep for the currently selected institution
				$instrepsql = "UPDATE institution set rep_pk='$PK' where pk='$INSTITUTION_PK'";
				$result = mysql_query($instrepsql) or die('Institution update query failed: ' . mysql_error());
				$Message .= "<b>Set this user as an institutional rep.</b><br/>";
			} else {
				// UNset this user as the rep for the currently selected institution
				$instrepsql = "UPDATE institution set rep_pk = null where pk='$INSTITUTION_PK' and rep_pk='$PK'";
				$result = mysql_query($instrepsql) or die('Institution update query failed: ' . mysql_error());
				$Message .= "<b>Unset this user as an institutional rep.</b><br/>";
			}

			// clear all values
			$USERNAME = "";
			$EMAIL = "";
			$FIRSTNAME = "";
			$LASTNAME = "";
			$INSTITUTION_PK = "";
		} else {
			$Message = "<div class='error'>Please fix the following errors:\n<blockquote>\n$Message</blockquote>\n</div>\n";
		}
	}


	// get the authenticated user information
	$authsql = "SELECT * FROM users WHERE pk = '$PK'";
	$result = mysql_query($authsql) or die('Query failed: ' . mysql_error());
	$thisUser = mysql_fetch_assoc($result);

	if (!empty($result)) {
		if (!strlen($USERNAME)) { $USERNAME = $thisUser["username"]; }
		if (!strlen($EMAIL)) { $EMAIL = $thisUser["email"]; }
		if (!strlen($FIRSTNAME)) { $FIRSTNAME = $thisUser["firstname"]; }
		if (!strlen($LASTNAME)) { $LASTNAME = $thisUser["lastname"]; }
		if (!strlen($INSTITUTION_PK)) { $INSTITUTION_PK = $thisUser["institution_pk"]; }
	}
	mysql_free_result($result);
	
	// get if this user is an institutional rep
	$isRep = 0;
	$check_rep_sql="select pk from institution where rep_pk = '$PK'";
	$result = mysql_query($check_rep_sql) or die('Query failed: ' . mysql_error());	
	if (mysql_num_rows($result) != 0) { $isRep = 1; }
	mysql_free_result($result);
?>

<?php $institutionDropdownText = generate_partner_dropdown($INSTITUTION_PK); ?>

<?= $Message ?>

<i style="font-size:9pt;">All fields are required</i><br/>
<form action="<?=$_SERVER['PHP_SELF']; ?>" method="post" name="account" style="margin:0px;">
<input type="hidden" name="pk" value="<?= $PK ?>">
<input type="hidden" name="saving" value="1">

<table border="0" cellpadding="0" cellspacing="0" width="100%">
<tr>
<td valign="top" width="50%">

<table border="0" class="padded">
	<tr>
		<td class="account"><b>Username:</b></td>
		<td><input type="text" name="username" tabindex="1" value="<?= $thisUser["username"] ?>" maxlength="50"></td>
	</tr>
	<tr>
		<td class="account"><b>Password:</b></td>
		<td><input type="password" name="password1" tabindex="2" maxlength="50"></td>
	</tr>
	<tr>
		<td class="account"><b>Confirm&nbsp;pwd:</b></td>
		<td><input type="password" name="password2" tabindex="3" maxlength="50"></td>
	</tr>
	<tr>
		<td class="account"><b>First name:</b></td>
		<td><input type="text" name="firstname" tabindex="4" value="<?= $FIRSTNAME ?>" size="40" maxlength="50"></td>
	</tr>
	<tr>
		<td class="account"><b>Last name:</b></td>
		<td><input type="text" name="lastname" tabindex="5" value="<?= $LASTNAME ?>" size="40" maxlength="50"></td>
	</tr>
	<tr>
		<td class="account"><b>Email:</b></td>
		<td><input type="text" name="email" tabindex="6" value="<?= $EMAIL ?>" size="50" maxlength="50"></td>
	</tr>
	<tr>
		<td class="account"><b>Institution:</b></td>
		<td>
		  <select name="institution_pk" tabindex="7">
		  	<option value=''> --Select Your Organization-- </option>
			<?= $institutionDropdownText?>
		  </select>
		</td>
	</tr>

	<tr>
		<td colspan="2">
			<input type="submit" name="account" value="Save information" tabindex="8">
		</td>
	</tr>
</table>

</td>
<td valign="top">

<table border="0" class="padded">
	<tr>
		<td class="account"><b>Activated:</b></td>
		<td class="checkbox">
			<input type="checkbox" name="activated" tabindex="9" value="1" <?php
				if ($thisUser["activated"]) { echo " checked='Y' "; }
			?>>
			<i> - is this account active? (inactive accounts cannot login)</i>
		</td>
	</tr>

	<tr>
		<td class="account"><b>Inst Rep:</b></td>
		<td class="checkbox">
			<input type="checkbox" name="setrep" tabindex="10" value="1" <?php
				if ($isRep) { echo " checked='Y' "; }
			?>>
			<i> - is this user the representative for the listed institution?</i>
		</td>
	</tr>

	<tr>
		<td colspan="2" class="account"><b>Admin Permissions:</b></td>
	</tr>

	<tr>
		<td class="account"><b>Accounts:</b></td>
		<td class="checkbox">
			<input type="checkbox" name="admin_accounts" tabindex="11" value="1" <?php
				if ($thisUser["admin_accounts"]) { echo " checked='Y' "; }
			?>>
			<i> - does this user have admin access to accounts?</i>
		</td>
	</tr>

	<tr>
		<td class="account"><b>Institutions:</b></td>
		<td class="checkbox">
			<input type="checkbox" name="admin_insts" tabindex="12" value="1" <?php
				if ($thisUser["admin_insts"]) { echo " checked='Y' "; }
			?>>
			<i> - does this user have admin access to institutions?</i>
		</td>
	</tr>

	<tr>
		<td class="account"><b>Requirements:</b></td>
		<td class="checkbox">
			<input type="checkbox" name="admin_reqs" tabindex="12" value="1" <?php
				if ($thisUser["admin_reqs"]) { echo " checked='Y' "; }
			?>>
			<i> - can this user administrate requirements?</i>
		</td>
	</tr>

</table>

</td>
</tr>
</table>

</form>

<?php // Include the FOOTER -AZ
include 'footer.php'; ?>

</body>
</html>