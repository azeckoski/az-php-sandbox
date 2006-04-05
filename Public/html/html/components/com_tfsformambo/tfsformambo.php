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
	
	//create TFSforMAMBO class to register visitors
	$TFSforMambers = new TFSforMAMBO($mainframe);
	
class TFSforMAMBO
{
	// useragent
	var $UserAgent = null;
	var $IpAddress = null;
	var $RequestedPage = null;
	var $vType = null;
	var $vExclude = null;
	var $MainFrame = null;
	var $hourdiff= null;
	var $onlinetime= null;
	
	function TFSforMAMBO($mainframe)
	{
		$this->MainFrame = &$mainframe;
		//get useragent visitor
		$this->GetUserAgent();
		//get ipadress visitor
		$this->GetIpAddress();
		//get requested page
		$this->GetRequestedPage();
		//read in configuration
		$this->GetConfiguration();
		
		// check ipaddress if not excluded the go on with registration
		if ($this->CheckIpAddress() != 1)
		{
			//get a visit id so we can link the requested pages
			//and then register the pages requested by the visitor
			$this->PageRequest($this->visits());
		}
	}
	
	function GetUserAgent()
	{		
		if (isset($_SERVER['HTTP_USER_AGENT']))
		{
			if ($_SERVER['HTTP_USER_AGENT'] != NULL)
			{
				$this->UserAgent = strtolower((string)$_SERVER['HTTP_USER_AGENT']);	
			}
			else
			{	
				$this->UserAgent = '';
			}
		}
		else
		{
			$this->UserAgent = '';
		}
				
	} // END function GetUserAgent()

	function GetRequestedPage()
	{		
		if(isset($_SERVER['REQUEST_URI']))
		{
			if ($_SERVER['REQUEST_URI'] != NULL)
			{
				$this->RequestedPage = (string)$_SERVER['REQUEST_URI'];	
			}
			else
			{	
				$this->RequestedPage = '';
			}
		}
		else
		{
			$this->RequestedPage = '';
		}
		
		// Search Engine Friendly url
		if ($this->MainFrame->_config->sef == '1')
		{
			$this->RequestedPage = sefRelToAbs($this->RequestedPage);
		}
		
		$this->RequestedPage = str_replace('http://',':#:',$this->RequestedPage);
		$this->RequestedPage = str_replace('//','/',$this->RequestedPage);
		$this->RequestedPage = str_replace(':#:','http://',$this->RequestedPage);

	} // END function GetRequestedPage()
	
	function GetConfiguration()
	{
		global $mosConfig_offset;
	
		$sql = "SELECT SQL_BIG_RESULT value FROM #__TFS_configuration WHERE description ='onlinetime'";
		
		$this->MainFrame->_db->setQuery($sql);
		
		$rs = mysql_query($this->MainFrame->_db->_sql);

		$row = mysql_fetch_array($rs);

		$this->onlinetime = $row['value'];

		mysql_free_result($rs);
		
		$this->hourdiff = $mosConfig_offset;
		
	}
	
	function GetIpAddress() 
	{
		//get usefull vars:
		$client_ip = '';
		$x_forwarded_for = '';
		$remote_addr = '';

		$client_ip = isset($_SERVER['HTTP_CLIENT_IP']) ? (string)$_SERVER['HTTP_CLIENT_IP'] : NULL;
		$x_forwarded_for = isset($_SERVER["HTTP_X_FORWARDED_FOR"]) ? (string)$_SERVER["HTTP_X_FORWARDED_FOR"] : NULL;
		$remote_addr = isset($_SERVER['REMOTE_ADDR']) ? (string)$_SERVER['REMOTE_ADDR'] : NULL;
	
		// then the script itself
		if (!empty ($client_ip) ) 
		{
			$ip_expl = explode('.',$client_ip);
			$referer = explode('.',$remote_addr);
	
			if($referer[0] != $ip_expl[0]) 
			{
				$ip=array_reverse($ip_expl);
				$this->IpAddress = implode('.',$ip);
			} 
			else 
			{
				$this->IpAddress = $client_ip;
			}
		} 
		elseif (!empty($x_forwarded_for) && strrpos($x_forwarded_for,'.') > 0 ) 
		{
			if(strstr($x_forwarded_for,',')) 
			{
				$ip_expl = explode(',',$x_forwarded_for);
				$this->IpAddress = end($ip_expl);
			} 
			else 
			{
				$this->IpAddress = $x_forwarded_for;
			}
		} 
		else 
		{
			$this->IpAddress = $remote_addr;
		}
	
		unset ($client_ip,$x_forwarded_for,$remote_addr,$ip_expl,$referer);
				
	}// END function GetIpAddress()
		
