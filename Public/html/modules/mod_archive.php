<?php
/**
* @version $Id: mod_archive.php,v 1.1 2005/07/22 01:58:29 eddieajau Exp $
* @package Mambo
* @copyright (C) 2000 - 2005 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

global $mosConfig_offset;

$count 				= intval( $params->def( 'count', 10 ) );
$moduleclass_sfx 	= $params->get( 'moduleclass_sfx' ); 
$now 				= date( 'Y-m-d H:i:s', time() + $mosConfig_offset * 60 * 60 );

$query = "SELECT MONTH(created) AS created_month, created, id, sectionid, title, YEAR(created) AS created_year"
. "\n FROM #__content"
. "\n WHERE ( state='-1' AND checked_out='0' AND sectionid > '0' )"
. "\n GROUP BY created_year DESC, created_month DESC LIMIT $count";
$database->setQuery( $query );
$rows = $database->loadObjectList();
?>
<ul>
<?php
foreach ( $rows as $row ) {
	$created_month 	= mosFormatDate ( $row->created, "%m" );
	$month_name 	= mosFormatDate ( $row->created, "%B" );
	$created_year 	= mosFormatDate ( $row->created, "%Y" );
	$link			= sefRelToAbs( 'index.php?option=com_content&amp;task=archivecategory&amp;year='. $created_year .'&amp;month='. $created_month .'&amp;module=1' );
	$text			= $month_name .', '. $created_year;
	?>
	<li>
	<a href="<?php echo $link; ?>">
	<?php echo $text; ?>
	</a>
	</li>
	<?php
}
?>
</ul>
