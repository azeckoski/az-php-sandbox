<?php
/**
* @version $Id: admin.config.php,v 1.4 2005/11/25 23:30:20 csouza Exp $
* @package Mambo
* @subpackage Config
* @copyright (C) 2000 - 2005 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

if (!$acl->acl_check( 'administration', 'config', 'users', $my->usertype )) {
	mosRedirect( 'index2.php', _NOT_AUTH );
}

/**
* @package Mambo
* @subpackage Config
*/
class mosConfig extends mosDBTable {
	/** @var int */
	var $config_offline=null;
	/** @var string */
	var $config_host=null;
	/** @var string */
	var $config_user=null;
	/** @var string */
	var $config_password=null;
	/** @var string */
	var $config_db=null;
	/** @var string */
	var $config_dbprefix=null;
	/** @var string */
	var $config_lang=null;
	/** @var string */
	var $config_path=null;
	/** @var string */
	var $config_live_site=null;
	/** @var string */
	var $config_sitename=null;
	/** @var int */
	var $config_auth=null;
	/** @var int */
	var $config_lifetime=null;
	/** @var string */
	var $config_offline_message=null;
	/** @var string */
	var $config_error_message=null;
	/** @var int */
	var $config_useractivation=null;
	/** @var int */
	var $config_uniquemail=null;
	/** @var string */
	var $config_metadesc=null;
	/** @var string */
	var $config_metakeys=null;
	/** @var int */
	var $config_metaauthor=null;
	/** @var int */
	var $config_metatitle=null;
	/** @var int */
	var $config_debug=0;
	/** @var string */
	var $config_locale=null;
	/** @var int */
	var $config_offset=null;
	/** @var int */
	var $config_hideauthor=null;
	/** @var int */
	var $config_hidecreate=null;
	/** @var int */
	var $config_hidemodify=null;
	/** @var int */
	var $config_hidepdf=null;
	/** @var int */
	var $config_hideprint=null;
	/** @var int */
	var $config_hideemail=null;
	/** @var int */
	var $config_enable_log_items=null;
	/** @var int */
	var $config_enable_log_searches=null;
	/** @var int */
	var $config_enable_stats=null;
	/** @var int */
	var $config_sef=0;
	/** @var int */
	var $config_vote=0;
	/** @var int */
	var $config_gzip=0;
	/** @var int */
	var $config_multipage_toc=0;
	/** @var int */
	var $config_allowUserRegistration=0;
	/** @var int */
	var $config_error_reporting=0;
	/** @var int */
	var $config_register_globals=0;
	/** @var int */
	var $config_link_titles=0;
	/** @var int */
	var $config_list_limit=0;
	/** @var int */
	var $config_caching=0;
	/** @var string */
	var $config_cachepath=null;
	/** @var string */
	var $config_cachetime=null;
	/** @var string */
	var $config_mailer=null;
	/** @var string */
	var $config_mailfrom=null;
	/** @var string */
	var $config_fromname=null;
	/** @var string */
	var $config_sendmail='/usr/sbin/sendmail';
	/** @var string */
	var $config_smtpauth=0;
	/** @var string */
	var $config_smtpuser=null;
	/** @var string */
	var $config_smtppass=null;
	/** @var string */
	var $config_smtphost=null;
	/** @var string */
	var $_alias=null;
	/** @var int */
	var $config_back_button=0;
	/** @var int */
	var $config_item_navigation=0;
	/** @var int */
	var $config_ml_support=0;
	/** @var string */
	var $config_secret=null;
	/** @var int */
	var $config_pagetitles=1;
	/** @var int */
	var $config_readmore=1;
	/** @var int */
	var $config_hits=1;
	/** @var int */
	var $config_icons=1;
	/** @var string */
	var $config_favicon=null;
	/** @var string */
	var $config_fileperms='0644';
	/** @var string */
	var $config_dirperms='0755';
	/** @var string */
	var $config_helpurl='';