	function CheckIpAddress()
	{

		$retval = 0;
		$visitor_tld = '';
		$visitor_nslookup = '';

		$sql = "SELECT SQL_BIG_RESULT exclude,type from #__TFS_ipaddresses where ip='$this->IpAddress' and useragent='$this->UserAgent'";
		
		$this->MainFrame->_db->setQuery($sql);
		
		$rs = mysql_query($this->MainFrame->_db->_sql);

		// if ip en useragent not known then lets get started
		if(!$row = mysql_fetch_array($rs))
		{
			// get fullname nslookup
			if(($this->IpAddress != NULL)&&($this->IpAddress != '127.0.0.1')&&(substr($this->IpAddress,0,8) != '192.168.')&&(substr($this->IpAddress,0,7) != '172.16.')&&(substr($this->IpAddress,0,7) != '172.31.'))
			{
				$visitor_nslookup = @gethostbyaddr($this->IpAddress);
			}
		
			// get country from visitor
			$pos = strrpos($visitor_nslookup,'.') + 1;
	
			if ($pos > 0)
			{
				$xt = substr($visitor_nslookup,$pos);
					
				if (ereg('([a-z])',$xt))
				{
					$visitor_tld = $xt;
				}
				else
				{
					$visitor_tld = '';
					$visitor_nslookup = $this->IpAddress;
				}
			}
			else
			{
				$visitor_tld = '';
				$visitor_nslookup = $this->IpAddress;
			}
	
			if ($visitor_tld == '')
			{
				
				$sql = "SELECT SQL_BIG_RESULT COUNTRY_CODE2 FROM #__TFS_iptocountry WHERE inet_aton('$this->IpAddress') >= ip_from AND inet_aton('$this->IpAddress') <= ip_to";
				
				$this->MainFrame->_db->setQuery($sql);
				
				$rs = mysql_query($this->MainFrame->_db->_sql);
	
				if($rs)
				{
					$row = mysql_fetch_array($rs);	
					$visitor_tld = strtolower($row['COUNTRY_CODE2']);
					mysql_free_result($rs);				
				}
			}
			
			// determine if bot or browser
			$type = 0;
		
			// get browser --------------------------------------------------------------------------
		
			$browser='';
	
			$sql = 'SELECT SQL_BIG_RESULT LENGTH( browser_string ) AS strlen, browser_string, browser_fullname FROM #__TFS_browsers ORDER BY strlen DESC';
			
			$this->MainFrame->_db->setQuery($sql);
			
			$rs = mysql_query($this->MainFrame->_db->_sql);
	
			while ($row = mysql_fetch_array($rs)) 
			{
				if(strpos($this->UserAgent,$row['browser_string']) !== FALSE)
				{
					$browser = mysql_escape_string($row['browser_fullname']);

					if (preg_match( "/".$row['browser_string']."[\/\sa-z]*([\d\.]*)/i", $this->UserAgent, $version))
					{
						$browser .= ' '.$version[1];
					}
							
					$type = 1;
					break;
				}        
			}
	
			mysql_free_result($rs);
	
			// get browser -----------------------------------------------------------------------END
	
			// if browser "" then look for bot ------------------------------------------------------
			
			if($browser == '')
			{
				// get bot
				$browser = '';
	
				$sql = 'SELECT SQL_BIG_RESULT LENGTH(bot_string) AS strlen, bot_string,bot_fullname FROM #__TFS_bots ORDER BY strlen DESC';
				
				$this->MainFrame->_db->setQuery($sql);
				
				$rs = mysql_query($this->MainFrame->_db->_sql);
	
				while ($row = mysql_fetch_array($rs)) 
				{
					if(strpos($this->UserAgent,$row['bot_string']) !== FALSE)
					{
						$browser = mysql_escape_string($row['bot_fullname']);
						$type = 2;
						break;
					}        
				}
	
				mysql_free_result($rs);
	
			}
	
			if($browser == '')
			{
				if (strpos($this->UserAgent,'robot') !== FALSE)
				{
					$browser = 'Unknown robot (identified by robot)';
					$type = 2;
				}
			}
	
			if($browser == '')
			{
				if (strpos($this->UserAgent,'crawl') !== FALSE)
				{
					$browser = 'Unknown robot (identified by crawl)';
					$type = 2;
				}
			}
			
			if($browser == '')
			{
				if (strpos($this->UserAgent,'spider') !== FALSE)
				{
					$browser = 'Unknown robot (identified by spider)';
					$type = 2;
				}
			}		
			// if browser "" then look for bot ---------------------------------------------------END
		
			// get OS version -----------------------------------------------------------------------
	
			$OS = '';

			$sql = 'SELECT SQL_BIG_RESULT LENGTH(sys_string) AS strlen,sys_string,sys_fullname FROM #__TFS_systems ORDER BY strlen DESC';
			
			$this->MainFrame->_db->setQuery($sql);
			
			$rs = mysql_query($this->MainFrame->_db->_sql);
		
			while ($row = mysql_fetch_array($rs)) 
			{
				if(strpos($this->UserAgent,$row['sys_string']) !== FALSE)
				{
					$OS = mysql_escape_string($row['sys_fullname']);
					break;
				}        
			}
	
			mysql_free_result($rs);
	
			// get OS version --------------------------------------------------------------------END
		
			// do insert off unique visitor ---------------------------------------------------------
			$sql = "insert into #__TFS_ipaddresses (ip,nslookup,useragent,tld,system,browser,type) values ('$this->IpAddress','$visitor_nslookup','$this->UserAgent','$visitor_tld','$OS','$browser',$type)";

			$this->MainFrame->_db->setQuery($sql);
			
			mysql_query($this->MainFrame->_db->_sql);
			// do insert off unique visitor ------------------------------------------------------END
			
		}
		else
		{
			$retval = $row["exclude"];
			// global var voor type off visit
			$type = $row["type"];
		}
		
		// set $vistyp to $typ off current visitor

		//set value for vistor type bot/browser		
		$this->vType = $type;
		// set value for exclude
		$this->vExclude = $retval;
		// return value
		return $retval;
		
	}// END function CheckIpAddress()

