<?php
/**
* @version $Id: version.php,v 1.8 2006/05/19 cauld Exp $
* @package Mambo
* @copyright (C) 2000 - 2007 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** Version information */
class version {
	/** @var string Product */
	var $PRODUCT = 'Mambo';
	/** @var int Main Release Level */
	var $RELEASE = '4.5';
	/** @var string Development Status */
	var $DEV_STATUS = 'Stable';
	/** @var int Sub Release Level */
	var $DEV_LEVEL = '5';
	/** @var string Codename */
	var $CODENAME = 'Arpie';
	/** @var string Date */
	var $RELDATE = '2-Feb-2007';
	/** @var string Time */
	var $RELTIME = '10:00';
	/** @var string Timezone */
	var $RELTZ = 'GMT';
	/** @var string Copyright Text */
	var $COPYRIGHT = 'Copyright 2000 - 2007 Mambo Foundation.  All rights reserved.';
	/** @var string URL */
	var $URL = '<a href="http://mambo-foundation.org">Mambo</a> is Free Software released under the GNU/GPL License.';
}
$_VERSION =& new version();

$version = $_VERSION->PRODUCT .' '. $_VERSION->RELEASE .'.'. $_VERSION->DEV_LEVEL .' '
. $_VERSION->DEV_STATUS
.' [ '.$_VERSION->CODENAME .' ] '. $_VERSION->RELDATE .' '
. $_VERSION->RELTIME .' '. $_VERSION->RELTZ;
?>