	function mosConfig() {
		$this->_alias = array(
		'config_offline'				=>'mosConfig_offline',
		'config_host'					=>'mosConfig_host',
		'config_user'					=>'mosConfig_user',
		'config_password'				=>'mosConfig_password',
		'config_db'						=>'mosConfig_db',
		'config_dbprefix'				=>'mosConfig_dbprefix',
		'config_lang'					=>'mosConfig_lang',
		'config_path'					=>'mosConfig_absolute_path',
		'config_live_site'				=>'mosConfig_live_site',
		'config_sitename'				=>'mosConfig_sitename',
		'config_auth'					=>'mosConfig_shownoauth',
		'config_useractivation'			=>'mosConfig_useractivation',
		'config_uniquemail'				=>'mosConfig_uniquemail',
		'config_offline_message'		=>'mosConfig_offline_message',
		'config_error_message'			=>'mosConfig_error_message',
		'config_debug' 					=>'mosConfig_debug',
		'config_lifetime'				=>'mosConfig_lifetime',
		'config_metadesc'				=>'mosConfig_MetaDesc',
		'config_metakeys'				=>'mosConfig_MetaKeys',
		'config_metaauthor'				=>'mosConfig_MetaAuthor',
		'config_metatitle'				=>'mosConfig_MetaTitle',
		'config_locale'					=>'mosConfig_locale',
		'config_offset'					=>'mosConfig_offset',
		'config_hideauthor'				=>'mosConfig_hideAuthor',
		'config_hidecreate'				=>'mosConfig_hideCreateDate',
		'config_hidemodify'				=>'mosConfig_hideModifyDate',
		'config_hidepdf'				=>'mosConfig_hidePdf',
		'config_hideprint'				=>'mosConfig_hidePrint',
		'config_hideemail'				=>'mosConfig_hideEmail',
		'config_enable_log_items'		=>'mosConfig_enable_log_items',
		'config_enable_log_searches'	=>'mosConfig_enable_log_searches',
		'config_enable_stats' 			=>'mosConfig_enable_stats',
		'config_sef'					=>'mosConfig_sef',
		'config_vote'					=>'mosConfig_vote',
		'config_gzip'					=>'mosConfig_gzip',
		'config_multipage_toc'			=>'mosConfig_multipage_toc',
		'config_allowUserRegistration'	=>'mosConfig_allowUserRegistration',
		'config_link_titles'			=>'mosConfig_link_titles',
		'config_error_reporting'		=>'mosConfig_error_reporting',
		'config_register_globals'		=>'mosConfig_register_globals',
		'config_list_limit'				=>'mosConfig_list_limit',
		'config_caching'				=>'mosConfig_caching',
		'config_cachepath'				=>'mosConfig_cachepath',
		'config_cachetime'				=>'mosConfig_cachetime',
		'config_mailer' 				=>'mosConfig_mailer',
		'config_mailfrom' 				=>'mosConfig_mailfrom',
		'config_fromname' 				=>'mosConfig_fromname',
		'config_sendmail' 				=>'mosConfig_sendmail',
		'config_smtpauth' 				=>'mosConfig_smtpauth',
		'config_smtpuser' 				=>'mosConfig_smtpuser',
		'config_smtppass' 				=>'mosConfig_smtppass',
		'config_smtphost' 				=>'mosConfig_smtphost',
		'config_back_button' 			=>'mosConfig_back_button',
		'config_item_navigation' 		=>'mosConfig_item_navigation',
		'config_secret' 				=>'mosConfig_secret',
		'config_pagetitles' 			=>'mosConfig_pagetitles',
		'config_readmore' 				=>'mosConfig_readmore',
		'config_hits' 					=>'mosConfig_hits',
		'config_icons' 					=>'mosConfig_icons',
		'config_favicon' 				=>'mosConfig_favicon',
		'config_fileperms' 				=>'mosConfig_fileperms',
		'config_dirperms' 				=>'mosConfig_dirperms',
		'config_ml_support'				=>'mosConfig_mbf_content',
		'config_helpurl' 				=>'mosConfig_helpurl'
		);
	}

	function getVarText() {
		$txt = '';
		foreach ($this->_alias as $k=>$v) {
			$txt .= "\$$v = '".addslashes( $this->$k )."';\n";
		}
		return $txt;
	}

	function bindGlobals() {
		foreach ($this->_alias as $k=>$v) {
			if(isset($GLOBALS[$v]))
				$this->$k = $GLOBALS[$v];
		}
	}
}

require_once( str_replace('\\','/',dirname(__FILE__)) . '/admin.config.html.php' );
$confightml = new HTML_config();


switch ( $task ) {
	case 'apply':
	case 'save':
		saveconfig( $task );
		break;

	case 'cancel':
		mosRedirect( 'index2.php' );
		break;

	default:
		showconfig($confightml, $database, $option);
		break;
}


