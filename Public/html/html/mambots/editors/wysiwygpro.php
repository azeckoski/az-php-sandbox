<?php
/* WYSIWYGPRO EDITOR PLUG-IN */

/* (C) Copyright Chris Bolt 2004 */


/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

$_MAMBOTS->registerFunction( 'onInitEditor', 'botWysiwygProEditorInit' );
$_MAMBOTS->registerFunction( 'onGetEditorContents', 'botWysiwygProEditorGetContents' );
$_MAMBOTS->registerFunction( 'onEditorArea', 'botWysiwygProEditorEditorArea' );

/**
* WYSIWYGPRO Editor - WysiwygPro doesn't need javascript initialisation, instead we add css modifications and do some JS stuff to fix compatability issues between WP and mambo.
*/
function botWysiwygProEditorInit() {
global $mosConfig_live_site;
// this fixes a bug were WP doesn't expand to 100% of available space in some templates.
// also fixes a problem where the context menu appears in the wrong place when viewing the events 1.2 component in Firefox
echo "<style type=\"text/css\">
@import url(".$mosConfig_live_site."/mambots/editors/wysiwygpro/editor_theme.css);
table.adminform {width: 100%;}
.adminForm {width: 100%;}
.pagetext {position:static}
</style>";
// this fixes a script conflict between an overlib function name and an IE native window object function of the same name.
echo "<script type=\"text/javascript\">
if (window.createPopup) var wp_oPopUp = window.createPopup();
</script>";
}
/**
* WYSIWYGPRO Editor - copy editor contents to form field
* @param string The name of the editor area
* @param string The name of the form field
*/
function botWysiwygProEditorGetContents( $editorArea, $hiddenField ) {
	$hiddenField = preg_replace("/[^A-Za-z0-9_]/smi", '', $hiddenField);
	echo "
	try {
		if (".$hiddenField.") {
			".$hiddenField.".updateHTML();
		}
	} catch (e) {}
	";
}


