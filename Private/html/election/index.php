<?php
/* file: index.php
 * Created on Mar 19, 2006 by @author az
 * 
 * Aaron Zeckoski (aaronz@vt.edu) - Virginia Tech (http://www.vt.edu/)
 */
?>
<?php
require_once 'include/tool_vars.php';

$PAGE_NAME = "Elections Intro";
$Message = "";

// connect to database
require 'sql/mysqlconnect.php';

// check authentication
require $ACCOUNTS_PATH.'include/check_authentic.php';



// Make sure user is authorized
$allowed = false; // assume user is NOT allowed unless otherwise shown
if (!$User->checkPerm("elections_nov2006")) {
	$allowed = false;
} else {
	$allowed = true;
}

// get the search
$searchtext = "";
if ($_REQUEST["searchtext"]) { $searchtext = $_REQUEST["searchtext"]; }
$sqlsearch = "";
if ($searchtext) {
	$sqlsearch = " and (E1.url like '%$searchtext%' or " .
		"E1.interests like '%$searchtext%' or U1.username like '%$searchtext%' or " .
		"U1.firstname like '%$searchtext%' or U1.lastname like '%$searchtext%' or " .
		"U1.email like '%$searchtext%' or U1.institution like '%$searchtext%' or " .
		"U1.primaryRole like '%$searchtext%' or U1.secondaryRole like '%$searchtext%') ";
}

// sorting
$sortorder = "date_created";
if ($_REQUEST["sortorder"]) { $sortorder = $_REQUEST["sortorder"]; }
$sqlsorting = " order by $sortorder ";

// main SQL to fetch all elections items
$from_sql = " from elections_entries E1 left join users U1 on U1.pk=E1.users_pk ";

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
$users_sql = "select E1.*, U1.username, U1.email, U1.firstname, " .
	"U1.lastname, U1.institution " .
	$from_sql . $sqlsearch . $sqlsorting . $mysql_limit;
//print "SQL=$users_sql<br/>";
$result = mysql_query($users_sql) or die('User query failed: ' . mysql_error());
$items_displayed = mysql_num_rows($result);


// this restricts the public viewing by date
$viewable = false;

$EXTRA_LINKS .= "<div class='date_message'>";
if (strtotime($NOMINEE_VIEW_DATE) > time()) {
	// No one can access after the close date
	$viewable = false;
	$Message = "Nominee Viewing opens " . date($DATE_FORMAT,strtotime($NOMINEE_VIEW_DATE));
	//$EXTRA_LINKS .= "Nominee viewing not open " . date($SHORT_DATE_FORMAT,strtotime($NOMINEE_VIEW_DATE));
}  else {
	// open voting is allowed
	$viewable = true;
}
$EXTRA_LINKS .= "</div>";

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
		if (newOrder.match("^.* desc$")) {
			document.adminform.sortorder.value = newOrder.replace(" desc","");
		} else {
			document.adminform.sortorder.value = newOrder;
		}
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
<?php include 'include/elections_LeftCol.php';  ?>
<?= $Message ?>


<?php
 //TODO
//add the search form back in
?>
<form name="adminform" method="post" action="<?=$_SERVER['PHP_SELF']; ?>" style="margin:0px;">
<input type="hidden" name="sortorder" value="<?= $sortorder ?>" />

<?php if ($total_items > 15) { 
	?>

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
<?php } ?>
<div>Click on a photo below or on a name in the left column to view the candidates' platform statements<br/><br/></div>

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
<div class="frame" id="tip<?= $item['users_pk'] ?>">
	<div style="width:<?= $MAX_THUMB_WIDTH ?>px;height:<?= $MAX_THUMB_HEIGHT ?>px;text-align:center;">
	<?php if (!$item['image_pk']) { ?>
		<a href="view.php?id=<?= $item['users_pk'] ?>"> <img src="include/images/blank_transparent.png" alt="no image provided" />
	</a>
	<?php
	}
	
	else { ?>
	<a href="view.php?id=<?= $item['users_pk'] ?>"> <img src="include/drawThumb.php?pk=<?= $item['image_pk'] ?>" alt="<?= $fullname ?> nominee image" />
	</a>
	<?php }  ?>
	</div>
	<div class="about" style="width:<?= $MAX_THUMB_WIDTH ?>px;">
		<div class="name">

		<a href="view.php?id=<?= $item['users_pk'] ?>"><?= $fullname ?> </a></div>
		<div class="institute"><label title="<?= $item['institution'] ?>"><?= $short_inst_name ?></label></div>

	</div>
</div>

<?php } ?>

</form>
<?php include '../conference/include/footer.php'; ?>