function showconfig($confightml, &$database, $option) {
	global $database, $mosConfig_absolute_path;
	$row = new mosConfig();
	$row->bindGlobals();

	// compile list of the languages
	$langs = array();
	$menuitems = array();

	if ($handle=opendir( "$mosConfig_absolute_path/language/" )) {
		$i=0;
		while (false !== ($file = readdir($handle))) {
			if (!strcasecmp(substr($file,-4),".php") && $file <> "." && $file <> ".." && strcasecmp(substr($file,-11),".ignore.php")) {
				$langs[] = mosHTML::makeOption( substr($file,0,-4) );
			}
		}
	}

	// sort list of languages
	sort($langs);
	reset($langs);

	// compile list of the editors
	$query = "SELECT id AS value, name AS text"
	. "\n FROM #__mambots"
	. "\n WHERE folder='editors' AND published >= 0"
	. "\n ORDER BY ordering, name"
	;
	$database->setQuery( $query );
	$edits = $database->loadObjectList();

	$query = "SELECT id"
	. "\n FROM #__mambots"
	. "\n WHERE folder='editors' AND published = 1"
	. "\n LIMIT 1"
	;
	$database->setQuery( $query );
	$editor = $database->loadResult();

	$lists = array();
	// build the html select list
	$lists['editor'] = mosHTML::selectList( $edits, 'editor', 'class="inputbox" size="1"', 'value', 'text', $editor );

	// build the html select list
	$lists['lang'] = mosHTML::selectList( $langs, 'config_lang', 'class="inputbox" size="1"', 'value', 'text', $row->config_lang );
	// make a generic -24 - 24 list
	for ($i=-24;$i<=24;$i++) {
		$timeoffset[] = mosHTML::makeOption( $i, $i );
	}

	// get list of menuitems
	$query = "SELECT id AS value, name AS text FROM #__menu"
	. "\n WHERE (type='content_section' OR type='components' OR type='content_typed')"
	. "\n AND published=1"
	. "\n AND access=0"
	. "\n ORDER BY name"
	;
	$database->setQuery( $query );
	$menuitems = array_merge( $menuitems, $database->loadObjectList() );

	$show_hide = array(
		mosHTML::makeOption( 1, 'Hide' ),
		mosHTML::makeOption( 0, 'Show' ),
	);

	$show_hide_r = array(
		mosHTML::makeOption( 0, 'Hide' ),
		mosHTML::makeOption( 1, 'Show' ),
	);

	$list_length = array(
		mosHTML::makeOption( 5, 5 ),
		mosHTML::makeOption( 10, 10 ),
		mosHTML::makeOption( 15, 15 ),
		mosHTML::makeOption( 20, 20 ),
		mosHTML::makeOption( 25, 25 ),
		mosHTML::makeOption( 30, 30 ),
		mosHTML::makeOption( 50, 50 ),
	);

	$errors = array(
		mosHTML::makeOption( -1, 'System Default' ),
		mosHTML::makeOption( 0, 'None' ),
		mosHTML::makeOption( E_ERROR|E_WARNING|E_PARSE, 'Simple' ),
		mosHTML::makeOption( E_ALL , 'Maximum' )
	);

	$register_globals = array(
		mosHTML::makeOption( 1, 'On' ),
		mosHTML::makeOption( 0, 'Off' ),
	);

	$mailer = array(
		mosHTML::makeOption( 'mail', 'PHP mail function', true ),
		mosHTML::makeOption( 'sendmail', 'Sendmail', true ),
		mosHTML::makeOption( 'smtp', 'SMTP Server', true )
	);

	// build the html select lists
	$lists['offline'] 				= mosHTML::yesnoRadioList( 'config_offline', 'class="inputbox"', $row->config_offline );

	$lists['auth'] 					= mosHTML::yesnoRadioList( 'config_auth', 'class="inputbox"', $row->config_auth );

	$lists['metaauthor']			= mosHTML::yesnoRadioList( 'config_metaauthor', 'class="inputbox"', $row->config_metaauthor );

	$lists['metatitle'] 			= mosHTML::yesnoRadioList( 'config_metatitle', 'class="inputbox"', $row->config_metatitle );

	$lists['useractivation'] 		= mosHTML::yesnoRadioList( 'config_useractivation', 'class="inputbox"',	$row->config_useractivation );

	$lists['uniquemail'] 			= mosHTML::yesnoRadioList( 'config_uniquemail', 'class="inputbox"',	$row->config_uniquemail );

	$lists['allowuserregistration'] = mosHTML::yesnoRadioList( 'config_allowUserRegistration', 'class="inputbox"',	$row->config_allowUserRegistration );

	$lists['debug'] 				= mosHTML::yesnoRadioList( 'config_debug', 'class="inputbox"', $row->config_debug );

	$lists['offset'] 				= mosHTML::selectList( $timeoffset, 'config_offset', 'class="inputbox" size="1"',	'value', 'text', $row->config_offset );

	$lists['hideauthor'] 			= mosHTML::RadioList( $show_hide, 'config_hideauthor', 'class="inputbox"', $row->config_hideauthor, 'value', 'text' );

	$lists['hidecreate'] 			= mosHTML::RadioList( $show_hide, 'config_hidecreate', 'class="inputbox"', $row->config_hidecreate, 'value', 'text' );

	$lists['hidemodify'] 			= mosHTML::RadioList( $show_hide, 'config_hidemodify', 'class="inputbox"', $row->config_hidemodify, 'value', 'text' );

	if (is_writable( "$mosConfig_absolute_path/media/" )) {
		$lists['hidepdf'] 			= mosHTML::RadioList( $show_hide, 'config_hidepdf', 'class="inputbox"', $row->config_hidepdf, 'value', 'text' );
	} else {
		$lists['hidepdf'] 			= '<input type="hidden" name="config_hidepdf" value="1" /><strong>Yes</strong>';
	}

	$lists['hideprint'] 			= mosHTML::RadioList( $show_hide, 'config_hideprint', 'class="inputbox"', $row->config_hideprint, 'value', 'text' );

	$lists['hideemail'] 			= mosHTML::RadioList( $show_hide, 'config_hideemail', 'class="inputbox"', $row->config_hideemail, 'value', 'text' );

	$lists['log_items']	 			= mosHTML::yesnoRadioList( 'config_enable_log_items', 'class="inputbox"', $row->config_enable_log_items );

	$lists['log_searches'] 			= mosHTML::yesnoRadioList( 'config_enable_log_searches', 'class="inputbox"', $row->config_enable_log_searches );

	$lists['enable_stats'] 			= mosHTML::yesnoRadioList( 'config_enable_stats', 'class="inputbox"', $row->config_enable_stats );

	$lists['sef'] 					= mosHTML::yesnoRadioList( 'config_sef', 'class="inputbox" onclick="javascript: if (document.adminForm.config_sef[1].checked) { alert(\'Remember to rename htaccess.txt to .htaccess\') }"', $row->config_sef );

	$lists['vote'] 					= mosHTML::RadioList( $show_hide_r, 'config_vote', 'class="inputbox"', $row->config_vote, 'value', 'text' );

	$lists['gzip'] 					= mosHTML::yesnoRadioList( 'config_gzip', 'class="inputbox"', $row->config_gzip );

	$lists['multipage_toc'] 		= mosHTML::RadioList( $show_hide_r, 'config_multipage_toc', 'class="inputbox"', $row->config_multipage_toc, 'value', 'text' );

	$lists['pagetitles'] 			= mosHTML::yesnoRadioList( 'config_pagetitles', 'class="inputbox"', $row->config_pagetitles );

	$lists['error_reporting'] 		= mosHTML::selectList( $errors, 'config_error_reporting', 'class="inputbox" size="1"', 'value', 'text', $row->config_error_reporting );

	$lists['register_globals'] 		= mosHTML::RadioList( $register_globals, 'config_register_globals', 'class="inputbox" size="1"', $row->config_register_globals, 'value', 'text' );

	$lists['link_titles'] 			= mosHTML::yesnoRadioList( 'config_link_titles', 'class="inputbox"', $row->config_link_titles );

	$lists['caching'] 				= mosHTML::yesnoRadioList( 'config_caching', 'class="inputbox"', $row->config_caching );

	$lists['mailer'] 				= mosHTML::selectList( $mailer, 'config_mailer', 'class="inputbox" size="1"', 'value', 'text', $row->config_mailer );

	$lists['smtpauth'] 				= mosHTML::yesnoRadioList( 'config_smtpauth', 'class="inputbox"', $row->config_smtpauth );

	$lists['list_length'] 			= mosHTML::selectList( $list_length, 'config_list_limit', 'class="inputbox" size="1"', 'value', 'text', ( $row->config_list_limit ? $row->config_list_limit : 50 ) );

	$lists['back_button'] 			= mosHTML::RadioList( $show_hide_r, 'config_back_button', 'class="inputbox"', $row->config_back_button, 'value', 'text' );

	$lists['item_navigation'] 		= mosHTML::RadioList( $show_hide_r, 'config_item_navigation', 'class="inputbox"', $row->config_item_navigation, 'value', 'text' );

	$lists['ml_support'] 			= mosHTML::yesnoRadioList( 'config_ml_support', 'class="inputbox" onclick="javascript: if (document.adminForm.config_ml_support[1].checked) { alert(\'Remember to install the MambelFish component.\') }"', $row->config_ml_support );

	$lists['readmore'] 				= mosHTML::RadioList( $show_hide_r, 'config_readmore', 'class="inputbox"', $row->config_readmore, 'value', 'text' );

	$lists['hits'] 					= mosHTML::RadioList( $show_hide_r, 'config_hits', 'class="inputbox"', $row->config_hits, 'value', 'text' );

	$lists['icons'] 				= mosHTML::RadioList( $show_hide_r, 'config_icons', 'class="inputbox"', $row->config_icons, 'value', 'text' );

//	$lists['favicon'] 				= mosHTML::RadioList( $show_hide_r, 'config_icons', 'class="inputbox"', $row->config_icons, 'value', 'text' );

	$confightml->showconfig( $row, $lists, $option );
}

