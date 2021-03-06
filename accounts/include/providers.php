<?php
/* 
 * file: providers.php
 * Created on Mar 24, 2006 by @author az
 * Aaron Zeckoski (aaronz@vt.edu) - Virginia Tech (http://www.vt.edu/)
 */
?>
<?php
/*
 * User and Institution objects
 * These objects are low level accessors which allow the programmer to access
 * user information or institutional information without having to know where it
 * comes from. The system will ALWAYS attempt to write data to the LDAP first
 * and will only attempt to write data locally as well.
 * 
 * The provider was written to use the LDAP over the database originally.
 * Because of performance concerns the system will now use the LDAP as the
 * authoritative data source but will store user information locally in the DB.
 * General queries should use the database. DB user info is refreshed each time
 * the user logs in and if any changes are made to the user. Institution
 * information is refreshed when updated.
 */
$TOOL_SHORT = "provider";
$SESSION_FROM_DB = true; // false means get the session data from the LDAP (slower but more accurate), true gets it from the DB always

// LDAP variables
require 'ldap_vars.php'; // has to be in same directory as this file

/*
 * GLOBAL VARS
 */
$LDAP_DS = null; // This is the LDAP connection

/*
 * Shared functions
 */

function ldapConnect() {
	// this is an easy connection script to make a connection to the LDAP server for us
	// and not reconnect if we are already connected - faster in theory
	global $LDAP_SSL, $LDAP_DS, $LDAP_SERVER, $LDAP_PORT, $LDAPS_SERVER;

	if (!isset($LDAP_DS)) {
		if ($LDAP_SSL) { // use secure connection as specified
			$LDAP_DS = ldap_connect($LDAPS_SERVER) or die ("CRITICAL SSL LDAP CONNECTION FAILURE"); // ssl connection
		} else {
			$LDAP_DS = ldap_connect($LDAP_SERVER,$LDAP_PORT) or die ("CRITICAL LDAP CONNECTION FAILURE");
		}

		if ($LDAP_DS) {
			ldap_set_option($LDAP_DS, LDAP_OPT_PROTOCOL_VERSION, 3) or die("Failed to set LDAP Protocol version to 3");
			return true;
		} else {
			$LDAP_DS = null;
			$this->Message = "CRITICAL Error: Unable to connect to LDAP server";
			return false;
		}
	}
	return true;
}

function getDS() {
	// simple getter
	global $LDAP_DS;

	return $LDAP_DS;
}

function ldapDisconnect() {
	// this is a simple disconnect script
	global $LDAP_DS;

	if (isset($LDAP_DS)) {
		ldap_close($LDAP_DS); // close connection
		$LDAP_DS = null;
	}
	return true;
}

// bring the specialized sort functions
require 'nested_sorting.php';

/*
 * Provides the methods needed to create, read, update and delete users
 */
class User {

	// member declaration
	public $pk = 0;
	public $username;
	public $fullname;
	public $firstname;
	public $lastname;
	public $email;
	public $institution;
	public $institution_pk;
	public $address;
	public $city;
	public $state;
	public $zipcode;
	public $country;
	public $phone;
	public $fax;
	public $primaryRole;
	public $secondaryRole;

	public $sakaiPerm = array();
	public $userStatus = array();
	public $active = false;
	public $isRep = false;
	public $isVoteRep = false;
	public $Message = "";

	private $data_source = "ldap";
	private $password;
	private $authentic = false;
	private $searchResults = array();

	// map object items to the ldap
	private $ldapItems = 
		array("pk"=>"uid", "username"=>"sakaiuser", "password"=>"userpassword", "fullname"=>"cn",
		"firstname"=>"givenname", "lastname"=>"sn", "email"=>"mail", 
		"primaryRole"=>"primaryrole", "secondaryRole"=>"secondaryrole", 
		"institution_pk"=>"iid", "institution"=>"o", 
		"address"=>"postaladdress", "city"=>"l", "state"=>"st", "zipcode"=>"postalcode", 
		"country"=>"c", "phone"=>"telephonenumber", "fax"=>"facsimiletelephonenumber", 
		"sakaiPerm"=>"sakaiperm", "userStatus"=>"userstatus");

	// LDAP variables:
	// uid, cn, givenname, sn, sakaiUser, mail, userPassword, o, iid, 
	// primaryRole, secondaryRole, sakaiPerm[], postalAddress, l, st, 
	// postalCode, c, telephoneNumber, facsimileTelephoneNumber, userstatus[]

	// maps the object items to the database
	private $dbItems = 
		array("pk"=>"pk", "username"=>"username", "password"=>"password", "fullname"=>"",
		"firstname"=>"firstname", "lastname"=>"lastname", "email"=>"email", 
		"primaryRole"=>"primaryRole", "secondaryRole"=>"secondaryRole", 
		"institution_pk"=>"institution_pk", "institution"=>"institution", 
		"address"=>"address", "city"=>"city", "state"=>"state", "zipcode"=>"zipcode", 
		"country"=>"country", "phone"=>"phone", "fax"=>"fax", 
		"sakaiPerm"=>"sakaiPerms", "userStatus"=>"userStatus");


/*
 * This is a simple set of getters to allow us to know the fields for this
 * object in a nice array
 */
	public function getFields() {
		return array_keys($this->ldapItems);
	}

	public function getLdapFields() {
		return array_values($this->ldapItems);
	}

	public function getDbFields() {
		return array_values($this->dbItems);
	}


	// constructor
	function __construct($userid=-1) {
		global $SESSION_FROM_DB;
		// constructor will create a user based on username or userpk if possible
		if ($userid == -1) { return true; } // created an empty user object

		if ($userid=="session") {
			// create a user from the session (if exists)
			if($this->checkSession()) {
				$data_source = "";
				if ($SESSION_FROM_DB) { $data_source = "db"; }
				return $this->getUserByPk($this->pk, $data_source);
			} else {
				return false;
			}
		}

		if (is_numeric($userid)) {
			// numeric so this is a userpk (at least I hope it is)
			return $this->getUserByPk($userid);
		} else if (eregi('^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$', $userid)) {
			// this must be an email
			return $this->getUserByEmail($userid);
		} else {
			// this must be a username
			return $this->getUserByUsername($userid);
		}
	}


	// destructor for this class
	function __destruct() {
		ldapDisconnect(); // disconnects from LDAP
	}

	function __toString() {
		return $this->toString();
	}

	function toString() {
		// return the entire object as a string
		$output = "pk:". $this->pk . ", " .
			"username:". $this->username . ", " .
			"fullname:". $this->fullname . ", " .
			"firstname:". $this->firstname . ", " .
			"lastname:". $this->lastname . ", " .
			"email:". $this->email . ", " .
			"institution:". $this->institution . ", " .
			"institution_pk:". $this->institution_pk . ", " .
			"address:". $this->address . ", " .
			"city:". $this->city . ", " .
			"state:". $this->state . ", " .
			"zipcode:". $this->zipcode . ", " .
			"country:". $this->country . ", " .
			"phone:". $this->phone . ", " .
			"fax:". $this->fax . ", " .
			"primaryRole:". $this->primaryRole . ", " .
			"secondaryRole:". $this->secondaryRole;
		$output .= ", active:";
		$output .= ($this->active)?"Y":"N";
		$output .= ", sakaiPerm{".implode(":",$this->sakaiPerm)."}";
		$output .= ", userStatus{".implode(":",$this->userStatus)."}";
		$output .= ", isRep:";
		$output .= ($this->isRep)?"Y":"N";
		$output .= ", isVoteRep:";
		$output .= ($this->isVoteRep)?"Y":"N";
		$output .= ", data_source: $this->data_source";
		return $output;
	}

	function toArray() {
		// return the entire object as an assoc array
		$output = array();
		$output['pk'] = $this->pk;
		$output['username'] = $this->username;
		$output['fullname'] = $this->fullname;
		$output['firstname'] = $this->firstname;
		$output['lastname'] = $this->lastname;
		$output['email'] = $this->email;
		$output['institution'] = $this->institution;
		$output['institution_pk'] = $this->institution_pk;
		$output['address'] = $this->address;
		$output['city'] = $this->city;
		$output['state'] = $this->state;
		$output['zipcode'] = $this->zipcode;
		$output['country'] = $this->country;
		$output['phone'] = $this->phone;
		$output['fax'] = $this->fax;
		$output['primaryRole'] = $this->primaryRole;
		$output['secondaryRole'] = $this->secondaryRole;
		$output['active'] = ($this->active)?"Y":"N";
		$output['sakaiPerm'] = implode(":",$this->sakaiPerm);
		$output['userStatus'] = implode(":",$this->userStatus);
		$output['isRep'] = ($this->isRep)?"Y":"N";
		$output['isVoteRep'] = ($this->isVoteRep)?"Y":"N";
		$output['data_source'] = $this->data_source;
		return $output;
	}

	// this function will revert this user object to a clean state
	public function clear() {
		$pk = 0;
		$username = "";
		$fullname = "";
		$firstname = "";
		$lastname = "";
		$email = "";
		$institution = "";
		$institution_pk = "";
		$address = "";
		$city = "";
		$state = "";
		$zipcode = "";
		$country = "";
		$phone = "";
		$fax = "";
		$primaryRole = "";
		$secondaryRole = "";

		$sakaiPerm = array();
		$userStatus = array();
		$active = false;
		$isRep = false;
		$isVoteRep = false;
		$Message = "";

		$data_source = "ldap";
		$password = "";
		$authentic = false;
		$searchResults = array();	
	}


	// SETTERS for private vars
	// password setter (no getter, password should not be retrieveable)
	public function setPassword($password) {
		$this->password = $password;
	}

	// let's us clear the password
	public function removePassword() {
		$this->password = "";
	}


