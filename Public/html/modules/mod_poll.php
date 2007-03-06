<?php
/**
* @version $Id: mod_poll.php,v 1.1 2005/07/22 01:58:30 eddieajau Exp $
* @package Mambo
* @copyright (C) 2000 - 2005 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

if (!defined( '_MOS_POLL_MODULE' )) {
	/** ensure that functions are declared only once */
	define( '_MOS_POLL_MODULE', 1 );

	function show_poll_vote_form( $Itemid ) {
		global $database;

		$Itemid = mosGetParam( $_REQUEST, 'Itemid', 0 );

		$query1 = "SELECT p.id, p.title"
		."\nFROM #__poll_menu AS pm, #__polls AS p"
		."\nWHERE (pm.menuid='$Itemid' OR pm.menuid='0') AND p.id=pm.pollid"
		."\nAND p.published=1";

		$database->setQuery( $query1 );
		$polls = $database->loadObjectList();

		if($database->getErrorNum()) {
			echo "MB ".$database->stderr(true);
			return;
		}

		foreach ($polls as $poll) {
			if ($poll->id && $poll->title) {

				$query = "SELECT id, text FROM #__poll_data"
				. "\nWHERE pollid='$poll->id' AND text <> ''"
				. "\nORDER BY id";
				$database->setQuery($query);

				if(!($options = $database->loadObjectList())) {
					echo "MD ".$database->stderr(true);
					return;
				}
				poll_vote_form_html( $poll, $options, $Itemid );
			}
		}
	}

	function poll_vote_form_html( &$poll, &$options, $Itemid ) {
		$tabclass_arr=array("sectiontableentry2","sectiontableentry1");
		$tabcnt = 0;
		?>
		<form name="form2" method="post" action="<?php echo sefRelToAbs("index.php?option=com_poll&amp;Itemid=$Itemid"); ?>">
		<table width="95%" border="0" cellspacing="0" cellpadding="1" align="center">
			<tr>
			  <td colspan="2" class="poll"><b><?php echo $poll->title; ?></b></td>
			</tr>
			<tr>
			  <td align="center">
			  <table class='pollstableborder' cellspacing='0' cellpadding='0' border='0'>
		<?php
		for ($i=0, $n=count( $options ); $i < $n; $i++) { ?>
			<tr>
			  <td class='<?php echo $tabclass_arr[$tabcnt]; ?>' valign="top"><input type="radio" name="voteid" id="voteid<?php echo $options[$i]->id;?>" value="<?php echo $options[$i]->id;?>" alt="<?php echo $options[$i]->id;?>" /></td>
			  <td class='<?php echo $tabclass_arr[$tabcnt]; ?>' valign="top"><label for="voteid<?php echo $options[$i]->id;?>"><?php echo $options[$i]->text; ?></label></td>
			</tr>
			<?php
			if ($tabcnt == 1){
				$tabcnt = 0;
			} else {
				$tabcnt++;
			}
		}
		?>
			  </table>
			  </td>
			</tr>
			<tr>
			  <td colspan="2" align="center">
			  <input type="submit" name="task_button" class="button" value="<?php echo _BUTTON_VOTE; ?>" />&nbsp;&nbsp;
			  <input type="button" name="option" class="button" value="<?php echo _BUTTON_RESULTS; ?>" onclick="document.location.href='<?php echo sefRelToAbs("index.php?option=com_poll&amp;task=results&amp;id=$poll->id"); ?>';" />
			  </td>
			</tr>
		</table>
		<input type="hidden" name="id" value="<?php echo $poll->id;?>" />
		<input type="hidden" name="task" value="vote" />
		</form>
	<?php
	}
}
show_poll_vote_form( $Itemid );
?>
