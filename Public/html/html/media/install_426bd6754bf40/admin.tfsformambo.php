<?PHP /* $Id$ */

	/**
	* TFS for MAMBO Class
	* @package TFSforMAMBO
	* @copyright 2004 PJH Diender
	* @license http://www.gnu.org/copyleft/gpl.html. GNU Public License
	* @version $Revision: 2.0-RC1 $
	* @author Patrick Diender <caffeincoder@oplossing.net>
	*/
	
	//ensure this file is being included by a parent file
	defined('_VALID_MOS') or die ('Direct Access to this location is not allowed.');

	require_once($mainframe->getPath('admin_html'));

	//$task = trim( mosGetParam( $_REQUEST, 'task', null ) );
	$cid = mosGetParam( $_REQUEST, 'cid', array( 0 ) );
	
	if (!is_array( $cid )) 
	{
		$cid = array ( 0 );
	}

	//create TFS engine for reporting
	$TFSE = new TFS_Engine($mainframe,$task);

	if($task == 'stats')
	{
		$TFSE->task = $TFSE->startoption;
		$task = $TFSE->startoption;
	}
	elseif($task == NULL) 
	{
		//workaround untill i figure out way $task is empty when paging
		$task="viewip";
	}
		
	switch ($task)
	{
		case "r01":
			$TFSE->TFSheader();
			echo $TFSE->ysummary();
			$TFSE->TFSfooter();
			break;
		case "r02":
			$TFSE->TFSheader();
			echo $TFSE->msummary();
			$TFSE->TFSfooter();
			break;
		case "r03":
			$TFSE->TFSheader();
			echo $TFSE->VisitInformation();
			$TFSE->TFSfooter();
			break;
		case "r04":
			$TFSE->TFSheader();
			echo $TFSE->botsInformation();
			$TFSE->TFSfooter();
			break;
		case "r05":
			$TFSE->TFSheader();
			echo $TFSE->getVisitorsByTld();
			$TFSE->TFSfooter();
			break;
		case "r06":
			$TFSE->TFSheader();
			echo $TFSE->getPageHits();
			$TFSE->TFSfooter();
			break;
		case "r07":
			$TFSE->TFSheader();
			echo $TFSE->getSystems();
			$TFSE->TFSfooter();
			break;
		case "r08":
			$TFSE->TFSheader();
			echo $TFSE->getBrowsers();
			$TFSE->TFSfooter();
			break;
		case "r09":
			$TFSE->TFSheader();
			echo $TFSE->getBots();
			$TFSE->TFSfooter();
			break;
		case "r10":
			$TFSE->TFSheader();
			echo $TFSE->getReferrers();
			$TFSE->TFSfooter();
			break;
		case "r11":
			$TFSE->TFSheader();
			echo $TFSE->getNotIdentified();
			$TFSE->TFSfooter();
			break;
		case "r12":
			$TFSE->TFSheader();
			echo $TFSE->getUnknown();
			$TFSE->TFSfooter();
			break;
		case "r14":
			$TFSE->TFSheader();
			echo $TFSE->getKeyWords();
			$TFSE->TFSfooter();
			break;
		case "r03a":
			$TFSE->TFSheader();
			echo $TFSE->moreVisitInfo();
			$TFSE->TFSfooter();
			break;
		case "r09a":
			$TFSE->TFSheader();
			echo $TFSE->moreVisitInfo();
			$TFSE->TFSfooter();
			break;
		case "summinfo":
			echo $TFSE->GetSummariseInfo();
			break;
		case "summtask":
			$TFSE->TFSheader();
			echo $TFSE->DoSummariseTask();
			$TFSE->TFSfooter();
			break;
		case "uninstall":
			echo $TFSE->GetUnInstallInfo();
			break;
		case "uninstalltask":
			$TFSE->TFSheader();
			echo $TFSE->DoUnInstallTask();
			$TFSE->TFSfooter();
			break;
		case "getconf":
			$TFSE->TFSheader();
			echo $TFSE->GetConfiguration();
			$TFSE->TFSfooter();
			break;
		case "saveconf":
			$TFSE->TFSheader();
			echo $TFSE->SetConfiguration();
			$TFSE->TFSfooter();
			break;
		case "info":
			echo $TFSE->GetInformation();
			break;
		case "exclude":
			excludeIpAddress( $cid, 1, $option);
			break;
		case "unexclude":
			excludeIpAddress( $cid, 0, $option);
			break;
		case "viewip":
			showIpAddresses($option);
			break;
		default:
			$TFSE->TFSheader();
			echo $TFSE->ysummary();
			$TFSE->TFSfooter();
			break;
	}	

	function showIpAddresses( $option ) {
		global $database, $mainframe, $my, $acl, $TFSE;
	
		$limit = $mainframe->getUserStateFromRequest( "viewlistlimit", 'limit', 10 );
		$limitstart = $mainframe->getUserStateFromRequest( "view{$option}limitstart", 'limitstart', 0 );
		$search = $mainframe->getUserStateFromRequest( "search{$option}", 'search', '' );
		$search = $database->getEscaped( trim( strtolower( $search ) ) );
	
		$where = array();
		if (isset( $search ) && $search!= "") {
			$where[] = "(ip LIKE '%$search%' OR nslookup LIKE '%$search%' OR browser LIKE '%$search%' OR system LIKE '%$search%')";
		}
	
		$database->setQuery( "SELECT COUNT(*) "
			. "FROM #__TFS_ipaddresses "
			. (count( $where ) ? "WHERE " . implode( ' AND ', $where ) : "")
		);
	
		$total = $database->loadResult();
	
		echo $database->getErrorMsg();
	
		require_once("includes/pageNavigation.php");
	
		$pageNav = new mosPageNav( $total, $limitstart, $limit  );
	
		$database->setQuery( "SELECT id, ip, nslookup, system, browser, exclude "
			."FROM #__TFS_ipaddresses "
			. (count( $where ) ? "\nWHERE " . implode( ' AND ', $where ) : "")
			. " ORDER BY exclude DESC, ip DESC"
			. " LIMIT $pageNav->limitstart, $pageNav->limit"
		);
	
		$rows = $database->loadObjectList();
		if ($database->getErrorNum()) {
			echo $database->stderr();
			return false;
		}
	
		$TFSE->listIpAddresses( $rows, $pageNav, $search, $option );
	}
	
	function excludeIpAddress( $cid=null, $block=1, $option ) {
		global $database, $my;
	
		if (count( $cid ) < 1) {
			$action = $block ? 'exclude' : 'unexclude';
			echo "<script> alert('Select an item to $action'); window.history.go(-1);</script>\n";
			exit;
		}
	
		$cids = implode( ',', $cid );
	
		$database->setQuery( "UPDATE #__TFS_ipaddresses SET exclude='$block' "
		. " WHERE id IN ($cids)"
		);
		if (!$database->query()) {
			echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
			exit();
		}
	
		mosRedirect( "index2.php?option=$option&task=viewip" );
	}	
?>