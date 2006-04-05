<?php
/*
 * file: textxml.php
 * Created on Mar 11, 2006 9:32:27 AM by @author aaronz
 * 
 * Aaron Zeckoski (aaronz@vt.edu) - Virginia Tech (http://www.vt.edu/)
 */
?>
<?php

/*** XML traversal and item count
$namesDoc = new DOMDocument();
$namesDoc->load($TOOL_PATH.'include/skin_names.xml');
$elements = $namesDoc->getElementsByTagName('NAME');
print "Size:".$elements->length."<br/>";
foreach ($elements as $node) {
	print $node->nodeValue.'<br>';
}
srand((double)microtime()*1000000); // random seed
$randomNum = rand(1,$elements->length); // bewteen 1 and number of xml elements
$elementCount = $elements->length;
print $elements->item($randomNum)->nodeValue.'<br>';

$namesDoc = new DOMDocument();
$namesDoc->load($TOOL_PATH.'include/skin_names.xml');
$elements = $namesDoc->getElementsByTagName('NAME');
$allNames = array();
foreach ($elements as $node) { $allNames[] = $node->nodeValue; }
$sql_names = "select title from skin_entries where round='$ROUND'";
$result = mysql_query($sql_names) or die("Name query failed ($sql_names): " . mysql_error());
$usedItems = array();
while ($row = mysql_fetch_row($result)) { $usedItems[]=$row[0]; }
mysql_free_result($result);
$allNames = array_diff($allNames,$usedItems);
****/

require_once 'include/tool_vars.php';

$PAGE_NAME = "Text XML sample";
$Message = "";

// connect to database
require 'sql/mysqlconnect.php';


$sql = "select * from users";
$result = mysql_query($sql) or warn('Query failed: ' . mysql_error());

// create a new XML document
$doc = new DomDocument('1.0');

// create root node
$root = $doc->appendChild($doc->createElement('ROOT'));

// process one row at a time
while($row = mysql_fetch_assoc($result)) {
	// make the item node
	$node = $root->appendChild($doc->createElement("ITEM"));

	foreach ($row as $name=>$value) {
        if ($value == "") { continue; }
        $textNode = $node->appendChild($doc->createElement(strtoupper($name)));
        $textNode->appendChild($doc->createTextNode($value));
	} // end for
} // end while

// stylesheet files
$styleSheet = $_SERVER["DOCUMENT_ROOT"].$TOOL_URL."/sql/debug.xsl";
if ($SHOW_XML) { $styleSheet = $_SERVER["DOCUMENT_ROOT"].$TOOL_URL."/sql/debug.xsl"; }

$xslt = new xsltProcessor;
$xsl = DOMDocument::load($styleSheet);
$xslt->importStyleSheet($xsl);
//$xslt->registerPHPFunctions(); // allow php functions to be called using: php:function
//$xmldata = $doc->saveXML(); // complete xml document as text
//print $xslt->transformToXML($doc);
// When generating a pure XML file, use the following headers:
//header( "Content-Type: text/html; charset=utf-8;" );
//header( "Content-Encoding: utf-8" );

?>

<?php include $ACCOUNTS_PATH.'include/top_header.php'; // INCLUDE THE HTML HEAD ?>
<script>
<!--
// -->
</script>
<?php include 'include/header.php'; // INCLUDE THE HEADER ?>

<?= $xslt->transformToXML($doc); ?>

<?php include 'include/footer.php'; // INCLUDE THE FOOTER ?>
