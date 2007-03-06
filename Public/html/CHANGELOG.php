<?php
/**
* @version $Id: CHANGELOG.php,v 1.32 2005/11/27 07:06:46 cauld Exp $
* @package Mambo_4.5
* @copyright (C) 2000 - 2004 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

// no direct access
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );
?>

1. Changelog
------------
This is a non-exhaustive (but still near complete) changelog for
Mambo 4.5.x, including beta and release candidate versions.
Our thanks to all those people who've contributed bug reports and
code fixes.

Legend:

# -> Bug Fix
+ -> Addition
! -> Change
- -> Removed
! -> Note

-------------------- 4.5.5 --------------------------------------------------

2-Feb-2007 Chad Auld (cauld)
! Updating changelog & version info
# NineKrit's commit on the 29th was a backport of the com_syndicate config parameters 
fix.  So now just backporting the RSS/SEO fix here as well to allow for SEF friendly 
URLS within the RSS feeds.

29-Jan-2007 Akarawuth Tamrareang (NineKrit)
# Fixed RSS (port from Chad fixed in mambo 4.6.2)

27-Jan-2007 Chad Auld (cauld)
! Adding IE 7 quirks mode to the template index files 
! Updating JSCookMenu to v2.0.3 to help fix some IE7 related issues

26-Jan-2007 Akarawuth Tamrareang (NineKrit)
# Fixed SQL injection in cancel edit functions

-------------------- 4.5.4 --------------------------------------------------

02-Oct-2006 Neil Thompson (neilt)
# security enhancements to fix XSS - FS#95

26-Sept-2006 Chad Auld (cauld) - Applying security changes for an SP3 release
# Adding a getEscaped call for $passwd in the Login function
! Updating mosGetParam to utilize addslashes for added security

31-August-2006 Chad Auld (cauld) - (Special thanks to MamboGuru for some additional security suggestions)
# Adding define( '_VALID_MOS', 1 ) to globals.php
! Updating register globals emulation code to protect against Zend_Hash_Del_Key_Or_Index Vulnerability.
# Updating com_weblinks to escape title and catid prior to query
! Tightening up com_search to limit search to limit search choices
# Fixed vulnerability with "oid" parameter in database.php

30-August-2006 Chad Auld (cauld)
# Fixing security vulnerabilities and releasing 4.5.4 SP2

30-August-2006 Akarawuth Tamrareang (NineKrit)
! include Patch for support Nok Kaew component

23-March-2006 Chad Auld (cauld)
! Found and updated help key reference for all toolbars to use new 454 help files

22-March-2006 Chad Auld (cauld) *Checking in for Ninekrit*
- Removed 453 help files
+ Adding 454 help files
! Updating help file URL to look locally

19-March-2006 Chad Auld (cauld)
! Updated TinyMCE from v2.0.2 to 2.0.6.1 (loads of fixes and enhancements)
! Updated overLIB from 4.06 to 4.21
! Updated "What's New in 4.5.4"

16-May-2006 Akarawuth Tamrareang (NineKrit)
# include 453h security patch1
# Fixed com_trash   
# Low risk RSS feed vulnerability special thank you IrishStevo 
!  update admin_content.php line 201 , 312  for support mysql 5
!  update sample_data.sql
!  Minor bug in Mambo Installation install1.php  
+ add file \installatin\sql\migrate_Joomla108_to_Mambo453.sql

14-March-2006 Chad Auld (cauld)
+ Back porting Mambo 4.6 end user survey functionality for PC World CD release

-------------------- 4.5.3 (Holiday Patch) Release --------------------------

31-Dec-2005 Chad Auld (cauld)
# Fixing PHP 5 related issues with admin.content.php
! Updating credits file
! Adjusting static content editor so it doesn't shift during editing with TinyMCE 2.0.1

31-Dec-2005 Carlos Souza (csouza)
# Replaced inconsistent short open tags that caused parse errors in some php versions

31-Dec-2005 Martin Brampton (counterpoint)
! Modified one line in pathway that was using globals no longer set - changed to super globals

29-Dec-2005 Chanh Ong (cong)
# Fix Parse error: parse error, unexpected '}' in php 5.1

26-Dec-2005 Chad Auld (cauld)
! Making some changes for the TinyMCE 2.0.1 update to handle the default to simple template change
! Updating version.php for release
# Fixing trash so that it is empty after a fresh install with sample data

23-Dec-2005 Chad Auld (cauld)
! Removing experimental Safari warning in TinyMCE
! Updating version.php for holiday patch

22-Dec-2005 Martin Brampton (counterpoint)
# Altered incorrect method for error message on row in admin.section.php
# Added default of null string to params field in mos_section.

21-Dec-2005 Chad Auld (cauld)
! Updating default templates with some minor fixes 
# Fixing some formatting errors on the sample data

21-Dec-2005 Carlos Souza (csouza)
# added session_start() calls to index.php and index2.php

21-Dec-2005 Chanh Ong (cong)
- Revert the change below due to the fix csouza made in index2.php which is better and more secure

20-Dec-2005 Chanh Ong (cong)
# Fix problem where Email icon on content not working where session lost its previous value.

20-Dec-2005 Chad Auld (cauld)
+ Adding 453 to 453h sql patch for TinyMCE 2.0.1 upgrade

19-Dec-2005 Chad Auld (cauld)
# Fixing admin content preview & upload session issue

18-Dec-2005 Chad Auld (cauld)
! Updated the default TinyMCE editor from 1.45 to 2.0.1
+ Added back in the old System Information administrator link

19-Dec-2005 Carlos Souza (csouza)
# Changed register globals emulation to default to 'On'

18-Dec-2005 Martin Brampton(counterpoint)
# Modified SQL statements having LEFT JOIN after list of joined tables
# Modified contact searchbot to set Itemid
# Modified content searchbot to avoid warnings on merge of nulls to arrays
# Modified content component to avoid warnings on merge of nulls to arrays

17-Dec-2005 Martin Brampton (counterpoint)
# Modified index.php to avoid conflict with SMF over $_REQUEST['message']
# Modified admin trash manager to fix failures and lack of page control

16-Dec-2005 Chanh Ong (cong)
# Fix bug that causes the "top" position always overlay other component

-------------------- 4.5.3 Release --------------------------

26-Nov-2005 Chad Auld (cauld)
! Fixed GPL text in install (made all 1 font, easier to read)
- Removed old templates
+ Added new Mambo default template
! Changed more sample data 
! Updated the default setup to fit new template
! Adding setting to default register globals emulation to "On"

24-Nov-2005 Chad Auld (cauld)
! Changed the default on the new admin simple/advanced interface to advanced

23-Nov-2005 Chad Auld (cauld)
! Changed header logos.  Removed references to 4.5.2.
! Updated most of the sample install data
! Update some of the default installation settings
! Changed out the included sample banners, install header banner, and admin header banners
- Removed old sample images no longer in use

23-Nov-2005 Carlos Souza (csouza)
 !  Replaced globals.php and sef.php to address the globals emulation overwrite vulnerability
 +  Added option in com_config to toggle register_globals emulation

16-Nov-2005 Carlos Souza (csouza)
+  Added fix in index*.php to address the Globals overwrite problem in versions < 4.4.1

14-Nov-2005 Ilias Antonopoulos (eliasan)
# Added Vcard option on Contact Items Parameters
  /administrator/components/com_contact/contact_items.xml
# Fixed. Link type, menu items don't show up on Pages/Items List.
  /includes/mambo.php
# Fixed. Empty Categories don't show up, although 'Show Empty Categories' is selected on a Table-Content Section menu Item
  /components/com_content/content.php
! 'List - Content Section' corrected to 'Table - Content Section'
  /administrator/components/com_menus/content_section/content_section.menu.html.php

13-Nov-2005 Chad Auld (cauld)
! Updated install screens to display 453 and release dates.  
! Changed the newsflash articles included with the sample data.
# [#8199] Database queries in gacl_api.class
# [#7713] mosMail fix bcc bug + add missing ReplyTo fields

12-Nov-2005 Giorgio Nordo (gin)
 # [#7590] fixed the bug of the related items module (the module showed also expired content items)

11-Nov-2005 Chad Auld (cauld)
 + [#8364] OSI Certification: Added README file.  Added OSI logo to install screens.

08-Nov-2005 Ilias Antonopoulos (eliasan)
 # [#8338] Help Mechanishm Unreliable: Changed all key references. Added new. Modified the code to display the right help screens. Expanded code to display the right help screen when adding a new menu item.
    For testing, set your help server to point at: http://www.mambobook.gr/draftdoc
    New Help screen will be uploaded to http://help.mamboserver.com

27-Oct-2005 Shaoying Sun (lang3)
 # [#7447] Image path input from backend results in broken links on frontend

26-Oct-2005 Carlos Souza (csouza)
 !  Hardened 'Email To Friend' form in com_content

22-Oct-2005 Shaoying Sun (lang3)
 !  Changed date format "Y-m-d h:i:s" to "Y-m-d H:i:s" in content, frontpage, typedcontent show in backend
 !  Changed date format "Y-m-d h:i:s" to "Y-m-d H:i:s" in message send in frontend

20-Oct-2005 Chad Auld (cauld)
 !  Fixed SQL injection hole in content submission 

20-Oct-2005 Cameron Fraser
+ Added Simple / Advanced functionality to Add / Edit (Content/Section/Category) pages
	admin.admin.html.php
	admin.content.html.php
	admin.sections.html.php
	admin.categories.html.php
	admin.typedcontent.html.php
	index2.php
		 
19-Oct-2005 Chad Auld (cauld)
 # [#8260] Search highlighting fails when a "?" is entered

16-Oct-2005 Chad Auld (cauld)
 # [#7601] MySQL password textbox is shown as a plain text box
 # [#7410] Mambo gzip fails when gzip compression is already enabled in php.ini
 # [#7746] Missing space in mosimage IMG tags
 # [#8157] Use of $mosConfig_abolute_path instead of $mosConfig_absolute_path
 # [#7714] User Registration allows dots and other chars besides A-Z 0-9

08-Aug-2005 Andrew Eddie
 ^ Encased text files in PHP wrapper to help obsfucate version info
 # Changed admin session name to hash of live_site to allow you to log into more than one mambo on the same host
 # Fixed hardcoded (c) character in web installer files
 # Fixed slow query in admin User Manager list screen
 # Fixed bug in poll stats calculation
 # Fixed SQL injection bugs in user activation (thanks Enno Klasing)
 # Updated bug fixes in phpMailer class
 # Fixed login bug for nested Mambo sites on the same domain

02-Aug-2005 Alex Kempkens
 # [#6775] Display of static content without Itemid
 # [#6330] Corrected default value of field

-------------------- 4.5.2.3 Patch Released ----------------------

15-Jun-2005 Andrew Eddie
 # Fixed sql injection vulnerability in voting form
 # Fixed over-sensitive filtering of content intro and full text fields
 ^ Updates database::setQuery code to more efficient version

-------------------- 4.5.2.2 Patch Released ----------------------

04-May-2005 Andrew Eddie
 # Fixed vulnerability with bind method in mosDBTable class
 # Fixed session id spoofing via administrator/index3.php
 # Fixed bug in mosAbstractTasker redirect method
 # Prevented attacks via injection of POST variables through GET
 # Fix injection bugs in various class 'check' methods
 + Added input filter class (replacement for built-in strip tags)
 - Removed vulnerable file in DOMIT library

4-Mar-2005 Rey Gigataras
 # Fixed [#4642] Can't login to ADMINISTATION
 # Fixed [#4768] emailCloaking() doesn't completely combine parts of mail address
 # Fixed [#4972] Truncated email address in Contacts
 # Fixed [#4607] admin.typedcontent.php missing $lists['_caption_align'] initialisation code
 # Fixed [#4610] MOSimage doesn't work in static content manager
 # Fixed [#4586] `List Length` is ignored

-------------------- 4.5.2.1 Patch Released ----------------------
19-Feb-2005 Andrew Eddie
 # Fixed security vulnerability in Tar.php

18-Feb-2005 Andy Miller
 # Fixed com_content to use <div> for componentheading
 ! Changed implementation of new -3 module style for more robust solution

-------------------- 4.5.2 Stable Released ----------------------

16-Feb-2005 Emir Sakic
 # Fixed JS Bug with save order button not refreshing the page in IE
 + Added support for language variable in content URL

16-Feb-2005 Andy Miller
 + Added css elements for image/caption in sf2
 ! Removed hardcoded default padding/margin in mosimage mambot

16-Feb-2005 Alex Kempkens
 # Fixed handling of header and search phrases in search component

16-Feb-2005 Rey Gigataras
 ! `Cancel` button replaced with `Close` button when editing existing items
 ! Moved `Mass Mail` to `Component` Sub-menu
 # Fixed [#4517]  Menu order incorrect
 # Fixed [#4466] Administrator may delete other administrator
 # Fixed [#4468] Administrator may change the level they belong to
 # Fixed [#4536] Logout Link wrong in User Menu
 # Fixed [#4467] Back-end Group may create 'Public Front-end' or 'Public Back-end' user
 # Fixed 'Other Categories' param problem in 'Newsfeeds` and `Contacts` components
 # Fixed [#4482] Error in WebLink Parameters
 # Fixed [#4532] Display problem in Table - Content Category
 # Fixed [#4533] Display problem in Table - Content Section
 # Fixed missing published button in `Newsfeed` Component edit page
 # Fixed [#4500] No Caption in Static Content

16-Feb-2005 Peter Koch
 # Fixed [#4090] navigation between archived articles is not possible
 # Fixed error in 'make unwriteable' when editing language and template files
 # Fixed category redirection error after calling from content item manager
 ! Updated cpanel icons and modules for hiding mainmenu when calling edit pages
 ! Updated typed/static content for hiding mainmenu when calling edit pages
 ! Spread menubar icons for improved usability
 ! Updated installation step 1 hints and warnings

16-Feb-2005 Andrew Eddie
 + Added new site module stype to allow for rounded corner styling techniques
 # Fixed bug in database error reporting when in debug mode
 # Fixed bug showing Not Auth message when linking via Key reference
 # Fixed help links to support and removed useless index link
 # Fixed [#4483] 4.5.2 Pre1: Powerd by Logo still shows 4.5.1
 # Fixed [#4496] Pre-1 Section Creation: No menu link creation possible
 + Added [#4502] Pre-1: User "Select Log Status" lacks "logged out" option
 # Fixed [#4480] 4.5.2 CVS missing language string in contacts (Download as Vcard)

15-Feb-2005 Rey Gigataras
 # Fixed bug `Search Category` mambot

15-Feb-2005 Peter Koch
 # Fixed creation of menuitems for weblink, newsfeed and contact categories
 # Fixed content menu should recognize empty sections and categories
 ! Hide main menu whenever an item is edited to reduce risk of lost checkouts.
 ! Improved backend messaging

15-Feb-2005 Andrew Eddie
 # Fixed spurious installer error msg when xml file is included in package file list
 + Added experimental task routing class
 + Added mainframe function to add custom html to the head tag of a template

14-Feb-2005 Emir Sakic
 # Fixed [#4207] Bug in Blog-Content Category Archives

14-Feb-2005 Peter Koch
 # Fixed [#4472] 4.5.2 CVS Menu Manager [menu] Overlib oddities
 # Fixed sample installation inconsistents
 # Fixed phrasing for all menuitem names
 # Fixed wrong category mgr if no weblink or newsfeed cat. exists

14-Feb-2005 Alex Kempkins
 # Fixed problem with RSS feeds & live feed
 # Removed config_ml_support from configuration dialogs

14-Feb-2005 Andrew Eddie
 # Fixed [#4305,3971] User with Manager or Administrator Access pb
 ! Converted help files to html, help index can point to help site

13-Feb-2005 Rey Gigataras
 # Fixed [#3840] Some curious things in the Groupmanagement
 # Fixed [#4272] Configuration: no 'back'; link to control panel
 ! Added logged filter to `User Manager`
 + mod_logged Admin module

12-Feb-2005 Rey Gigataras
 # Fixed [#4319] 4.5.2 CVS mod_rssfeed malfunction

12-Feb-2005 Peter Koch
 # Fixed [#4345] stripslashes on array in includes/mambo.php:mosBindArrayToObject()
 + Added optional parameters for $cc, $bcc, $attachment to mosMail()
 + Made path to sendmail configurable ($mosConfig_sendmail)

11-Feb-2005 Andy Miller
 # Fixed Long SEF URLs showing up in search results
 + Added a function to show area of text in search results based on keyword
 # Fixed rotate image module to include trailing <br /> for IE compatibility
 # Fixed search highlighting to display properly

11-Feb-2005 Peter Koch
 # Fixed [#4321] 4.5.2 CVS mod_sections module displays empty sections
 # Fixed [#3072] Update DB from 4.5.0 to 4.5.1

11-Feb-2005 Rey Gigataras
 # Fixed Live Bookmarks handling
 + Additional parameters for TinyMCE
 ! Added group filtering for User Manager
 ! Added `User Manager` & `Media Manager` to Admin Panel Quickicons
 ! Restrutured Admin `Content` Sub-Menu

10-Feb-2005 Peter Koch
 # Fixed [#4251] (Again) Issues with other categories display
 # Fixed [#4361] script tag in submit news bloqs admin backend

10-Feb-2005 Alex Kempkens
 ! Removed multi lingual calls from index and searchbot scripts

10-Feb-2005 Andrew Eddie
 # Fixed bug in module display for free text and style=-1
 # fixed bug in mambot uninstaller

09-Feb-2005 Peter Koch
 # Fixed [#4396] 4.5.2 CVS Order column in lists? Editing can't be saved.
 # Fixed [#4251] 4.5.2 CVS Menu Manager/Menu Items Editing window typos and bugs

08-Feb-2005 Peter Koch
 # Fixed [#4404] 4.5.2 CVS mod_templatechooser Typo
 # Fixed [#4405] 4.5.2 CVS mod_whosonline oddity
 # Fixed [#4400] problem with copying menu in admin panel

07-Feb-2005 Peter Koch
 # Fixed [#4105] Fixes to new item counters, category display, etc.
 # Fixed [#4359] 4.5.2 CVS new Menu Manager display bug after 05/02/cvs update

07-Feb-2005 Alex Kempkens
 # Fixed small variable notices
 ! Added configuration value for ml support
 # Fixed small issues about content categories & notice warnings for news-flash module

06-Feb-2005
 # Fixed bug that in usermenu logout link that prevents access to com_login

05-Feb-2005 Alex Kempkens
 + Added small corrections in the select handling for multi lingual contents
 + Integrated basic check for multi lingual component, same technique like
   SEF
 ! Added the use of css 'sectiontableentry1/2' in the content item table of
   the category list

05-Feb-2005 Emir Sakic
 # Fixed JS error in TinyMCE advanced editor
 # Fixed SEF bug
 # Fixed TOC SEF bug
 # Fixed cosmetic admin menu bug
 ! Removed IFRAME borders on admin help page
 # Fixed [#4267] Module Manager list default bug
 ! Added icon for save order admin listing

05-Feb-2005 Andrew Eddie
 + Added Quote method to database class
 + Added php 4.1.2 compat functions

03-Feb-2005 Andrew Eddie
 + Add Walter Zorn tooltip library

02-Feb-2005 Andrew Eddie
 ! Fixed x-site injection vulnerability related to PHP bug

30-Jan-2005 Andy Stewart
 # Fixed [#4520] Changed singular "Module" into plural "Module(s)" when deleting a menu.
 # Fixed [#4220] Static content linking to content item in menu manager.

29-Jan-2005 Alex Kempkens
 # Fixed live feed handling of RRS and integrated possibility to name
   the feed file

27-Jan-2005 Andy Stewart
 # Fixed [#2938] Added strtolower to filename when chmod after upload

27-Jan-2005 Andrew Eddie
 + Added folder offset to <files> tag in installer

26-Jan-2005 Peter Koch
 ! Change content editors width to 100%

25-Jan-2005 Peter Koch
 # Fixed weblinks not working with SEF enabled
 # Fixed [#3851] Alternative gzip page compression doesn't work (for example in Opera)
 # Fixed non-standard HTML in user manager

24-Jan-2005 Andy Stewart
 # Fixed [3565] updated publish_array to point to correct key
 # Fixed [3824] Closed, resolved by [3289] fix
 # Fixed [3473] Closed, resolved by [3289] fix
 # Fixed [3752] Not a bug, user not understood ini_get function

24-Jan-2005 Peter Koch
 # Fixed misspelling cateogry/category in english.php
 # Fixed non-standard HTML in admin control panel

23-Jan-2005 Levis Bisson
 + Added the global configuration -> Show UnAuthorized Links condition
   to the mod_latestnews.php, mod_mostread.php and mod_newsflash.php

23-Jan-2005 Peter Koch
 + Added write protection handling to template html and css editors.
 + Added write protection handling to language file editor.
 # Fixed [#3289] Media Manager not working with globals off
 # Fixed [#3352] Global configuration and Logout Fail

22-Jan-2005 Rey Gigataras
 # Fixed missing Back Button option for Search component page
 # Fixed 'no results' found when first entering Search component - without engaging a search
 # Fixed pathway html entity problem

21-Jan-2005 Peter Koch
 + Added checkboxes in site global configuration to make configuration.php
   unwritable after saving, or to override write protection while saving
   respectively.
 + Added function mosIsChmodable($file) to administrator/includes/admin.php.
   Returns TRUE if mambo can chmod the file. Used for overwrite/add write
   protection functions in administration editors.

19-Jan-2005 Rey Gigataras
 + Added Vcard capability to Contact Component

18-Jan-2005 Peter Koch
 # General fix for chmod issues [#3842] [#3727] [#3275]:
 + Added configurable file and directory permissions (chmod) to installation steps.
 + Added configurable file & directory permissions (chmod) to global configuration
 + Added function mosChmodRecursive($path, $filemode=NULL, $dirmode=NULL) to mambo.php.
 + Added function mosChmod($path) to mambo.php.
 ! 3rd party addons may adopt the permission flags while still keeping backward compatibility.
 ! Updated com_installer to use the new chmod options above
 ! Updated com_media to use the new chmod options above
 # Fixed $mosConfig_absolute_path having double slashes after installing on windows
 # Fixed several minor html errors in installer and com_config

18-Jan-2005 Rey Gigataras
 ! Added Date column to Content Managers

17-Jan-2005 Rey Gigataras
 + Added Caption support to {mosimage}
 # Fixed Category param in Blog Category
 # Fixed inability to hide Categories in Category view of 'List - Content Section'

16-Jan-2005 Rey Gigataras
 ! Separated Menu Item Types into groups

15-Jan-2005 Rey Gigataras
 ! Added param for `title` & `heading` attribs of 'mospagebreak' to be added to <site> tag
 ! Added `heading` attribute to 'mospagebreak' to control title of first item in TOC
 ! Add Search button params for `Search Module`
 ! Add forget password and register new user for Login Component page

14-Jan-2005 Rey Gigataras
 + Added new Ordering ability for Admin list/table views
 ! Template Manager preview template thumbnail, on by default
 ! Improved New Menu Item creation page - added tooltips from XML file
 ! Improved MOSTooltip function

13-Jan-2005 Rey Gigataras
 + Added Reset Clicks button to Banner manager
 ! Added Author column and Author filter to Content Item and Static Content Manager

12-Jan-2005 Rey Gigataras
 + Added `Load Module Position` mambot

11-Jan-2005 Rey Gigataras
 + Added `Wrapper` module
 + Added option to send HTML emails in `Massmail` component
 # Fixed Wrapper Component XHTML validation issue
 # Fixed [#4051] Can search sections and categories even if they have not been published

10-Jan-2005 Rey Gigataras
 ! 'Latest News' module can now show Static Content - configurable via new `Module Mode` param
 ! 'Most Read' module can now show Static Content - configurable via new `Module Mode` param

09-Jan-2005 Rey Gigataras
 + Site `Favourite Icon` now configurable via Global Configuration
 + Added Syndication support for Firefox `Live Bookmarks`
 + Added 'Apply' action to Menu Items
 + Added 'Apply' action to Content Item, Static Content, Section, Category & Global Config
 + Added 'Apply' button ( saves item but does not exit `edit` mode )
 ! Reordered `Page Title` to have sitename appear before page name
 # Fixed unnecessary extra commas in Meta Tags

07-Jan-2005 Rey Gigataras
 ! Added action message to 'Copy' module function
 ! Replace `split` funtion with faster `explode` function to determine ISO encoding
 # Fixed Error messages in 'Copy' Menu Item confirmation page

05-Jan-2005 Rey Gigataras
 # Fixed [#3990] Saving or editing existing categories gives errors

04-Jan-2005 Andy Stewart
 # Fixed [#3473] Added code to auto delete index.html from empty media manager folder
 ! Added code to media manager function create_folder to create index.html

04-Jan-2005 Rey Gigataras
 # Fixed handling of menus when more than one module assigned to display a particular menutype
 # Fixed Search Contacts mambot sql error

04-Jan-2005 Andrew Eddie
 # Fixed hardcoded classname in mosParameters that prevents derived classes from working
 # Fixed wrongly named iscore property in mosComponents class
 ! Updated mosReadDirectory function to be able to recurse into sub-directories

03-Jan-2005 Rey Gigataras
 # Fixed Admin Module 'Components' being visible for Managers
 # Fixed Admin Module 'Menu Stats' including Trashed menu items in count

02-Jan-2005 Rey Gigataras
 + New 'Installer' sub-menu for Admin and Super Admin - amalgamates links for all installers
 ! Improvement to Category 'Link to Menu' handling
 ! Improvement to Section 'Link to Menu' handling
 # Fixed page title param for Contact Component menu items

01-Jan-2005 Rey Gigataras
 ! Improvement to Static Content 'Link to Menu' handling
 ! Improvement to Content Item 'Link to Menu' handling
 ! Improvement to Menu Manager edit menu item linking

31-Dec-2004 Rey Gigataras
 ! Improvement to Content Item 'Reset Hits' handling
 ! Improvement to Static Content 'Reset Hits' handling
 # Fixed RSS Syndication author validation error - removed author info

31-Dec-2004 Andrew Eddie
 # Fixed stripping of backslashes when loading an object
 # Fixed error if xml didn't exist in Mambot and Module install screens

30-Dec-2004 Rey Gigataras
 # Fixed [#2706] Bug(?) with 'time to publish' in relation to timezone (time offset)
 # Fixed [#3922] POLL: Page Title is missing (Parameters)
 # Fixed params for 'Component - Search' menu item
 # Fixed Poll dropdown select missing Itemid

30-Dec-2004 Peter Koch
 # Fixed [#3610] Missing #__ in admin.content.php
 # Fixed [#3503] Missing quote in admin.media.html.php
 # Fixed [#3217] Typo in variable name, missing $ sign

30-Dec-2004 Andrew Eddie
 ! Admin custom toolbar now displays only text if images not defined

29-Dec-2004 Rey Gigataras
 + Search Newsfeeds mambot
 + Added Feed Image, Feed descrip, Item descrip & word count params to 'Link - Newsfeed'
 + Added Feed Image, Feed descrip, Item descrip & word count params to 'Component - Newsfeed'
 + Added Feed Image, Item description & word count params to RSS Feed module
 ! Modified Search Weblinks mambot

27-Dec-2004 Rey Gigataras
 + Added hyperlink to Frontpage Manager list linking to Category Edit
 + Added hyperlink to Frontpage Manager list linking to Section Edit
 + Added hyperlink to Content Manager list linking to Category Edit
 + Added hyperlink to Content Manager list linking to Section Edit
 + Added hyperlink to Category Manager list linking to Section Edit
 ! Cosmetic change to Module Item layout - shifted from tab to column layout
 # Fixed mambot description in Edit Mambot page

26-Dec-2004 Rey Gigataras
 + Added hyperlink to Menu Manager for Contact Item menu items directly to the item itself
 + Added hyperlink to Menu Manager for Newsfeed Item menu items directly to the item itself
 + Added hyperlink to Menu Manager for Content Item menu items directly to the item itself
 + Ability to link to Content Items from Edit Content Item menu page
 + Ability to link to Static Content from Edit Static Content Item menu page
 ! Cosmetic change to Menu Item layout - shifted from tab to column layout
 # Fixed [#3551] Failed during uninstallation of Admin's module
 # Fixed [#3056] No handling of illegal section names in Category Manager
 # Fixed [#3030] Query in archive modul don't work
 # Fixed [#2847] archive module not using SEO

25-Dec-2004 Rey Gigataras
 ! Disabled edit icon appearing in newsflash module
 # Fixed [#3891] Checkout for Banner Clients don't work
 # Fixed [#2986] com_banner option listclients doesn't work in FireFox 1.0
 # Fixed [#3048] Problem with Frontend editing checked-out Content

24-Dec-2004 Andrew Eddie
 ! Added PEAR Archive Tar library

24-Dec-2004 Rey Gigataras
 # Fixed [#3287] Login fails if index.php is not the default for the domain
 # Fixed [#3669] str_replace( '&', '&amp;', $path ) may break unicode
 # Fixed [#2982] minor error in pathway.php
 # Fixed [#3290] Sort by button broken in 'Browser, OS, Domain Statistics' page
 # Fixed [#2984] Centering of text in install components
 # Fixed [#2791] Administrators can delete themselves
 # Fixed [#3058] Control Panel
 # Fixed [#3426] component com_contacts several issues
 # Fixed [#3375] Multiple contacts printing error
 # Fixed [#3482] Contacts Page Class Suffix and Page Title don`t work

23-Dec-2004 Rey Gigataras
 # Fixed [#3895] 'Active' Column in Contact Categories list always zero
 # Fixed mambot xml group attribute

22-Dec-2004 Andrew Eddie
 ! Replaced Incutio xmlrpc library with DOMIT xmlrpc library

20-Dec-2004 Andrew Eddie
 # Removed display of href in returned search results (long urls corrupt display)

19-Dec-2004 Rey Gigataras
 + Block renaming of menutype for 'mainmenu' menu
 + Block deletion of 'mainmenu' menu
 + Block deletion of 'mainmenu' module
 ! Hides email by default on Contacts component table view
 ! Cosmetic change to representation of Menu Tree
 ! Administrator Group now able to access Trash Manager
 # Fixed [#3127] typo in 'List - Content Section' menu item params: Filter Field
 # Fixed [#2693] Bug by install local 4.51a local WIN XP PRP XAMPP
 # Fixed [#2752] blogsection mode, shows IMG element wwhen no image is selected
 # Fixed [#2734] 'Register Globals' set to OFF, Bug with viewing page as PDF or to Print
 # Fixed [#2743] index2.php option-variable used before initialisation
 # Fixed [#2867] $author not visible in email for user submitted weblink
 # Fixed [#2917] Can't edit static content in backend via edit button
 # Fixed [#3152] menu class suffix parameter does not work for sublevels
 # Fixed [#3513] 'Do not use image' doesn't remove weblink icon
 # Fixed [#2862] menu copy doesn't copy sublevel items
 # Fixed [#3827] Trashed Content is displayed to those with frontend edit access
 # Fixed [#2689] Link to Menu, will not show empty menus in Menu Select list
 # Fixed [#3829] Access to Menu Manager not allowed for Administrators
 # Fixed [#3701] Changing menu module menu class suffix interferes with menu menutype
 # Fixed [#3128] Menu manager issues
 # Fixed [#3109] menutype shows a wrong value
 # Fixed [#2710] Problem with menu manager
 # Fixed renaming of Menu Type also renames type for menu items

18-Dec-2004 Andy Stewart
 # Fixed [#3794] Replaced $mainframe->getCfg("mosConfig_dbprefix") with $mosConfig_dbprefix

18-Dec-2004 Rey Gigataras
 # Fixed [#2992] Spelling error in Registration module
 # Fixed [#3725] Spelling Error in Global Config
 # Fixed [#2717] Missing parameters for 'Component - Search' menu item
 # Fixed [#2690] Newsfeed Component not outputing Feeds image
 # Fixed [#2825] Poll Lag is Broken
 # Fixed [#3748] Impossible to reply to mails from contact component
 # Fixed [#3802] Contact component js redirect fails on submit in Firefox

17-Dec-2004 Rey Gigataras
 + Email Cloaking mambot
 + Search Content Sections mambot
 + Search Content Categories mambot
 ! Added css class distinction between next and previous item navigation buttons
 ! TinyMCE removed from uninstall list
 ! On clean install TinyMCE in 'Advanced' mode loaded as default editor
 ! Upgraded feedcreator to 1.72
 # Fixed [#2923] Pb when Using Textarea as module parameter
 # Fixed [#3770] RSS - not correctly validating
 # Fixed [#3771] RSS - encoding German Umlauts
 # Fixed [#3025] Bugs in encoding in rss feeds
 # Fixed [#3067] Content without a category is gone but still there
 # Fixed [#3321] Editing Administrator Module does not load corrent parameter from xml file
 # Fixed [#3122] "table - newsfeed category" have contact category's parameters
 # Fixed [#3123] typo on popup info help on login component menu item's parameters tab
 # Fixed [#3125] typo in "List - Content Section" parameters tab
 # Fixed [#3018] Menu Bug? or Style issues w/ Solarflare template
 # Fixed [#2701] Read more on all frontpage items
 # Fixed [#3071] missing <selected> tag in create user
 # Fixed [#2788] Submit News returns Not authorised for Author level
 # Fixed [#2930] Search Module (Search Box) - Display extra line below the input box
 # Fixed [#3050] Filter in com_contact is broken
 # Fixed [#3078] errors in mosmenubar
 # Fixed [#2874] css for news module
 # Fixed [#2896] Mod_mainmenu Spacer settings not functional
 # Fixed [#2899] Saving content - mosmessages missing Slashes
 # Fixed [#2871] no edit-icon if show_title set to off
 # Fixed [#2687] page class suffix for home (w3c xhtml)
 # Fixed [#2630] 4.5.1 and Static Contant Manager and Link to Menu
 # Fixed [#3057] Error with Help in Static Content Manager
 # Fixed RSS IE display error
 # Fixed RSS feed Itemid problem
 # Fixed Banner Client Manager Checked Out field not showing data
 # Fixed Contact Manager Checked Out field showing incorrect data
 # Fixed Contact Item Link not displaying correct info when editing menu item entry
 # Fixed 'Blog - Content Category' Param to show/hide Category description & image
 # Fixed 'Blog - Content Section' Param to show/hide Section description & image

17-Dec-2004 Andrew Eddie
 # Fixed possible bug with PHP 4.3.10
 # Fixed colon in _NEW_USER_MESSAGE causing problems with some url's
 ! Upgraded TinyMCE to version 1.38
 # Fixed wrong field in weblinks search for newest/oldest/default
 ! Improvements to search engine to facilitate xml-rpc integration
 # Fixed [#2813] database query bug
 + Added improve code highlight bot based on GeSHi

16-Dec-2004 Andrew Eddie
 # [#3225] Site Preview uses base URL not a call to index.php

15-Dec-2004 Andrew Eddie
 ! Updated DOMIT version to 1.0 pre_g
 + Added desciption to Modules edit page
 + Added linkable title option to newsflash module
 # Fixed access parameter and select query

13-Dec-2004 Andrew Eddie
 # Random Image: Corrected noted default image type, improved parameter help text

10-Dec-2004 Andrew Eddie
 ! Updated screen help pages
 ! Moved system info, credits, license & support from menu to help page

06-Dec-2004 Andrew Eddie
 + Added Id and Component Id column to menu item list
 + Added hyperlink to Menu Manager for Static Content menu items directly to the item itself
 + Parameter added to control how weblink opens
 ! New weblinks will assign category if selected in the links list
 ! Allow parameters handler to assign different control name

-------------------- 4.5.1a Stable Released ----------------------

2. Copyright and disclaimer
---------------------------
This application is opensource software released under the GPL.  Please
see source code and the LICENSE file
