<?php
/**
* @version $Id: getids.php,v 1.1 2005/07/22 01:57:13 eddieajau Exp $
* @package Mambo
* @copyright (C) 2000 - 2005 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

function getcatids($field, $table, $gid, $db, $_dbprefix){
	
	//Get all Story Topics
	$resultC = mysql_db_query ($db, "SELECT $field FROM ".$_dbprefix."$table WHERE published=1") or $mysql_eval_err = mysql_error();
	if ($mysql_eval_err<>'') {
		return '';
	}
	$c = 0;
	while ($rowC = mysql_fetch_object($resultC)){
		$topic[$c] = $rowC->$field;
		$c++;
	}
	
	//Build CatID query
	$accquery="(";
	for ($a=0; $a<count($topic); $a++){
		$pos = strrpos($accquery, $topic[$a]);
		if ($pos === false) {
			$accquery = $accquery."id=".$topic[$a]." OR ";
		}
	}
	
	//Strip off the final OR
	if (strlen($accquery)>4) {
		$accquery = substr($accquery,0,(strlen($accquery)-4));
	}
	$accquery=$accquery.")";
	
	//Get all CatIDs
	$resultD = mysql_db_query ($db, "SELECT id FROM ".$_dbprefix."categories WHERE (access<='$gid' AND published=1 AND ".$accquery.")") or $mysql_eval_err = mysql_error();
	if ($mysql_eval_err<>'') {
		return '';
	}
	$d = 0;
	while ($rowD = mysql_fetch_object($resultD)){
		$cid[$d] = $rowD->id;
		$d++;
	}
	
	//Build TopicID query
	$topquery="(";
	for ($a=0; $a<count($cid); $a++){
		$pos = strrpos($topquery, $cid[$a]);
		if ($pos === false) {
			$topquery = $topquery.$field."=".$cid[$a]." OR ";
		}
	}
	
	//Strip off the final OR
	if (strlen($topquery)>4) {
		$topquery = substr($topquery,0,(strlen($topquery)-4));
		$topquery = "AND ".$topquery.")";
	} else {
		$topquery = "";
	}
	
	
	return $topquery;
}


function getmenuids($field, $table, $gid, $db, $_dbprefix){
	
	//Get all Story Topics
	$resultC = mysql_db_query ($db, "SELECT $field FROM ".$_dbprefix."$table WHERE published=1") or $mysql_eval_err = mysql_error();
	if ($mysql_eval_err<>'') {
		return '';
	}
	$c = 0;
	while ($rowC = mysql_fetch_object($resultC)){
		$topic[$c] = $rowC->$field;
		$c++;
	}
	
	//Build MenuID query
	$accquery="(";
	for ($a=0; $a<count($topic); $a++){
		$pos = strpos($accquery, $topic[$a]);
		if ($pos === false) {
			$accquery = $accquery."id=".$topic[$a]." OR ";
		}
	}
	//Strip off the final OR
	if (strlen($accquery)>4) {
		$accquery = substr($accquery,0,(strlen($accquery)-4));
	}
	$accquery=$accquery.")";
	
	//Get all MenuIDs
	$resultD = mysql_db_query ($db, "SELECT id FROM ".$_dbprefix."menu WHERE (access<='$gid' AND published=1 AND ".$accquery.")") or $mysql_eval_err = mysql_error();
	if ($mysql_eval_err<>'') {
		return '';
	}
	$d = 0;
	while ($rowD = mysql_fetch_object($resultD)){
		$cid[$d] = $rowD->id;
		$d++;
	}
	
	//Build MenuContentID query
	$topquery="(";
	for ($a=0; $a<count($cid); $a++){
		$pos = strpos($topquery, $cid[$a]);
		if ($pos === false) {
			$topquery = $topquery."menuid"."=".$cid[$a]." OR ";
		}
	}
	
	//Strip off the final OR
	if (strlen($topquery)>4) {
		$topquery = substr($topquery,0,(strlen($topquery)-4));
		$topquery = "AND ".$topquery.")";
	} else {
		$topquery = "";
	}
	
	return $topquery;
}
?>