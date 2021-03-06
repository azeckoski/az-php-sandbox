<?php
/*
 * file: create_badge.php
 * Created on Apr 25, 2006 by @author aba
 * Tony Atkins (anthony.atkins@vt.edu) - Virginia Tech (http://www.vt.edu/)
 * copyright 2006 Virginia Tech
 * 
 * Added code to track badges printed -AZ
 * 
 * Create a badge for a user.
 * Expects USERS_PK=# for a specific badge or USERS_PK=all to print all badges.
 * 
 */
?>
<?php
require_once '../include/tool_vars.php';

$PAGE_NAME = "Sakai Conference Badge Generator";
$Message = "";

// connect to database
require $ACCOUNTS_PATH.'sql/mysqlconnect.php';

// check authentication
require $ACCOUNTS_PATH.'include/check_authentic.php';

// login if not autheticated
require $ACCOUNTS_PATH.'include/auth_login_redirect.php';

// Make sure user is authorized
$allowed = false; // assume user is NOT allowed unless otherwise shown
if (!$User->checkPerm("admin_conference")) {
	$allowed = false;
	$Message = "Only admins with <b>admin_conference</b> may view this page.<br/>" .
		"Try out this one instead: <a href='$TOOL_PATH/'>$TOOL_NAME</a>";

	// STOP them here if not authorized
	echo $Message;
	exit();
} else {
	$allowed = true;
}

// simple script to generate a badge based on a person's information

// load ezPDF library
// for usage information, look at http://ros.co.nz/pdf/readme.pdf
include('../../accounts/include/class.ezpdf.php');

$vertical_margin          = 24;
$margin                   = 12;
$left_margin              = 18;
$right_margin             = 18;
$top_margin				  = 72;
$bottom_margin            = 72;
$page_width               = 612;
$page_height              = 792;
$badge_width              = 288;
$badge_height             = 216;
$base_width               = round(($badge_width-($margin*2))/12);
$base_height			  = round(($badge_height-($margin*2))/12);

// Vancouver logo - works
//$logo_file		          = "../../accounts/include/images/sakai-logo-6inch.png";

// Atlanta logo - works
//$logo_file		          = "../../accounts/include/images/atlantaBadgeLogo.png";

// Amsterdam logo - works but is a rough image capture,  pasted into the original atlantaBadgeLogo.png file
//$logo_file		          = "../../accounts/include/images/atlantaBadgeLogo2.png";


// Amsterdam logo - does not work
$logo_file		          = "../../accounts/include/images/Final_amsterdamPoloLogo2.png";

$logo_width               = 72;
$logo_height              = 52;

// new variable for "print all" link when there are too many records.  Should be divisible by 3.
$recordsPerPage = 33;

/* one or more PKs for badges pulled from the database */
$USERS_PK      = $_REQUEST["USERS_PK"];

/* variables for a custom badge */
$firstname      = $_REQUEST["firstname"];
$lastname       = $_REQUEST["lastname"];
$institution    = $_REQUEST["institution"];
$primaryRole    = $_REQUEST["primaryRole"];
$secondaryRole  = $_REQUEST["secondaryRole"];

$primaryColor   = $_REQUEST["primaryColor"];
if (!isset($primaryColor) || $primaryColor == "") { $primaryColor = "#000000"; }

$secondaryColor = $_REQUEST["secondaryColor"];
if (!isset($secondaryColor) || $secondaryColor == "") { $secondaryColor = "#000000"; }

