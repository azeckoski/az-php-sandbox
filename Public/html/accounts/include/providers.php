<?php
/* file: providers.php
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
 * and will only attempt to write data locally if the LDAP is inaccessible. The
 * advantage of this is that local development can be done easily by simply
 * changing USE_LDAP to false. There are some disadvantages though (like having to
 * fetch the data from the ldap which is slower than the database) so there is
 * a caching mechanism built in. The cache timer can be controlled below.
 */
$CACHE_EXPIRE_USERS = 0; // minutes before cache will force a refresh
$CACHE_EXPIRE_INSTS = 120; // minutes before cache will force a refresh
$TOOL_SHORT = "provider";

/*
 * LDAP variables
 * These are stored here since the rest of the system should not need to
 * have any concept of LDAP, it should only understand the concept of a
 * user or an institution
 */
//$LDAP_SERVER = "reynolds.cc.vt.edu"; // test server 1
$LDAP_SERVER = "bluelaser.cc.vt.edu"; // prod server 1
$LDAPS_SERVER = "ldaps://bluelaser.cc.vt.edu"; // SSL prod server 1
$LDAP_PORT = "389";
$LDAP_ADMIN_DN = "cn=Manager,dc=sakaiproject,dc=org";
$LDAP_ADMIN_PW = "ldapadmin";
$LDAP_READ_DN = "uid=!readonly,ou=users,dc=sakaiproject,dc=org";
$LDAP_READ_PW = "ironchef";
// TODO - make the passwords more secure


/*
 * Provides the methods needed to create, read, update and delete users
 * requires a caching table called users_cache (see new_db.sql)
 */
class User {

   // member declaration
   public $pk = 0;
   public $username;
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
	public $isRep = false;
	public $isVoteRep = false;

	public $active = false;
	public $Message = "";

	private $data_source = "ldap";
	private $password;
	private $authentic = false;
	private $searchResults = array();

	// constructor
	function __construct($userid=-1) {
		// constructor will create a user based on username or userpk if possible
		if ($userid == -1) { return true; } // created an empty user object

		if (is_numeric($userid)) {
			// numeric so this is a userpk (at least I hope it is)
			return $this->getUserByPk($userid);
		} else {
			// this must be a username
			return $this->getUserByUsername($userid);
		}
	}


	function __toString() {
		return $this->toString();
	}

	function toString() {
		// return the entire object as a string
		$output = "pk:". $this->pk . ", " .
			"username:". $this->username . ", " .
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
		$output .= ", activated:";
		$output .= ($this->active)?"Y":"N";
		$output .= ", authentic:";
		$output .= ($this->authentic)?"Y":"N";
		$output .= ", sakaiPerm{".implode(":",$this->sakaiPerm)."}";
		return $output;
	}

