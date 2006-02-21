<?php
/**
* @version $Id: mod_search.php,v 1.5 2005/01/15 07:47:12 stingrey Exp $
* @package Mambo
* @copyright (C) 2000 - 2005 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

$button			= $params->get( 'button', '' );
$button_pos		= $params->get( 'button_pos', 'left' );
$button_text	= $params->get( 'button_text', _SEARCH_TITLE );
$width 			= intval( $params->get( 'width', 20 ) );
$text 			= $params->get( 'text', _SEARCH_BOX );
$moduleclass_sfx 	= $params->get( 'moduleclass_sfx' );

$output = '<input alt="search" class="inputbox'. $moduleclass_sfx .'" type="text" name="searchword" size="'. $width .'" value="'. $text .'"  onblur="if(this.value==\'\') this.value=\''. $text .'\';" onfocus="if(this.value==\''. $text .'\') this.value=\'\';" />';

if ( $button ) {
	$button = '<input type="submit" value="'. $button_text .'" class="button'. $moduleclass_sfx .'"/>';
}

switch ( $button_pos ) {
	case 'top':
		$button = $button .'<br/>';
		$output = $button . $output;
		break;
		
	case 'bottom':
		$button =  '<br/>'. $button;
		$output = $output . $button;
		break;
		
	case 'right':
		$output = $output . $button;
		break;

	case 'left':
	default:
		$output = $button . $output;
		break;
}
?>


<FORM method=GET action="http://www.google.com/u/sakaiproject" target="_blank">
        <tr><td align="center">
   		<INPUT TYPE="text\" name=\"q\" size=\"15\" maxlength=\"255\" value=\"\"><br>
   		 <INPUT type="submit\" name=\"sa\" value=\"go\">

</form>
</div>
