<?php//*****************************************////Sakai Facebook Version 2 Austin//September 2005//shardin@umich.edu////print_all.php   for printing out 6 images per page//width is 200px//*****************************************//?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html xmlns="http://www.w3.org/1999/xhtml"><head><title>Sakai Project: SEPP Conference Facebook</title><meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"><meta name="description" content=",Sakai - www.sakaiproject.org, Community Source Software for Education."><meta name="keywords" content=",sakai, sakaiproject.org, sakaiproject, Sakai, Community Source, Open Source, open-open, educational software, collaborative"><meta name="robots" content="index, follow"><style type="text/css">body {font-family: Arial;font-size: 9px;font-weight: normal;color: #000;}#photos {width: 800px;padding:5px;align: center;}#photos a, #photos a:link, #photos a:visited{font-weight: normal;color: #000;}#photos a:hover{font-weight: normal;color: #ffcc33;}#header {background: #fff;text-align: center;}#header {background: #fff;text-align: center;}#frame{float: left;width: 280px;height: 320px;background: #fff;padding: 2px;text-align: center;padding-bottom: 10px;}#frame img {text-align: center;padding: 1px;border: 1px solid #eee;vertical-align: bottom;}#label {height: 20px;}#about .name{font-size: 24px;font-weight: bold;}#about .institute{font-size: 18px;font-weight: normal;}#about .interests{font-size: 12px;}</style></head><body><table bgcolor="#ffffff" border="0" cellpadding="0" cellspacing="0" width="100%">  <tbody>       <tr class="mainPageContent">      <td class="centerContent" width="100%">      <div id="photos">        <?php		 	    require 'includes/resize.php';require "includes/mysqlconnect.php";	// how many rows to show per page$rowsPerPage = 6;// by default we show first page$pageNum = 1;// if $_GET['page'] defined, use it as page numberif(isset($_GET['page'])){    $pageNum = $_GET['page'];}// counting the offset$offset = ($pageNum - 1) * $rowsPerPage;	$query  = "SELECT * FROM facebook order by id LIMIT $offset, $rowsPerPage";$searchresult = mysql_query($query);// how many rows we have in database$count   = "SELECT COUNT(*) AS numrows FROM facebook";$result  = mysql_query($count) or die('Error, query failed');$row     = mysql_fetch_array($result, MYSQL_ASSOC);$numrows = $row['numrows'];// how many pages we have when using paging?$maxPage = ceil($numrows/$rowsPerPage);$self = $_SERVER['PHP_SELF'];// creating 'previous' and 'next' link// plus 'first page' and 'last page' link// print 'previous' link only if we're not// on page oneif ($pageNum > 1){    $page = $pageNum - 1;    $prev = " <a href=\"$self?page=$page\">[Prev]</a> ";        $firstp = " <a href=\"$self?page=1\">[First Page]</a> ";}else{    $prev  = ' [Prev] ';       // we're on page one, don't enable 'previous' link    $firstp = ' [First Page] '; // nor 'first page' link}// print 'next' link only if we're not// on the last pageif ($pageNum < $maxPage){    $page = $pageNum + 1;    $next = " <a href=\"$self?page=$page\">[Next]</a> ";        $lastp = " <a href=\"$self?page=$maxPage\">[Last Page]</a> ";}else{    $next = ' [Next] ';      // we're on the last page, don't enable 'next' link    $lastp = ' [Last Page] '; // nor 'last page' link}if ($numrows > 10)echo "<div id=nav align=center>$firstp &nbsp;&nbsp; $prev &nbsp;&nbsp;  page &nbsp;<strong>$pageNum</strong> &nbsp;of &nbsp;<strong>$maxPage</strong>&nbsp; pages &nbsp;&nbsp;  $next &nbsp;&nbsp; $lastp</div>";// print the imagesecho"<div id=box><br /> ";		while($links=mysql_fetch_array($searchresult))		{				$add_url="1";		$id=$links["id"]; 		$first=$links["First"]; 		$last=$links["Last"]; 		$institution=$links["Institution"]; 		$emailadd=$links["email"];		$filename=$links["pict"];		$interests=$links["interests"];		$url=$links["url"];		if ($url=='')		$add_url="0";	echo "<div id=frame>";		imageResize($filename, "200", "");		echo "<div id=about><div class=name>"; if ($add_url=='1')echo"<a href=\"$url\" target=\"blank\"></a>";echo" $first $last</div><div class=institute>$institution</div><div class=interests>$interests</div></div>				 </div></div>";  }// print the page navigation link?></div><td></tr>    </tbody></table></body></html>