	function toArray() {
		// return the entire object as an assoc array
		$output = array();
		$output['pk'] = $this->pk;
		$output['username'] = $this->username;
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
		$output['authentic'] = $this->authentic;
		$output['activated'] = $this->active;
		foreach($this->sakaiPerm as $value) {
			$output[$value] = $value;
		}
		return $output;
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

	// simple getter for authentic check
	public function getAuthentic() {
		return $this->authentic;
	}


/*
 * PERMISSIONS handling
 * works with permissions in the object, does not persist them
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
		ksort($this->sakaiPerm[$permString]); // keep perms in alpha order
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

	public function setRep($setting) {
		// TODO - make this do something
		return false;
	}

	public function setVoteRep($setting) {
		// TODO - make this do something
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
	public function create() {
		global $USE_LDAP;
		
		// create the user in the appropriate location
		if ($this->data_source == "ldap" && $USE_LDAP) {
			return $this->createLDAP();
		} else if ($this->data_source == "db") {
			return $this->createDB();
		} else {
			$this->Message = "Invalid data_source: $this->data_source, could not create";
			return false;
		}
	}

	private function createDB() {
		// check to see if the user already exists
		$checksql = "SELECT pk from users where pk='$this->pk' or " .
			"username='$this->username' or email='$this->email'";
		$checkresult = mysql_query($checksql) or die("Check query failed ($checksql): " . mysql_error());
		if (mysql_num_rows($checkresult) == 0) {
			// write the new values to the DB
			$sql = "INSERT INTO users (username,password,firstname,lastname,email," .
					"primaryRole,secondaryRole,institution_pk,date_created," .
					"address,city,state,zipcode,country,phone,fax,otherInst) values " .
					"('$this->username',PASSWORD('$this->password'),'$this->firstname'," .
					"'$this->lastname','$this->email','$this->primaryRole','$this->secondaryRole'," .
					"'$this->institution_pk',NOW(),'$this->address','$this->city'," .
					"'$this->state','$this->zipcode','$this->country','$this->phone'," .
					"'$this->fax','$this->institution')";

			$result = mysql_query($sql);
			if (!$result) {
				$this->Message = "Insert query failed ($sql): " . mysql_error();
				return false;
			}
			$this->pk = mysql_insert_id();
			return true;
		} else {
			$this->pk = $checkresult['pk'];
			return $this->updateDB();
		}
	}

	private function createLDAP() {
		global $LDAP_SERVER, $LDAP_PORT, $LDAP_ADMIN_DN, $LDAP_ADMIN_PW, $TOOL_SHORT;

		// write the values to LDAP
		$ds=ldap_connect($LDAP_SERVER,$LDAP_PORT) or die ("CRITICAL LDAP CONNECTION FAILURE");
		if ($ds) {
			ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3) or die("Failed to set LDAP Protocol version to 3"); 
			// bind with appropriate dn to give update access
			$admin_bind=ldap_bind($ds, $LDAP_ADMIN_DN, $LDAP_ADMIN_PW);
			if ($admin_bind) {

				// first check to see if this user exists already
				$existsSearch = "(|(uid=$this->pk)(sakaiUser=$this->username)(mail=$this->email))";
				$sr=ldap_search($ds, "ou=users,dc=sakaiproject,dc=org", $existsSearch, array("uid"));
				$exists = ldap_get_entries($ds, $sr);
				if($exists['count'] > 0) {
					// entry already exists
					$this->pk = $exists[0]['uid'][0];
					return $this->updateLDAP();
				}
				ldap_free_result($sr);


				// prepare data array
				$info = array();
				$info["cn"]="$this->firstname $this->lastname";
				$info["givenname"]=$this->firstname;
				$info["sn"]=$this->lastname;
				$info["sakaiuser"]=$this->username;
				$info["mail"]=$this->email;
				$info["iid"]="$this->institution_pk";
				$info["primaryrole"]=$this->primaryRole;
				$info["secondaryrole"]=$this->secondaryRole;
				$info["postaladdress"]=$this->address;
				$info["l"]=$this->city;
				$info["st"]=$this->state;
				$info["postalcode"]=$this->zipcode;
				$info["c"]=$this->country;
				$info["telephonenumber"]=$this->phone;
				$info["facsimiletelephonenumber"]=$this->fax;
					
				// get the institution name for this $INSTITUTION_PK
				$sr=ldap_search($ds, "ou=institutions,dc=sakaiproject,dc=org", "iid=$institution_pk", array("o"));
				$item = ldap_get_entries($ds, $sr);
				if ($item["count"]) {
					$info["o"]=$item[0]["o"][0];
				}

				// only set password if it is not blank
				if (strlen($this->password) > 0) {
					$info["userpassword"]=$this->password;
				}

				$permissions = array();
				foreach($this->sakaiPerm as $value) {
					$permissions[] = $value;
				}
				$info["sakaiperm"]=$permissions;

				// empty items must be set to a blank array
				foreach ($info as $key => $value) if (empty($info[$key])) $info[$key] = array();

				//prepare user dn, find next available uid
				$sr=ldap_search($ds, "ou=users,dc=sakaiproject,dc=org", "uid=*", array("uid"));
				ldap_sort($ds, $sr, 'uid');
				$uidinfo = ldap_get_entries($ds, $sr);
				$lastnum = $uidinfo["count"] - 1;
				$uid = $uidinfo[$lastnum]["uid"][0] + 1;
				ldap_free_result($sr);

				// DN FORMAT: uid=#,ou=users,dc=sakaiproject,dc=org
				$user_dn = "uid=$uid,ou=users,dc=sakaiproject,dc=org";
				//print "uid: $uid; user_dn='$user_dn'<br/>";

				$info["objectClass"][0]="top";
				$info["objectClass"][1]="person";
				$info["objectClass"][2]="organizationalPerson";
				$info["objectClass"][3]="inetOrgPerson";
				$info["objectClass"][4]="sakaiAccount";
				$info["uid"]=$uid;

				// insert the user into ldap
				$ldap_result=ldap_add($ds, $user_dn, $info);
				if ($ldap_result) {
					$Message = "Added new ldap user";
					$this->pk = $uid;
					writeLog($TOOL_SHORT,$this->username,"user added (ldap): " .
							"$this->firstname $this->lastname ($this->email) [$this->pk]" );
					ldap_close($ds);
					return true;
				} else {
					$this->Message = "Failed to add user to LDAP (".ldap_error($ds).":".ldap_errno($ds).")";
				}
			} else {
				$this->Message = "Critical ERROR: Admin bind failed";
			}
			ldap_close($ds);
			return false;
		} else {
			$this->Message = "ERROR: Unable to connect to LDAP server";
			return false;
		}
	}

	private function createCache() {
		// check to see if the cache already exists for this user
		if(!$this->pk || $this->pk < 1) {
			$this->Message = "Cannot cache user object, pk not set or invalid ($this->pk)";
			return false;
		}
		$checksql = "SELECT pk from users_cache where users_pk='$this->pk'";
		$checkresult = mysql_query($checksql) or die("Check query failed ($checksql): " . mysql_error());
		if (mysql_num_rows($checkresult) == 0) {
			// write the new values to the Cache
			$sql = "INSERT INTO users_cache (users_pk,username,firstname," .
					"lastname,email,primaryRole,secondaryRole," .
					"institution_pk,date_created,address,city," .
					"state,zipcode,country,phone," .
					"fax,institution) values " .
					"('$this->pk','$this->username','$this->firstname'," .
					"'$this->lastname','$this->email','$this->primaryRole','$this->secondaryRole'," .
					"'$this->institution_pk',NOW(),'$this->address','$this->city'," .
					"'$this->state','$this->zipcode','$this->country','$this->phone'," .
					"'$this->fax','$this->institution')";
	
			$result = mysql_query($sql);
			if (!$result) {
				$this->Message = "Insert query failed ($sql): " . mysql_error();
				return false;
			}
			return true;
		} else {
			return $this->updateCache();
		}
	}



	// READ functions
	// User fetchers will try to get the user data in the fastest
	// and most reliable way possible

/*
 * get the User data by PK
 */
	public function getUserByPk($pk) {
		global $USE_LDAP;

		if($this->getUserFromCache("pk",$pk)) {
			return true;
		}
		if ($USE_LDAP) {
			if($this->getUserFromLDAP("pk",$pk)) {
				return true;
			}
		}
		return $this->getUserFromDB("pk",$pk);
	}


/*
 * get the User data by username
 */
	public function getUserByUsername($username) {
		// this has to get the user pk from the username
		global $USE_LDAP;

		if($this->getUserFromCache("username",$username)) {
			return true;
		}
		if ($USE_LDAP) {
			if($this->getUserFromLDAP("username",$username)) {
				return true;
			}
		}
		return $this->getUserFromDB("username",$username);
	}

	
/*
 * get the User data by email
 */
	public function getUserByEmail($useremail) {
		// this has to get the user pk from the email
		global $USE_LDAP;

		if($this->getUserFromCache("email",$useremail)) {
			return true;
		}
		if ($USE_LDAP) {
			if($this->getUserFromLDAP("email",$useremail)) {
				return true;
			}
		}
		return $this->getUserFromDB("email",$useremail);
	}

	
/*
 * Fetch the user data from varying sources based on params
 * id is the type (e.g. pk), value is the value (e.g. 1)
 */
	private function getUserFromCache($id, $value) {
		global $CACHE_EXPIRE_USERS;
		
		$search = "";
		switch ($id) {
			case "pk": $search = "users_pk = '$value'"; break;
			case "email": $search = "email = '$value'"; break;
			case "username": $search = "username = '$value'"; break;
			default: $this->Message="Invalid getUserFromCache id: $id, $value"; return false;
		}

		// grab the data from cache if it is fresh enough
		$sql = "select * from users_cache where $search and " .
			"now() < date_modified+INTERVAL $CACHE_EXPIRE_USERS MINUTE";
		$result = mysql_query($sql);
		if (!$result) {
			$this->Message = "User fetch query failed ($sql): " . mysql_error();
			return false;
		}
		$USER = mysql_fetch_assoc($result);
		if (!$USER) { return false; }
		$this->updateFromDBArray($USER);
		return true;
	}

	private function getUserFromLDAP($id, $value) {
		global $LDAP_SERVER, $LDAP_PORT, $LDAP_READ_DN, $LDAP_READ_PW, $TOOL_SHORT;

		$search = "";
		switch ($id) {
			case "pk": $search = "uid=$value"; break;
			case "email": $search = "mail=$value"; break;
			case "username": $search = "sakaiUser=$value"; break;
			default: $this->Message="Invalid getUserFromLDAP id: $id, $value"; return false;
		}

		$ds=ldap_connect($LDAP_SERVER,$LDAP_PORT) or die ("CRITICAL LDAP CONNECTION FAILURE");
		if ($ds) {
			ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3) or die("Failed to set LDAP Protocol version to 3"); 
			// bind with appropriate dn to give readonly access
			$read_bind=ldap_bind($ds, $LDAP_READ_DN, $LDAP_READ_PW); // do bind as read user
			if ($read_bind) {
				//the attribs will let us limit the return if we want
				//$attribs = array("cn","givenname","sn","uid","sakaiuser","mail","dn","iid","o","sakaiperm");
			   	//$sr=ldap_search($ds, "ou=users,dc=sakaiproject,dc=org", $search, $attribs);
				$sr=ldap_search($ds, "ou=users,dc=sakaiproject,dc=org", $search);
				$info = ldap_get_entries($ds, $sr);
				if($info['count'] == 0) {
					$this->Message = "No matching ldap item for $search";
					return false;
				}
				$this->updateFromLDAPArray($info);
				$this->data_source = "ldap";
				$this->createCache();
				return true;
			} else {
				$this->Message ="ERROR: Read bind to ldap failed";
			}
			ldap_close($ds); // close connection
			return false;
		} else {
		   $this->Message = "CRITICAL Error: Unable to connect to LDAP server";
		   return false;
		}
	}