/* pull badge data from the database */
if (isset($USERS_PK) && is_array($USERS_PK)) {
	$where_clause = "";
	if ($USERS_PK[0] != "all") {
		$where_clause= "where U.pk in ('" . join("','", $USERS_PK) . "') ";
	}
	else {
		$pageNumber = $_REQUEST["pageNumber"];
		$numRecords = $_REQUEST["numRecords"];

		if (isset($pageNumber) && $pageNumber != "") { 
			$startRecord=( $pageNumber * $recordsPerPage) + 1;
			$limit_clause="limit $startRecord,$recordsPerPage";
		}
	}
	
	$select_statement = 
			"select U.firstname as FIRSTNAME, " .
			"U.lastname as LASTNAME, " .
			"U.institution as INSTITUTION, " .
			"R1.role_name as PRIMARY_ROLE, " .
			"R1.color as PRIMARY_COLOR, " .
			"R2.role_name as SECONDARY_ROLE, " .
			"R2.color as SECONDARY_COLOR " .
			"from users U " .
			"join conferences C on C.users_pk=U.pk and C.activated='Y' and C.confID = '$CONF_ID' ".
			"left join roles R1 on R1.role_name=U.primaryRole " .
			"left join roles R2 on R2.role_name=U.secondaryRole " .
			$where_clause .
			"order by U.lastname, U.firstname " .
			"$limit_clause";

	$result = mysql_query($select_statement) or die("Fetch query failed ($select_statement): " . mysql_error());

	if (!isset($numRecords) || $numRecords == "") {
		$numRecords = mysql_num_rows($result);
	}
	
	if (mysql_num_rows($result) < 1) {
		die("No information found for user $USERS_PK.");
	} else {
		// update the badge printing tracker
		$users_sql = "";
		if ($USERS_PK[0] != "all") {
			$users_sql = "and U.pk in ('" . join("','", $USERS_PK) . "') ";
		}
		$sql = "update conferences CONF join users U on U.pk = CONF.users_pk " . $users_sql .
			"set CONF.printed_badge = 'Y' where CONF.confID = '$CONF_ID' and CONF.activated = 'Y'";
		mysql_query($sql) or die("Update query failed ($sql): " . mysql_error());
	}

	/* build an array of user records */
	while ($person = mysql_fetch_assoc($result)) {
		$people[]=$person;		
	}
}
/* create a custom record for a single badge */
elseif (isset($firstname) && $firstname != "" &&
        isset($lastname) && $lastname != "" && 
        isset($institution) && $institution != "" &&
        isset($primaryRole) && $primaryRole != "") {
	/* create a single user record from the supplied data */
	$person["FIRSTNAME"]       = $firstname;
	$person["LASTNAME"]        = $lastname;
	$person["INSTITUTION"]     = $institution;
	$person["PRIMARY_ROLE"]    = $primaryRole;
	$person["SECONDARY_ROLE"]  = $secondaryRole;	
	$person["PRIMARY_COLOR"]   = $primaryColor;
	$person["SECONDARY_COLOR"] = $secondaryColor;	

	$people[0]=$person;
}
else {
	die("Can't continue without a value for USERS_PK or a custom user record.");
}