function saveconfig( $task ) {
	global $database, $mosConfig_absolute_path;

	$row = new mosConfig();
	if (!$row->bind( $_POST )) {
		mosRedirect( "index2.php", $row->getError() );
	}
	
	$editor = intval( mosGetParam( $_POST, 'editor', 0 ) );
	if ($editor > 0) {
		$query = "UPDATE #__mambots"
	    . "\n SET published = 0"
	    . "\n WHERE published >= 0 AND folder='editors'"
		;
		$database->setQuery( $query );
		$database->query() or die( $database->getErrorMsg() );

		$query = "UPDATE #__mambots"
	    . "\n SET published = 1"
	    . "\n WHERE id = $editor"
		;
		$database->setQuery( $query );
		$database->query() or die( $database->getErrorMsg() );
	}

	$config = "<?php \n";
	$config .= $row->getVarText();
	$config .= "setlocale (LC_TIME, \$mosConfig_locale);\n";
	$config .= '?>';

	$fname = '../configuration.php';
    $enable_write = mosGetParam($_POST,'enable_write',0);
	$oldperms = fileperms($fname);
	if ($enable_write) @chmod($fname, $oldperms | 0222);
	if ( $fp = fopen($fname, 'w') ) {
		fputs($fp, $config, strlen($config));
		fclose($fp);
		if ($enable_write) {
			@chmod($fname, $oldperms);
		} else {
			if (mosGetParam($_POST,'disable_write',0))
				@chmod($fname, $oldperms & 0777555);
		} // if

		$msg = 'The Configuration Details have been updated';

	    // apply file and directory permissions if requested by user
	    $applyFilePerms = mosGetParam($_POST,'applyFilePerms',0) && $row->config_fileperms!='';
	    $applyDirPerms = mosGetParam($_POST,'applyDirPerms',0) && $row->config_dirperms!='';
	    if ($applyFilePerms || $applyDirPerms) {
	        $mosrootfiles = array(
	            'administrator',
	            'cache',
	            'components',
	            'editor',
	            'help',
	            'images',
	            'includes',
	            'installation',
	            'language',
	            'mambots',
	            'media',
	            'modules',
	            'templates',
	            'CHANGELOG',
	            'configuration.php-dist',
	            'configuration.php',
	            'globals.php',
	            'htaccess.txt',
	            'index.php',
	            'index2.php',
	            'INSTALL',
	            'LICENSE',
	            'mainbody.php',
	            'offline.php',
	            'pathway.php',
	            'robots.txt'
	        );
	        $filemode = NULL;
	        if ($applyFilePerms) $filemode = octdec($row->config_fileperms);
	        $dirmode = NULL;
	        if ($applyDirPerms) $dirmode = octdec($row->config_dirperms);
	        foreach ($mosrootfiles as $file)
	            mosChmodRecursive($mosConfig_absolute_path.'/'.$file, $filemode, $dirmode);
	    } // if

		switch ( $task ) {
			case 'apply':
				mosRedirect( 'index2.php?option=com_config&hidemainmenu=1', $msg );
				break;

			case 'save':
			default:
				mosRedirect( 'index2.php', $msg );
				break;
		}
	} else {
		if ($enable_write) @chmod($fname, $oldperms);
		mosRedirect( 'index2.php', 'An Error Has Occurred! Unable to open config file to write!' );
	}
}
?>