	private function getUserFromDB($id, $value) {
		$search = "";
		switch ($id) {
			case "pk": $search = "users_pk = '$value'"; break;
			case "email": $search = "email = '$value'"; break;
			case "username": $search = "username = '$value'"; break;
			default: $this->Message="Invalid getUserFromDB id: $id, $value"; return false;
		}

		$sql = "select * from users where $search";
		$result = mysql_query($sql);
		if (!$result) {
			$this->Message = "User fetch query failed ($sql): " . mysql_error();
			return false;
		}
		$USER = mysql_fetch_assoc($result);
		if (!$USER) { return false; }
		$this->updateFromDBArray($USER);
		$this->data_source = "db";
		return true;
	}


/*
 * get a set of User PKs by search params
 * Can limit searching to only one data_source
 */
	public function getUsersBySearch($search, $limit="") {
		// this has to get the users based on a search
		global $USE_LDAP;

		$this->searchResults = array(); // reset array
		
		// have to search both the LDAP and the DB unless limited
		if ($USE_LDAP && ($limit=="" || $limit=="ldap") ) {
			$this->getSearchFromLDAP($search);
		}
		if ($limit=="" || $limit=="db") {
			$this->getSearchFromDB($search);
		}
		
		if (empty($this->searchResults)) {
			return false;
		}
		return true;
	}

	private function getSearchFromLDAP($search) {
		global $LDAP_SERVER, $LDAP_PORT, $LDAP_READ_DN, $LDAP_READ_PW, $TOOL_SHORT;

		$ds=ldap_connect($LDAP_SERVER,$LDAP_PORT) or die ("CRITICAL LDAP CONNECTION FAILURE");
		if ($ds) {
			ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3) or die("Failed to set LDAP Protocol version to 3"); 
			// bind with appropriate dn to give readonly access
			$read_bind=ldap_bind($ds, $LDAP_READ_DN, $LDAP_READ_PW); // do bind as read user
			if ($read_bind) {
				//the attribs will let us limit the return if we want
				//$attribs = array("cn","uid","sakaiuser","mail","iid","o","sakaiperm");
				$filter = "(|(sakaiUser=$this->username)(mail=$this->email)" .
					"(cn=$this->firstname $this->lastname)(o=$this->institution))";
				$sr=ldap_search($ds, "ou=users,dc=sakaiproject,dc=org", $filter, array("uid"));
				$info = ldap_get_entries($ds, $sr);
				if($info['count'] == 0) {
					$this->Message = "No matching ldap item for $search";
					return false;
				}
				$this->data_source = "ldap";
				$this->Message = "Search results found (ldap): " . ldap_count_entries($ds, $sr);
				// add the result PKs to the array
				for ($line=0; $line<$info["count"]; $line++) {
					$this->searchResults[] = $info[$line]["uid"][0];
				}
				return true;
			} else {
				$this->Message ="ERROR: Read bind to ldap failed";
			}
			ldap_close($ds); // close connection
			return false;
		} else {
		   $this->Message = "CRITICAL Error: Unable to connect to LDAP server";
		   return false;
		}
	}

	private function getSearchFromDB($search) {
		$search = trim($search,"*"); // cleanup the ldap search chars
		$sql = "select pk from users U1 where (U1.username like '%$search%' or " .
			"U1.firstname like '%$search%' or U1.lastname like '%$search%' or " .
			"U1.email like '%$search%' or U1.otherInst like '%$search%')";
		$result = mysql_query($sql);
		if (!$result) {
			$this->Message = "User search query failed ($sql): " . mysql_error();
			return false;
		}
		$this->data_source = "db";
		$this->Message = "Search results found (db): " . mysql_num_rows($result);
		// add the result PKs to the array
		while($row=mysql_fetch_assoc($result)) {
			$this->searchResults[] = $row["pk"];
		}
		return true;
	}

/*
 * Special helper that grabs all info for the PKs in the searchResults array
 * and dumps it into an array of associative arrays
 */
	public function getInfoForSearch() {
		// TODO - implement this helper and see if it is useful
	}

