<?php

// Bring in the system variables
// You must verify the path to the system_vars and the
// user control directory are correct or many things will break -AZ
$ACCOUNTS_PATH = "../accounts/";
require ("$ACCOUNTS_PATH/system_vars.php");

// Tool variables
$TOOL_PATH = "/accounts";
$TOOL_NAME = "Account Management";
$TOOL_SHORT = "acnts";
$CSS_FILE = "accounts.css";

$DATE_FORMAT = "l, F dS, Y h:i A";

// tool functions

// Generate password, update db, and send email
function makeRandomPassword() {
      $salt = "abchefghjkmnpqrstuvwxyz0123456789";
      srand((double)microtime()*1000000);
      $i = 0;
      while ($i <= 7) {
            $num = rand() % 33;
            $tmp = substr($salt, $num, 1);
            $pass = $pass . $tmp;
            $i++;
      }
      return $pass;
}
?>
