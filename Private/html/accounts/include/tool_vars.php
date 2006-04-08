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

/*
 * LDAP variables
 * These are stored here since the rest of the system should not need to
 * have any concept of LDAP, it should only understand the concept of a
 * user or an institution
 * 
 * Test user for testing LDAP auth:
 * Username: sakai 
 * Password: ironchef
 * NOTE: This user cannot function in the system, they can only be used to
 * test the LDAP authentication, they cannot have a valid session
 */
//$LDAP_SERVER = "reynolds.cc.vt.edu"; // test server 1
$LDAP_SERVER = "bluelaser.cc.vt.edu"; // prod server 1
$LDAP_PORT = "389";
$LDAPS_SERVER = "ldaps://bluelaser.cc.vt.edu"; // SSL prod server 1
$LDAP_ADMIN_DN = "cn=Manager,dc=sakaiproject,dc=org";
$LDAP_ADMIN_PW = "ldapadmin";
$LDAP_READ_DN = "uid=!readonly,ou=users,dc=sakaiproject,dc=org";
$LDAP_READ_PW = "ironchef";
$LDAP_TEST_DN = "uid=test,ou=users,dc=sakaiproject,dc=org";
$LDAP_TEST_PW = "ironchef";
// TODO - make the passwords more secure


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

function is_utf8($string) {
	if (mb_detect_encoding($string) == "UTF-8") { return true; }
	return false;
}

?>