/*
 * UPDATE and save functions
 */
	public function update() {
		global $USE_LDAP;
		
		// save the user to the appropriate location
		if ($this->data_source == "ldap" && $USE_LDAP) {
			return $this->updateLDAP();
		} else if ($this->data_source == "db") {
			return $this->updateDB();
		} else {
			$this->Message = "Invalid data_source: $this->data_source, could not save";
			return false;
		}
	}

	private function updateDB() {
		$passChange = "";
		if ($this->password) {
			$passChange = " password=PASSWORD('$this->password'), ";
		}

		// handle the other institution stuff in a special way
		$otherInstSql = " otherInst=NULL, ";
		if ($this->institution_pk == 1) {
			// assume someone is using the other institution, Other MUST be pk=1
			$otherInstSql = " otherInst='$institution', ";
		}

		$permString = implode(":",$this->sakaiPerm); // convert the array of perms into a string
		$sql = "UPDATE users set username='$this->username', email='$this->email', " . $passChange .
			"firstname='$this->firstname', lastname='$this->lastname', " . $otherInstSql .
			"primaryRole='$this->primaryRole', secondaryRole='$this->secondaryRole'," .
			"institution_pk='$this->institution_pk', address='$this->address', " .
			"city='$this->city', state='$this->state', zipcode='$this->zipcode', " .
			"country='$this->country', phone='$this->phone', " .
			"fax='$this->fax', sakaiPerms='$permString' where pk='$this->pk'";

		$result = mysql_query($sql);
		if (!$result) {
			$this->Message = "Update query failed ($sql): " . mysql_error();
			return false;
		}
		return true;
	}

	private function updateLDAP() {
		global $LDAP_SERVER, $LDAP_PORT, $LDAP_ADMIN_DN, $LDAP_ADMIN_PW, $TOOL_SHORT;
		// write the values to LDAP
		$ds=ldap_connect($LDAP_SERVER,$LDAP_PORT) or die ("CRITICAL LDAP CONNECTION FAILURE");
		if ($ds) {
			ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3) or die("Failed to set LDAP Protocol version to 3"); 
			// bind with appropriate dn to give update access
			$admin_bind=ldap_bind($ds, $LDAP_ADMIN_DN, $LDAP_ADMIN_PW);
			if ($admin_bind) {

				// prepare data array
				$info = array();
				$info["cn"]="$this->firstname $this->lastname";
				$info["givenname"]=$this->firstname;
				$info["sn"]=$this->lastname;
				$info["sakaiuser"]=$this->username;
				$info["mail"]=$this->email;
				$info["iid"]="$this->institution_pk";
				$info["primaryrole"]=$this->primaryRole;
				$info["secondaryrole"]=$this->secondaryRole;
				$info["postaladdress"]=$this->address;
				$info["l"]=$this->city;
				$info["st"]=$this->state;
				$info["postalcode"]=$this->zipcode;
				$info["c"]=$this->country;
				$info["telephonenumber"]=$this->phone;
				$info["facsimiletelephonenumber"]=$this->fax;
					
				// get the institution name for this $INSTITUTION_PK
				$sr=ldap_search($ds, "ou=institutions,dc=sakaiproject,dc=org", "iid=$institution_pk", array("o"));
				$item = ldap_get_entries($ds, $sr);
				if ($item["count"]) {
					$info["o"]=$item[0]["o"][0];
				}

				// only set password if it is not blank
				if (strlen($this->password) > 0) {
					$info["userpassword"]=$this->password;
				}

				if (isset($this->sakaiPerm)) {
					$info["sakaiperm"] = array_values($this->sakaiPerm);
				}

				// empty items must be set to a blank array
				foreach ($info as $key => $value) if (empty($info[$key])) $info[$key] = array();

				$user_dn = "uid=$this->pk,ou=users,dc=sakaiproject,dc=org";
				$ldap_result=ldap_modify($ds, $user_dn, $info);
				if ($ldap_result) {
					$this->Message = "Updated ldap user information";
					writeLog($TOOL_SHORT,$this->username,"user modified (ldap): " .
							"$this->firstname $this->lastname ($this->email) [$this->pk]" );
					ldap_close($ds);
					return true;
				} else {
					$this->Message = "Failed to modify user in LDAP (".ldap_error($ds).":".ldap_errno($ds).")";
				}
				
			} else {
				$this->Message = "Critical ERROR: Admin bind failed";
			}
			ldap_close($ds);
			return false;
		} else {
			$this->Message = "ERROR: Unable to connect to LDAP server";
			return false;
		}
	}

	private function updateCache() {
		$permString = implode(":",$this->sakaiPerm); // convert the array of perms into a string
		$sql = "UPDATE users_cache set username='$this->username', email='$this->email', " .
			"firstname='$this->firstname', lastname='$this->lastname', " .
			"primaryRole='$this->primaryRole', secondaryRole='$this->secondaryRole'," .
			"institution='$this->institution', institution_pk='$this->institution_pk', " .
			"address='$this->address', city='$this->city', state='$this->state', " .
			"zipcode='$this->zipcode', country='$this->country', phone='$this->phone', " .
			"fax='$this->fax', sakaiPerms='$permString', date_modified=NOW() " .
			"where users_pk='$this->pk'";

		$result = mysql_query($sql);
		if (!$result) {
			$this->Message = "Update cache query failed ($sql): " . mysql_error();
			return false;
		}
		return true;
	}



