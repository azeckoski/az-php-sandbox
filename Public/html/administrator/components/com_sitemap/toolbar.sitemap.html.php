<?php

defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

class MENU_sitemap {

	function CONFIG_MENU() {

		mosMenuBar::startTable();
		mosMenuBar::spacer();
		mosMenuBar::saveedit();
		mosMenuBar::cancel();
		mosMenuBar::spacer();
		mosMenuBar::endTable();
	}

	function DEFAULT_MENU() {

		mosMenuBar::startTable();
		mosMenuBar::spacer();
		mosMenuBar::back();
		mosMenuBar::spacer();
		mosMenuBar::endTable();
	}
}
?>
