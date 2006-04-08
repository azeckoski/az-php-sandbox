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
if ($_REQUEST["searchtext"]) { $searchtext = $_REQUEST["searchtext"]; }
$sqlsearch = "";
if ($searchtext) {
	$sqlsearch = " and (F1.url like '%$searchtext%' or " .
		"F1.interests like '%$searchtext%' or U1.username like '%$searchtext%' or " .
		"U1.firstname like '%$searchtext%' or U1.lastname like '%$searchtext%' or " .
		"U1.email like '%$searchtext%' or U1.institution like '%$searchtext%' or " .
		"U1.primaryRole like '%$searchtext%' or U1.secondaryRole like '%$searchtext%') ";
}

// sorting
$sortorder = "date_created";
if ($_REQUEST["sortorder"]) { $sortorder = $_REQUEST["sortorder"]; }
$sqlsorting = " order by $sortorder ";

// main SQL to fetch all facebook items
$from_sql = " from facebook_entries F1 left join users U1 on U1.pk=F1.users_pk " .
		"where viewable >= '$viewable' ";

// counting number of items
// **************** NOTE - APPLY THE FILTERS TO THE COUNT AS WELL
$count_sql = "select count(*) " . $from_sql . $sqlsearch;
$result = mysql_query($count_sql) or die('Count query failed: ' . mysql_error());
$row = mysql_fetch_array($result);
$total_items = $row[0];

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
$mysql_limit = " LIMIT $limitvalue, $num_limit";

$start_item = $limitvalue + 1;
$end_item = $limitvalue + $num_limit;
if ($end_item > $total_items) { $end_item = $total_items; }

// the main user fetching query
$users_sql = "select F1.*, U1.username, U1.email, U1.firstname, " .
	"U1.lastname, U1.institution " .
	$from_sql . $sqlsearch . $sqlsorting . $mysql_limit;
//print "SQL=$users_sql<br/>";
$result = mysql_query($users_sql) or die('User query failed: ' . mysql_error());
$items_displayed = mysql_num_rows($result);

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
	if (document.adminform.sortorder.value.match == newOrder) {
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

<div class="navigation" style="width:100%;">
	<div style="display:inline;text-align:left;">
		<input type="hidden" name="page" value="<?= $page ?>" />
		<input class="filter" type="submit" name="paging" value="first" title="Go to the first page" />
		<input class="filter" type="submit" name="paging" value="prev" title="Go to the previous page" />
		Page <?= $page ?> of <?= $total_pages ?>
		<input class="filter" type="submit" name="paging" value="next" title="Go to the next page" />
		<input class="filter" type="submit" name="paging" value="last" title="Go to the last page" />
		&nbsp;-&nbsp;
		Displaying <?= $start_item ?> - <?= $end_item ?> of <?= $total_items ?> items (<?= $items_displayed ?> shown)
	</div>
	&nbsp;--&nbsp;
	<div style="display:inline;text-align:right;">
		Sort order: <strong><?= $sortorder ?></strong>
	</div>
</div>

<?php 
$line = 0;
while($item=mysql_fetch_array($result)) {
	$line++;
	$fullname = $item['firstname']." ".$item['lastname'];

	// shorten the long items
	$short_inst_name = $item['institution'];
	if (strlen($short_inst_name) > 25) {
		$short_inst_name = substr($short_inst_name,0,22) . "...";
	}
?>

<div class="frame">
	<div style="width:<?= $MAX_THUMB_WIDTH ?>px;height:<?= $MAX_THUMB_HEIGHT ?>px;text-align:center;">
		<img src="include/drawThumb.php?pk=<?= $item['image_pk'] ?>" alt="<?= $fullname ?> facebook image" />
	</div>
	<div class="about" style="width:<?= $MAX_THUMB_WIDTH ?>px;">
		<div class="name">
<?php if ($item['url']) { ?>
			<a href='<?= $item['url'] ?>' target="blank"><img src="include/images/weblink.png" border="0" height="10" width="10" alt="weblink"/></a>
<?php } ?>
		<label title="<?= $item['interests'] ?>"><?= $fullname ?></label></div>
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