/*
 * DELETE functions
 */
	public function delete() {
		global $USE_LDAP;
		
		// delete the user from the appropriate location
		if ($this->data_source == "ldap" && $USE_LDAP) {
			return $this->deleteLDAP();
		} else if ($this->data_source == "db") {
			return $this->deleteDB();
		} else {
			$this->Message = "Invalid data_source: $this->data_source, could not save";
			return false;
		}
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
		global $LDAP_SERVER, $LDAP_PORT, $LDAP_ADMIN_DN, $LDAP_ADMIN_PW, $TOOL_SHORT;
		// write the values to LDAP
		$ds=ldap_connect($LDAP_SERVER,$LDAP_PORT) or die ("CRITICAL LDAP CONNECTION FAILURE");
		if ($ds) {
			ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3) or die("Failed to set LDAP Protocol version to 3"); 
			// bind with appropriate dn to give update access
			$admin_bind=ldap_bind($ds, $LDAP_ADMIN_DN, $LDAP_ADMIN_PW);
			if ($admin_bind) {
				$user_dn = "uid=$this->pk,ou=users,dc=sakaiproject,dc=org";
				$delresult = ldap_delete($ds,$user_dn);
				if ($delresult) {
					$this->Message = "Removed ldap user: $user_dn";
					$this->deleteCache(); // also clear the cache
					return true;
				} else {
					$this->Message = "Failed to remove ldap user: $user_dn";
					return false;
				}
			} else {
				$this->Message = "Critical ERROR: Admin bind failed";
				return false;
			}
			ldap_close($ds);
		} else {
			$this->Message = "ERROR: Unable to connect to LDAP server";
			return false;
		}
	}

	private function deleteCache() {

		$sql = "DELETE from users_cache where users_pk='$this->pk'";
		$result = mysql_query($sql);
		if (!$result) {
			$this->Message = "Remove cache query failed ($sql): " . mysql_error();
			return false;
		}
		return true;
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
		
		$this->username = $username;
		$this->password = $password;
		
		// attempt LDAP authenticate first
		if ($USE_LDAP) {
			if($this->authenticateUserFromLDAP($username,$password)) {
				$this->createCache();
				return true;
			}
		}

		// attempt DB authentication as a fallback
		if($this->authenticateUserFromDB($username,$password)) {
			return true;
		}

		$this->authentic = false;
		return false;
	}

	private function authenticateUserFromLDAP($username,$password) {
		global $LDAP_SERVER, $LDAP_PORT, $TOOL_SHORT;
		
		$ds=ldap_connect($LDAP_SERVER,$LDAP_PORT) or die ("CRITICAL LDAP CONNECTION FAILURE");
		//$ds=ldap_connect("ldaps://bluelaser.cc.vt.edu/") or die ("CRITICAL LDAP CONNECTION FAILURE");
		if ($ds) {
			ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3) or die("Failed to set LDAP Protocol version to 3"); 
			$anon_bind=ldap_bind($ds); // do an anonymous ldap bind, expect ranon=1
			if ($anon_bind) {
				// Searching for (sakaiUser=username)
			   	$sr=ldap_search($ds, "ou=users,dc=sakaiproject,dc=org", "sakaiUser=$username"); // expect sr=array
		
				//echo "Number of entries = " . ldap_count_entries($ds, $sr) . "<br />";
				$info = ldap_get_entries($ds, $sr); // $info["count"] = items returned
				
				// annonymous call to sakai ldap will only return the dn
				$user_dn = $info[0]["dn"];

				// set up for TLS encrypted connection
				//ldap_start_tls($ds) or die("Ldap_start_tls failed"); 

   				// now attempt to bind as the userdn and password
				$auth_bind=@ldap_bind($ds, $user_dn, $password);
				if ($auth_bind) {
					// valid bind, user is authentic
					writeLog($TOOL_SHORT,$username,"user logged in (ldap):" . $_SERVER["REMOTE_ADDR"].":".$_SERVER["HTTP_REFERER"]);

					// get the user info for this user
					$sr=ldap_search($ds, $user_dn, "sakaiUser=$username");
					$info = ldap_get_entries($ds, $sr);
					$this->updateFromLDAPArray($info);
					if ($this->active) {
						$this->authentic = true;
					}
					$this->Message = "Valid LDAP login: $username";
					$this->data_source = "ldap";
					ldap_close($ds);
					return true;
				} else {
					// invalid bind, password is not good
					$this->Message = "Invalid login: $username - password is not good";
				}
			} else {
				$this->Message ="ERROR: Anonymous bind to ldap failed";
			}
			ldap_close($ds); // close connection
			return false;
		} else {
		   $this->Message = "<h4>CRITICAL Error: Unable to connect to LDAP server</h4>";
		   return false;
		}
	}
	
	private function authenticateUserFromDB($username,$password) {
		global $TOOL_SHORT;
		
		// check the username and password
		$sql1 = "SELECT pk FROM users WHERE username = '$username' and " .
			"password = PASSWORD('$password') and activated = '1'";
		$result = mysql_query($sql1) or die('Query failed: ' . mysql_error());
		$count = mysql_num_rows($result);
		$row = mysql_fetch_assoc($result);
	
		if( !empty($result) && ($count == 1)) {
			// valid login
			$this->Message = "Valid login: $username";
			$USER_PK = $row["pk"];

			//print ("Internal Auth Suceeded");
			writeLog($TOOL_SHORT,$username,"user logged in (internal):" . $_SERVER["REMOTE_ADDR"].":".$_SERVER["HTTP_REFERER"]);

			$sqlusers = "select * from users where pk = '$USER_PK'";
			$result = mysql_query($sqlusers) or die('User query failed: ' . mysql_error());
			$USER = mysql_fetch_assoc($result);
			$this->updateFromDBArray($USER);
			if ($this->active) {
				$this->authentic = true;
			}
			$this->data_source = "db";
			return true;
		}
		$this->Message = "Invalid login: $username not in DB";
		return false;
	}
	
/*
 * These functions allow us to populate the object from
 * the database query results or from the LDAP query results
 */
	public function updateFromArray($userArray) {
		if (!$userArray || empty($userArray)) {
			$this->Message = "Cannot updateFromArray, userArray empty";
			return false;
		}
		return updateFromDBArray($userArray);
	}

	private function updateFromDBArray($USER) {
		if (!$USER || empty($USER)) {
			$this->Message = "Cannot updateFromDBArray, USER empty";
			return false;
		}

		$this->pk = $USER['pk'];
		$this->username = $USER['username'];
		$this->firstname = $USER['firstname'];
		$this->lastname = $USER['lastname'];
		$this->email = $USER['email'];
		$this->institution_pk = $USER['institution_pk'];
		if ($USER['otherInst']) {
			$this->institution = $USER['otherInst'];
		} else {
			$inst = new Institution($this->institution_pk);
			$this->institution = $inst->name;
		}
		$this->address = $USER['address'];
		$this->city = $USER['city'];
		$this->state = $USER['state'];
		$this->zipcode = $USER['zipcode'];
		$this->country = $USER['country'];
		$this->phone = $USER['phone'];
		$this->fax = $USER['fax'];
		$this->primaryRole = $USER['primaryRole'];
		$this->secondaryRole = $USER['secondaryRole'];
		// convert the string of perms to an array
		$permArray = explode(":",$USER['sakaiPerms']);
		if (is_array($permArray)) {
			foreach ($permArray as $value) {
				$this->sakaiPerm[$value] = "$value";
			}
		} else { $this->sakaiPerm = array(); }
		if ($this->sakaiPerm["active"]) { $this->active=true; }
		return true;
	}

	private function updateFromLDAPArray($info) {
		if (!$info || empty($info)) {
			$this->Message = "Cannot updateFromLDAPArray, INFO empty";
			return false;
		}
		
		$this->pk = $info[0]["uid"][0]; // uid is multivalue, we want the first only
		$this->username = $info[0]["sakaiuser"][0];
		$this->firstname = $info[0]["givenname"][0];
		$this->lastname = $info[0]["sn"][0];
		$this->email = $info[0]["mail"][0];
		$this->institution = $info[0]["o"][0];
		$this->institution_pk = $info[0]["iid"][0];
		$this->primaryRole = $info[0]["primaryrole"][0];
		$this->secondaryRole = $info[0]["secondaryrole"][0];
		$this->address = $info[0]["postaladdress"][0];
		$this->city = $info[0]["l"][0];
		$this->state = $info[0]["st"][0];
		$this->zipcode = $info[0]["postalcode"][0];
		$this->country = $info[0]["c"][0];
		$this->phone = $info[0]["telephonenumber"][0];
		$this->fax = $info[0]["facsimiletelephonenumber"][0];
		$this->sakaiPerm = array();
		if (is_array($info[0]["sakaiperm"])) {
			foreach ($info[0]["sakaiperm"] as $key1=>$value1) {
				if ($key1 !== "count") {
					$this->sakaiPerm[$value1] = "$value1";
				}
			}
		}
		if ($this->sakaiPerm["active"]) { $this->active=true; }
		return true;
	}
}