	// GETTERS for private vars
	// simple getter for the data_source
	public function getDataSource() {
		return $this->data_source;
	}


/*
 * PERMISSIONS handling
 * works with permissions in the object, does not persist them
 * Perms would be things like: admin_accounts, admin_insts, admin_reqs
 */

	// add a permission to this user
	public function addPerm($permString) {
		if (!$permString) {
			$this->Message = "Error: permString is empty";
			return false;
		}
		$permString = strtolower($permString);

		if ($this->sakaiPerm[$permString]) {
			$this->Message = "Error: $permString already in perms";
			return true; // no failure if perm already exists
		}

		$this->sakaiPerm[$permString] = $permString;
		if ($permString == "active") { $this->active = true; }
		ksort($this->sakaiPerm); // keep perms in alpha order
		return true;
	}

	// remove a permission from this user
	public function removePerm($permString) {
		if (!$permString) {
			$this->Message = "Error: permString is empty";
			return false;
		}
		$permString = strtolower($permString);

		if (!$this->sakaiPerm[$permString]) {
			$this->Message = "Error: $permString already in perms";
			return true; // no failure if perm not found
		}
		
		unset($this->sakaiPerm[$permString]);
		if ($permString == "active") { $this->active = false; }
		return true;
	}

	// check if this user has a permission
	public function checkPerm($permString) {
		if (!$permString) {
			$this->Message = "Error: permString is empty";
			return false;
		}
		$permString = strtolower($permString);

		if ($this->sakaiPerm[$permString]) {
			return true;
		}
		return false;
	}


/*
 * STATUS handling
 * works with status in the object, does not persist it
 * Status would be things like: active, board_member, sakai_fellow
 */

	// add a status to this user
	public function addStatus($statusString) {
		if (!$statusString) {
			$this->Message = "Error: statusString is empty";
			return false;
		}
		$statusString = strtolower($statusString);

		if ($this->userStatus[$statusString]) {
			$this->Message = "Error: $statusString already in status";
			return true; // no failure if status already exists
		}

		$this->userStatus[$statusString] = $statusString;
		if ($statusString == "active") { $this->active = true; }
		ksort($this->userStatus); // keep status in alpha order
		return true;
	}

	// remove a status from this user
	public function removeStatus($statusString) {
		if (!$statusString) {
			$this->Message = "Error: statusString is empty";
			return false;
		}
		$statusString = strtolower($statusString);

		if (!$this->userStatus[$statusString]) {
			$this->Message = "Error: $statusString already in status";
			return true; // no failure if status not found
		}
		
		unset($this->userStatus[$statusString]);
		if ($statusString == "active") { $this->active = false; }
		return true;
	}

	// check if this user has a status
	public function checkStatus($statusString) {
		if (!$statusString) {
			$this->Message = "Error: statusString is empty";
			return false;
		}
		$statusString = strtolower($statusString);

		if ($this->userStatus[$statusString]) {
			return true;
		}
		return false;
	}



/*
 * Special setters
 * These are designed to allow the some of the special properties of the user to be set
 */
	public function setActive($active) {
		if ($active) {
			if (!$this->sakaiPerm["active"]) {
				$this->sakaiPerm["active"] = "active";
			}
			return true;
		} else {
			if ($this->sakaiPerm["active"]) {
				unset($this->sakaiPerm["active"]);
			}
			return true;
		}
	}


	/*
	 * Check if this user is an inst or polling rep
	 */
	public function repCheck() {
		if (!$this->institution_pk) {
			$this->Message = "Invalid institution_pk ($this->institution_pk)";
			return false;
		}

		// first get the Institution for this user
		$Inst = new Institution($this->institution_pk);
		if ($Inst->pk <= 0) {
			$this->Message = "Invalid institution object ($this->institution_pk)";
			return false;
		}

		// now set the vars
		if ($Inst->rep_pk == $this->pk) {
			$this->isRep = true;
		} else {
			$this->isRep = false;
		}			

		if ($Inst->repvote_pk == $this->pk) {
			$this->isVoteRep = true;
		} else {
			$this->isVoteRep = false;
		}
		return true;
	}

	/*
	 * Set current user as the institutional rep (true or false)
	 */
	public function setRep($set=true) {
		// TODO - make sure this works
		if (!$this->institution_pk) {
			$this->Message = "Invalid institution_pk ($this->institution_pk)";
			return false;
		}

		// first get the Institution for this user
		$Inst = new Institution($this->institution_pk);
		if ($Inst->pk <= 0) {
			$this->Message = "Invalid institution object ($this->institution_pk)";
			return false;
		}

		// clear the rep
		if (!$set) {
			$Inst->rep_pk = "";
			$this->isRep = false;
			return $Inst->save();
		}

		// then set this person as the rep
		$Inst->rep_pk = $this->pk;
		if (!$Inst->repvote_pk) { // if no polling rep (set to the inst rep by default)
			$Inst->repvote_pk = $this->pk;
			$this->isVoteRep = true;
		}

		// save the new rep(s)
		if ($Inst->save()) {
			$this->isRep = true;
			return true;
		}
		return false;
	}

	/*
	 * Set current user as the institutional polling rep (true or false)
	 */
	public function setVoteRep($set=true) {
		// TODO - make sure this works
		if (!$this->institution_pk) {
			$this->Message = "Invalid institution_pk ($this->institution_pk)";
			return false;
		}

		// first get the Institution for this user
		$Inst = new Institution($this->institution_pk);
		if ($Inst->pk <= 0) {
			$this->Message = "Invalid institution object ($this->institution_pk)";
			return false;
		}

		// clear the rep (set to the inst rep by default)
		if (!$set) {
			$Inst->repvote_pk = $Inst->rep_pk;
			$this->isVoteRep = false;
			return $Inst->save();
		}

		// then set this person as the rep
		$Inst->repvote_pk = $this->pk;

		// save the new vote rep
		if ($Inst->save()) {
			$this->isVoteRep = true;
			return true;
		}
		return false;
	}


/*
 * Convenience save function (will insert or update as needed)
 */
 	public function save() {
		return $this->create();
	}

/*
 * CREATE functions
 */
	public function create($data_source="") {
		global $USE_LDAP;
		$this->username = strtolower($this->username);

		// make sure the institution is always set correctly
		if ($this->institution_pk > 1) {
			$Inst = new Institution($this->institution_pk);
			$this->institution = $Inst->name;
		}

		// try to create the user
		if ($USE_LDAP) {
			$this->createLDAP(); // create the LDAP entry first if possible
		}
		return $this->createDB(); // create the DB entry always
	}

	public function createLDAP() {
		global $LDAP_ADMIN_DN, $LDAP_ADMIN_PW, $TOOL_SHORT;

		// write the values to LDAP
		if (ldapConnect()) {
			// bind with appropriate dn to give update access
			$admin_bind=ldap_bind(getDS(), $LDAP_ADMIN_DN, $LDAP_ADMIN_PW);
			if ($admin_bind) {
				// first check to see if this user exists already
				$existsSearch = "(|(uid=$this->pk)(sakaiUser=$this->username)(mail=$this->email))";
				$sr=ldap_search(getDS(), "ou=users,dc=sakaiproject,dc=org", $existsSearch, array("uid"));
				$exists = ldap_get_entries(getDS(), $sr);
				ldap_free_result($sr);
				if($exists['count'] > 0) {
					// entry already exists
					$this->pk = $exists[0]['uid'][0];
					return $this->updateLDAP();
				}


				// prepare data array
				$info = array();
				$info["cn"]=utf8_encode("$this->firstname $this->lastname");
				$info["givenname"]=utf8_encode($this->firstname);
				$info["sn"]=utf8_encode($this->lastname);
				$info["sakaiuser"]=$this->username;
				$info["mail"]=$this->email;
				$info["o"]=utf8_encode($this->institution);
				$info["iid"]=$this->institution_pk;
				$info["primaryrole"]=$this->primaryRole;
				$info["secondaryrole"]=$this->secondaryRole;
				$info["postaladdress"] = utf8_encode(trim($this->address));
				$info["l"]=utf8_encode($this->city);
				$info["st"]=utf8_encode($this->state);
				$info["postalcode"]=$this->zipcode;
				$info["c"]=utf8_encode($this->country);
				$info["telephonenumber"]=$this->phone;
				$info["facsimiletelephonenumber"]=$this->fax;
				
				// only set password if it is not blank
				if (strlen($this->password) > 0) {
					$info["userpassword"]=$this->password;
				}

				if (isset($this->sakaiPerm)) {
					$info["sakaiperm"] = array_values($this->sakaiPerm);
				}

				if (isset($this->userStatus)) {
					$info["userstatus"] = array_values($this->userStatus);
				}

				// empty items must be removed
				// Note: you cannot pass an empty array for any values or the add will fail!
				foreach ($info as $key => $value) if (empty($info[$key])) unset($info[$key]);

				//prepare user dn, find next available uid
				$uid = $this->pk; // use the current pk if one is set
				if($uid <= 0) {
					if (!$uid = nextAutoIncrement("users")) {
						$this->Message = "Could not get a valid uid for new user ($uid)";
						return false;
					}
				}

				// DN FORMAT: uid=#,ou=users,dc=sakaiproject,dc=org
				$user_dn = "uid=$uid,ou=users,dc=sakaiproject,dc=org";
				//print "uid: $uid; user_dn='$user_dn'; $uidinfo[count]; ".$uidinfo[0]['uid'][0]."<br/>";
				
				$info["objectClass"][0]="top";
				$info["objectClass"][1]="person";
				$info["objectClass"][2]="organizationalPerson";
				$info["objectClass"][3]="inetOrgPerson";
				$info["objectClass"][4]="sakaiAccount";
				$info["uid"]=$uid;

				// insert the user into ldap
				// Note: you cannot pass an empty array for any values or the add will fail!
				$ldap_result=ldap_add(getDS(), $user_dn, $info);
				if ($ldap_result) {
					$this->Message = "Added new ldap user";
					$this->pk = $uid;
					writeLog($TOOL_SHORT,$this->username,"user added (ldap): " .
							"$this->firstname $this->lastname ($this->email) [$this->pk]" );
					return true;
				} else {
					$this->Message = "Failed to add user to LDAP (".ldap_error(getDS()).":".ldap_errno(getDS()).")";
					return false;
				}
			} else {
				$this->Message = "Critical ERROR: Admin bind failed";
			}
			return false;
		}
		return false;
	}

