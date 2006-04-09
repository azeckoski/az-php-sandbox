<?php
// Have to load these modules here first -AZ
if( !extension_loaded( 'gettext')) {
    if( !@dl( 'gettext.so')) {
		die("Could not enable the gettext library!");
    }
}

// Load LDAP module also
if (!extension_loaded('ldap')) {
    if (!dl('ldap.so')) {
    	die("Could not enable LDAP library!");
    }
}

# This is a temporary file
@define('LIBDIR',sprintf('%s/',realpath('../lib/')));
require LIBDIR.'common.php';
?>