/*
 * Provides the methods needed to create, read, update and delete institutions
 * requires a caching table called insts_cache (see new_db.sql)
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

	private $data_source = "ldap";
	private $searchResults = array();

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


	function __toString() {
		return $this->toString();
	}

	function toString() {
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

	function toArray() {
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
		
		// create the user in the appropriate location
		if ($this->data_source == "ldap" && $USE_LDAP) {
			return $this->createLDAP();
		} else if ($this->data_source == "db") {
			return $this->createDB();
		} else {
			$this->Message = "Invalid data_source: $this->data_source, could not create";
			return false;
		}
	}

	private function createDB() {
		// check to see if the inst already exists
		$checksql = "SELECT pk from institution where pk='$this->pk'";
		$checkresult = mysql_query($checksql) or die("Check query failed ($checksql): " . mysql_error());
		if (mysql_num_rows($checkresult) == 0) {
			// write the new values to the DB
			$sql = "INSERT INTO institution " .
				"(date_created,name,type,city,state,zipcode,country,rep_pk,repvote_pk) values " .
				"(NOW(),'$this->name','$this->type','$this->city','$this->state'," .
				"'$this->zipcode','$this->country','$this->rep_pk','$this->repvote_pk')";
			
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
		global $LDAP_SERVER, $LDAP_PORT, $LDAP_ADMIN_DN, $LDAP_ADMIN_PW, $TOOL_SHORT;
		// write the values to LDAP
		$ds=ldap_connect($LDAP_SERVER,$LDAP_PORT) or die ("CRITICAL LDAP CONNECTION FAILURE");
		if ($ds) {
			ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3) or die("Failed to set LDAP Protocol version to 3"); 
			// bind with appropriate dn to give update access
			$admin_bind=ldap_bind($ds, $LDAP_ADMIN_DN, $LDAP_ADMIN_PW);
			if ($admin_bind) {

				// first check to see if this user exists already
				$existsSearch = "(iid=$this->pk)";
				$sr=ldap_search($ds, "ou=users,dc=sakaiproject,dc=org", $existsSearch, array("iid"));
				$exists = ldap_get_entries($ds, $sr);
				if($exists['count'] > 0) {
					// entry already exists
					$this->pk = $exists[0]['iid'][0];
					$this->updateLDAP();
				}
				ldap_free_result($sr);


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
					
				// empty items must be set to a blank array
				foreach ($info as $key => $value) if (empty($info[$key])) $info[$key] = array();

				//prepare inst dn, find next available iid
				$sr=ldap_search($ds, "ou=institutions,dc=sakaiproject,dc=org", "iid=*", array("iid"));
				ldap_sort($ds, $sr, 'iid');
				$idinfo = ldap_get_entries($ds, $sr);
				$lastnum = $idinfo["count"] - 1;
				$id = $idinfo[$lastnum]["iid"][0] + 1;
				ldap_free_result($sr);

				// DN FORMAT: iid=#,ou=institutions,dc=sakaiproject,dc=org
				$item_dn = "iid=$id,ou=institutions,dc=sakaiproject,dc=org";

				$info["objectClass"][0]="sakaiInst";
				$info["iid"]=$id;

				// insert the item into ldap
				$ldap_result=ldap_add($ds, $item_dn, $info);
				if ($ldap_result) {
					$Message = "Added new ldap institution";
					$this->pk = $id;
					writeLog($TOOL_SHORT,$this->username,"inst added (ldap): " .
							"$this->name ($this->type) [$this->pk]" );
					ldap_close($ds);
					return true;
				} else {
					$this->Message = "Failed to add inst to LDAP (".ldap_error($ds).":".ldap_errno($ds).")";
				}
			} else {
				$this->Message = "Critical ERROR: Admin bind failed";
			}
			ldap_close($ds);
			return false;
		} else {
			$this->Message = "ERROR: Unable to connect to LDAP server";
			return false;
		}
	}

	private function createCache() {
		// check to see if the cache already exists for this user
		if(!$this->pk || $this->pk < 1) {
			$this->Message = "Cannot cache object, pk not set or invalid ($this->pk)";
			return false;
		}
		$checksql = "SELECT pk from insts_cache where insts_pk='$this->pk'";
		$checkresult = mysql_query($checksql) or die("Check query failed ($checksql): " . mysql_error());
		if (mysql_num_rows($checkresult) == 0) {
			// write the new values to the Cache
			$sql = "INSERT INTO insts_cache " .
				"(date_created,insts_pk,name,type,city,state,zipcode,country,rep_pk,repvote_pk) values " .
				"(NOW(),'$this->pk','$this->name','$this->type','$this->city','$this->state'," .
				"'$this->zipcode','$this->country','$this->rep_pk','$this->repvote_pk')";
	
			$result = mysql_query($sql);
			if (!$result) {
				$this->Message = "Insert query failed ($sql): " . mysql_error();
				return false;
			}
			return true;
		} else {
			return $this->updateCache();
		}
	}


/*
 * get the Institution data by PK
 */
	public function getInstByPk($pk) {
		global $USE_LDAP;

		if($this->getInstFromCache("pk",$pk)) {
			return true;
		}
		if ($USE_LDAP) {
			if($this->getInstFromLDAP("pk",$pk)) {
				return true;
			}
		}
		return $this->getInstFromDB("pk",$pk);
	}

