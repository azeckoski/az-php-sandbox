<?php
require_once 'include/tool_vars.php';

$PAGE_NAME = "Activate Account";
$Message = "";

// connect to database
require 'sql/mysqlconnect.php';

// process GET vars
$ID = $_REQUEST['id'];
$CODE = $_REQUEST['code'];

$sql = mysql_query("UPDATE users SET activated='1' WHERE pk='$ID'") or
	die('User activation failed: ' . mysql_error());

$sql_doublecheck = mysql_query("SELECT * FROM users WHERE pk='$ID' AND activated='1'");
$doublecheck = mysql_num_rows($sql_doublecheck);

// check to see if the activation code corresponds to a valid user
$sql_activationcheck = mysql_query("SELECT username from users where pk='$ID'");
$activationRow = mysql_fetch_array($sql_activationcheck);
$myActivationCode = substr(md5($activationRow[0]),0,10);

if($doublecheck == 1 && ($CODE == $myActivationCode)){
	$Message = "<strong>Your account has been activated!</strong><br/>" .
		"Please <a href='login.php'>log in</a> to continue.";
} else {
	$Message = "<span class='error'>Your account could not be activated!</span><br/>" .
		"Please contact an administrator at $HELP_EMAIL.";
}
?>

<?php include 'include/top_header.php'; // INCLUDE THE HTML HEAD ?>
<script>
<!--
function focus(){document.adminform.searchtext.focus();}
// -->
</script>
<?php include 'include/header.php'; // INCLUDE THE HEADER ?>

<?= $Message ?>

<?php include 'include/footer.php'; // Include the FOOTER ?>