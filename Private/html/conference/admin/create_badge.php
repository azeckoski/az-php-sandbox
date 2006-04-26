<?php
/*
 * file: create_badge.php
 * Created on Apr 25, 2006 by @author aba
 * Tony Atkins (anthony.atkins@vt.edu) - Virginia Tech (http://www.vt.edu/)
 * copyright 2006 Virginia Tech
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

// simple script to generate a badge based on a person's information

// load ezPDF library
// for usage information, look at http://ros.co.nz/pdf/readme.pdf
include('../../accounts/include/class.ezpdf.php');

$page_width               = 297.64;
$page_height              = 209.76;
$margin                   = 5;
$base_width               = ($page_width-($margin*4))/12;
$base_height              = ($page_height-($margin*4))/12;

$logo_file		          = "../../accounts/include/images/vancouverBadgeLogo.jpg";
$logo_width               = 96;
$logo_height              = 69;


$USERS_PK = $_GET["USERS_PK"];
if (!isset($USERS_PK) || $USERS_PK == "") {
	die("Can't continue without a USERS_PK.");
}


$where_clause = "";
if($USERS_PK != "all") {
	$where_clause= "where U.pk='" . mysql_real_escape_string($USERS_PK) . "'";
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
		"join conferences C on C.users_pk=U.pk and C.activated='Y' ".
		"left join roles R1 on R1.role_name=U.primaryRole " .
		"left join roles R2 on R2.role_name=U.secondaryRole " .
		$where_clause;

$result = mysql_query($select_statement) or die("Fetch query failed ($select_statement): " . mysql_error());

if (mysql_num_rows($result) < 1) {
	die("No information found for user $USERS_PK.");
}

// this is the closest predefined page size matching the labels
$pdf = new Cezpdf('A7','landscape');
$pdf->ezSetMargins('15','15','15','15');
$pdf->selectFont('../../accounts/include/fonts/Helvetica.afm');
$pdf->setFontFamily('b');   

$pdf->addInfo("Creator", "Sakai Conference Badge Generator");
$pdf->addInfo("Author", "Educational Technologies at Virginia Tech");
$pdf->addInfo("Title", "Sakai Conference Badges");
$pdf->addInfo("CreationDate", localtime());

$pageCount = 0;

while ($person = mysql_fetch_assoc($result)) {
	if ($pageCount > 0) { 
		$pdf->ezNewPage(); 
	}
	
	$pdf->addJpegFromFile($logo_file, (round($page_width/2) - round($logo_width/2)), ($page_height - $margin - ($base_height*2) - $logo_height) ,$logo_width);

	$nameString = $person["FIRSTNAME"] . " " . $person["LASTNAME"];
	$nameSize = 32;

	while ($pdf->getTextWidth($nameSize, $nameString) > 260) {
		$nameSize-=2;	
	}

	$nameX=$page_width/2-($pdf->getTextWidth($nameSize,$nameString)/2);
	$nameY=$page_height-($margin*2)-$base_height-$logo_height-$pdf->getFontHeight($nameSize);
	$pdf->addText($nameX,$nameY, $nameSize, $nameString);

	$institutionString = $person["INSTITUTION"];
	$institutionSize = 18;

	while ($pdf->getTextWidth($institutionSize, $institutionString) > 568) {
		$institutionSize-=2;	
	}

	$institutionX=$page_width/2-($pdf->getTextWidth($institutionSize,$institutionString)/2);
	$institutionY=$nameY - $pdf->getFontHeight($institutionSize) - $margin;
	
	/* display shorter institutions on a single line */
	if ($pdf->getTextWidth($institutionSize, $institutionString) < 234) {
		$pdf->addText($institutionX, $institutionY, $institutionSize, $institutionString);
	}
	/* split longer institutions up over two lines */
	else {
		$institutionStringArray=split(' ',$institutionString);
		$institutionString1="";
		$institutionString2="";
		
		for ($a=0;$a<count($institutionStringArray);$a++) {
			if ($pdf->getTextWidth($institutionSize, "$institutionString1 " . $institutionStringArray[$a]) < 234) {
				if ($institutionString1 != "") { $institutionString1 .= " "; }
				$institutionString1 .= $institutionStringArray[$a];
			}
			else {
				if ($institutionString1 != "") { $institutionString2 .= " "; }
				$institutionString2 .= $institutionStringArray[$a];
			}
		}

		$institutionX = $page_width/2-($pdf->getTextWidth($institutionSize,$institutionString1)/2);
		$pdf->addText($institutionX,$institutionY,$institutionSize,$institutionString1);


		$institutionX2 = $page_width/2-($pdf->getTextWidth($institutionSize,$institutionString2)/2);
		$institutionY2 = $institutionY - $pdf->getFontHeight($institutionSize);
		$pdf->addText($institutionX2,$institutionY2,$institutionSize,$institutionString2);
	}



	$lpoints = array($margin,$margin,
					 $margin+($base_width*1),$margin,
					 $margin+($base_width*2),$margin+$base_height,
					 $margin+$base_width/2, $margin+$base_height,
					 $margin+$base_width/2, ($page_height-$base_height-$margin),
					 $margin+(9.5*$base_width), ($page_height-$base_height-$margin),
				 	 $margin+(10.5*$base_width), ($page_height-$margin),
				 	 $margin, ($page_height-$margin)
					);

	$rpoints = array($page_width-$margin,$margin,
					 $page_width-($margin+($base_width*10.5)),$margin,
					 $page_width-($margin+($base_width*9.5)),$margin+$base_height,
					 $page_width-($margin+$base_width/2), $margin+$base_height,
					 $page_width-($margin+$base_width/2), ($page_height-$base_height-$margin),
					 $page_width-($margin+(2*$base_width)), ($page_height-$base_height-$margin),
				 	 $page_width-($margin+(1*$base_width)), ($page_height-$margin),
				 	 $page_width-$margin, ($page_height-$margin)
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
		$rpoints[2]=($page_width-($margin+($base_width*11.5)));
		$rpoints[4]=($page_width-($margin+($base_width*10.5)));
		$rpoints[10]=($page_width-($margin+(3*$base_width)));
		$rpoints[12]=($page_width-($margin+(2*$base_width)));
	}

	/* don't display the outline if the person has no role */
	if ($person["PRIMARY_ROLE"] != "Unknown") {
		$color = get_color($person["PRIMARY_COLOR"]);
		$pdf->setcolor($color[0],$color[1],$color[2]);	

	    $pdf->polygon($lpoints,8,1);

		$color = get_text_color($person["PRIMARY_COLOR"]);
		$pdf->setcolor($color[0],$color[1],$color[2]);	
		$role1Width = $pdf->getTextWidth(12, $person["PRIMARY_ROLE"]);
		$pdf->addText($margin+$base_width/2, $page_height-$margin-12, 12, $person["PRIMARY_ROLE"]);
	
		$color = get_color($person["SECONDARY_COLOR"]);
		$pdf->setcolor($color[0],$color[1],$color[2]);	

	    $pdf->polygon($rpoints,8,1);
	
		$color = get_text_color($person["SECONDARY_COLOR"]);
		$pdf->setcolor($color[0],$color[1],$color[2]);	
		$role2Width = $pdf->getTextWidth(12, $person["SECONDARY_ROLE"]);
		$pdf->addText($page_width-$margin-$base_width/2-$role2Width, $margin+round($base_height/4), 12, $person["SECONDARY_ROLE"]);

		$pdf->setcolor(0,0,0);
	}

	$pageCount++;
}

$buf = $pdf->ezOutput();
$len = strlen($buf);

$date = date("Ymd_His");

header("Content-type: application/pdf");
header("Content-Length: $len");
header("Content-Disposition: inline; filename=sakaiBadge$date.pdf");
print $buf;

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