/*
 * Fetch the user data from varying sources based on params
 * id is the type (e.g. pk), value is the value (e.g. 1)
 */
	private function getInstFromCache($id, $value) {
		global $CACHE_EXPIRE_INSTS;
		
		$search = "";
		switch ($id) {
			case "pk": $search = "insts_pk = '$value'"; break;
			default: $this->Message="Invalid getInstFromCache id: $id, $value"; return false;
		}

		// grab the data from cache if it is fresh enough
		$sql = "select * from insts_cache where $search and " .
			"now() < date_modified+INTERVAL $CACHE_EXPIRE_INSTS MINUTE";
		$result = mysql_query($sql);
		if (!$result) {
			$this->Message = "Inst fetch query failed ($sql): " . mysql_error();
			return false;
		}
		$ITEM = mysql_fetch_assoc($result);
		if (!$ITEM) { return false; }
		$this->updateFromDBArray($ITEM);
		return true;
	}

	private function getInstFromLDAP($id, $value) {
		global $LDAP_SERVER, $LDAP_PORT, $LDAP_READ_DN, $LDAP_READ_PW, $TOOL_SHORT;

		$search = "";
		switch ($id) {
			case "pk": $search = "iid=$value"; break;
			default: $this->Message="Invalid getInstFromLDAP id: $id, $value"; return false;
		}

		$ds=ldap_connect($LDAP_SERVER,$LDAP_PORT) or die ("CRITICAL LDAP CONNECTION FAILURE");
		if ($ds) {
			ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3) or die("Failed to set LDAP Protocol version to 3"); 
			// bind with appropriate dn to give readonly access
			$read_bind=ldap_bind($ds, $LDAP_READ_DN, $LDAP_READ_PW); // do bind as read user
			if ($read_bind) {
				//the attribs will let us limit the return if we want
				//$attribs = array("cn","givenname","sn","uid","sakaiuser","mail","dn","iid","o","sakaiperm");
			   	//$sr=ldap_search($ds, "ou=users,dc=sakaiproject,dc=org", $search, $attribs);
				$sr=ldap_search($ds, "ou=institutions,dc=sakaiproject,dc=org", $search);
				$info = ldap_get_entries($ds, $sr);
				if($info['count'] == 0) {
					$this->Message = "No matching ldap item for $search";
					return false;
				}
				$this->updateFromLDAPArray($info);
				$this->data_source = "ldap";
				$this->createCache();
				return true;
			} else {
				$this->Message ="ERROR: Read bind to ldap failed";
			}
			ldap_close($ds); // close connection
			return false;
		} else {
		   $this->Message = "CRITICAL Error: Unable to connect to LDAP server";
		   return false;
		}
	}

	private function getInstFromDB($id, $value) {
		$search = "";
		switch ($id) {
			case "pk": $search = "pk = '$value'"; break;
			default: $this->Message="Invalid getInstFromDB id: $id, $value"; return false;
		}

		$sql = "select * from institution where $search";
		$result = mysql_query($sql);
		if (!$result) {
			$this->Message = "Inst fetch query failed ($sql): " . mysql_error();
			return false;
		}
		$ITEM = mysql_fetch_assoc($result);
		if (!$ITEM) { return false; }
		$this->updateFromDBArray($ITEM);
		$this->data_source = "db";
		return true;
	}


/*
 * get a set of Inst PKs by search params
 * Can limit searching to only one data_source
 */
	public function getInstsBySearch($search, $limit="") {
		// this has to get the users based on a search
		global $USE_LDAP;

		$this->searchResults = array(); // reset array
		
		// have to search both the LDAP and the DB unless limited
		if ($USE_LDAP && ($limit=="" || $limit=="ldap") ) {
			$this->getSearchFromLDAP($search);
		}
		if ($limit=="" || $limit=="db") {
			$this->getSearchFromDB($search);
		}
		
		if (empty($this->searchResults)) {
			return false;
		}
		return true;
	}

	private function getSearchFromLDAP($search) {
		global $LDAP_SERVER, $LDAP_PORT, $LDAP_READ_DN, $LDAP_READ_PW, $TOOL_SHORT;

		$ds=ldap_connect($LDAP_SERVER,$LDAP_PORT) or die ("CRITICAL LDAP CONNECTION FAILURE");
		if ($ds) {
			ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3) or die("Failed to set LDAP Protocol version to 3"); 
			// bind with appropriate dn to give readonly access
			$read_bind=ldap_bind($ds, $LDAP_READ_DN, $LDAP_READ_PW); // do bind as read user
			if ($read_bind) {
				//the attribs will let us limit the return if we want
				//$attribs = array("cn","uid","sakaiuser","mail","iid","o","sakaiperm");
				$filter = "(|(o=$this->name)(type=$this->type))";
				$sr=ldap_search($ds, "ou=institutions,dc=sakaiproject,dc=org", $filter, array("iid"));
				$info = ldap_get_entries($ds, $sr);
				if($info['count'] == 0) {
					$this->Message = "No matching ldap item for $search";
					return false;
				}
				$this->data_source = "ldap";
				$this->Message = "Search results found (ldap): " . ldap_count_entries($ds, $sr);
				// add the result PKs to the array
				for ($line=0; $line<$info["count"]; $line++) {
					$this->searchResults[] = $info[$line]["iid"][0];
				}
				return true;
			} else {
				$this->Message ="ERROR: Read bind to ldap failed";
			}
			ldap_close($ds); // close connection
			return false;
		} else {
		   $this->Message = "CRITICAL Error: Unable to connect to LDAP server";
		   return false;
		}
	}

	private function getSearchFromDB($search) {
		$search = trim($search,"*"); // cleanup the ldap search chars
		$sql = "select pk from institution I1 where " .
			"(I1.name like '%$search%' or I1.type like '%$search%')";
		$result = mysql_query($sql);
		if (!$result) {
			$this->Message = "Inst search query failed ($sql): " . mysql_error();
			return false;
		}
		$this->data_source = "db";
		$this->Message = "Search results found (db): " . mysql_num_rows($result);
		// add the result PKs to the array
		while($row=mysql_fetch_assoc($result)) {
			$this->searchResults[] = $row["pk"];
		}
		return true;
	}


