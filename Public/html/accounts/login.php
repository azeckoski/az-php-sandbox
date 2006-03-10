<?php
require_once 'include/tool_vars.php';

$PAGE_NAME = "Login";
$Message = "";

// connect to database
require 'sql/mysqlconnect.php';

// Clear the current session cookie
setcookie("SESSION_ID", "NULL", null, "/", false, 0);

// Pass along the referrer
$REF = $_REQUEST["ref"]; // This is the refering page

// Get the username and password (force username to lowercase)
$USERNAME = strtolower($_POST["username"]);
$PASSWORD = stripslashes($_POST["password"]);

// check the username/password to auth if present
if (strlen($USERNAME) && strlen($PASSWORD)) {
	$login_success = 0;
	
	// ATTEMPT LDAP AUTH FIRST
	if ($USE_LDAP) {
		$ds=ldap_connect($LDAP_SERVER,$LDAP_PORT);  // must be a valid LDAP server!
		if ($ds) {
			$reporting_level = error_reporting(E_ERROR); // suppress warning messages
			$anon_bind=ldap_bind($ds); // do an anonymous ldap bind, expect ranon=1
			if ($anon_bind) {
				// Searching for (sakaiUser=username)
			   	$sr=ldap_search($ds, "dc=sakaiproject,dc=org", "sakaiUser=$USERNAME"); // expect sr=array
		
				//echo "Number of entries = " . ldap_count_entries($ds, $sr) . "<br />";
				$info = ldap_get_entries($ds, $sr); // $info["count"] = items returned
				
				// annonymous call to sakai ldap will only return the dn
				$user_dn = $info[0]["dn"];
		
				// now attempt to bind as the userdn and password
				$auth_bind=ldap_bind($ds, $user_dn, $PASSWORD);
				if ($auth_bind) {
					// valid bind, user is authentic
					$login_success = 1;
					writeLog($TOOL_SHORT,$USERNAME,"user logged in (ldap):" . $_SERVER["REMOTE_ADDR"].":".$_SERVER["HTTP_REFERER"]);
					
					$sr=ldap_search($ds, $user_dn, "sakaiUser=$USERNAME");
					$info = ldap_get_entries($ds, $sr);
					$user_pk = $info[0]["uid"][0]; // uid is multivalue, we want the first only
				} else {
					// invalid bind, password is not good
					$login_success = 0;
				}
			} else {
				$login_success = 0;
				$Message ="ERROR: Anonymous bind to ldap failed";
			}
			ldap_close($ds); // close connection
			error_reporting($reporting_level); // reset error reporting
						
		} else {
		   $Message = "<h4>CRITICAL Error: Unable to connect to LDAP server</h4>";
		   $login_success = 0;
		}
	} // end use ldap check
		
	if (!$login_success) {
		// ATTEMPT AUTH VIA LOCAL DB
	
		// check the username and password
		$sql1 = "SELECT pk FROM users WHERE username = '$USERNAME' and " .
			"password = PASSWORD('$PASSWORD') and activated = '1'";
		$result = mysql_query($sql1) or die('Query failed: ' . mysql_error());
		$count = mysql_num_rows($result);
		$row = mysql_fetch_assoc($result);
	
		if( !empty($result) && ($count == 1)) {
			// valid login
			$Message = "Valid login: $USERNAME <br/>";
			$user_pk = $row["pk"];

			//print ("Internal Auth Suceeded");
			writeLog($TOOL_SHORT,$USERNAME,"user logged in (internal):" . $_SERVER["REMOTE_ADDR"].":".$_SERVER["HTTP_REFERER"]);
			$login_success = 1;
		}
	}

	if ($login_success && $user_pk) {
		// login suceeded so create the session in the database
		
		$cookie_val = md5($row["pk"] . time() . mt_rand() );
		// create session cookie, this should last until the user closes the browser
		setcookie("SESSION_ID", $cookie_val, null, "/", false, 0);

		// delete all sessions related to this user
		$sql2 = "DELETE FROM sessions WHERE users_pk = '$user_pk'";
		$result = mysql_query($sql2) or die('Query failed: ' . mysql_error());

		// add user to sessions table
		$sql3 = "insert into sessions (users_pk, passkey) values ('$user_pk', '$cookie_val')";
		$result = mysql_query($sql3) or die('Query failed: ' . mysql_error());

		// redirect after login -AZ
		//print "ref = $REF<br/>";

		if ($REF) {
			header('location:'.$REF);
		} else {
			header('location:index.php');
		}

	} else {
		// user/pass combo not found
		$Message .= "<span class='error'>Invalid login: $USERNAME </span><br/>" .
			"Please check your username and password and make sure your account is activated.";

		// Clear the current session cookie
		setcookie("SESSION_ID", "NULL", null, "/", false, 0);
	}
}
?>

<? include 'include/top_header.php'; // INCLUDE THE HTML HEAD ?>
<script>
<!--
// -->
</script>
<? include 'include/header.php'; // INCLUDE THE HEADER ?>

<?= $Message ?>

<table border="0">
<tr>

<td width="10%" valign="top" height="100">
	<div class="login">
	<form name="adminform" method="post" action="<?=$_SERVER['PHP_SELF']; ?>" style="margin:0px;">
<?php if($REF) { ?>
	<input type="hidden" name="ref" value="<?= $REF ?>">
<?php } ?>
	<div class="loginheader">Voting Form Login</div>
	<table border="0" class="padded">
		<tr>
			<td><b>Username:</b></td>
			<td><input type="text" name="username" tabindex="1" value="<?= $USERNAME ?>"></td>
			<script>document.adminform.username.focus();</script>
		</tr>
		<tr>
			<td><b>Password:</b></td>
			<td><input type="password" name="password" tabindex="2" value="<?= $PASSWORD ?>"></td>
		</tr>
		<tr>
			<td colspan="2"><input type="submit" name="login" value="Login" tabindex="3"></td>
		</tr>
		<tr>
			<td colspan="2">
				<a class="pwhelp" href="createaccount.php">Need to create an account?</a>
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<a class="pwhelp" href="forgot_password.php">Forgot your password?</a>
			</td>
		</tr>
	</table>
	</form>
	</div>
</td>

<td valign="top">
	<div class="right">
	<div class="rightheader">Info Display</div>
	<table border="0" class="padded">
	<tr>
	<td>
	This space is planned to be used later to add help information as needed.

	</td>
	</tr>
	</table>
	</div>
</td>

</tr>
</table>

<? include 'include/footer.php'; // Include the FOOTER ?>