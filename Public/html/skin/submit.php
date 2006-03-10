<?php
/*
 * file: submit.php
 * Created on Mar 10, 2006 3:20:03 PM by @author aaronz
 * 
 * Aaron Zeckoski (aaronz@vt.edu) - Virginia Tech (http://www.vt.edu/)
 */
?>
<?php
require_once 'include/tool_vars.php';

$PAGE_NAME = "Introduction";
$Message = "";

// connect to database
require 'sql/mysqlconnect.php';

// check authentication
require $ACCOUNTS_PATH.'include/check_authentic.php';

// login if not autheticated
require $ACCOUNTS_PATH.'include/auth_login_redirect.php';

// add in the help link
$EXTRA_LINKS = " - <a style='font-size:.8em;' href='$HELP_LINK' target='_HELP'>Help</a><br/>";
?>

<?php include $ACCOUNTS_PATH.'include/top_header.php'; // INCLUDE THE HTML HEAD ?>
<script>
<!--
// -->
</script>
<?php include 'include/header.php'; // INCLUDE THE HEADER ?>

<h1>Currently In Development</h1>

<? include 'include/footer.php'; // Include the FOOTER ?>