	function visits()
	{

		$sql = "SELECT SQL_BIG_RESULT id from #__TFS_ipaddresses where ip='$this->IpAddress' and useragent='$this->UserAgent'";
				
		$this->MainFrame->_db->setQuery($sql);
		
		$rs = mysql_query($this->MainFrame->_db->_sql);
	
		if($row = mysql_fetch_array($rs))
		{
			$visitid = $row['id'];
			mysql_free_result($rs);
		}
		
		$sql = "SELECT SQL_BIG_RESULT id from #__TFS_visits WHERE month=MONTH(DATE_ADD(NOW(), INTERVAL ".$this->hourdiff." HOUR)) AND year=YEAR(DATE_ADD(NOW(), INTERVAL ".$this->hourdiff." HOUR)) AND ip_id='$visitid' and time >= DATE_ADD(DATE_ADD(NOW(), INTERVAL ".$this->hourdiff." HOUR), INTERVAL -".$this->onlinetime." MINUTE)";
				
		$this->MainFrame->_db->setQuery($sql);
				
		$rs = mysql_query($this->MainFrame->_db->_sql);
	
		if($row = mysql_fetch_array($rs))
		{
			
			$visitnumber = $row['id'];
			
			mysql_free_result($rs);
			
			$sql = "UPDATE #__TFS_visits SET time=DATE_ADD(NOW(), INTERVAL ".$this->hourdiff." HOUR) WHERE id='$visitnumber'";
	
			$this->MainFrame->_db->setQuery($sql);
			
			$rs = mysql_query($this->MainFrame->_db->_sql);
			
		}
		else
		{
			$sql = "INSERT INTO #__TFS_visits (ip_id,hour,day,month,year,time) values ($visitid,HOUR(DATE_ADD(NOW(), INTERVAL ".$this->hourdiff." HOUR)),DAYOFMONTH(DATE_ADD(NOW(), INTERVAL ".$this->hourdiff." HOUR)),MONTH(DATE_ADD(NOW(), INTERVAL ".$this->hourdiff." HOUR)),YEAR(DATE_ADD(NOW(), INTERVAL ".$this->hourdiff." HOUR)),DATE_ADD(NOW(), INTERVAL ".$this->hourdiff." HOUR))";
						
			$this->MainFrame->_db->setQuery($sql);
				
			mysql_query($this->MainFrame->_db->_sql);
	
			$visitnumber = mysql_insert_id($this->MainFrame->_db->_resource);
		}
		
		return $visitnumber;
	}// END function visits()