if ($USERS_PK[0] == "all" && !isset($pageNumber) && ( $numRecords > $recordsPerPage) ) {
	print "<div style=\"padding:2em;background-color:#ccccff;border:1px solid #0000ff\">";
	print "<p>There are too many records to display in a single file.  Please download each of the following files individually:</p>";
	print "<ul>";
	for ($a=0; $a<$numRecords/$recordsPerPage; $a++) {
		$startRecord=1+($a*$recordsPerPage);
		if ($numRecords > $startRecord+$recordsPerPage) {
			$endRecord=$startRecord+$recordsPerPage-1;
		}
		else {
			$endRecord=$numRecords-1;
		}
		print "<li><a href=\"create_badge.php?USERS_PK[]=all&numRecords=$numRecords&pageNumber=$a\">PDF file for records $startRecord-$endRecord</a></li>";
	}
	print "</ul>";
	print "</div>";
}
else {
	// this is the closest predefined page size matching the labels
	$pdf = new Cezpdf('LETTER','portrait');
	$pdf->ezSetMargins($top_margin,$bottom_margin,$left_margin,$right_margin);
	$pdf->selectFont('../../accounts/include/fonts/Helvetica.afm');
	$pdf->setFontFamily('b');   

	$pdf->addInfo("Creator", "Sakai Conference Badge Generator");
	$pdf->addInfo("Author", "Educational Technologies at Virginia Tech");
	$pdf->addInfo("Title", "Sakai Conference Badges");
	$pdf->addInfo("CreationDate", localtime());

	$pageCount = 0;
	$offsetRow = 2;

	foreach ($people as $person) {
		if ($pageCount > 0 && $offsetRow == 2) { 
			$pdf->ezNewPage(); 
		}
	
		for ($columnOffset=0; $columnOffset<=1; $columnOffset++) {
			$left_edge   = $left_margin + (($badge_width) * $columnOffset) + $margin;
			$right_edge  = $left_edge + $badge_width - ($margin*2);
			$top_edge    = $top_margin + (($offsetRow+1) * $badge_height) - $margin;
			$bottom_edge = $top_edge - $badge_height + ($margin*2);
			$center      = $left_edge + ($badge_width-$margin-($base_height/2))/2;

	 		$logoY = $top_edge - $logo_height - ($base_height*1.5);
			$pdf->addPngFromFile($logo_file, $left_edge + $badge_width/2 - $logo_width/2 -12 , $logoY, $logo_width, $logo_height);

			$nameString = ucfirst($person["FIRSTNAME"]) . " " . ucfirst($person["LASTNAME"]);
			$nameSize = 32;

			while ($pdf->getTextWidth($nameSize, $nameString) > ($badge_width-($margin*4))) {
				$nameSize-=2;	
			}

			$nameX=$center-($pdf->getTextWidth($nameSize,$nameString)/2);
			$nameY=$logoY-$pdf->getFontHeight($nameSize)+6;
			$pdf->addText($nameX,$nameY, $nameSize, $nameString);
		
			$institutionString = $person["INSTITUTION"];
			$institutionSize = 18;
	
//			while ($pdf->getTextWidth($institutionSize, $institutionString) > 568) {
//				$institutionSize-=2;	
//			}

			// new "guesstimated" cutoff width for resizing text
			while ($pdf->getTextWidth($institutionSize, $institutionString) > 300) {
				$institutionSize-=2;	
			}	
	
			$institutionX=$center-($pdf->getTextWidth($institutionSize,$institutionString)/2);
			$institutionY=$nameY - $pdf->getFontHeight($institutionSize);
		
			/* display shorter institutions on a single line */
			if ($pdf->getTextWidth($institutionSize, $institutionString) < 234) {
				$pdf->addText($institutionX, $institutionY, $institutionSize, $institutionString);
			}	
			/* split longer institutions up over two lines */
			else {
				$institutionStringArray=split(' ',$institutionString);
				$institutionString1="";
				$institutionString2="";
				
				$gotoSecondLine = 0;
				for ($a=0;$a<count($institutionStringArray);$a++) {
					if ($gotoSecondLine == 0 && $pdf->getTextWidth($institutionSize, "$institutionString1 " . $institutionStringArray[$a]) < 234) {
						if ($institutionString1 != "") { $institutionString1 .= " "; }
						$institutionString1 .= $institutionStringArray[$a];	
					}
					else {
						$gotoSecondLine = 1;
						if ($institutionString2 != "") { $institutionString2 .= " "; }
						$institutionString2 .= $institutionStringArray[$a];
					}
				}
	
				$institutionX = $center-($pdf->getTextWidth($institutionSize,$institutionString1)/2);
//				$pdf->addText($institutionX,$institutionY,$institutionSize, $pdf->getTextWidth($institutionSize, $institutionString) . ":" . $institutionString1);
				$pdf->addText($institutionX,$institutionY,$institutionSize, $institutionString1);
	
	
				$institutionX2 = $center-($pdf->getTextWidth($institutionSize,$institutionString2)/2);
				$institutionY2 = $institutionY - $pdf->getFontHeight($institutionSize);
				$pdf->addText($institutionX2,$institutionY2,$institutionSize,$institutionString2);
			}

			$lpoints = array($left_edge,$bottom_edge,
						 $left_edge+($base_width*1),$bottom_edge,
						 $left_edge+($base_width*2),$bottom_edge+($base_height*1.25),
						 $left_edge+$base_width/2, $bottom_edge+($base_height*1.25),
						 $left_edge+$base_width/2, $top_edge - ($base_height*1.25),
						 $left_edge+(9.5*$base_width), $top_edge - ($base_height*1.25),
					 	 $left_edge+(10.5*$base_width), $top_edge,
					 	 $left_edge, $top_edge
						);
	
			$rpoints = array($right_edge,$bottom_edge,
						 $right_edge-($base_width*10.5),$bottom_edge,
						 $right_edge-($base_width*9.5),$bottom_edge+($base_height*1.25),
						 $right_edge-($base_width/2), $bottom_edge+($base_height*1.25),
						 $right_edge-($base_width/2), ($top_edge-($base_height*1.25)),
						 $right_edge-(2*$base_width), ($top_edge-($base_height*1.25)),
					 	 $right_edge-(1*$base_width), $top_edge,
					 	 $right_edge, $top_edge
						);
	
			if (!isset($person["PRIMARY_ROLE"]) || $person["PRIMARY_ROLE"] == "") {
				$person["PRIMARY_ROLE"]="Unknown";		
			}
			if (!isset($person["PRIMARY_COLOR"]) || $person["PRIMARY_COLOR"] == "") {
				$person["PRIMARY_COLOR"]="999999";
			}
	
			if (!isset($person["SECONDARY_ROLE"]) || $person["SECONDARY_ROLE"] == "") {
				$person["SECONDARY_ROLE"]=$person["PRIMARY_ROLE"];		
			}
			if (!isset($person["SECONDARY_COLOR"]) || $person["SECONDARY_COLOR"] == "") {
				$person["SECONDARY_COLOR"]=$person["PRIMARY_COLOR"];
			}
	
			/* present a uniform outline if the roles are the same */
			if ($person["PRIMARY_ROLE"] == $person["SECONDARY_ROLE"]) {
				$rpoints[2]=($right_edge-($base_width*11));
				$rpoints[4]=($right_edge-($base_width*10));
				$rpoints[10]=($right_edge - (3*$base_width));
				$rpoints[12]=($right_edge - (2*$base_width));
			}
	
			/* don't display the outline if the person has no role */
			if ($person["PRIMARY_ROLE"] != "Unknown") {
				$color = get_color($person["PRIMARY_COLOR"]);
				$pdf->setcolor($color[0],$color[1],$color[2]);	
		
				$pdf->polygon($lpoints,8,1);
	
				$color = get_text_color($person["PRIMARY_COLOR"]);
				$pdf->setcolor($color[0],$color[1],$color[2]);	
				$role1Width = $pdf->getTextWidth(12, $person["PRIMARY_ROLE"]);
				$pdf->addText($left_edge+$base_width/2, $top_edge-12, 12, $person["PRIMARY_ROLE"]);
		
				$color = get_color($person["SECONDARY_COLOR"]);
				$pdf->setcolor($color[0],$color[1],$color[2]);	
		
				$pdf->polygon($rpoints,8,1);
		
				$color = get_text_color($person["SECONDARY_COLOR"]);
				$pdf->setcolor($color[0],$color[1],$color[2]);	
				$role2Width = $pdf->getTextWidth(12, $person["SECONDARY_ROLE"]);
				$pdf->addText($right_edge-$base_width/2-$role2Width, $bottom_edge+6, 12, $person["SECONDARY_ROLE"]);
		
				$pdf->setcolor(0,0,0);
			}

		}

		if ($offsetRow == 0) {
			$offsetRow=2;
			$pageCount++;
		}
		else { $offsetRow--; }
	}

	$buf = $pdf->ezOutput();
	$len = strlen($buf);

	$date = date("Ymd_His");

	header("Content-type: application/pdf");
	header("Content-Length: $len");
	header("Content-Disposition: inline; filename=sakaiBadge$date.pdf");
	print $buf;
}

