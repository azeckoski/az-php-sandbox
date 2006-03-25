<?php
/* file: user_provider.php
 * Created on Mar 24, 2006 by @author az
 * Aaron Zeckoski (aaronz@vt.edu) - Virginia Tech (http://www.vt.edu/)
 */
?>
<?php
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

	public $activated = false;
	public $Message = "";

	private $data_source = "ldap";
	private $password;
	private $authentic = false;

	// constructor
	function __construct() {} // empty constructor

	function __toString() {
		return $this->toString();
	}

	function toString() {
		// return the entire object as a string
		$output = "pk:". $this->pk . "," .
			"username:". $this->username . "," .
			"firstname:". $this->firstname . "," .
			"lastname:". $this->lastname . "," .
			"email:". $this->email . "," .
			"institution:". $this->institution . "," .
			"institution_pk:". $this->institution_pk . "," .
			"address:". $this->address . "," .
			"city:". $this->city . "," .
			"state:". $this->state . "," .
			"zipcode:". $this->zipcode . "," .
			"country:". $this->country . "," .
			"phone:". $this->phone . "," .
			"fax:". $this->fax . "," .
			"primaryRole:". $this->primaryRole . "," .
			"secondaryRole:". $this->secondaryRole;
		$output .= ",activated:";
		$output .= ($this->activated)?"Y":"N";
		$output .= ",authentic:";
		$output .= ($this->authentic)?"Y":"N";
		$output .= ",sakaiperm{";
		foreach($this->sakaiPerm as $key=>$value) {
			$output .= "$key:";
		}
		$output .= "}";
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
		$output['activated'] = $this->activated;
		foreach($this->sakaiPerm as $key=>$value) {
			$output[$key] = $value;
		}
		return $output;
	}

	// SETTERS
	// password setter (no getter, password should not be retrieveable)
	public function setPassword($password) {
		$this->password = $password;
	}

	// set all method
	function setAll($pk, $username, $firstname, $lastname, $email, 
			$institution, $institution_pk, $address, $city, $state,
			$zipcode, $country, $phone, $fax, $primaryRole,
			$secondaryRole, $sakaiPerm) {
		// full contructor
		$this->pk = $pk;
		$this->username = $username;
		$this->firstname = $firstname;
		$this->lastname = $lastname;
		$this->email = $email;
		$this->institution = $institution;
		$this->institution_pk = $institution_pk;
		$this->address = $address;
		$this->city = $city;
		$this->state = $state;
		$this->zipcode = $zipcode;
		$this->country = $country;
		$this->phone = $phone;
		$this->fax = $fax;
		$this->primaryRole = $primaryRole;
		$this->secondaryRole = $secondaryRole;
		$this->sakaiPerm = $sakaiPerm;
	}

	// GETTERS
	// simple getter for the data_source
	public function getDataSource() {
		return $this->data_source;
	}

	// simple getter for authentic check
	public function getAuthentic() {
		return $this->authentic;
	}

	// functional method declaration
	public function save() {
		// save the user to the appropriate location
		if ($this->data_source == "ldap") {
			return $this->saveLDAP();
		} else if ($this->data_source == "db") {
			return $this->saveDB();
		} else {
			$this->Message = "Invalid data_source: $this->data_source, could not save";
			return false;
		}
	}

	private function saveDB() {
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

		$sqledit = "UPDATE users set email='$this->email', " . $passChange .
			"firstname='$this->firstname', lastname='$this->lastname', " . $otherInstSql .
			"primaryRole='$this->primaryRole', secondaryRole='$this->secondaryRole'," .
			"institution_pk='$this->institution_pk', address='$this->address', city='$this->city', " .
			"state='$this->state', zipcode='$this->zipcode', country='$this->country', phone='$this->phone', " .
			"fax='$this->fax' where pk='$this->pk'";

		$result = mysql_query($sqledit) or die('Update query failed: ' . mysql_error());
		return true;
	}

	private function saveLDAP() {
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
					$info["userPassword"]=$this->password;
				}

				$permissions = array();
				foreach($this->sakaiPerm as $key=>$value) {
					$permissions[] = $key;
				}
				if (!empty($permissions)) {
					$info["sakaiperm"]=$permissions;
				}

				// have to drop any empty items from the array
				foreach ($info as $key => $value) if (empty($info[$key])) unset($info[$key]);

				$user_dn = "uid=$this->pk,ou=users,dc=sakaiproject,dc=org";
				$ldap_result=ldap_modify($ds, $user_dn, $info);
				if ($ldap_result) {
					$this->Message = "<b>Updated user information</b><br/>";
					writeLog($TOOL_SHORT,$this->username,"user modified (ldap): " .
							"$this->firstname $this->lastname ($this->email) [$this->pk]" );
					return true;
				} else {
					$this->Message = "Failed to modify user in LDAP (".ldap_error($ds).":".ldap_errno($ds).")<br/>";
					return false;
				}
				
			} else {
				$this->Message = "Critical ERROR: Admin bind failed<br/>";
				return false;
			}
			ldap_close($ds);
		} else {
			$this->Message = "ERROR: Unable to connect to LDAP server";
			return false;
		}
	}

	// user fetching functions for use by the outside
	public function getUserByPk($username) {
	}

	public function getUserByUsername($username) {
	}
	
	public function getUserByEmail($username) {
	}
	
	public function getUsersBySearch($username) {
	}
	
	// this is the actual user fetching function
	// it will attempt to get the user from the most
	// reliable and fastest sources
	private function getUserFromPk($pk) {
	}
	
	private function getUserFromDB($pk) {
	}

	private function getUserFromDBCache($pk) {
	}

	private function getUserFromLDAP($pk) {
	}

	// this will attempt to authorize a user based on
	// a username and password from mutliple sources
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
				return true;
			}
		}

		// attempt DB authentication as a fallback
		return $this->authenticateUserFromDB($username,$password);		
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
					$perms = array();
					foreach ($info[0]["sakaiperm"] as $key1=>$value1) {
						if ($key1 !== "count") {
							$perms[$value1] = "Y";
						}
					}
					$this->sakaiPerm = $perms;
					if ($this->sakaiPerm['active']) { $this->activated=true; }

					$this->Message = "Valid LDAP login: $username";
					if ($this->activated) {
						$this->authentic = true;
					}
					$this->data_source = "ldap";
					return true;
				} else {
					// invalid bind, password is not good
					$this->Message = "Invalid login: $username - password is not good";
					return false;
				}
			} else {
				$this->Message ="ERROR: Anonymous bind to ldap failed";
				return false;
			}
			ldap_close($ds); // close connection
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

			$this->pk = $USER['pk'];
			$this->username = $USER['username'];
			$this->firstname = $USER['firstname'];
			$this->lastname = $USER['lastname'];
			$this->email = $USER['email'];
			if ($USER['otherInst']) {
				$this->institution = $USER['otherInst'];
			} else {
				$this->institution = "fetch this information!";
			}
			$this->institution_pk = $USER['institution_pk'];
			$this->address = $USER['address'];
			$this->city = $USER['city'];
			$this->state = $USER['state'];
			$this->zipcode = $USER['zipcode'];
			$this->country = $USER['country'];
			$this->phone = $USER['phone'];
			$this->fax = $USER['fax'];
			$this->primaryRole = $USER['primaryRole'];
			$this->secondaryRole = $USER['secondaryRole'];
			$this->sakaiPerm = $USER['sakaiPerms'];
			if ($USER['activated'] == 'Y') { $this->activated=true; }

			if ($this->activated) {
				$this->authentic = true;
			}
			$this->data_source = "db";
			return true;
		}
		$this->Message = "Invalid login: $username not in DB";
		return false;
	}
}
?>