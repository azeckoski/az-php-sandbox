<?php
/* admin_ldap.php
 * Created on Apr 7, 2006 by @author az - Aaron Zeckoski
 * Aaron Zeckoski (aaronz@vt.edu) - Virginia Tech (http://www.vt.edu/)
 * copyright 2006 Virginia Tech 
 */
?>
<?php
require_once '../include/tool_vars.php';

$PAGE_NAME = "Admin LDAP";

$ACTIVE_MENU="ACCOUNTS";  //for managing active links on multiple menus

$Message = "";

// connect to database
require $ACCOUNTS_PATH.'sql/mysqlconnect.php';

// check authentication
require $ACCOUNTS_PATH.'include/check_authentic.php';

// login if not autheticated
require $ACCOUNTS_PATH.'include/auth_login_redirect.php';

// Make sure user is authorized
$allowed = false; // assume user is NOT allowed unless otherwise shown
if (!$User->checkPerm("admin_accounts")) {
	$allowed = false;
	$Message = "Only admins with <b>admin_accounts</b> or <b>admin_insts</b> may view this page.<br/>" .
		"Try out this one instead: <a href='$TOOL_PATH/'>$TOOL_NAME</a>";
} else {
	$allowed = true;
}

// top header links
$EXTRA_LINKS = "<br/><span style='font-size:.9em;'>" .
	"<a href='index.php'>Admin</a>: " .
	"<a href='admin_ldap.php'><strong>LDAP</strong></a> - " .
	"<a href='admin_users.php'>Users</a> - " .
	"<a href='admin_insts.php'>Institutions</a> - " .
"<a href='admin_perms.php'>Permissions</a> - <a href='admin_roles.php'>Roles</a>" .
	"</span>";

?>

<?php include $ACCOUNTS_PATH.'include/top_header.php'; ?>
<script type="text/javascript">
<!--
// -->
</script>
<?php include $ACCOUNTS_PATH.'include/header.php'; ?>

<?php
	// Put in footer and stop the rest of the page from loading if not allowed -AZ
	if (!$allowed) {
		echo $Message;
		include $ACCOUNTS_PATH.'include/footer.php';
		exit;
	}
?>

<table border=0 cellpadding=0 cellspacing=3 width="100%">
<tr>
<td valign="top" width="80%">

<div class="info">


<?php
if ($_REQUEST['usersLdapToDb']) {
	// get all ldap item data and write to the database
} else if ($_REQUEST['usersDbToLdap']) {
	// get all database items and write to the ldap
	set_time_limit(600); // timeout increased to 10 minutes

	$search = "*";
	if ($_REQUEST['username']) {
		$search = "username=".$_REQUEST['username'];
	}

	$allItems = $User->getUsersBySearch($search,"username","*",false,"db");
	$items_count = count($allItems);

	if ($_REQUEST['username']) {
		$Message = "Updating Ldap user from the Database: ".$_REQUEST['username']."<br/>";
	} else {
		$Message = "Updating Ldap users from the Database ($items_count items)...<br/>";
	}
	$errors = 0;
	foreach ($allItems as $item) {
		$opUser = new User(); // create empty user to write the data
		if($opUser->updateFromArray($item)) {
			if($opUser->createLdap()) {
				$Message .= "Created/Updated user in LDAP: $opUser->username <br/>";
			} else {
				$Message .= "<strong>Failed to update ldap user: " .
						"$item[username]: $opUser->Message </strong><br/>";
				//echo "<pre>",print_r($opUser->toArray()),"</pre><br/>";
				$errors++;
			}
		} else {
			$Message .= "<strong>Failed to update user from array: $item[username] </strong><br/>";
			$errors++;
		}
	}
	$Message .= "Ldap updating Complete! $errors errors.<br/><br/>";
}
?>

<?= $Message ?>

<strong><?= $TOOL_NAME ?> Admin Operations</strong><br/>
<div style="margin:8px;"></div>

<form name="adminform" method="post" action="<?=$_SERVER['PHP_SELF']; ?>" style="margin:0px;">

Username: <input type="input" name="username" size="30" value="<?= $_REQUEST['username'] ?>"/> 
<em>optional</em><br/>
<em>allows you to work with a single user - leaving blank = all users</em><br/>
<br/>

<input type="submit" name="usersDbToLdap" value="Users DB to LDAP"/> 
- This will update the ldap users from the database<br/>
<i style="font-size:.9em;">This is very slow and should never be used unless you know what you are doing!</i><br/>
<br/>

</form>

<a href="<?= $ACCOUNTS_URL ?>/ldapadmin/index.php">Access the phpLDAPAdmin tool</a><br/>

</div>
</td>
<td valign="top" width="20%">
	<div class="right">
	<div class="rightheader"><?= $TOOL_NAME ?> information</div>
	<div class="padded">

<?php
$user_count = $User->getUsersBySearch("*","","pk",true);
$Inst = new Institution();
$inst_count = $Inst->getInstsBySearch("*","","pk",true);
?>

	<span style="font-weight:bold;text-decoration:underline;">Statistics:</span><br/>
	<b>Accounts:</b> <?= $user_count['db'] ?><br/>
<?php if ($USE_LDAP) { ?>
	&nbsp;&nbsp;- LDAP: <?= $user_count['ldap'] ?><br/>
<?php } ?>
	<b>Institutions:</b> <?= $inst_count['db'] ?><br/>
<?php if ($USE_LDAP) { ?>
	&nbsp;&nbsp;- LDAP: <?= $inst_count['ldap'] ?><br/>
<?php } ?>
	<br/>

	</div>
	</div>
</td>
</tr>
</table>



<?php include $ACCOUNTS_PATH.'include/footer.php'; ?>