	public function createDB() {
		// check to see if the user already exists
		$checksql = "SELECT pk from users where pk='$this->pk' or " .
			"username='$this->username' or email='$this->email'";
		$checkresult = mysql_query($checksql) or die("Check query failed ($checksql): " . mysql_error());
		if (mysql_num_rows($checkresult) == 0) {

			// write the new values to the DB
			$sql = sprintf("INSERT INTO users (username,password,firstname,lastname,email," .
					"primaryRole,secondaryRole,institution_pk,date_created,date_modified," .
					"address,city,state,zipcode,country," .
					"phone,fax,institution) values " .
					"('%s',PASSWORD('%s'),'%s','%s','%s'," .
					"'%s','%s','%s', NOW(), NOW()," .
					"'%s','%s','%s','%s','%s'," .
					"'%s','%s','%s')",
					mysql_real_escape_string($this->username),
					mysql_real_escape_string($this->password),
					mysql_real_escape_string($this->firstname),
					mysql_real_escape_string($this->lastname),
					mysql_real_escape_string($this->email),
					mysql_real_escape_string($this->primaryRole),
					mysql_real_escape_string($this->secondaryRole),
					mysql_real_escape_string($this->institution_pk),
					mysql_real_escape_string($this->address),
					mysql_real_escape_string($this->city),
					mysql_real_escape_string($this->state),
					mysql_real_escape_string($this->zipcode),
					mysql_real_escape_string($this->country),
					mysql_real_escape_string($this->phone),
					mysql_real_escape_string($this->fax),
					mysql_real_escape_string($this->institution) );

			$result = mysql_query($sql);
			if (!$result) {
				$this->Message = "Insert query failed ($sql): " . mysql_error();
				return false;
			}
			$this->pk = mysql_insert_id();
			return true;
		} else {
			return $this->updateDB();
		}
	}



// READ functions
// User fetchers will try to get the user data in the fastest
// and most reliable way possible

/*
 * get the User data by PK (convenience function)
 * WARNING: DO NOT user this function repeatedly to grab multiple users,
 * it will run VERY slow, use getUsersByPkList to grab a group of users
 * when you cannot use a search based on the user data only (i.e. get all
 * users who registered for the conference)
 */
	public function getUserByPk($pk, $data_source="") {
		if (!$pk) {
			$this->Message = "User PK is empty";
			return false;
		}

		// first use the search to get the user data
		if(!$this->getUsersBySearch("pk=$pk", "", "*", false, $data_source)) {
			$this->Message = "Could not find user by pk: $pk";
			return false;
		}

		// now put the user data into the object
		return $this->updateFromArray(reset($this->searchResults)); // first element only
	}


/*
 * get the User data by username (convenience function)
 * WARNING: DO NOT user this function repeatedly to grab multiple users (see getUserByPk comment)
 */
	public function getUserByUsername($username) {
		if (!$username) {
			$this->Message = "Username is empty";
			return false;
		}

		// first use the search to get the user data
		if(!$this->getUsersBySearch("username=$username", "", "*")) {
			$this->Message = "Could not find user by username: $username";
			return false;
		}

		// now put the user data into the object
		return $this->updateFromArray(reset($this->searchResults)); // first element only
	}

	
/*
 * get the User data by email (convenience function)
 * WARNING: DO NOT user this function repeatedly to grab multiple users (see getUserByPk comment)
 */
	public function getUserByEmail($useremail) {
		if (!$useremail) {
			$this->Message = "User email is empty";
			return false;
		}

		// first use the search to get the user data
		if(!$this->getUsersBySearch("email=$useremail", "", "*")) {
			$this->Message = "Could not find user by email: $useremail";
			return false;
		}

		// now put the user data into the object
		return $this->updateFromArray(reset($this->searchResults)); // first element only
	}



/*
 * get a set of User data by search params (* means return everything)
 * Returns an array of arrays which contain the user data
 * Search params should be "type=value" (e.g. "username=a*")
 * Multiple search params are supported (e.g. "username=a*, institution=v*")
 * Can specify the items to be returned (e.g. "pk,username" (default pk)
 * Can specify the sort order (e.g. "username desc") (default pk asc)
 * Can only return the count (in an array as $array['count'])
 * Can limit searching to only one data_source (e.g. "db")
 * 
 * Duplicate PKs will default to the existing data in the order they were
 * fetched (i.e. if there is already a user with PK=4 then another user with 
 * PK=4 will be ignored if found)
 */
	public function getUsersBySearch($search="*", $order="", $items="pk,username", $count=false, $data_source="") {
		// this has to get the users based on a search
		// TODO - allow "and" based searches instead of just "or" based
		global $USE_LDAP;
		$this->searchResults = array(); // must reset array first

		// have to search both the LDAP and the DB unless limited
		if ($USE_LDAP && ($data_source=="" || $data_source=="ldap") ) {
			$this->getSearchFromLDAP($search, $items, $count);
		}
		if ($data_source=="" || $data_source=="db") {
			$this->getSearchFromDB($search, $items, $count);
		}

		// now do the ordering (only if count is off)
		if ($order && !$count) {
			list($o1,$o2) = explode(' ', $order);
			if ($o2 == "desc") {
				// reverse sort
				$this->searchResults = nestedArraySortReverse($this->searchResults, $o1);
			} else {
				// forward sort
				$this->searchResults = nestedArraySort($this->searchResults, $o1);
			}
		}

		return $this->searchResults;
	}

	private function getSearchFromLDAP($search, $items, $count) {
		global $LDAP_READ_DN, $LDAP_READ_PW, $TOOL_SHORT;

		if (ldapConnect()) {
			// bind with appropriate dn to give readonly access
			$read_bind=@ldap_bind(getDS(), $LDAP_READ_DN, $LDAP_READ_PW); // do bind as read user
			if ($read_bind) {
				// set up the search filter
				$filter = "";
				if($search == "*") {
					// get all items
					$filter = "(uid=*)";
				} else if (strpos($search,"PKLIST") !== false) {
					// do the special pklist search
					list($i,$pklist) = split("=",$search);
					foreach (explode(",", $pklist) as $pkitem) {
						$filter .= "(uid=$pkitem)";
					}
					$filter = "(|$filter)";
				} else {
					foreach (explode(",", $search) as $search_item) {
						list($item,$value) = split("=",$search_item);
						if($item && $value && $this->ldapItems[$item]) {
							$filter .= "(".$this->ldapItems[$item]."=$value)";
						}
					}
					$filter = "(|$filter)";
				}
				if (!$filter) {
					$this->Message = "Warning: Could not set filter based on search";
					$filter = "(uid=0)"; // filter is not set so return nothing
				}

				// change the return items into something that ldap understands
				$returnItems = array("uid"); // always return the uid, if counting then only return the uid
				if ($items != "*" && !$count) {
					foreach (explode(",", $items) as $item) {
						if ($this->ldapItems[$item] && $item != "pk") {
							$returnItems[] = $this->ldapItems[$item];
						}
					}
				}

				$sr = 0;
				if ($items == "*") {
					// return all items
					$sr = ldap_search(getDS(), "ou=users,dc=sakaiproject,dc=org", $filter);
				} else {
					// return requested items only (much faster)
					$sr = ldap_search(getDS(), "ou=users,dc=sakaiproject,dc=org", $filter, $returnItems);
				}

				$itemCount = ldap_count_entries(getDS(), $sr);
				if ($count) {
					// only return the count
					$this->searchResults['count'] += $itemCount;
					$this->searchResults['ldap'] = $itemCount;
					return true;
				}

				if($itemCount <= 0) {
					$this->Message = "No matching ldap items for $search";
					return false;
				}
				// get items based on search
				$info = ldap_get_entries(getDS(), $sr);

				$data_source = "ldap";
				$this->Message = "Search results found (ldap): " . $info['count'];
				// add the results to the array with the data_source
				$translator = array_flip($this->ldapItems);
				for ($line=0; $line<$info["count"]; $line++) {
					$pk = $info[$line]["uid"][0];
					if ($this->searchResults[$pk]) { continue; } // if already exists then skip
					$this->searchResults[$pk] = $this->arrayFromLDAP($info[$line], $translator);
					$this->searchResults[$pk]["data_source"] = $data_source;
				}
				return true;
			} else {
				$this->Message ="ERROR: Read bind to ldap failed";
			}
			return false;
		}
		return false;
	}

	// this will create and return an array based on a single ldap return array
	private function arrayFromLDAP($a, $aTranslator=array(), $thisArray=array()) {
		if (empty($aTranslator)) { $aTranslator = array_flip($this->ldapItems); }
		if (empty($a)) { return $thisArray; }

		foreach ($a as $key=>$value) {
			if($aTranslator[$key]) {
				if ($key == "sakaiperm" || $key == "userstatus") {
					unset($value["count"]); // remove the count
					$thisArray[$aTranslator[$key]] = implode(":",$value);
				} else {
					$thisArray[$aTranslator[$key]] = $value[0];
				}
			}
		}
		//echo "<pre>",print_r($thisArray),"</pre>";
		return $thisArray;
	}


