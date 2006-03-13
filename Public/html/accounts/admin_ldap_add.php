<?php
/*
 * file: admin_ldap_add.php
 * Created on Mar 8, 2006 11:00:45 PM by @author aaronz
 * 
 * Aaron Zeckoski (aaronz@vt.edu) - Virginia Tech (http://www.vt.edu/)
 */
?>
<?php
require_once 'include/tool_vars.php';

$PAGE_NAME = "Admin LDAP user control";
$Message = "";

// connect to database
require 'sql/mysqlconnect.php';

// check authentication
require 'include/check_authentic.php';

// login if not autheticated
require 'include/auth_login_redirect.php';

// Make sure user is authorized
$allowed = 0; // assume user is NOT allowed unless otherwise shown
if (!$USER["admin_accounts"]) {
	$allowed = 0;
	$Message = "Only admins with <b>admin_accounts</b> may view this page.<br/>" .
		"Try out this one instead: <a href='$TOOL_PATH/'>$TOOL_NAME</a>";
} else {
	$allowed = 1;
}

// set the header links
// set header links
$EXTRA_LINKS = "<br><span style='font-size:9pt;'><a href='admin_users.php'>Users admin</a> - " .
	"<a href='admin_ldap.php'>LDAP admin</a> - " .
	"<a href='admin_insts.php'>Institutions admin</a></span>";
?>

<?php include 'include/top_header.php'; // INCLUDE THE HTML HEAD ?>
<script>
<!--
// -->
</script>
<?php include 'include/header.php'; // INCLUDE THE HEADER ?>

<?= $Message ?>

<?php
	// Put in footer and stop the rest of the page from loading if not allowed -AZ
	if (!$allowed) {
		include 'include/footer.php';
		exit;
	}
?>