	function PageRequest($visitid)
	{
		
		$page = mysql_escape_string($this->RequestedPage);
			
		$sql = "SELECT SQL_BIG_RESULT page_id FROM #__TFS_pages WHERE page='$page'";
		
		$this->MainFrame->_db->setQuery($sql);
				
		$rs = mysql_query($this->MainFrame->_db->_sql);
	
		if(!$row = mysql_fetch_array($rs))
		{
			$sql = "INSERT INTO #__TFS_pages (page) values ('$page')";

			$this->MainFrame->_db->setQuery($sql);
				
			mysql_query($this->MainFrame->_db->_sql);
			
			$pageid = mysql_insert_id($this->MainFrame->_db->_resource);
		}
		else
		{
			$pageid = $row['page_id'];
			mysql_free_result($rs);
		}
					
		$sql = "INSERT INTO #__TFS_page_request (page_id,hour,day,month,year,ip_id) values ($pageid,HOUR(DATE_ADD(NOW(), INTERVAL ".$this->hourdiff." HOUR)),DAYOFMONTH(DATE_ADD(NOW(), INTERVAL ".$this->hourdiff." HOUR)),MONTH(DATE_ADD(NOW(), INTERVAL ".$this->hourdiff." HOUR)),YEAR(DATE_ADD(NOW(), INTERVAL ".$this->hourdiff." HOUR)),$visitid)";
	
		$this->MainFrame->_db->setQuery($sql);
		
		mysql_query($this->MainFrame->_db->_sql);
		
		$this->Regreferrer();
		
	}// END function PageRequest()

	function Regreferrer()
	{
		// if referer is not nothing then
		if(isset($_SERVER['HTTP_REFERER']))
		{
			$ref = $_SERVER['HTTP_REFERER'];

			if(isset($_SERVER['HTTP_HOST']))
			{
				$hst = $_SERVER['HTTP_HOST'];
			}
						
			if(trim($ref) != '')
			{
				$ref = mysql_escape_string(trim($ref));
				$hst = mysql_escape_string(trim($hst));
				
				if((strpos($ref,$hst) === FALSE) && (substr($ref,0,1) != '/'))
				{
					if (substr($ref,0,7) == 'http://')
					{
						if(strpos($ref,'/',7) !== FALSE)
						{
							$pos = strpos($ref,'/',7) - 7;
							$dom = substr($ref,7,$pos);
						}
						else
						{
							$dom = substr($ref,7);
						}
		
						if ((substr($dom,0,3) == "www") || (substr($dom,0,3) == "WWW"))
						{
							$dom = substr($dom,4);
						}
						
						if ($this->regKeyWords($ref) === false)
						{
							$sql = "INSERT INTO #__TFS_referrer (referrer,domain,day,month,year) values ('$ref','$dom',DAYOFMONTH(DATE_ADD(NOW(), INTERVAL ".$this->hourdiff." HOUR)),MONTH(DATE_ADD(NOW(), INTERVAL ".$this->hourdiff." HOUR)),YEAR(DATE_ADD(NOW(), INTERVAL ".$this->hourdiff." HOUR)))";
			
							$this->MainFrame->_db->setQuery($sql);
								
							mysql_query($this->MainFrame->_db->_sql);
						}

					}
													
				}
			}
		}
	}// END function Regreferrer()

	function regKeyWords($url)
	{
	
		$sql = "SELECT SQL_BIG_RESULT * FROM #__TFS_search_engines";
		
		$this->MainFrame->_db->setQuery($sql);
			
		$rs = mysql_query($this->MainFrame->_db->_sql);
		
		while($row = mysql_fetch_array($rs))
		{
			if (strpos($url,addslashes($row['search'])) !== FALSE)
			{
				$ar = explode(",",$row['searchvar']);

				for($i=0;$i <= count($ar);$i++)
				{
					$qsp1 = strpos($url,$ar[$i]);
			
					if ($qsp1 !== false)
					{
						$qsp1 = ($qsp1 + strlen($ar[$i]));
			
						$qsp2 = strpos($url,'&',$qsp1);
						
						if($qsp2 !== false)
						{
							$kwrds = urldecode(substr($url,$qsp1,($qsp2-$qsp1)));
						}
						else
						{
							$kwrds = urldecode(substr($url,$qsp1));
						}
					}
				}
				break;
			}
		}
		
		if(trim($kwrds) != '')
		{
			$sql = "INSERT INTO #__TFS_keywords (kwdate,searchid,keywords) VALUES (DATE_ADD(NOW(), INTERVAL ".$this->hourdiff." HOUR),".$row['searchid'].",'".mysql_escape_string($kwrds)."')";

			$this->MainFrame->_db->setQuery($sql);
				
			mysql_query($this->MainFrame->_db->_sql);

			return true;
		}
		else
		{
			return false;
		}
	}
}
?>