	private function getSearchFromDB($search, $items, $count) {
		$search = mysql_real_escape_string($search);

		// set up the search filter
		$filter = "";
		if(strpos($search,"PKLIST") !== false) {
			// do the special pklist search
			list($i,$pklist) = split("=",$search);
			$filter = " pk in ($pklist) ";
		} else {
			foreach (explode(",", $search) as $search_item) {
				list($item,$value) = split("=",$search_item);
				if($item && $value) {
					// TODO - make the search work for perms and status
					$value = str_replace("*","%",$value); // cleanup the ldap search chars
					if ($filter) { $filter .= " or "; }
					if ($item == "fullname") {
						$filter .= "CONCAT(firstname,' ',lastname) like '$value'";
					} else {
						$filter .= "$item like '$value'";
					}
				}
			}
			$filter= trim($filter, " ,"); // trim spaces and commas
		}
		if ($filter) { $filter = "where ($filter)"; }
		// change the return items into something that DB understands
		$returnItems = "pk"; // always return the pk
		if ($count) {
			// return only pk (this is blank on purpose)
		} else if ($items == "*") {
			// return all items
			$returnItems = "*";
		} else {
			foreach (explode(",", $items) as $item) {
				if ($this->dbItems[$item] && $item != "pk") {
					$returnItems .= "," . $this->dbItems[$item];
				} else if ($item == "fullname") {
					// special handling for fullname in DB
					$returnItems .= ",firstname,lastname";
				}
			}
			$returnItems = trim($returnItems, " ,"); // trim spaces and commas
		}

		$sql = "select $returnItems from users $filter";
		$result = mysql_query($sql);
		if (!$result) {
			$this->Message = "User search query failed ($sql): " . mysql_error();
			return false;
		}

		$itemCount = mysql_num_rows($result);
		if ($count) {
			// only return the count
			$this->searchResults['count'] += $itemCount;
			$this->searchResults['db'] = $itemCount;
			return true;
		}

		if ($itemCount <= 0) {
			$this->Message = "No items found for this search: $search";
			return false;
		}

		$data_source = "db";
		$this->Message = "Search results found (db): " . mysql_num_rows($result);
		// add the result PKs to the array
		$translator = array_flip($this->dbItems);
		while($row=mysql_fetch_assoc($result)) {
			$pk = $row["pk"];
			if ($this->searchResults[$pk]) { continue; } // if already exists then skip
			$this->searchResults[$pk] = $this->arrayFromDB($row, $translator);
			$this->searchResults[$pk]["data_source"] = $data_source;
		}
		mysql_free_result($result);
		return true;
	}

	// this will create and return an array based on a single DB return array
	private function arrayFromDB($a, $aTranslator=array(), $thisArray=array()) {
		if (empty($aTranslator)) { $aTranslator = array_flip($this->dbItems); }
		if (empty($a)) { return $thisArray; }

		if ($a["firstname"] && $a["lastname"]) {
			$thisArray["fullname"] = $a["firstname"]." ".$a["lastname"];
		}
		foreach ($a as $key=>$value) {
			if($aTranslator[$key]) {
				$thisArray[$aTranslator[$key]] = $value;
			}
		}
		return $thisArray;
	}


/*
 * Special helper fucntion that grabs all info for the PKs in the list and 
 * returns an array (similar to a search but fetches based on a
 * big list of PKs instead of search params)
 * Returns an array of arrays which contain the user data
 * Can specify the items to be returned (e.g. "pk,username" (default pk)
 * Can limit the fetch to only one data_source (e.g. "db")
 */
	public function getUsersByPkList($pkList=array(), $items="pk,username", $data_source="") {
		if (empty($pkList)) { return false; }
		$this->searchResults = array(); // reset array
		$max = 500;

		if (count($pkList) > $max) {
			// split the list into chunks of max size
			$totalItems = array();
			$splitArray = array_chunk($pkList, $max);
			foreach ($splitArray as $partList) {
				$pkSearch = "PKLIST=" . implode(",",$partList);
				$partItems = $this->getUsersBySearch($pkSearch, "", $items, false, $data_source);
				$totalItems = array_combine($totalItems, $partItems);
			}
			$this->searchResults = $totalItems; // store the return in the searchresult for convenience
			return $totalItems;
		} else {
			// do the search
			$pkSearch = "PKLIST=" . implode(",",$pkList);
			return $this->getUsersBySearch($pkSearch, "", $items, false, $data_source);
		}
	}

/*
 * UPDATE and save functions
 * if setBlanks is true (default) then the update will blank out entries if
 * the variable in the object has no value, else blanks will be ignored
 */
	public function update($setBlanks=true) {
		global $USE_LDAP;
		if (!$this->pk || $this->pk == 0) {
			return false;
		}

		$this->username = strtolower($this->username);

		// make sure the institution is always set correctly
		if ($this->institution_pk > 1) {
			$Inst = new Institution($this->institution_pk);
			$this->institution = $Inst->name;
		}

		// save the user to the appropriate location
		if ($USE_LDAP) {
			$this->updateLDAP($setBlanks); // update the LDAP entry first if possible
		}
		return $this->updateDB($setBlanks); // update the DB entry always
	}

	private function updateDB($setBlanks=true) {
		$permString = implode(":",$this->sakaiPerm); // convert the array of perms into a string
		$statusString = implode(":",$this->userStatus); // convert the array of status into a string

		$update_sql = "";
		if ($this->username || $setBlanks) { $update_sql .= " username='".mysql_real_escape_string($this->username)."', "; }
		if ($this->password) { $update_sql .= " password=PASSWORD('".mysql_real_escape_string($this->password)."'), "; }
		if ($this->email || $setBlanks) { $update_sql .= " email='".mysql_real_escape_string($this->email)."', "; }
		if ($this->firstname || $setBlanks) { $update_sql .= " firstname='".mysql_real_escape_string($this->firstname)."', "; }
		if ($this->lastname || $setBlanks) { $update_sql .= " lastname='".mysql_real_escape_string($this->lastname)."', "; }
		if ($this->institution_pk || $setBlanks) { $update_sql .= " institution_pk='".mysql_real_escape_string($this->institution_pk)."', "; }
		if ($this->institution || $setBlanks) { $update_sql .= " institution='".mysql_real_escape_string($this->institution)."', "; }
		if ($this->primaryRole || $setBlanks) { $update_sql .= " primaryRole='".mysql_real_escape_string($this->primaryRole)."', "; }
		if ($this->secondaryRole || $setBlanks) { $update_sql .= " secondaryRole='".mysql_real_escape_string($this->secondaryRole)."', "; }
		if ($this->address || $setBlanks) { $update_sql .= " address='".mysql_real_escape_string($this->address)."', "; }
		if ($this->city || $setBlanks) { $update_sql .= " city='".mysql_real_escape_string($this->city)."', "; }
		if ($this->state || $setBlanks) { $update_sql .= " state='".mysql_real_escape_string($this->state)."', "; }
		if ($this->zipcode || $setBlanks) { $update_sql .= " zipcode='".mysql_real_escape_string($this->zipcode)."', "; }
		if ($this->country || $setBlanks) { $update_sql .= " country='".mysql_real_escape_string($this->country)."', "; }
		if ($this->phone || $setBlanks) { $update_sql .= " phone='".mysql_real_escape_string($this->phone)."', "; }
		if ($this->fax || $setBlanks) { $update_sql .= " fax='".mysql_real_escape_string($this->fax)."', "; }
		if ($permString || $setBlanks) { $update_sql .= " sakaiPerms='$permString', "; }
		if ($statusString || $setBlanks) { $update_sql .= " userStatus='$statusString', "; }
		$sql .= "UPDATE users set $update_sql date_modified=NOW() where pk='$this->pk'";

		if ($update_sql) {
			$result = mysql_query($sql);
			if (!$result) {
				$this->Message = "Update query failed ($sql): " . mysql_error();
				return false;
			}
		} else {
			return false; // nothing to update
		}
		return true;
	}

	private function updateLDAP($setBlanks=true) {
		global $LDAP_ADMIN_DN, $LDAP_ADMIN_PW, $TOOL_SHORT;
		// write the values to LDAP
		if (ldapConnect()) {
			// bind with appropriate dn to give update access
			$admin_bind=ldap_bind(getDS(), $LDAP_ADMIN_DN, $LDAP_ADMIN_PW);
			if ($admin_bind) {

				// prepare data array
				$info = array();
				$info["cn"]=utf8_encode(trim("$this->firstname $this->lastname"));
				$info["givenname"]=utf8_encode($this->firstname);
				$info["sn"]=utf8_encode($this->lastname);
				$info["sakaiuser"]=$this->username;
				$info["mail"]=$this->email;
				$info["o"]=utf8_encode($this->institution);
				$info["iid"]=$this->institution_pk;
				$info["primaryrole"]=$this->primaryRole;
				$info["secondaryrole"]=$this->secondaryRole;
				$info["postaladdress"] = utf8_encode(trim($this->address));
				$info["l"]=utf8_encode($this->city);
				$info["st"]=utf8_encode($this->state);
				$info["postalcode"]=$this->zipcode;
				$info["c"]=utf8_encode($this->country);
				$info["telephonenumber"]=$this->phone;
				$info["facsimiletelephonenumber"]=$this->fax;

				// only set password if it is not blank
				if (strlen($this->password) > 0) {
					$info["userpassword"]=$this->password;
				}

				if (isset($this->sakaiPerm)) {
					$info["sakaiperm"] = array_values($this->sakaiPerm);
				}

				if (isset($this->userStatus)) {
					$info["userstatus"] = array_values($this->userStatus);
				}

				if ($setBlanks) {
					// empty items must be set to a blank array
					foreach ($info as $key => $value) if (empty($info[$key])) $info[$key] = array();
				} else {
					// empty items must be removed
					foreach ($info as $key => $value) if (empty($info[$key])) unset($info[$key]);
					if (empty($info)) {
						return false; // no items to update
					}
				}
				//echo "<pre>",print_r($info),"</pre><br/>";

				$user_dn = "uid=$this->pk,ou=users,dc=sakaiproject,dc=org";
				$ldap_result=ldap_modify(getDS(), $user_dn, $info);
				if ($ldap_result) {
					$this->Message = "Updated ldap user information";
					writeLog($TOOL_SHORT,$this->username,"user modified (ldap): " .
							"$this->firstname $this->lastname ($this->email) [$this->pk]" );
					return true;
				} else {
					$this->Message = "Failed to modify user in LDAP (".ldap_error(getDS()).":".ldap_errno(getDS()).")";
					//echo "<pre>",print_r($info),"</pre><br/>";
				}
				
			} else {
				$this->Message = "Critical ERROR: Admin bind failed";
			}
			return false;
		}
		return false;
	}


/*
 * DELETE functions
 */
	public function delete() {
		global $USE_LDAP;

		// delete the user from the appropriate location
		if ($USE_LDAP) {
			$this->deleteLDAP(); // remove the LDAP entry first if possible
		}
		return $this->deleteDB(); // remove the DB entry always
	}

