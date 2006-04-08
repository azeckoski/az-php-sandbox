<?php
/*
 * file: ldap_vars.php
 * Created on Apr 8, 2006 by @author az
 * Aaron Zeckoski (aaronz@vt.edu) - Virginia Tech (http://www.vt.edu/)
 * copyright 2006 Virginia Tech
 */
?>
<?php
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
?>