<?php
/*
 * file: login.php
 * Created on Mar 3, 2006 9:45:03 PM by @author aaronz
 * Aaron Zeckoski (aaronz@vt.edu) - Virginia Tech (http://www.vt.edu/)
 */
?>
<?php
require_once 'include/tool_vars.php';


$PAGE_NAME = "Login";

$ACTIVE_MENU="ACCOUNTS";  //for managing active links on multiple menus
$Message = "";

// connect to database
require 'sql/mysqlconnect.php';

// Load User and Inst PROVIDERS
require $ACCOUNTS_PATH.'include/providers.php';

// construct empty user object
$User = new User();

// Pass along the referrer
$REF = $_REQUEST["ref"]; // This is the refering page

// Get the username and password (force username to lowercase)
$username = $_POST["username"];
$password = $_POST["password"];

$errors = 0;
if (ereg('[[:space:]]',$username)) {
	$errors++;
	$Message .= "<span style='color:red;'>Username cannot contain spaces</span><br/>";
}

if (ereg('[[:space:]]',$password)) {
	$errors++;
	$Message .= "<span style='color:red;'>Password cannot contain spaces</span><br/>";
}

// check the username/password to auth if present
if (!$errors && strlen($username) && strlen($password)) {

	if ($User->login($username, $password)) {
		// redirect after login -AZ
		//print "ref = $REF<br/>";

		
		if ($REF) {
			header('location:'.$REF);
		} else {
			header('location:index.php');
		}
		exit;

	}  else {
		// user login failed
		$Message .= "<span class='error'>Invalid login: $username </span><br/>" .
			"Please check your username and password and make sure your account is activated.";

		// Clear the current session cookie
		$User->destroySession();
	}
}


// top header links
$EXTRA_LINKS = "<span class='extralinks'>";
	$EXTRA_LINKS .= "<a  class='active' href='$CONFADMIN_URL/index.php' title='Sakai accounts home'><strong>Home</strong></a>:";

$EXTRA_LINKS .= "<a href='$CONFADMIN_URL/registration/index.php'>Register</a>" .
"<a href='$CONFADMIN_URL/proposals/index.php'>Call for Proposals</a>" ;
if ($SCHEDULE_PUBLISHED) { 
		$EXTRA_LINKS .= "<a href='$CONFADMIN_URL/admin/schedule.php'>Schedule (table view)</a>";
		$EXTRA_LINKS .= "<a href='$CONFADMIN_URL/admin/schedule_details.php'>Schedule (list view)</a>";
		 }  else {
		 		$EXTRA_LINKS .= "<a href='$CONFADMIN_URL/admin/draft_schedule.php'>Schedule</a>";
	
		 	
		 }
		
	
	$EXTRA_LINKS.="</span>";

?>
<?php //INCLUDE THE HEADER

include 'include/top_header.php';  ?>
<script type="text/javascript">
<!--
// -->
</script>
<!-- // INCLUDE THE HEADER -->
<?php include 'include/header.php';  ?>
<div style="padding: 3px 20px;"> 
<?= $Message ?>  </div>

<table id="maincontent" border="0" width="100%" cellspacing="0" cellpadding="0">
<tr>
<td width="10%" valign="top" height="100" style="padding:10px;">
	<div class="login" style="padding:10px;">
	<div><strong>LOGIN REQUIRED: </strong><br/>You must login to register or<br/> submit a proposal for this event. <br/>
		<br/>If you do not have an account, please <a href='$ACCOUNTS_URL/createaccount.php'>create one.</a><br/><br/><br/></div>
	<form name="adminform" method="post" action="<?=$_SERVER['PHP_SELF']; ?>" style="margin:0px;">
<?php if($REF) { ?>
	<input type="hidden" name="ref" value="<?= $REF ?>" />
<?php } ?>
	<div class="loginheader">Login to this event:</div>
	<table border="0" class="padded">
		<tr>
			<td><strong style="font-size:1em">Username:</strong></td>
			<td><input type="text" name="username" tabindex="1" value="<?= $username ?>" size="20" /></td>
		</tr>
		<tr>
			<td><strong style="font-size:1em">Password:</strong></td>
			<td><input type="password" name="password" tabindex="2" value="<?= $password ?>" size="20" /></td>
		</tr>
		<tr>
			<td>&nbsp;</td><td align="right"><input id="submitbutton" type="submit" name="login" value="Login" tabindex="3" /></td>
		</tr>
		<tr>
			<td colspan="2"><br/>
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
<td width="5%"> &nbsp;</td>
<td valign="top">
	<div class="right">
			<div class="componentheading"><br/><img src="<?=$admin_logo?>" height="60" alt="event organization logo" /> <br/><br/> <?=$CONF_NAME?><div  style="color:#666;padding-top:3px; font-size: 1em;">&nbsp;<?=$CONF_LOC?><br/>&nbsp;<?=$CONF_DAYS?></div><br/> </div>
	
	</div>
<div><br/>
	</div>
</td>

</tr>
</table>

<script type="text/javascript">
<!--
	document.adminform.username.focus();
// -->
</script>

<?php include 'include/footer.php'; // Include the FOOTER ?>