	private function deleteDB() {

		$sql = "DELETE from users where pk='$this->pk'";
		$result = mysql_query($sql);
		if (!$result) {
			$this->Message = "Remove query failed ($sql): " . mysql_error();
			return false;
		}
		return true;
	}

	private function deleteLDAP() {
		global $LDAP_ADMIN_DN, $LDAP_ADMIN_PW, $TOOL_SHORT;
		// write the values to LDAP
		if (ldapConnect()) {
			// bind with appropriate dn to give update access
			$admin_bind=ldap_bind(getDS(), $LDAP_ADMIN_DN, $LDAP_ADMIN_PW);
			if ($admin_bind) {
				$user_dn = "uid=$this->pk,ou=users,dc=sakaiproject,dc=org";
				$delresult = ldap_delete(getDS(),$user_dn);
				if ($delresult) {
					$this->Message = "Removed ldap user: $user_dn";
					return true;
				} else {
					$this->Message = "Failed to remove ldap user: $user_dn";
				}
			} else {
				$this->Message = "Critical ERROR: Admin bind failed";
			}
			return false;
		}
		return false;
	}

/*
 * Will attempt to authenticate a user based on
 * a username and password (works from multiple sources)
 * Running an authenticate will also populate the user object
 * if the authentication is successful
 */
	public function authenticateUser($username,$password) {
		global $USE_LDAP;

		// returns true if the authetication succeeds, false otherwise
		if (!$username || !$password) {
			$this->Message = "Empty username or password.";
			return false;
		}

		$username = strtolower($username);
		$this->username = $username;
		$this->password = $password;
		$this->authentic = false; // start out not authenticated

		// attempt LDAP authenticate first
		if ($USE_LDAP) {
			if($this->authenticateUserFromLDAP($username,$password)) {
				$this->createDB(); // update the DB from the LDAP (sync)
				return true;
			}
		}

		// attempt DB authentication as a fallback
		if($this->authenticateUserFromDB($username,$password)) {
			if ($USE_LDAP) {
				$this->createLDAP(); // update the LDAP from the DB (sync)
			}
			return true;
		}

		return false;
	}

	private function authenticateUserFromLDAP($username,$password) {
		global $LDAP_SERVER, $LDAP_PORT, $TOOL_SHORT;

		if (ldapConnect()) {
			$anon_bind=ldap_bind(getDS()); // do an anonymous ldap bind, expect ranon=1
			if ($anon_bind) {
				// Searching for (sakaiUser=username)
			   	$sr=ldap_search(getDS(), "ou=users,dc=sakaiproject,dc=org", 
					"(&(sakaiUser=$username)(userStatus=active))"); // expect sr=array

				//echo "Number of entries = " . ldap_count_entries(getDS(), $sr) . "<br />";
				$info = ldap_get_entries(getDS(), $sr); // $info["count"] = items returned

				// annonymous call to sakai ldap will only return the dn
				$user_dn = $info[0]["dn"];

				// set up for TLS encrypted connection
				//ldap_start_tls(getDS()) or die("Ldap_start_tls failed"); 

   				// now attempt to bind as the userdn and password
				$auth_bind=@ldap_bind(getDS(), $user_dn, $password);
				if ($auth_bind) {
					// valid bind, user is authentic
					writeLog($TOOL_SHORT,$username,"user logged in (ldap):" . $_SERVER["REMOTE_ADDR"].":".$_SERVER["HTTP_REFERER"]);

					// get the user info for this user
					$sr=ldap_search(getDS(), $user_dn, "sakaiUser=$username");
					$info = ldap_get_entries(getDS(), $sr);

					// put the data into the user object
					$this->pk = $info[0]["uid"][0];
					$this->updateFromArray($this->arrayFromLDAP($info[0]));

					$this->Message = "Valid LDAP login: $username";
					$this->data_source = "ldap";
					if ($this->active) {
						$this->authentic = true;
						return true;
					} else {
						$this->Message = "Cannot login; user is not active: $username";
						return false;
					}
				} else {
					// invalid bind, password is not good
					$this->Message = "Invalid login: $username - password is not good";
				}
			} else {
				$this->Message ="ERROR: Anonymous bind to ldap failed";
			}
			return false;
		}
		return false;
	}
	
	private function authenticateUserFromDB($username,$password) {
		global $TOOL_SHORT;

		$username = mysql_real_escape_string($username);
		$password = mysql_real_escape_string($password);
		// check the username and password
		$sql = "SELECT pk FROM users WHERE " .
			"username = '$username' and password = PASSWORD('$password') " .
			"and userStatus like '%active%'";
		$result = mysql_query($sql) or die("Auth query failed ($sql):" . mysql_error());
		$count = mysql_num_rows($result);
		$row = mysql_fetch_assoc($result);

		if( !empty($result) && ($count == 1)) {
			// valid login
			$this->Message = "Valid login: $username";
			$userPK = $row["pk"];

			//print ("Internal Auth Suceeded");
			writeLog($TOOL_SHORT,$username,"user logged in (internal):" . $_SERVER["REMOTE_ADDR"].":".$_SERVER["HTTP_REFERER"]);

			$sqlusers = "select * from users where pk = '$userPK'";
			$result = mysql_query($sqlusers) or die('User query failed: ' . mysql_error());
			$user_row = mysql_fetch_assoc($result);

			$this->pk = $user_row["pk"];
			$this->updateFromArray($this->arrayFromDB($user_row));

			$this->data_source = "db";
			if ($this->active) {
				$this->authentic = true;
				return true;
			} else {
				$this->Message = "Cannot login; user is not active: $username";
				return false;
			}
		}
		$this->Message = "Invalid login: $username not in DB";
		return false;
	}

/*
 * SESSION handling functions
 * These sessions will handle the user session so that users do not have to login
 * on every page
 */

	// this is a convenience function for login which handles the entire
	// login process including authenticting the user, creating a session,
	// and populating the user object
	public function login($username, $password) {
		$username = strtolower($username);
		
		if (!isset($username) || !isset($password)) {
			$this->Message = "Blank username or password";
			return false;
		}
		
		if (!$this->authenticateUser($username, $password)) {
			$this->Message = "Invalid username or password";
			$this->destroySession();
			return false;
		}

		if (!$this->createSession()) {
			$this->Message = "Cannot create session for $this->username";
			return false;
		}
		return true;
	}


	// convenience function to logout a user (the user does not have to be known for this
	// function to work, in other words, user object can be empty)
	public function logout() {
		if (!$this->pk) {
			if ($this->destroySession()) {
				return true;
			}
		}

		if ($this->destroySessions()) {
			return true;
		}
		return false;
	}


	// creates a session for an authenticated user
	public function createSession() {
		// only create a session if the user is authenticated
		if (!$this->pk) {
			$this->Message = "Cannot create session for unidentified user ($this->pk)";
			return false;
		}

		if (!$this->authentic) {
			$this->Message = "Cannot create session for unauthenticated user";
			return false;
		}

		// delete all sessions related to this user first
		$this->destroySessions();

		$cookie_val = md5($this->pk . time() . mt_rand() );
		// create session cookie, this should last until the user closes their browser
		setcookie("SAKAIWEB", $cookie_val, null, "/", false, 0);

		// add to sessions table
		$sql3 = "insert into sessions (users_pk, passkey, date_created) " .
			"values ('$this->pk', '$cookie_val', NOW())";
		$result = mysql_query($sql3) or die('Query failed: ' . mysql_error());
		return true;
	}

	// gets the user pk from the current session if there is one
	private function checkSession() {
		$PASSKEY = $_COOKIE["SAKAIWEB"];

		// check the passkey
		if (isset($PASSKEY)) {
			$sql = "SELECT users_pk FROM sessions WHERE passkey = '$PASSKEY'";
			$result = mysql_query($sql) or die("Session query failed ($sql): " . mysql_error());
			if (!$result) {
				$this->Message = "Session query failed ($sql): " . mysql_error();
				return false;
			}
			$row = mysql_fetch_assoc($result);
			mysql_free_result($result);
			if (!$row) {
				// no valid key exists, user not authenticated
				$this->pk = 0;
				return false;
			} else {
				// authenticated user
				$this->pk = $row["users_pk"];
				return true;
			}
		} else {
			return false;
		}
	}

	// destroy the session for the current browser (not necessarily tied to user)
	public function destroySession() {
		// delete the current session based on the cookie
		$PASSKEY = $_COOKIE["SAKAIWEB"];
		$sql = "DELETE FROM sessions WHERE passkey = '$PASSKEY'";
		$result = mysql_query($sql) or die('Query failed: ' . mysql_error());

		// Clear the current session cookie
		setcookie("SAKAIWEB", "NULL", null, "/", false, 0);

		if (mysql_affected_rows()) {
			$this->Message = "Removed current session";
			return true;
		}
		return false;
	}

