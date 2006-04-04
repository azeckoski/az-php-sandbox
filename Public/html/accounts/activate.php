<?php
require_once 'include/tool_vars.php';

$PAGE_NAME = "Activate Account";
$Message = "";

// connect to database
require 'sql/mysqlconnect.php';

// Load User and Inst PROVIDERS
require $ACCOUNTS_PATH.'include/providers.php';


// process GET vars
$id = $_REQUEST['id'];
$code = $_REQUEST['code'];

$error = false;
if (!$id || !$code) { $error = true; }

$thisUser = new User($id);
if($thisUser->pk <= 0) { $error = true; }

if (!$error) {
	// check to see if the activation code corresponds to a valid user
	$myActivationCode = substr(md5($thisUser->username),0,10);

	if ($code == $myActivationCode) {
		$thisUser->addStatus("active");
	} else {
		$error = true;
	}
}

if(!$error){
	$Message = "<strong>Your account has been activated!</strong><br/>" .
		"Please <a href='login.php'>log in</a> to continue.";
} else {
	$Message = "<span class='error'>Your account could not be activated!</span><br/>" .
		"Please contact an administrator at $HELP_EMAIL.";
}
?>

<?php include 'include/top_header.php'; ?>
<script type="text/javascript">
<!--
// -->
</script>
<?php include 'include/header.php'; ?>

<?= $Message ?>

<?php include 'include/footer.php'; ?>