<?php
require_once 'include/tool_vars.php';

// connect to database
require 'sql/mysqlconnect.php';

// Load User and Inst PROVIDERS
require 'include/providers.php';

// Clear the current session cookie
$User = new User();
$User->destroySession();
// Handle the login process or display a login page
$PAGE_NAME = "Logout";

// redirect to the main page

header('location:'.$CONFADMIN_URL.'/index.php');

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title><?= $TOOL_NAME ?> - <?= $PAGE_NAME ?></title>
<link href="<?= $CSS_FILE ?>" rel="stylesheet" type="text/css">
</head>
<body>
Logged out user, redirecting to main page
</body>
</html>