	// destroy all sessions for the current user (use on logout)
	public function destroySessions() {
		if (!$this->pk) {
			$this->Message = "Cannot remove all sessions for unidentified user ($this->pk)";
			return false;
		}

		// Clear the current session cookie
		setcookie("SAKAIWEB", "NULL", null, "/", false, 0);

		// delete all sessions related to this user
		$sql = "DELETE FROM sessions WHERE users_pk = '$this->pk'";
		$result = mysql_query($sql) or die("Query failed ($sql): " . mysql_error());
		if (mysql_affected_rows()) {
			$this->Message = "Removed all sessions for $this->username ($this->pk)";
			return true;
		}
		return false;
	}


/*
 * These functions allow us to populate the object from
 * the database query results or from the LDAP query results or
 * a user supplied array of values (also standardizes the fields)
 */
	public function updateFromArray($userArray) {
		if (!$userArray || empty($userArray)) {
			$this->Message = "Cannot updateFromArray, userArray empty";
			return false;
		}

		if (!$userArray['data_source']) {
			$this->data_source = "unknown";
		} else {
			$this->data_source = $userArray['data_source'];
		}
		$this->pk = $userArray['pk'];
		$this->username = $userArray['username'];
		if ($userArray['fullname']) {
			$this->fullname = $userArray['fullname'];
		} else {
			$this->fullname = $userArray['firstname'] ." ". $userArray['lastname'];
		}
		$this->firstname = $userArray['firstname'];
		$this->lastname = $userArray['lastname'];
		$this->email = $userArray['email'];
		$this->institution_pk = $userArray['institution_pk'];
		$this->institution = $userArray['institution'];
		$this->address = $userArray['address'];
		$this->city = $userArray['city'];
		$this->state = $userArray['state'];
		$this->zipcode = $userArray['zipcode'];
		$this->country = $userArray['country'];
		$this->phone = $userArray['phone'];
		$this->fax = $userArray['fax'];
		$this->primaryRole = $userArray['primaryRole'];
		$this->secondaryRole = $userArray['secondaryRole'];
		// convert the string of perms to an array
		$a = explode(":",$userArray['sakaiPerm']);
		if (is_array($a)) {
			foreach ($a as $value) {
				if (!$value) { continue; }
				$this->sakaiPerm[$value] = "$value";
			}
		} else { $this->sakaiPerm = array(); }
		// convert the string of status to an array
		$a = explode(":",$userArray['userStatus']);
		if (is_array($a)) {
			foreach ($a as $value) {
				if (!$value) { continue; }
				$this->userStatus[$value] = "$value";
			}
		} else { $this->userStatus = array(); }
		if ($this->userStatus["active"]) { $this->active=true; }
		return true;
	}
}



/*
 * Provides the methods needed to create, read, update and delete institutions
 */
class Institution {

	// member declaration
	public $pk = 0;
	public $name;
	public $type;
	public $city;
	public $state;
	public $zipcode;
	public $country;
	public $rep_pk;
	public $repvote_pk;

	public $Message = "";

	private $currentName;
	private $data_source = "ldap";
	private $searchResults = array();

	// map object items to the ldap
	private $ldapItems = 
		array("pk"=>"iid", "name"=>"o", "type"=>"insttype",
		"city"=>"l", "state"=>"st", "zipcode"=>"postalcode", 
		"country"=>"c", "rep_pk"=>"repuid", "repvote_pk"=>"voteuid");

	// LDAP variables:
	// iid, o, instType, repUid, voteUid, l, st, postalCode, c

	// maps the object items to the database
	private $dbItems = 
		array("pk"=>"pk", "name"=>"name", "type"=>"type",
		"city"=>"city", "state"=>"state", "zipcode"=>"zipcode", 
		"country"=>"country", "rep_pk"=>"rep_pk", "repvote_pk"=>"repvote_pk");

/*
 * This is a simple set of getters to allow us to know the fields for this
 * object in a nice array
 */
	public function getFields() {
		return array_keys($this->ldapItems);
	}

	public function getLdapFields() {
		return array_values($this->ldapItems);
	}

	public function getDbFields() {
		return array_values($this->dbItems);
	}


	// constructor
	function __construct($id=-1) {
		// constructor will create an inst based on pk if possible
		if ($id == -1) {
			$this->Message = "Success: Empty object created";
			return true;
		} // created an empty inst object

		if (is_numeric($id)) {
			// numeric so this is a pk (at least I hope it is)
			if($this->getInstByPk($id)) {
				return true;
			}
		}
		$this->Message = "Failed: Empty object created";
		return false;
	}

	// destructor for this class
	function __destruct() {
		ldapDisconnect(); // disconnects from LDAP
	}

	function __toString() {
		return $this->toString();
	}

	public function toString() {
		// return the entire object as a string
		$output = 
			"pk:". $this->pk . ", " .
			"name:". $this->name . ", " .
			"type:". $this->type . ", " .
			"city:". $this->city . ", " .
			"state:". $this->state . ", " .
			"zipcode:". $this->zipcode . ", " .
			"country:". $this->country . ", " .
			"rep_pk:". $this->rep_pk . ", " .
			"repvote_pk:". $this->repvote_pk;
		return $output;
	}

	public function toArray() {
		// return the entire object as an assoc array
		$output = array();
		$output['pk'] = $this->pk;
		$output['name'] = $this->name;
		$output['type'] = $this->type;
		$output['city'] = $this->city;
		$output['state'] = $this->state;
		$output['zipcode'] = $this->zipcode;
		$output['country'] = $this->country;
		$output['rep_pk'] = $this->rep_pk;
		$output['repvote_pk'] = $this->repvote_pk;
		return $output;
	}

	// this function will revert this object to a clean state
	public function clear() {
		$pk = 0;
		$name = "";
		$type = "";
		$city = "";
		$state = "";
		$zipcode = "";
		$country = "";
		$rep_pk = "";
		$repvote_pk = "";

		$Message = "";

		$currentName = "";
		$data_source = "ldap";
		$searchResults = array();
	}

/*
 * Function to return whether this institution is a partner or not
 */
 	public function isPartner() {
 		if ($this->pk <= 1) { return false; } // Other is never a partner

 		if ($this->type == "non-member" || $this->type == "") {
 			return false;
 		}
 		return true;
	}


/*
 * Convenience save function (will insert or update as needed)
 */
 	public function save() {
		return $this->create();
	}


/*
 * CREATE functions
 */
	public function create() {
		global $USE_LDAP;
		
		// create the instituion
		if ($USE_LDAP) {
			$this->createLDAP(); // create the LDAP entry first if possible
		}
		return $this->createDB(); // create the DB entry always
	}

	private function createDB() {
		// check to see if the inst already exists
		$checksql = "SELECT pk from institution where pk='$this->pk'";
		$checkresult = mysql_query($checksql) or die("Check query failed ($checksql): " . mysql_error());
		if (mysql_num_rows($checkresult) == 0) {
			// write the new values to the DB
			$sql = sprintf("INSERT INTO institution " .
				"(date_created, name, type, city, state, zipcode, " .
				"country, rep_pk, repvote_pk) values " .
				"(NOW(),'%s','%s','%s','%s','%s'," .
				"'%s','%s','%s')",
					mysql_real_escape_string($this->name),
					mysql_real_escape_string($this->type),
					mysql_real_escape_string($this->city),
					mysql_real_escape_string($this->state),
					mysql_real_escape_string($this->zipcode),
					mysql_real_escape_string($this->country),
					mysql_real_escape_string($this->rep_pk),
					mysql_real_escape_string($this->repvote_pk) );
			
			$result = mysql_query($sql);
			if (!$result) {
				$this->Message = "Insert query failed ($sql): " . mysql_error();
				return false;
			}
			$this->pk = mysql_insert_id();
			return true;
		} else {
			return $this->updateDB();
		}
	}

	private function createLDAP() {
		global $LDAP_ADMIN_DN, $LDAP_ADMIN_PW, $TOOL_SHORT;
		// write the values to LDAP
		if (ldapConnect()) {
			// bind with appropriate dn to give update access
			$admin_bind=ldap_bind(getDS(), $LDAP_ADMIN_DN, $LDAP_ADMIN_PW);
			if ($admin_bind) {

				// first check to see if this exists already
				$existsSearch = "(iid=$this->pk)";
				$sr=ldap_search(getDS(), "ou=users,dc=sakaiproject,dc=org", $existsSearch, array("iid"));
				$exists = ldap_get_entries(getDS(), $sr);
				ldap_free_result($sr);
				if($exists['count'] > 0) {
					// entry already exists
					$this->pk = $exists[0]['iid'][0];
					return $this->updateLDAP();
				}


				// prepare data array
				$info = array();
				$info["o"]=$this->name;
				$info["insttype"]=$this->type;
				$info["l"]=$this->city;
				$info["st"]=$this->state;
				$info["postalcode"]=$this->zipcode;
				$info["c"]=$this->country;
				$info["repuid"]=$this->rep_pk;
				$info["voteuid"]=$this->repvote_pk;

				// empty items must be removed
				// Note: you cannot pass an empty array for any values or the add will fail!
				foreach ($info as $key => $value) if (empty($info[$key])) unset($info[$key]);

				//prepare inst dn, find next available iid
				$id = $this->pk; // use the current pk if one is set
				if($id <= 0) {
					if (!$id = nextAutoIncrement("institution")) {
						$this->Message = "Could not get a valid iid for new item ($id)";
						return false;
					}
				}

//				$sr=ldap_search(getDS(), "ou=institutions,dc=sakaiproject,dc=org", "iid=*", array("iid"));
//				ldap_sort(getDS(), $sr, 'iid');
//				$idinfo = ldap_get_entries(getDS(), $sr);
//				$lastnum = $idinfo["count"] - 1;
//				$id = $idinfo[$lastnum]["iid"][0] + 1;
//				ldap_free_result($sr);

				// DN FORMAT: iid=#,ou=institutions,dc=sakaiproject,dc=org
				$item_dn = "iid=$id,ou=institutions,dc=sakaiproject,dc=org";

				$info["objectClass"][0]="sakaiInst";
				$info["iid"]=$id;

				// insert the item into ldap
				$ldap_result=ldap_add(getDS(), $item_dn, $info);
				if ($ldap_result) {
					$Message = "Added new ldap institution";
					$this->pk = $id;
					writeLog($TOOL_SHORT,$this->username,"inst added (ldap): " .
							"$this->name ($this->type) [$this->pk]" );
					return true;
				} else {
					$this->Message = "Failed to add inst to LDAP (".ldap_error(getDS()).":".ldap_errno(getDS()).")";
				}
			} else {
				$this->Message = "Critical ERROR: Admin bind failed";
			}
			return false;
		}
		return false;
	}


/*
 * get the Institution data by PK (convenience function)
 * WARNING: DO NOT use this function repeatedly to grab multiple items,
 * it will run VERY slow, use getInstsByPkList to grab a group of insts
 * when you cannot use a search based on the inst data only (i.e. get all
 * institutions for users who registered for the conference)
 */
	public function getInstByPk($pk) {
		if (!$pk) {
			$this->Message = "Inst PK is empty";
			return false;
		}

		// first use the search to get the user data
		if(!$this->getInstsBySearch("pk=$pk", "", "*")) {
			$this->Message = "Could not find inst by pk: $pk";
			return false;
		}
		// now put the data into the object
		return $this->updateFromArray(reset($this->searchResults)); // first element only
	}