function get_color($hex_string="999999") {
	$color[0] = (hexdec(substr($hex_string, 0,2))/255);	
	$color[1] = (hexdec(substr($hex_string, 2,2))/255);	
	$color[2] = (hexdec(substr($hex_string, 4,2))/255);	

	return($color);
}

function get_text_color($hex_string="999999") {
	$fill_color[0] = hexdec(substr($hex_string, 0,2));	
	$fill_color[1] = hexdec(substr($hex_string, 2,2));	
	$fill_color[2] = hexdec(substr($hex_string, 4,2));	

	/* perceived brightness formula:
	 * 
	 * ((R * 299) + (G*587) + (B*114))/1000
	 * 
	 * Where R,G,B all range from 0-255, and the perceived brightness calculated 
	 * ranges from 0-255.
	 * 
	 * taken from:
	 * http://juicystudio.com/article/luminositycontrastratioalgorithm.php
	 */

	$brightness = (($fill_color[0]*299) + ($fill_color[1]*587) + ($fill_color[2]*114))/1000;

	$cutoff = 85;

	if ($brightness <= $cutoff) {
		$color[0]=1;
		$color[1]=1;
		$color[2]=1;
	}
	else {
		$color[0]=0;
		$color[1]=0;
		$color[2]=0;
	}
	
	return($color);
}