<?php

	$SAVE = $_POST["saving"];

	$PK = $_REQUEST["pk"]; // if editing/removing this will be set
	if ($PK) {
		$Message = "Edit the information below to adjust the account.<br/>";
	}

	$USERNAME = $_POST["username"];
	$EMAIL = $_POST["email"];
	$PASS1 = $_POST["password1"];
	$PASS2 = $_POST["password2"];
	$FIRSTNAME = $_POST["firstname"];
	$LASTNAME = $_POST["lastname"];
	$INSTITUTION_PK = $_POST["institution_pk"];
	$ACTIVATED = $_POST["activated"];
	if (!$ACTIVATED) { $ACTIVATED = 0; }


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
		if (!strlen($INSTITUTION_PK)) {
			$Message .= "<span class='error'>Error: You must select an institution</span><br/>";
			$errors++;
		}
		// password must be set for new user
		if (!$PK && !strlen($PASS1)) {
			$Message .= "<span class='error'>Error: Password cannot be blank</span><br/>";
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
			// write the values to LDAP
			$ds=ldap_connect($LDAP_SERVER,$LDAP_PORT);
			if ($ds) {
				// bind with appropriate dn to give update access
				$admin_bind=ldap_bind($ds, $LDAP_ADMIN_DN, $LDAP_ADMIN_PW);
				if ($admin_bind) {

					// prepare data array
					$info = array();
					$info["cn"]="$FIRSTNAME $LASTNAME";
					$info["givenname"]=$FIRSTNAME;
					$info["sn"]=$LASTNAME;
					$info["sakaiUser"]=$USERNAME;
					$info["mail"]=$EMAIL;
					$info["iid"]="$INSTITUTION_PK";

					// get the institution name for this $INSTITUTION_PK
					$sr=ldap_search($ds, "ou=institutions,dc=sakaiproject,dc=org", "iid=$INSTITUTION_PK", array("o"));
					$item = ldap_get_entries($ds, $sr);
					if ($item["count"]) {
						$info["o"]=$item[0]["o"][0];
					}

					// only set password if it is not blank
					if (strlen($PASS1) > 0) {
						$info["userPassword"]=$PASS1;
					}

					$permissions = array();
					if ($_REQUEST["active"]) { $permissions[] = "active"; }
					if ($_REQUEST["admin_accounts"]) { $permissions[] = "admin_accounts"; }
					if ($_REQUEST["admin_insts"]) { $permissions[] = "admin_insts"; }
					if ($_REQUEST["admin_reqs"]) { $permissions[] = "admin_reqs"; }
					if ($PK or !empty($permissions)) {
						$info["sakaiperm"]=$permissions;
					}

					if (!$PK) { // ADDING USER TO LDAP
						//prepare user dn, find next available uid
						$sr=ldap_search($ds, "ou=users,dc=sakaiproject,dc=org", "uid=*", array("uid"));
						ldap_sort($ds, $sr, 'uid');
						$uidinfo = ldap_get_entries($ds, $sr);
						$lastnum = $uidinfo["count"] - 1;
						$uid = $uidinfo[$lastnum]["uid"][0] + 1;
						ldap_free_result($sr);

						// DN FORMAT: uid=#,ou=users,dc=sakaiproject,dc=org
						$user_dn = "uid=$uid,ou=users,dc=sakaiproject,dc=org";
						//print "uid: $uid; user_dn='$user_dn'<br>";
		
						$info["objectClass"][0]="top";
						$info["objectClass"][1]="person";
						$info["objectClass"][2]="organizationalPerson";
						$info["objectClass"][3]="inetOrgPerson";
						$info["objectClass"][4]="sakaiAccount";
						$info["uid"]=$uid;
                                        
						$ldap_result=ldap_add($ds, $user_dn, $info);
						if ($ldap_result) {
							$Message = "<b>Added new user</b><br/>";
							$PK = $uid;
							writeLog($TOOL_SHORT,$USERNAME,"user added (ldap): $FIRSTNAME $LASTNAME ($EMAIL) [$PK]" );
						} else {
							print "Failed to add user to LDAP (".ldap_error($ds).":".ldap_errno($ds).")<br>";
						}
					} else {
						// EDITING LDAP INFO
						$user_dn = "uid=$PK,ou=users,dc=sakaiproject,dc=org";
						$ldap_result=ldap_modify($ds, $user_dn, $info);
						if ($ldap_result) {
							$Message = "<b>Updated user information</b><br/>";
							writeLog($TOOL_SHORT,$USERNAME,"user modified (ldap): $FIRSTNAME $LASTNAME ($EMAIL) [$PK]" );
						} else {
							print "Failed to modify user in LDAP (".ldap_error($ds).":".ldap_errno($ds).")<br>";
						}
					}
					
				} else {
					$Message = "Critical ERROR: Admin bind failed<br>";
				}
				ldap_close($ds);
			} else {
				$Message = "ERROR: Unable to connect to LDAP server";
			}




			// TODO - REP STUFF
			// set or unset the voting rep (this has to happen before the rep set)
			if ($_REQUEST["setrepvote"]) {
				// set this user as the rep for the currently selected institution
				$Message .= "<b>Set this user as a voting rep.</b><br/>";
			} else {
				// UNset this user as the rep for the currently selected institution
				//$Message .= "<b>Unset this user as a voting rep.</b><br/>";
			}

			// set or unset the inst rep if needed
			if ($_REQUEST["setrep"]) {
				// set this user as the rep for the currently selected institution
				$Message .= "<b>Set this user as an institutional rep.</b><br/>";
				
				// now also set the voting rep if it is not set for this inst
				
				if (!$checkRep[0]) {
					$Message .= "<b>Auto set this user as a voting rep also.</b><br/>";
				}
			} else {
				// UNset this user as the rep for the currently selected institution
				//$Message .= "<b>Unset this user as an institutional rep.</b><br/>";
			}

// TODO - do I need this?
/**
			// clear all values
			$USERNAME = "";
			$EMAIL = "";
			$FIRSTNAME = "";
			$LASTNAME = "";
			$INSTITUTION_PK = "";
**/
		} else {
			$Message = "<div class='error'>Please fix the following errors:\n<blockquote>\n$Message</blockquote>\n</div>\n";
		}
	}


	// get the user information from LDAP if $PK is set
	$output = "";
	$result = array();
	if ($USE_LDAP && $PK) {
		$ds=ldap_connect($LDAP_SERVER,$LDAP_PORT);  // must be a valid LDAP server!
		if ($ds) {
			$reporting_level = error_reporting(E_ERROR); // suppress warning messages
			$read_bind=ldap_bind($ds, $LDAP_READ_DN, $LDAP_READ_PW); // do bind as read user
			if ($read_bind) {
				$attribs = array("cn","givenname","sn","uid","sakaiuser","mail","dn","iid","o","sakaiperm");
			   	$sr=ldap_search($ds, "ou=users,dc=sakaiproject,dc=org", "uid=$PK", $attribs);
				$result = ldap_get_entries($ds, $sr);
				
/**** TESTING ***/
// TODO - comment this out
				$sr=ldap_search($ds, "ou=users,dc=sakaiproject,dc=org", "uid=$PK");
				$output = "<table>";
				$output .= "<tr><td colspan='2'>Number of ldap entries returned: " . 
					ldap_count_entries($ds, $sr) . "</td></tr>";
				$info = ldap_get_entries($ds, $sr); // $info["count"] = items returned
				for ($i=0; $i<$info["count"]; $i++) {
					$output .= "<tr><td colspan='2'><b>LDAP user ".($i+1)." (" . $info[$i]["count"] . " data fields):</b></td></tr>";
					foreach ($info[$i] as $key=>$value) {
						$outvalue = $value;
						if (is_numeric($key) || $key === "count") {
							// skip it
							continue;
						} else if (is_array($value)) {
							$outvalue = "";
							foreach ($value as $key1=>$value1) {
								if ($key1 !== "count") {
									$outvalue .= "$value1 ";
								}
							}
						}
						$output .= "<tr><td align='right'>" . $key . ":</td><td>" . $outvalue . "</td></tr>";
					}
				}
				$output .= "</table>";
/*******/
			} else {
				$Message ="<h4>ERROR: Read bind to ldap failed</h4>";
			}
			ldap_close($ds); // close connection
			error_reporting($reporting_level); // reset error reporting
						
		} else {
		   $Message = "<h3>CRITICAL Error: Unable to connect to LDAP server</h3>";
		}
	}

	if (!empty($result)) {
		if (!strlen($USERNAME)) { $USERNAME = $result[0]["sakaiuser"][0]; }
		if (!strlen($EMAIL)) { $EMAIL = $result[0]["mail"][0]; }
		if (!strlen($FIRSTNAME)) { $FIRSTNAME = $result[0]["givenname"][0]; }
		if (!strlen($LASTNAME)) { $LASTNAME = $result[0]["sn"][0]; }
		if (!strlen($INSTITUTION_PK)) { $INSTITUTION_PK = $result[0]["iid"][0]; }
	}

	// get if this user is an institutional rep or voting rep

