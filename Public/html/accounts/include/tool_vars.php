<?php

// Bring in the system variables
// You must verify the path to the system_vars and the
// user control directory are correct or many things will break -AZ
$ACCOUNTS_PATH = $_SERVER["DOCUMENT_ROOT"].'/accounts/';
require ($ACCOUNTS_PATH.'include/system_vars.php');

// Tool variables
$TOOL_PATH = $ACCOUNTS_URL;
$TOOL_NAME = "Account Management";
$TOOL_SHORT = "acnts";
$CSS_FILE = $ACCOUNTS_URL."/include/accounts.css";
//$HELP_LINK = "";

$DATE_FORMAT = "l, F dS, Y h:i A";

// LDAP variables
$LDAP_SERVER = "reynolds.cc.vt.edu";
//$LDAP_SERVER = "bluelaser.cc.vt.edu";
$LDAP_PORT = "389";
$LDAP_ADMIN_DN = "cn=Manager,dc=sakaiproject,dc=org";
$LDAP_ADMIN_PW = "ldapadmin";
$LDAP_READ_DN = "uid=0,ou=users,dc=sakaiproject,dc=org";
$LDAP_READ_PW = "ironchef";


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