/**
* WYSIWYGPRO Editor - display the editor
* @param string The name of the editor area
* @param string The content of the field
* @param string The name of the form field
* @param string The width of the editor area
* @param string The height of the editor area
* @param int The number of columns for the editor area
* @param int The number of rows for the editor area
*/
function botWysiwygProEditorEditorArea( $name, $content, $hiddenField, $width, $height, $col, $row ) {
	
	// error_reporting ( E_ALL );
	
	// dirty hack to fix bad context menu positioning in events component 1.2 front end with Firefox
	// also fixes browser crash in older Mozilla/Firebird releases
	echo "<style type=\"text/css\">
.pagetext {position:static}
#page1 {display:block}
#ev_page1 {display:block}
</style>";
	
	global $mosConfig_live_site, $mosConfig_absolute_path, $mosConfig_dirperms, $mosConfig_fileperms, $mosConfig_sef, $mainframe, $database, $_MAMBOTS;

	// Includes, and install check
	if (!include_once ($mosConfig_absolute_path.'/mambots/editors/wysiwygpro/config.php')) {
exit ('<strong>WysiwygPro Mambot setup error:</strong> Please copy the <strong>editor_files</strong> folder into <strong>[mambo installation directory]/mambots/editors/</strong> and then renamed the folder to "wysiwygpro".<br />
Then copy the special config.php file into this folder over-writing the original config.php file. The special config.php file can be found in your WysiwygPro zip package in Goodies/Mambo/');
	}
	if (!defined('WP_MAMBOT_CONFIG')) {
exit ('<strong>WysiwygPro Mambot setup error:</strong> Please copy the special config.php file into <strong>[mambo installation directory]/mambots/editors/wysiwygpro/</strong> over-writing the original config.php file. The special config.php file can be found in your WysiwygPro zip package in Goodies/Mambo/');
	}
	
	include_once ($mosConfig_absolute_path.'/mambots/editors/wysiwygpro/editor_class.php');
	
	if (!isset($wp_live_site)) {
		$wp_live_site = preg_replace('/^http(|s):\/\/[^\/]+/smi', '', $mosConfig_live_site);
	}
	// load paramaters
	
	// load WysiwygPro mambot configuration
	static $mambot = NULL;
	static $params = NULL;
	if ($mambot == NULL || $params == NULL) {
		$query = "SELECT id FROM #__mambots WHERE element = 'WysiwygPro' AND folder = 'editors'";
		$database->setQuery( $query );
		$id = $database->loadResult();
		$mambot = new mosMambot( $database );
		$mambot->load($id);
		$params = & new mosParameters($mambot->params);
	}
	
	/*
	if ($params->get( 'cache', '' )) {
		$cacheid = 'WP_'.md5($name.$hiddenField.$width.$height.$col.$row);
	} else {
		$cacheid = '';
	}
	// create WP class:
	$editor = new wysiwygPro($cacheid);*/
	$editor = new wysiwygPro();
 
 	if ($editor->has_expired) {	
		
		// WP Configuration
		//--> DO NOT CHANGE WP CONFIG IN THIS FILE
		//--> DO NOT CHANGE WP CONFIG IN THIS FILE
		// If you do you may loose configuration through the mambot control panel.
		
		// set name
		$editor->set_name($hiddenField);
		
		// record first instance of WP on page for later
		static $first_editor = '';
		if (empty($first_editor)) {
			$first_editor = $editor->name;
		}
		
		// work out stylesheet path, if in admin we can't use mainframe here 'cause we always want the frontend template not the admin one.
		if ($styles = $params->get( 'stylesheet', '' )) {
			$stylesheet = $styles;
		} else {
			static $template = '';
			if (empty($template)) {
				// are we in administrator?
				if (strstr($_SERVER['PHP_SELF'], '/administrator/')) {
					$query = "SELECT template FROM #__templates_menu WHERE client_id = '0'";
					$database->setQuery( $query );
					$template = $database->loadResult();
				} else {
					$template = $mainframe->getTemplate();
				}
			}
			$stylesheet = $mosConfig_live_site.'/templates/'.$template.'/css/template_css.css';
		}
		$editor->set_stylesheet($stylesheet);
		
		// image manager
		if (!$styles = $params->get( 'image_manager', 1 )) {
			$editor->disableimgmngr();
		}
		
		// color swatches
		if ($values = $params->get( 'colors', '' )) {
			$editor->set_color_swatches($values);
		}
		
		// set menus
		
		// format menu
		if ($values = $params->get( 'formats', '' )) {
			$values = explode(',', $values);
			$array = array();
			$num = count($values);
			for ($i=0; $i<$num; $i++) {
				switch(strtolower(trim($values[$i]))) {
					case 'p':
						$v = '##normal## (p)';
						break;
					case 'div':
						$v = '##normal## (div)';
						break;
					case 'h1':
						$v = '##heading_1##';
						break;
					case 'h2':
						$v = '##heading_2##';
						break;
					case 'h3':
						$v = '##heading_3##';
						break;
					case 'h4':
						$v = '##heading_4##';
						break;
					case 'h5':
						$v = '##heading_5##';
						break;
					case 'h6':
						$v = '##heading_6##';
						break;
					case 'pre':
						$v = '##pre_formatted##';
						break;
					case 'address':
						$v = '##address1##';
						break;
					default:
						$v = $values[$i];
						break;
				}
				$array[$values[$i]] = $v;
			}
			$editor->set_formatmenu($array);
		}
		
		// font menu
		if ($values = $params->get( 'fonts', '' )) {
			$editor->set_fontmenu($values);
		}
		
		// class menu
		if ($values = $params->get( 'classes', '' )) {
			$values = explode(',', $values);
			$array = array();
			$num = count($values);
			for ($i=0; $i<$num; $i++) {
				$array[$values[$i]] = $values[$i];
			}
			$editor->set_classmenu($array);
		}
		
		// size menu
		if ($values = $params->get( 'sizes', '' )) {
			$values = explode(',', $values);
			$array = array();
			$num = count($values);
			for ($i=0; $i<$num; $i++) {
				$array[$values[$i]] = $values[$i];
			}
			$editor->set_sizemenu($array);
		}
		
		// remove buttons
		static $deadbuttons = array();
		if (empty($deadbuttons)) {
			$definitions = array('toolbar1','toolbar2','tab','html','preview','print','find','spacer1','pasteword','spacer2','undo','redo','spacer3','tbl','edittable','spacer4','image','smiley','ruler','link','document','bookmark','special','format','font','size','spacer5','bold','italic','underline','spacer6','left','center','right','full','spacer7','ol','ul','indent','outdent','spacer8','color','highlight');
			$num = count($definitions);
			for ($i=0; $i<$num; $i++) {
				if (!$params->get( $definitions[$i], 1 )) {
					array_push($deadbuttons, $definitions[$i]);
				}
			}
		}
		$editor->removebuttons(implode(',',$deadbuttons));
		
		// build links menu
		if ($params->get( 'content_links', 1)) {
			static $links = array();
			if (empty($links)) {
				// static content...
				$database->setQuery( "SELECT id, title FROM #__content WHERE state = '1' AND sectionid = '0' ORDER BY ordering ASC" );
				$contentItems = $database->loadObjectList();
				$num2 = count($contentItems);
				for ($j=0; $j<$num2; $j++) {
					if ($j==0) {
						array_push($links, array(0, 'folder', 'Static Content') );
					}
					array_push($links, array(1, $mosConfig_live_site.'/index.php?option=content&task=view&id='.$contentItems[$j]->id, $contentItems[$j]->title) );
				}
				// other content...
				$database->setQuery( "SELECT id, title FROM #__sections WHERE published = '1' ORDER BY ordering ASC" );
				$sections = $database->loadObjectList();
				$num = count($sections);
				for ($i=0; $i<$num; $i++) {
					$database->setQuery( "SELECT id, title FROM #__content WHERE state = '1' AND sectionid = '".$sections[$i]->id."' ORDER BY ordering ASC" );
					$contentItems = $database->loadObjectList();
					$num2 = count($contentItems);
					for ($j=0; $j<$num2; $j++) {
						if ($j==0) {
							array_push($links, array(0, 'folder', $sections[$i]->title) );
						}
						array_push($links, array(1, $mosConfig_live_site.'/index.php?option=content&task=view&id='.$contentItems[$j]->id, $contentItems[$j]->title) );
					} 
				}
				$editor->set_links($links);
			}
		}
		
		// build inserts menu
		static $inserts = array();
		if (empty($inserts)) {
				if ( $label = $params->get( 'snippet1_label', '' ) ) {
					$html = $params->get( 'snippet1_html', '' );
					$inserts[$label] = $html;
				}
				if ( $label = $params->get( 'snippet2_label', '' ) ) {
					$html = $params->get( 'snippet2_html', '' );
					$inserts[$label] = $html;
				}
				if ( $label = $params->get( 'snippet3_label', '' ) ) {
					$html = $params->get( 'snippet3_html', '' );
					$inserts[$label] = $html;
				}
				if ( $label = $params->get( 'snippet4_label', '' ) ) {
					$html = $params->get( 'snippet4_html', '' );
					$inserts[$label] = $html;
				}
				if ( $label = $params->get( 'snippet5_label', '' ) ) {
					$html = $params->get( 'snippet5_html', '' );
					$inserts[$label] = $html;
				}
				$editor->set_inserts($inserts);
		}
		if (!empty($inserts) && $editor->name != $first_editor) {
			$editor->set_inserts(array('dummy'=>'dummy'));
		}
		
		// base url
		$editor->set_baseurl($mosConfig_live_site);
		
		// line returns
		$usep = $params->get( 'line_returns', 1 );
		$editor->usep($usep);
		
		// charset and HTML version
		$usexhtml = $params->get( 'html_version', 1 );
		$iso = split( '=', (defined('_ISO') ? _ISO : 'charset=iso-8859-1') );
		$editor->usexhtml($usexhtml,$iso[1]);
		$editor->set_charset($iso[1]);
		
		// Full URLS?
		$fullurls = $params->get( 'full_urls', 1 );
		$editor->usefullurls($fullurls);
		
	}
	// set the editor code:
	$content = str_replace("&lt;", "<", $content);
	$content = str_replace("&gt;", ">", $content);
	$content = str_replace("&amp;", "&", $content);
	//$content = str_replace("&nbsp;", " ", $content);
	$content = str_replace("&quot;", "\"", $content);
	$editor->set_code($content);
	
	// load editor inline to fix "please wait" error in Mambo 4.5.2 with Firefox
	$editor->loadmethod('inline');
	
	// print the editor to the browser:
	if ($params->get( 'fixed_width', 0 )) {
		$width = 615;
	} else {
		$width = '100%';
	}
	$editor->print_editor($width, intval($height)+50);
	
	// mosimage button etc...
	$results = $_MAMBOTS->trigger( 'onCustomEditorButton' );
	$buttons = array();
	foreach ($results as $result) {
			$buttons[] = '<img src="'.$mosConfig_live_site.'/mambots/editors-xtd/'.$result[0].'" onclick="if('.$editor->name.'.html_mode == false)'.$editor->name.'.insertAtSelection(\''.$result[1].'\')" alt="Insert '.$result[1].' Tag" title="Insert '.$result[1].' Tag" />';
	}
	$buttons = implode( "", $buttons );
	echo $buttons;
	
	// load variables from the first editor to save download times
	if ($first_editor != $editor->name) {
		echo '<script type="text/javascript">
	'.$editor->name.'.links = config_'.$first_editor.'.links;
	'.$editor->name.'.custom_inserts = config_'.$first_editor.'.custom_inserts;
</script>';
	}
	
}
?>