$institutionDropdownText = generate_partner_dropdown($INSTITUTION_PK);
?>

<?= $Message ?>

<i style="font-size:9pt;">All fields are required</i><br/>
<form action="<?=$_SERVER['PHP_SELF']; ?>" method="post" name="adminform" style="margin:0px;">
<input type="hidden" name="pk" value="<?= $PK ?>">
<input type="hidden" name="saving" value="1">

<table border="0" cellpadding="0" cellspacing="0" width="100%">
<tr>
<td valign="top" width="50%">

<table border="0" class="padded">
	<tr>
		<td class="account"><b>Username:</b></td>
		<td><input type="text" name="username" tabindex="1" value="<?= $USERNAME ?>" size="40" maxlength="50"></td>
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
		<script>document.adminform.firstname.focus();</script>
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
			<input type="checkbox" name="active" tabindex="9" value="1" <?php
				if (in_array("active",$result[0]["sakaiperm"])) { echo " checked='Y' "; }
			?>>
			<i> - account is active (inactive accounts cannot login)</i>
		</td>
	</tr>

	<tr>
		<td class="account"><b>Inst Rep:</b></td>
		<td class="checkbox">
			<input type="checkbox" name="instrep" tabindex="10" value="1" <?php
				if (in_array("instrep",$result[0]["sakaiperm"])) { echo " checked='Y' "; }
			?>>
			<i> - user is the representative for the listed institution</i>
		</td>
	</tr>

	<tr>
		<td class="account"><b>Vote Rep:</b></td>
		<td class="checkbox">
			<input type="checkbox" name="voterep" tabindex="11" value="1" <?php
				if (in_array("voterep",$result[0]["sakaiperm"])) { echo " checked='Y' "; }
			?>>
			<i> - user is the voting rep for the listed institution</i>
		</td>
	</tr>
	
	<tr>
		<td colspan="2" class="account"><b>Admin Permissions:</b></td>
	</tr>

	<tr>
		<td class="account"><b>Accounts:</b></td>
		<td class="checkbox">
			<input type="checkbox" name="admin_accounts" tabindex="12" value="1" <?php
				if (in_array("admin_accounts",$result[0]["sakaiperm"])) { echo " checked='Y' "; }
			?>>
			<i> - user has admin access to accounts</i>
		</td>
	</tr>

	<tr>
		<td class="account"><b>Institutions:</b></td>
		<td class="checkbox">
			<input type="checkbox" name="admin_insts" tabindex="13" value="1" <?php
				if (in_array("admin_insts",$result[0]["sakaiperm"])) { echo " checked='Y' "; }
			?>>
			<i> - user has admin access to institutions</i>
		</td>
	</tr>

	<tr>
		<td class="account"><b>Requirements:</b></td>
		<td class="checkbox">
			<input type="checkbox" name="admin_reqs" tabindex="14" value="1" <?php
				if (in_array("admin_reqs",$result[0]["sakaiperm"])) { echo " checked='Y' "; }
			?>>
			<i> - user has admin access to req voting</i>
		</td>
	</tr>

</table>

</td>
</tr>
</table>

</form>

<span style="font-size:9pt;">
	<b>Note:</b> <i>To change your password, enter the new values in the fields above.<br/>
	To leave your password at it's current value, leave the password fields blank.</i>
</span>

<?= $output ?>

<?php include 'include/footer.php'; // Include the FOOTER ?>