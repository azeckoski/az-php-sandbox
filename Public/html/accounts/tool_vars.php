<?php

// Bring in the system variables
// You must verify the path to the system_vars and the
// user control directory are correct or many things will break -AZ
$ACCOUNTS_PATH = "../accounts";
require ("$ACCOUNTS_PATH/system_vars.php");

// Tool variables
$TOOL_PATH = "/accounts";
$TOOL_NAME = "Account Management";

$ACTIVATION_PASSCODE = "A348SJD984JS92K";


// the list of Sakai partners, used in drop down lists, etc.
$SAKAI_PARTNERS=array('Albany Medical College',
 'Arizona State University',
 'Australian National University',
 'Boston University School of Management',
 'Brown University',
 'Carleton College',
 'Carnegie Foundation for the Advancement of Teaching',
 'Carnegie Mellon University',
 'Cerritos Community College',
 'Charles Sturt University',
 'Coast Community College District (Coastline Community College)',
 'Columbia University',
 'Cornell University',
 'Dartmouth College',
 'Edgenics',
 'Florida Community College at Jacksonville',
 'Foothill College',
 'Franklin University',
 'Georgetown University',
 'Harvard University',
 'Hosei University IT Research Center',
 'Indiana University',
 'Johns Hopkins University',
 'Lancaster University',
 'Loyola University, Chicago',
 'Luebeck University of Applied Sciences',
 'Maricopa County Community College District',
 'Marist College',
 'MIT',
 'Monash University',
 'Nagoya University',
 'New York University',
 'Northeastern University',
 'North-West University (SA)',
 'Northwestern University',
 'Ohio State University',
 'Pennsylvania State University',
 'Portand State University',
 'Princeton University',
 'Rice University',
 'Ringling School of Art and Design',
 'Roskilde University (Denmark)',
 'Rutgers University',
 'Simon Fraser University',
 'Stanford University',
 'State University of New York System Administration',
 'Stockholm University',
 'SURF/University of Amsterdam',
 'Syracuse University',
 'Texas State University - San Marcos',
 'Tufts University',
 'University College Dublin',
 'Universidad Politecnica de Valencia (Spain)',
 'Universitat de Lleida (Spain)',
 'University College Dublin',
 'University of Arizona',
 'University of British Columbia',
 'University of California, Office of the Chancellor',
 'University of California Berkeley',
 'University of California, Davis',
 'University of California, Los Angeles',
 'University of California, Merced',
 'University of California, Santa Barbara',
 'University of Cambridge, CARET',
 'University of Cape Town, SA',
 'University of Chicago',
 'University of Colorado at Boulder',
 'University College Dublin',
 'University of Delaware',
 'University of Hawaii',
 'University of Hull',
 'University of Illinois at Urbana-Champaign',
 'University of Limerick',
 'University of Melbourne',
 'University of Michigan',
 'University of Minnesota',
 'University of Missouri',
 'University of Nebraska',
 'University of North Texas',
 'University of Oklahoma',
 'University of South Africa (UNISA)',
 'University of Texas at Austin',
 'University of Toronto, Knowledge Media Design Institute',
 'University of Virginia',
 'University of Washington',
 'University of Wisconsin, Madison',
 'Virginia Tech',
 'Weber State University',
 'Whitman College',
 'Yale University',
 'Other'
 );

function generate_partner_dropdown($select_name="institution", $institution="") {
	global $SAKAI_PARTNERS;
	$output = "";

	if (!isset($institution)) { $institution = $_POST['institution']; }
	if (!isset($institution)) { $institution = $_GET['institution']; }

	$output .= "<select name=\"$select_name\">";
	$output .= "<option value=\"\"> --Select Your Organization--</option>";

	foreach ($SAKAI_PARTNERS as $partner) {
	    if (isset($partner) && ($institution == $partner)) { $selected="selected=\"Y\""; }
	    else { $selected=""; }
		$output .= "<option value=\"$partner\"$selected>$partner</option>\n";
	}
 
	$output .= "</select>";
 
 	return $output;
 	print "output:$output";

}
?>