	public function getInstByName($name) {
		if (!$name) {
			$this->Message = "Inst Name is empty";
			return false;
		}

		// first use the search to get the user data
		if(!$this->getInstsBySearch("name=$name", "", "*")) {
			$this->Message = "Could not find inst by name: $name";
			return false;
		}

		// now put the data into the object
		return $this->updateFromArray(reset($this->searchResults)); // first element only
	}


/*
 * get a set of Inst data by search params (* means return everything)
 * Returns an array of arrays which contain the data
 * Search params should be "type=value" (e.g. "name=a*")
 * Multiple search params are supported (e.g. "name=a*, type=educational")
 * Can specify the items to be returned (e.g. "pk,name" (default pk)
 * Can specify the sort order (e.g. "name desc") (default pk asc)
 * Can limit searching to only one data_source (e.g. "db")
 * 
 * Duplicate PKs will default to the existing data in the order they were
 * fetched (i.e. if there is already an inst with PK=5 then another inst with 
 * PK=5 will be ignored if found)
 */
	public function getInstsBySearch($search="*", $order="", $items="pk,name", $count=false, $data_source="") {
		// this has to get the insts based on a search
		// TODO - allow "and" based searches instead of just "or" based
		global $USE_LDAP;
		$this->searchResults = array(); // must reset array first

		// have to search both the LDAP and the DB unless limited
		if ($USE_LDAP && ($data_source=="" || $data_source=="ldap") ) {
			$this->getSearchFromLDAP($search, $items, $count);
		}
		if ($data_source=="" || $data_source=="db") {
			$this->getSearchFromDB($search, $items, $count);
		}

		// now do the ordering (only if not counting)
		if ($order && !$count) {
			list($o1,$o2) = explode(' ', $order);
			if ($o2 == "desc") {
				// reverse sort
				if ($o1 == "pk") {
					$this->searchResults = nestedArrayNumSortReverse($this->searchResults, $o1);
				} else {
					$this->searchResults = nestedArraySortReverse($this->searchResults, $o1);
				}
			} else {
				// forward sort
				if ($o1 == "pk") {
					$this->searchResults = nestedArrayNumSort($this->searchResults, $o1);
				} else {
					$this->searchResults = nestedArraySort($this->searchResults, $o1);
				}
			}
		}

		return $this->searchResults;
	}

	private function getSearchFromLDAP($search, $items, $count) {
		global $LDAP_READ_DN, $LDAP_READ_PW, $TOOL_SHORT;

		if (ldapConnect()) {
			// bind with appropriate dn to give readonly access
			$read_bind=ldap_bind(getDS(), $LDAP_READ_DN, $LDAP_READ_PW); // do bind as read user
			if ($read_bind) {
				// set up the search filter
				$filter = "";
				if($search == "*") {
					// get all items
					$filter = "(iid=*)";
				} else if (strpos($search,"PKLIST") !== false) {
					// do the special pklist search
					list($i,$pklist) = split("=",$search);
					foreach (explode(",", $pklist) as $pkitem) {
						$filter .= "(iid=$pkitem)";
					}
					$filter = "(|$filter)";
				} else {
					foreach (explode(",", $search) as $search_item) {
						list($item,$value) = split("=",$search_item);
						if($item && $value && $this->ldapItems[$item]) {
							$filter .= "(".$this->ldapItems[$item]."=$value)";
						}
					}
					$filter = "(|$filter)";
				}
				if (!$filter) {
					$this->Message = "Warning: Could not set filter based on search";
					$filter = "(iid=0)"; // filter is not set so return nothing
				}

				// change the return items into something that ldap understands
				$returnItems = array("iid"); // always return the iid
				if ($items != "*") {
					foreach (explode(",", $items) as $item) {
						if ($this->ldapItems[$item] && $item != "pk") {
							$returnItems[] = $this->ldapItems[$item];
						}
					}
				}

				$sr = 0;
				if ($items == "*") {
					// return all items
					$sr = ldap_search(getDS(), "ou=institutions,dc=sakaiproject,dc=org", $filter);
				} else {
					// return requested items only (much faster)
					$sr = ldap_search(getDS(), "ou=institutions,dc=sakaiproject,dc=org", $filter, $returnItems);
				}

				$itemCount = ldap_count_entries(getDS(), $sr);
				if ($count) {
					// only return the count
					$this->searchResults['count'] += $itemCount;
					$this->searchResults['ldap'] = $itemCount;
					return true;
				}

				if($itemCount <= 0) {
					$this->Message = "No matching ldap items for $search";
					return false;
				}

				// get items based on search
				$info = ldap_get_entries(getDS(), $sr);

				$data_source = "ldap";
				$this->Message = "Search results found (ldap): " . ldap_count_entries(getDS(), $sr);
				// add the results to the array with the data_source
				$translator = array_flip($this->ldapItems);
				for ($line=0; $line<$info["count"]; $line++) {
					$pk = $info[$line]["iid"][0];
					if ($this->searchResults[$pk]) { continue; } // if already exists then skip
					$this->searchResults[$pk] = $this->arrayFromLDAP($info[$line], $translator);
					$this->searchResults[$pk]["data_source"] = $data_source;
				}
				return true;
			} else {
				$this->Message ="ERROR: Read bind to ldap failed";
			}
			return false;
		}
		return false;
	}

	// this will create and return an array based on a single ldap return array
	private function arrayFromLDAP($a, $aTranslator=array(), $thisArray=array()) {
		if (empty($aTranslator)) { $aTranslator = array_flip($this->ldapItems); }
		if (empty($a)) { return $thisArray; }

		foreach ($a as $key=>$value) {
			if($aTranslator[$key]) {
				$thisArray[$aTranslator[$key]] = $value[0];
			}
		}
		return $thisArray;
	}


	private function getSearchFromDB($search, $items, $count) {
		$search = mysql_real_escape_string($search);

		// set up the search filter
		$filter = "";
		if(strpos($search,"PKLIST") !== false) {
			// do the special pklist search
			list($i,$pklist) = split("=",$search);
			$filter = " pk in ($pklist) ";
		} else {
			foreach (explode(",", $search) as $search_item) {
				list($item,$value) = split("=",$search_item);
				if($item && $value) {
					$value = str_replace("*","%",$value); // cleanup the ldap search chars
					if ($filter) { $filter .= " or "; }
					$filter .= "$item like '$value'";
				}
			}
			$filter= trim($filter, " ,"); // trim spaces and commas
		}
		if ($filter) { $filter = "($filter) and "; }

		// change the return items into something that DB understands
		$returnItems = "pk"; // always return the pk
		if ($items == "*") {
			// return all items
			$returnItems = "*";
		} else {
			foreach (explode(",", $items) as $item) {
				if ($this->dbItems[$item] && $item != "pk") {
					$returnItems .= "," . $this->dbItems[$item];
				}
			}
			$returnItems = trim($returnItems, " ,"); // trim spaces and commas
		}

		$sql = "select $returnItems from institution where $filter pk > 1"; // skip the other Inst
		$result = mysql_query($sql);
		if (!$result) {
			$this->Message = "Inst search query failed ($sql): " . mysql_error();
			return false;
		}

		$itemCount = mysql_num_rows($result);
		if ($count) {
			// only return the count
			$this->searchResults['count'] += $itemCount;
			$this->searchResults['db'] = $itemCount;
			return true;
		}

		if ($itemCount <= 0) {
			$this->Message = "No items found for this search: $search";
			return false;
		}

		$data_source = "db";
		$this->Message = "Search results found (db): " . mysql_num_rows($result);
		// add the result PKs to the array
		$translator = array_flip($this->dbItems);
		// fetch the items
		while($row=mysql_fetch_assoc($result)) {
			$pk = $row["pk"];
			if ($this->searchResults[$pk]) { continue; } // if already exists then skip
			$this->searchResults[$pk] = $this->arrayFromDB($row, $translator);
			$this->searchResults[$pk]["data_source"] = $data_source;
		}
		mysql_free_result($result);
		return true;
	}

