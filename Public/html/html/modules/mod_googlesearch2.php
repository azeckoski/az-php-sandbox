<?php
// Google Search 2.0 Module //
/**
* @ Version: 2.0
* @ Copyright (C) 2004 MamboPT
* @ Autor : MamboPT ( Adriano )
* @ Todos os direitos reservados. (All rights reserveds.)
* @ URL: www.mambopt.com
* @ MAIL: webmaster@mambopt.com
**/

defined( '_VALID_MOS' ) or die( 'Directly access to file not permited.' );


// http://www.google.com/searchcode.html
$searchType="Normal";
$searchType="Safe";
$searchType="SiteSearch";


// URL of your site
$yourdomain="$mosConfig_live_site";

// $defultsearch="me";
// $defultsearch="www";
$defultsearch="www";

/************************************************************************/
/* Configuração do módulo                                               */
/************************************************************************/

if ($searchType=="Normal") {
	$content = "\n<!-- Search Google -->\n"
   		. "<center>\n"
		. "<TABLE cellpadding=\"0\" cellspacing=\"0\" border=\"0\">\n"
	  	. "<FORM method=GET action=\"http://www.google.com/search\" target=\"_blank\">\n"
                . "<tr><td align=\"center\">\n"
		. "<A HREF=\"http://www.google.com/\" target=\"_blank\">\n"
		. "<IMG SRC=\"$mosConfig_live_site/modules/images/google.png\" border=\"0\" ALT=\"Google\" align=\"absmiddle\"></A>\n"
		. "<INPUT TYPE=\"text\" name=\"q\" size=\"15\" maxlength=\"255\" value=\"\"><br>\n"
		. "<INPUT type=\"submit\" name=\"btnG\" VALUE=\"Google\">\n"
		. "</center>\n"
		. "<!-- Search Google -->\n";
} elseif ($searchType=="Safe") {
	$content = "\n<!-- Google SafeSearch  -->\n"
   		. "<center>\n"
		. "<TABLE cellpadding=\"0\" cellspacing=\"0\" border=\"0\">\n"
   		. "<FORM method=GET action=\"http://www.google.com/search\" target=\"_blank\">\n"
                 . "<tr><td align=\"center\">\n"
   		. "<A HREF=\"http://www.google.com/search?safe=vss\" target=\"_blank\">\n"
   		. "<IMG SRC=\"$mosConfig_live_site/modules/images/google.png\" border=\"0\" ALT=\"Google\" align=\"absmiddle\"></A>\n"
   		. "<INPUT TYPE=\"text\" name=\"q\" size=\"15\" maxlength=\"255\" value=\"\"><br>\n"
   		. "<INPUT type=\"hidden\" name=\"safe\" value=\"vss\">\n"
   		. "<INPUT type=\"submit\" name=\"sa\" value=\"safe Google\">\n"
   		. "</center>\n"
   		. "<!-- Google SafeSearch -->\n";
} elseif ($searchType=="SiteSearch") {
	if ($defultsearch=="me") {
         	$defwww="";
		$defme=" checked";
         } else {
         	$defwww=" checked";
		$defme="";
         }
	$content = "\n<!-- SiteSearch Google -->\n"
   		. "<center>\n"
		. "<TABLE width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\">\n"
   		. "<FORM method=GET action=\"http://www.google.com/search\" target=\"_blank\">\n"
                . "<tr><td align=\"center\">\n"
   		. "<A HREF=\"http://www.google.com/\" target=\"_blank\">\n"
   		. "<IMG SRC=\"$mosConfig_live_site/modules/images/google.png\" border=\"0\" ALT=\"Google\"></A>\n"
   		. "<br>\n"
   		. "<INPUT TYPE=\"text\" name=\"q\" size=\"15\" maxlength=\"255\" value=\"\"><br>\n"
   		. "<INPUT type=\"submit\" name=\"btnG\" VALUE=\"Google\"><br>\n"
   		. "<font size=\"-1\">\n"
   		. "<input type=\"hidden\" name=\"domains\" value=\"".$yourdomain."\"><br>\n"
                . "<input type=\"radio\" name=\"sitesearch\" value=\"\"".$defwww.">www\n"
        . "<input type=\"radio\" name=\"sitesearch\" value=\"".$yourdomain."\"".$defme.">".$yourdomain."<br>\n"
   		. "</font>\n"
		. "</td></tr></FORM></TABLE>\n"
   		. "</center>\n"
   		. "<!-- SiteSearch Google -->\n";
} else {
	$content = "<center>"
          	 . "Error!!!! :(<br>"
                 . "</center>";
}

$content .= "";