/*
 * UPDATE and save functions
 */
	public function update() {
		global $USE_LDAP;
		
		// save the user to the appropriate location
		if ($this->data_source == "ldap" && $USE_LDAP) {
			return $this->updateLDAP();
		} else if ($this->data_source == "db") {
			return $this->updateDB();
		} else {
			$this->Message = "Invalid data_source: $this->data_source, could not save";
			return false;
		}
	}

	private function updateDB() {
		$sql = "UPDATE institution set name='$this->name', type='$this->type', " .
			"city='$this->city', state='$this->state', zipcode='$this->zipcode', " .
			"country='$this->country', rep_pk='$this->rep_pk', repvote_pk='$this->repvote_pk' " .
			"where pk='$this->pk'";

		$result = mysql_query($sql);
		if (!$result) {
			$this->Message = "Update query failed ($sql): " . mysql_error();
			return false;
		}
		return true;
	}

	private function updateLDAP() {
		global $LDAP_SERVER, $LDAP_PORT, $LDAP_ADMIN_DN, $LDAP_ADMIN_PW, $TOOL_SHORT;
		// write the values to LDAP
		$ds=ldap_connect($LDAP_SERVER,$LDAP_PORT) or die ("CRITICAL LDAP CONNECTION FAILURE");
		if ($ds) {
			ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3) or die("Failed to set LDAP Protocol version to 3"); 
			// bind with appropriate dn to give update access
			$admin_bind=ldap_bind($ds, $LDAP_ADMIN_DN, $LDAP_ADMIN_PW);
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

				// empty items must be set to a blank array
				foreach ($info as $key => $value) if (empty($info[$key])) $info[$key] = array();

				// DN FORMAT: iid=#,ou=institutions,dc=sakaiproject,dc=org
				$item_dn = "iid=$this->pk,ou=institutions,dc=sakaiproject,dc=org";
				$ldap_result=ldap_modify($ds, $item_dn, $info);
				if ($ldap_result) {
					$this->Message = "Updated ldap inst information";
					writeLog($TOOL_SHORT,$this->username,"inst modified (ldap): " .
							"$this->name ($this->type) [$this->pk]" );
					ldap_close($ds);
					return true;
				} else {
					$this->Message = "Failed to modify inst in LDAP (".ldap_error($ds).":".ldap_errno($ds).")";
				}
				
			} else {
				$this->Message = "Critical ERROR: Admin bind failed";
			}
			ldap_close($ds);
			return false;
		} else {
			$this->Message = "ERROR: Unable to connect to LDAP server";
			return false;
		}
	}

	private function updateCache() {
		$sql = "UPDATE insts_cache set insts_pk='$this->pk', name='$this->name', type='$this->type', " .
			"city='$this->city', state='$this->state', zipcode='$this->zipcode', " .
			"country='$this->country', rep_pk='$this->rep_pk', repvote_pk='$this->repvote_pk' " .
			"where pk='$this->pk'";

		$result = mysql_query($sql);
		if (!$result) {
			$this->Message = "Update cache query failed ($sql): " . mysql_error();
			return false;
		}
		return true;
	}


/*
 * DELETE functions
 */
	public function delete() {
		global $USE_LDAP;
		
		// delete the user from the appropriate location
		if ($this->data_source == "ldap" && $USE_LDAP) {
			return $this->deleteLDAP();
		} else if ($this->data_source == "db") {
			return $this->deleteDB();
		} else {
			$this->Message = "Invalid data_source: $this->data_source, could not save";
			return false;
		}
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
		global $LDAP_SERVER, $LDAP_PORT, $LDAP_ADMIN_DN, $LDAP_ADMIN_PW, $TOOL_SHORT;
		// write the values to LDAP
		$ds=ldap_connect($LDAP_SERVER,$LDAP_PORT) or die ("CRITICAL LDAP CONNECTION FAILURE");
		if ($ds) {
			ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3) or die("Failed to set LDAP Protocol version to 3"); 
			// bind with appropriate dn to give update access
			$admin_bind=ldap_bind($ds, $LDAP_ADMIN_DN, $LDAP_ADMIN_PW);
			if ($admin_bind) {
				$item_dn = "iid=$this->pk,ou=institutions,dc=sakaiproject,dc=org";
				$delresult = ldap_delete($ds,$item_dn);
				if ($delresult) {
					$this->Message = "Removed ldap institution: $item_dn";
					$this->deleteCache(); // also clear the cache
					return true;
				} else {
					$this->Message = "Failed to remove ldap inst: $item_dn";
					return false;
				}
			} else {
				$this->Message = "Critical ERROR: Admin bind failed";
				return false;
			}
			ldap_close($ds);
		} else {
			$this->Message = "ERROR: Unable to connect to LDAP server";
			return false;
		}
	}

	private function deleteCache() {

		$sql = "DELETE from insts_cache where insts_pk='$this->pk'";
		$result = mysql_query($sql);
		if (!$result) {
			$this->Message = "Remove cache query failed ($sql): " . mysql_error();
			return false;
		}
		return true;
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
		return updateFromDBArray($objArray);
	}

	private function updateFromDBArray($item) {
		if (!$item || empty($item)) {
			$this->Message = "Cannot updateFromDBArray, inst ITEM empty";
			return false;
		}

		$this->pk = $item['pk'];
		$this->name = $item['name'];
		$this->type = $item['type'];
		$this->city = $item['city'];
		$this->state = $item['state'];
		$this->zipcode = $item['zipcode'];
		$this->country = $item['country'];
		$this->rep_pk = $item['rep_pk'];
		$this->repvote_pk = $item['repvote_pk'];
		return true;
	}

	private function updateFromLDAPArray($info) {
		if (!$info || empty($info)) {
			$this->Message = "Cannot updateFromLDAPArray, inst INFO empty";
			return false;
		}

		$this->pk = $info[0]["iid"][0];
		$this->name = $info[0]["o"][0];
		$this->type = $info[0]["insttype"][0];
		$this->city = $info[0]["l"][0];
		$this->state = $info[0]["st"][0];
		$this->zipcode = $info[0]["postalcode"][0];
		$this->country = $info[0]["c"][0];
		$this->rep_pk = $info[0]["repuid"][0];
		$this->repvote_pk = $info[0]["voteuid"][0];
		return true;
	}
}
?>