	// this will create and return an array based on a single DB return array
	private function arrayFromDB($a, $aTranslator=array(), $thisArray=array()) {
		if (empty($aTranslator)) { $aTranslator = array_flip($this->dbItems); }
		if (empty($a)) { return $thisArray; }

		foreach ($a as $key=>$value) {
			if($aTranslator[$key]) {
				$thisArray[$aTranslator[$key]] = $value;
			}
		}
		return $thisArray;
	}

/*
 * Special helper fucntion that grabs all info for the PKs in the list and 
 * returns an array (similar to a search but fetches based on a
 * big list of PKs instead of search params)
 * Returns an array of arrays which contain the user data
 * Can specify the items to be returned (e.g. "pk,username" (default pk)
 * Can limit the fetch to only one data_source (e.g. "db")
 */
	public function getInstsByPkList($pkList=array(), $items="pk,username", $data_source="") {
		if (empty($pkList)) { return false; }
		$this->searchResults = array(); // reset array
		$max = 500;

		if (count($pkList) > $max) {
			// split the list into chunks of max size
			$totalItems = array();
			$splitArray = array_chunk($pkList, $max);
			foreach ($splitArray as $partList) {
				$pkSearch = "PKLIST=" . implode(",",$partList);
				$partItems = $this->getInstsBySearch($pkSearch, "", $items, false, $data_source);
				$totalItems = array_combine($totalItems, $partItems);
			}
			$this->searchResults = $totalItems; // store the return in the searchresult for convenience
			return $totalItems;
		} else {
			// do the search
			$pkSearch = "PKLIST=" . implode(",",$pkList);
			return $this->getInstsBySearch($pkSearch, "", $items, false, $data_source);
		}
	}



/*
 * UPDATE and save functions
 */
	public function update($setBlanks=true) {
		global $USE_LDAP;
		
		// update the instituion
		if ($USE_LDAP) {
			$this->updateLDAP(); // update the LDAP entry first if possible
		}
		if ($this->updateDB()) { // update the DB entry always
			if ($this->name != $this->currentName) {
				// inst name was changed
				return $this->updateUsersInstName();
			}
			return true;
		} else {
			return false;
		}
	}

	private function updateDB($setBlanks=true) {

		// only update the entries that are filled out
		$update_sql = "";
		if ($this->name || $setBlanks) { $update_sql .= " name='".mysql_real_escape_string($this->name)."', "; }
		if ($this->type || $setBlanks) { $update_sql .= " type='".mysql_real_escape_string($this->type)."', "; }
		if ($this->city || $setBlanks) { $update_sql .= " city='".mysql_real_escape_string($this->city)."', "; }
		if ($this->state || $setBlanks) { $update_sql .= " state='".mysql_real_escape_string($this->state)."', "; }
		if ($this->zipcode || $setBlanks) { $update_sql .= " zipcode='".mysql_real_escape_string($this->zipcode)."', "; }
		if ($this->country || $setBlanks) { $update_sql .= " country='".mysql_real_escape_string($this->country)."', "; }
		if ($this->rep_pk || $setBlanks) { $update_sql .= " rep_pk='".mysql_real_escape_string($this->rep_pk)."', "; }
		if ($this->repvote_pk || $setBlanks) { $update_sql .= " repvote_pk='".mysql_real_escape_string($this->repvote_pk)."', "; }
		$sql .= "UPDATE institution set $update_sql date_modified=NOW() where pk='$this->pk'";

		if ($update_sql) {
			$result = mysql_query($sql);
			if (!$result) {
				$this->Message = "Inst: updateDB query failed ($sql): " . mysql_error();
				return false;
			}

			if ($this->name != $this->currentName) {
				// inst name was changed
				return $this->updateUsersInstName();
			}
		} else {
			return false; // nothing to update
		}
		return true;
	}

	private function updateLDAP($setBlanks=true) {
		global $LDAP_SERVER, $LDAP_PORT, $LDAP_ADMIN_DN, $LDAP_ADMIN_PW, $TOOL_SHORT;
		// write the values to LDAP
		if (ldapConnect()) {
			// bind with appropriate dn to give update access
			$admin_bind=ldap_bind(getDS(), $LDAP_ADMIN_DN, $LDAP_ADMIN_PW);
			if ($admin_bind) {

				// prepare data array
				$info = array();
				$info["o"]=$this->name;
				$info["insttype"]=$this->type;
				$info["l"]=$this->city;
				$info["st"]=$this->state;
				$info["postalcode"]=$this->zipcode;
				$info["c"]=$this->country;
				$info["repuid"]=$this->rep_pk;
				$info["voteuid"]=$this->repvote_pk;

				if ($setBlanks) {
					// empty items must be set to a blank array
					foreach ($info as $key => $value) if (empty($info[$key])) $info[$key] = array();
				} else {
					// empty items must be removed
					foreach ($info as $key => $value) if (empty($info[$key])) unset($info[$key]);
					if (empty($info)) {
						return false; // no items to update
					}
				}

				// DN FORMAT: iid=#,ou=institutions,dc=sakaiproject,dc=org
				$item_dn = "iid=$this->pk,ou=institutions,dc=sakaiproject,dc=org";
				$ldap_result=ldap_modify(getDS(), $item_dn, $info);
				if ($ldap_result) {
					$this->Message = "Updated ldap inst information";
					writeLog($TOOL_SHORT,$this->username,"inst modified (ldap): " .
							"$this->name ($this->type) [$this->pk]" );
					return true;
				} else {
					$this->Message = "Failed to modify inst in LDAP (".ldap_error(getDS()).":".ldap_errno(getDS()).")";
				}
				
			} else {
				$this->Message = "Critical ERROR: Admin bind failed";
			}
			
			return false;
		}
		return false;
	}

/*
 * This is a special function to keep the institution name up to date
 * when it gets changed since it is stored in the ldap user as well
 * as in the ldap institution
 */
	private function updateUsersInstName() {

		// first get the list of users with the currentName as institution
		$opUser = new User();
		$userList = $opUser->getUsersBySearch("institution=".$this->currentName, "", "pk");
		//echo "Found ".count($userList)." users matching inst named: ".$this->currentName."<br/>";

		// loop through the list and update each user
		$this->Message = "";
		$errors = 0;
		foreach($userList as $user) {
			$opUser->pk = $user['pk'];
			// only update the institution name
			$opUser->institution = $this->name;
			if(!$opUser->update(false)) {
				$this->Message .= "Failed to update institution to ".
					$this->name." for user (".$user['pk'].") \n";
				$errors++;
			}
		}
		if ($errors > 0) {
			$this->Message .= "$errors errors occurred updating ".count($userList)." users inst names";
			echo $this->Message."<br/>";
			return false;
		}
		return true;
	}


/*
 * DELETE functions
 */
	public function delete() {
		global $USE_LDAP;

		if ($this->pk == 1) {
			$this->Message = "Invalid pk ($this->pk): The Other inst cannot be deleted";
			return false;
		}
		
		// create the instituion
		if ($USE_LDAP) {
			$this->deleteLDAP(); // delete the LDAP entry first if possible
		}
		return $this->deleteDB(); // delete the DB entry always
	}

	private function deleteDB() {

		$sql = "DELETE from institution where pk='$this->pk'";
		$result = mysql_query($sql);
		if (!$result) {
			$this->Message = "Remove query failed ($sql): " . mysql_error();
			return false;
		}
		return true;
	}

	private function deleteLDAP() {
		global $LDAP_ADMIN_DN, $LDAP_ADMIN_PW, $TOOL_SHORT;
		// write the values to LDAP
		if (ldapConnect()) {
			// bind with appropriate dn to give update access
			$admin_bind=ldap_bind(getDS(), $LDAP_ADMIN_DN, $LDAP_ADMIN_PW);
			if ($admin_bind) {
				$item_dn = "iid=$this->pk,ou=institutions,dc=sakaiproject,dc=org";
				$delresult = ldap_delete(getDS(),$item_dn);
				if ($delresult) {
					$this->Message = "Removed ldap institution: $item_dn";
					return true;
				} else {
					$this->Message = "Failed to remove ldap inst: $item_dn";
				}
			} else {
				$this->Message = "Critical ERROR: Admin bind failed";
			}
			return false;
		}
		return false;
	}



/*
 * These functions allow us to populate the object from
 * the database query results or from the LDAP query results
 */
	public function updateFromArray($objArray) {
		if (!$objArray || empty($objArray)) {
			$this->Message = "Cannot updateFromArray (inst), objArray empty";
			return false;
		}

		if (!$objArray['data_source']) {
			$this->data_source = "unknown";
		} else {
			$this->data_source = $objArray['data_source'];
		}
		$this->pk = $objArray['pk'];
		$this->name = $objArray['name'];
		// use the currentName to hold the last fetched name so we can 
		// tell if the name was updated
		if(!$this->currentName) {
			$this->currentName = $objArray['name'];
		}
		$this->type = $objArray['type'];
		$this->city = $objArray['city'];
		$this->state = $objArray['state'];
		$this->zipcode = $objArray['zipcode'];
		$this->country = $objArray['country'];
		$this->rep_pk = $objArray['rep_pk'];
		$this->repvote_pk = $objArray['repvote_pk'];
		return true;
	}


/*
 * Generate the options for a pulldown list of institutions
 * setting the institution will select the institution with that pk
 * setting short to true will truncate the institution names
 * setting an ignore value will cause the list skip that item
 */
	public function generate_partner_dropdown($institution="", $short=false, $ignore="") {
		$output = "";

		$items = $this->getInstsBySearch("*", "name", "pk,name");
	    foreach ($items as $item) {
	    	$selected="";
			if ($ignore == $item['pk']) { continue; } // skip the ignore item
		    if ( $institution && $institution == $item['pk'] ) {
		    	$selected=" selected='y'";
		    }
		    $instName = $item['name'];
		    if ($short && (strlen($instName) > 38) ) {
				$instName = substr($instName,0,35) . "...";
		    }
			$output .= "<option title='$item[name]' value='$item[pk]' $selected>$instName</option>\n";
		}
	 	return $output;
	}
}
?>