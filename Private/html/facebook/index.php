<?php
/* file: index.php
 * Created on Mar 19, 2006 by @author az
 * Aaron Zeckoski (aaronz@vt.edu) - Virginia Tech (http://www.vt.edu/)
 */
?>
<?php
require_once 'include/tool_vars.php';

$PAGE_NAME = "Facebook Intro";
$Message = "";

// connect to database
require 'sql/mysqlconnect.php';

// check authentication
require $ACCOUNTS_PATH.'include/check_authentic.php';

$viewable = 1;
if ($User->pk) {
	$viewable = 0;
}

// get the search
$searchtext = "";
$providerSearch = "";
if ($_REQUEST["searchtext"]) {
	$searchtext = $_REQUEST["searchtext"];
	$providerSearch = "username=$searchtext,firstname=$searchtext,lastname=$searchtext,email=$searchtext,institution=$searchtext";
}
$sqlsearch = "";
if ($searchtext) {
	$sqlsearch = " and (F1.url like '%$searchtext%' or F1.interests like '%$searchtext%') ";
}

// the main fetching query (must fetch all items for sort and search to work)
$sql = "select * from facebook_entries F1 where viewable >= '$viewable' " . $sqlsearch;
//print "SQL=$sql<br/>";
$result = mysql_query($sql) or die("Query failed ($sql): " . mysql_error());
$total_items = mysql_num_rows($result);

// put all of the query results into an array first
while($row=mysql_fetch_assoc($result)) { $items[$row['pk']] = $row; }

// pagination control
$num_limit = 15;
if ($_REQUEST["num_limit"]) { $num_limit = $_REQUEST["num_limit"]; }

$total_pages = ceil($total_items / $num_limit);

$page = 1;
$PAGE = $_REQUEST["page"];
if ($PAGE) { $page = $PAGE; }

$PAGING = $_REQUEST["paging"];
if ($PAGING) {
	if ($PAGING == 'first') { $page = 1; }
	else if ($PAGING == 'prev') { $page--; }
	else if ($PAGING == 'next') { $page++; }
	else if ($PAGING == 'last') { $page = $total_pages; }
}

if ($page > $total_pages) { $page = $total_pages; }
if ($page <= 0) { $page = 1; }

$limitvalue = $page * $num_limit - ($num_limit);
$start_item = $limitvalue + 1;
$end_item = $limitvalue + $num_limit;
if ($end_item > $total_items) { $end_item = $total_items; }
$items_displayed = $end_item - $start_item + 1;

// Use the user pks to get the user info for these proposal users
$userPks = array();
foreach ($items as $item) {
	// this should produce a nice unique list of user pks
	$userPks[$item['users_pk']] = $item['users_pk'];
}

// use the current User object to get the userinfo
$userInfo = $User->getUsersByPkList($userPks, "lastname,fullname,email,institution");
//echo "<pre>",print_r($userInfo),"</pre><br/>";

// put the userInfo into the items array
foreach ($items as $item) {
	$items[$item['pk']]['lastname'] = $userInfo[$item['users_pk']]['lastname'];
	$items[$item['pk']]['fullname'] = $userInfo[$item['users_pk']]['fullname'];
	$items[$item['pk']]['email'] = $userInfo[$item['users_pk']]['email'];
	$items[$item['pk']]['institution'] = $userInfo[$item['users_pk']]['institution'];
}

// SORTING now happens on the output array
$sortorder = "date_created";
if ($_REQUEST["sortorder"]) { $sortorder = $_REQUEST["sortorder"]; }
$items = nestedArraySort($items, $sortorder);

?>

<!-- // INCLUDE THE HTML HEAD -->
<?php include $ACCOUNTS_PATH.'include/top_header.php';  ?>
<script type="text/javascript" src="/accounts/ajax/validate.js"></script>
<script type="text/javascript">
<!--
function popup(url,name,w,h){
	settings="width=" + w + ",height=" + h + ",scrollbars=yes,location=no,directories=no,status=no,menubar=no,toolbar=no,resizable=yes";
	win=window.open(url,name,settings);
}

function orderBy(newOrder) {
	if (document.adminform.sortorder.value == newOrder) {
		document.adminform.sortorder.value = newOrder + " desc";
	} else {
		document.adminform.sortorder.value = newOrder;
	}
	document.adminform.submit();
	return false;
}
// -->
</script>
<!-- // INCLUDE THE HEADER -->
<?php include 'include/header.php';  ?>

<?= $Message ?>

<form name="adminform" method="post" action="<?=$_SERVER['PHP_SELF']; ?>" style="margin:0px;">
<input type="hidden" name="sortorder" value="<?= $sortorder ?>" />

<div class="navigation">
	<input type="hidden" name="page" value="<?= $page ?>" />
	<input class="filter" type="submit" name="paging" value="first" title="Go to the first page" />
	<input class="filter" type="submit" name="paging" value="prev" title="Go to the previous page" />
	Page <?= $page ?> of <?= $total_pages ?>
	<input class="filter" type="submit" name="paging" value="next" title="Go to the next page" />
	<input class="filter" type="submit" name="paging" value="last" title="Go to the last page" />
	&nbsp;-&nbsp;
	Displaying <?= $start_item ?> - <?= $end_item ?> of <?= $total_items ?> items (<?= $items_displayed ?> shown)
</div>

<?php 
$line = 0;
foreach ($items as $item) { // loop through all of the proposal items
	$line++;
	
	// only show items for this page
	if ($line < $start_item || $line > $end_item) { continue; }
	
	// shorten the long items
	$short_inst_name = $item['institution'];
	if (strlen($short_inst_name) > 25) {
		$short_inst_name = substr($short_inst_name,0,22) . "...";
	}
?>

<div class="frame">
	<div style="width:<?= $MAX_THUMB_WIDTH ?>px;height:<?= $MAX_THUMB_HEIGHT ?>px;text-align:center;">
		<img src="include/drawThumb.php?pk=<?= $item['image_pk'] ?>" alt="<?= $item['fullname'] ?> facebook image" />
	</div>
	<div class="about" style="width:<?= $MAX_THUMB_WIDTH ?>px;">
		<div class="name">
<?php if ($item['url']) { ?>
			<a href='<?= $item['url'] ?>' target="blank"><img src="include/images/weblink.png" border="0" height="10" width="10" alt="weblink"/></a>
<?php } ?>
		<label title="<?= $item['interests'] ?>"><?= $item['fullname'] ?></label></div>
		<div class="institute"><label title="<?= $item['institution'] ?>"><?= $short_inst_name ?></label></div>
<?php // TODO - make this so it shortens the output of interests
	/**	
		<div class=interests><?= $item['interests'] ?></div>
	**/
?>
	</div>
</div>

<?php } ?>

</form>

<?php include 'include/footer.php'; ?>