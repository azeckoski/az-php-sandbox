<?php
/*
 * file: admin_ldap.php
 * Created on Mar 8, 2006 10:52:28 PM by @author aaronz
 * Aaron Zeckoski (aaronz@vt.edu) - Virginia Tech (http://www.vt.edu/)
 */
?>
<?php
require_once '../include/tool_vars.php';

$PAGE_NAME = "Users Control";
$Message = "";

// connect to database
require $ACCOUNTS_PATH.'sql/mysqlconnect.php';

// check authentication
require $ACCOUNTS_PATH.'include/check_authentic.php';

// login if not autheticated
require $ACCOUNTS_PATH.'include/auth_login_redirect.php';

// Make sure user is authorized
$allowed = 0; // assume user is NOT allowed unless otherwise shown
if (!$User->checkPerm("admin_accounts")) {
	$allowed = 0;
	$Message = "Only admins with <b>admin_accounts</b> or <b>admin_insts</b> may view this page.<br/>" .
		"Try out this one instead: <a href='$TOOL_PATH/'>$TOOL_NAME</a>";
} else {
	$allowed = 1;
}


// delete ldap item
if ($_REQUEST["ldapdel"]) {
	$LDAP_PK = $_REQUEST["ldapdel"];
	$thisUser = new User($LDAP_PK);
	if (!$thisUser->delete()) {
		$Message = "Error: Could not remove user: ".$thisUser->Message;
	}
	unset($thisUser);
}


// get the search
$searchtext = "";
if ($_REQUEST["searchtext"]) { $searchtext = $_REQUEST["searchtext"]; }

// sorting
$sortorder = "username";
if ($_REQUEST["sortorder"]) { $sortorder = $_REQUEST["sortorder"]; }

$output = "Enter search text to the right";
$items = array();
if ($searchtext) { // no results without doing a search
	$returnItems = "pk,username,fullname,email,institution,institution_pk";
	$search = $searchtext;
	if (strpos($searchtext,"=") === false) { // there is not a specific search
		$search = "username=$searchtext,lastname=$searchtext,email=$searchtext,institution=$searchtext";
	}
	$items = $User->getUsersBySearch($search,$sortorder,$returnItems);
	$output = "Number of entries returned: " . count($items);
} else { // end use ldap check
	$output = "No search text entered...";
	if (!$USE_LDAP) {
		$output .= "(<b>LDAP is disabled!</b>)";
	}
}


// top header links
$EXTRA_LINKS = "<br/><span style='font-size:9pt;'>";
$EXTRA_LINKS .= "<a href='index.php'>Admin</a>: ";
if ($USE_LDAP) {
	$EXTRA_LINKS .=	"<a href='admin_ldap.php'><strong>Users</strong></a> - ";
}
$EXTRA_LINKS .= 
	"<a href='admin_insts.php'>Institutions</a> - " .
	"<a href='admin_perms.php'>Permissions</a>" .
	"</span>";

?>

<?php include $ACCOUNTS_PATH.'include/top_header.php'; ?>
<script type="text/javascript">
<!--
function orderBy(newOrder) {
	if (document.adminform.sortorder.value == newOrder) {
		document.adminform.sortorder.value = newOrder + " desc";
	} else {
		document.adminform.sortorder.value = newOrder;
	}
	document.adminform.submit();
	return false;
}

function ldapdel(itempk) {
	var response = window.confirm("Are you sure you want to remove this user (id="+itempk+") from ldap?");
	if (response) {
		document.adminform.ldapdel.value = itempk;
		document.adminform.submit();
		return false;
	}
}
// -->
</script>
<?php include $ACCOUNTS_PATH.'include/header.php'; ?>

<?= $Message ?>

<?php
	// Put in footer and stop the rest of the page from loading if not allowed -AZ
	if (!$allowed) {
		include $ACCOUNTS_PATH.'include/footer.php';
		exit;
	}
?>

<form name="adminform" method="post" action="<?=$_SERVER['PHP_SELF']; ?>" style="margin:0px;">
<input type="hidden" name="sortorder" value="<?= $sortorder ?>" />
<input type="hidden" name="ldapdel" value="" />

<div class="filterarea">
	<table border=0 cellspacing=0 cellpadding=0 width="100%">
	<tr>

	<td nowrap="y" width="5%"><b style="font-size:1.1em;">Search:&nbsp;</b></td>
	<td nowrap="y" align="left">
		<?= $output ?>
	</td>

	<td nowrap="y" align="left">
		<a href="admin_ldap_add.php">Create New User</a>
	</td>

	<td nowrap="y" align="right">
        <input class="filter" type="text" name="searchtext" value="<?= $searchtext ?>"
        	size="20" title="Enter search text here" />
        <script type="text/javascript">document.adminform.searchtext.focus();</script>
        <input class="filter" type="submit" name="search" value="Search" title="Search the requirements" />
	</td>

	</tr>
	</table>
</div>

<table border="0" cellspacing="0" width="100%">
<tr class='tableheader'>
<td></td>
<td><a href="javascript:orderBy('username');">username</a></td>
<td><a href="javascript:orderBy('lastname');">Name</a></td>
<td><a href="javascript:orderBy('email');">Email</a></td>
<td><a href="javascript:orderBy('institution');">Institution</a></td>
<td align="center"><a href="javascript:orderBy('date_created');">Date</a></td>
</tr>

<?php
$line = 0;
foreach ($items as $item) {
	$line++;
	$printInst = $item['institution'];
	if (strlen($printInst) > 38) {
		$printInst = substr($printInst,0,35) . "...";
	}

	$rowstyle = "";
	if ($not_activated) {
		$rowstyle = " style = 'color:red;' ";
	} else if ($admin_reqs) {
		$rowstyle = " style = 'color:darkgreen;' ";
	} else if ($admin_insts) {
		$rowstyle = " style = 'color:darkblue;' ";
	} else if ($admin_accounts) {
		$rowstyle = " style = 'color:#330066;' ";
	}
	
	$linestyle = "oddrow";
	if ($line % 2 == 0) {
		$linestyle = "evenrow";
	} else {
		$linestyle = "oddrow";
	}
?>
<tr class="<?= $linestyle ?>" <?= $rowstyle ?> >
	<td class="line" align="center"><em><?= $line ?>&nbsp;</em></td>
	<td class="line"><?= $item['username'] ?></td>
	<td class="line"><?= $item['fullname'] ?></td>
	<td class="line"><?= $item['email'] ?></td>
	<td class="line"><?= $printInst ?></td>
	<td class="line" align="center">
		<a href="admin_ldap_add.php?pk=<?= $item['pk'] ?>">edit</a> |
		<a href="javascript:ldapdel('<?= $item['pk'] ?>')">del</a>
	</td>
</tr>
<?php } // end for loop ?>

</table>

</form>

<?php include $ACCOUNTS_PATH.'include/footer.php'; // Include the FOOTER ?>