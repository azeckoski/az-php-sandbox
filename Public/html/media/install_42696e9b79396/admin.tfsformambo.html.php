<?php /* $Id$ */

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
	
	class TFS_Engine
	{
		
		var $d = null; 			//day
		var $m = null; 			//month
		var $y = null; 			//year
		var $dom = null; 		// domain
		var $vid = null; 		// visitors id
		var $updatemsg= null; 		//update message used for purge
		var $language = null;		//language setting
		var $langini = null;		//language setting ini file
		var $hourdiff = null;		//hourdiff local vs server
		var $onlinetime = null;		//time online in minutes before new visitor
		var $startoption = null;	//option for starting statistics
		var $purgetime = null;		//time for purge database
		var $version = null;		//version of script
		var $MainFrame = null;		//mainframe object MOS
		var $task = null;		//task for TFS_Engine

		
		function TFS_Engine(&$mainframe,$task)
		{
			global $mosConfig_offset;

			$this->MainFrame = &$mainframe;
			
			$this->task = $task;

			$sql = "SELECT SQL_BIG_RESULT * FROM #__TFS_configuration";
			
			$this->MainFrame->_db->setQuery($sql);
			
			$rs = mysql_query($this->MainFrame->_db->_sql);
	
			$this->hourdiff = $mosConfig_offset;

			while($row = mysql_fetch_array($rs))
			{
	
				if ($row['description'] == 'onlinetime')
				{
					$this->onlinetime = $row['value'];
				}

				if ($row['description'] == 'startoption')
				{
					$this->startoption = $row['value'];
				}

				if ($row['description'] == 'language')
				{
					$this->langini = $row['value'];
				}

				if ($row['description'] == 'purgetime')
				{
					$this->purgetime = $row['value'];
				}

				if ($row['description'] == 'version')
				{
					$this->version = $row['value'];
				}

			}
	
			mysql_free_result($rs);

			if(file_exists($this->MainFrame->_config->absolute_path.'/administrator/components/com_tfsformambo/language/'.$this->langini.'.ini.php'))
			{
				//include language support
				$this->language = parse_ini_file($this->MainFrame->_config->absolute_path.'/administrator/components/com_tfsformambo/language/'.$this->langini.'.ini.php',true);
			}
			else
			{
				//include language support
				$this->language = parse_ini_file($this->MainFrame->_config->absolute_path.'/administrator/components/com_tfsformambo/language/en.ini.php',true);
			}	
			
			// calculate time diff from server time to local time
			$visittime = (time() + ($this->hourdiff * 3600));					
		
			if(!isset($_GET['d']))
			{
				$this->d = date('j',$visittime);
			}
			else
			{
				$this->d = $_GET['d'];
			}
		
			if(!isset($_GET['m']))
			{
				$this->m = date('n',$visittime);
			}
			else
			{
				$this->m = $_GET['m'];
			}
			
			if(!isset($_GET['y']))
			{
				$this->y = date('Y',$visittime);
			}
			else
			{
				$this->y = $_GET['y'];
			}
		
			if(isset($_GET['dom']))
			{
				$this->dom = $_GET['dom'];
			}
			else
			{
				$this->dom = '%';
			}

			if(isset($_GET['v']))
			{
				$this->vid = $_GET['v'];
			}
			else
			{
				$this->vid = '';
			}
						
		}
		
		function CreateDayCmb()
		{
			for($i=1;$i <= 31;$i++)
			{
				if ($this->d != $i)
				{
					echo "<option value=\"$i\">".$i."</option>\n";
				}
				else
				{
					echo "<option selected value=\"$i\">".$i."</option>\n";
				}
			}
			
			if ($this->d == 'total')
			{
				echo '<option selected value="total">-</option>';
			}
			else
			{
				echo '<option value="total">-</option>';
			}
		}

		function CreateMonthCmb()
		{
			$a = array('','Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec');
			
			for($i=1;$i < 13;$i++)
			{
				if ($this->m != $i)
				{
					echo "<option value=\"$i\">".$a[$i]."</option>\n";
				}
				else
				{
					echo "<option selected value=\"$i\">".$a[$i]."</option>\n";
				}
			}
			
			if ($this->m == 'total')
			{
				echo '<option selected value="total">-</option>';
			}
			else
			{
				echo '<option value="total">-</option>';
			}

		}

		function CreateYearCmb()
		{
			for($i=2003;$i <= date('Y',time());$i++)
			{
				if ($this->y != $i)
				{
					echo "<option value=\"$i\">$i</option>\n";
				}
				else
				{
					echo "<option selected value=\"$i\">$i</option>\n";
				}
			}
		}

		function SetConfiguration()
		{

			$onlinetime = isset($_POST['onlinetime']) ? $_POST['onlinetime'] : '15';
			$startoption = isset($_POST['startoption']) ? $_POST['startoption'] : '002';
			$language = isset($_POST['language']) ? $_POST['language'] : 'en';
			$timelimit = isset($_POST['timelimit']) ? $_POST['timelimit'] : '30';
			
			$sql = "UPDATE #__TFS_configuration set value='$onlinetime' WHERE description='onlinetime'";
			$this->MainFrame->_db->setQuery($sql);
			mysql_query($this->MainFrame->_db->_sql);

			$sql = "UPDATE #__TFS_configuration set value='$startoption' WHERE description='startoption'";
			$this->MainFrame->_db->setQuery($sql);
			mysql_query($this->MainFrame->_db->_sql);

			$sql = "UPDATE #__TFS_configuration set value='$language' WHERE description='language'";
			$this->MainFrame->_db->setQuery($sql);
			mysql_query($this->MainFrame->_db->_sql);

			$sql = "UPDATE #__TFS_configuration set value='$timelimit' WHERE description='purgetime'";
			$this->MainFrame->_db->setQuery($sql);
			mysql_query($this->MainFrame->_db->_sql);

			//redirect to default stats		
			mosRedirect('index2.php?option=com_tfsformambo&task=stats');
			
		}

		function getdbversion()
		{
			echo $this->version;
		}
		
		function getdbsize()
		{

			$sql = "SHOW TABLE STATUS FROM `".$this->MainFrame->_config->db."` LIKE '#__TFS_%'";
	
			$this->MainFrame->_db->setQuery($sql);
		
			$rs = mysql_query($this->MainFrame->_db->_sql);

			$total = 0;
					
			while ($row = mysql_fetch_array($rs))
			{
				//echo $row['Data_length'] + $row['Index_length'] ."<br>";
				$total += $row['Data_length'] + $row['Index_length'];
			}
				
			echo round((($total/1024)/1024),1);
				
			mysql_free_result($rs);
			
		}
		
		function menu()
		{
			$n = NULL;
			
			echo '<table width="100%" border="0" cellpadding="2" cellspacing="0">';
			echo '<tr>';
			echo '<td width="10">&nbsp;</td>';
			while ( list( $id, $description ) = each( $this->language['menu'] ))
			{
				if (strlen($id) == 3)
				{
				    echo '<td >';
					echo "<a href=\"index2.php?option=com_tfsformambo&task=$id&d=".$this->d."&m=".$this->m."&y=".$this->y."\">$description</a>";
					echo '</td>';

					$n++;
					if($n % 6 == 0)
					{
						echo '<td>&nbsp;</td></tr><tr><td width="10">&nbsp;</td>';
					}
				}
			}		
			echo '</tr></table>';
		}
		
		function DisplayTitle()
		{
			if (strlen($this->task) == 3)
			{
				echo $this->language['menu'][$this->task];
				if ($this->dom != '' && $this->dom != '%')
				{
					echo "&nbsp;&lt;$this->dom&gt;";
				}
			}
			else
			{
				echo $this->language['extra'][$this->task];
			}
		} 

		function resetVar($opt)
		{
			if ($opt == 1)
			{
				if($this->d == 'total'){$this->d = '%';}
				if($this->m == 'total'){$this->m = '%';}
				if($this->y == 'total'){$this->y = '%';}
			}
			else
			{
				if($this->d == '%'){$this->d = 'total';}
				if($this->m == '%'){$this->m = 'total';}
				if($this->y == '%'){$this->y = 'total';}
			}
			
		}
		
		function ysummary()
		{	
			$a = array('','Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec');
			
			$retval = '<table class="adminlist" cellspacing="0" width="100%"><tr>';
			$retval .= '<th align="center" nowrap>'.$this->language['tableheaders']['t02'].'</th>';
			$retval .= '<th align="center" nowrap>'.$this->language['tableheaders']['t03'].'</th>';
			$retval .= '<th align="center" nowrap>'.$this->language['tableheaders']['t04'].'</th>';
			$retval .= '<th align="center" nowrap>'.$this->language['tableheaders']['t05'].'</th>';
			$retval .= '<th align="center" nowrap>'.$this->language['tableheaders']['t06'].'</th>';
			$retval .= '<th align="center" nowrap>'.$this->language['tableheaders']['t07'].'</th>';
			$retval .= '<th align="center" nowrap>'.$this->language['tableheaders']['t08'].'</th>';
			$retval .= '<th align="center" nowrap>'.$this->language['tableheaders']['t09'].'</th>';
			$retval .= '</tr>';				
		
			$tuv=0;
			$tv=0;
			$tub=0;
			$tb=0;
			$tp=0;
			$tr=0;
							
			for($i=1;$i < 13;$i++)
			{
				// get visitors
				$this->resetVar(1);
				$sql = "SELECT SQL_BIG_RESULT count(*) FROM `#__TFS_visits` LEFT JOIN `#__TFS_ipaddresses` ON (#__TFS_visits.ip_id=#__TFS_ipaddresses.id) WHERE #__TFS_ipaddresses.type=1 and #__TFS_visits.month=$i and #__TFS_visits.year=$this->y";
				$this->resetVar(0);
	
				$this->MainFrame->_db->setQuery($sql);
			
				$rs = mysql_query($this->MainFrame->_db->_sql);

				$row = mysql_fetch_array($rs);
				
				$v = $row[0];

				if($v == null)
				{
					$v=0;
				}
				
				$tv += $v;
								
				mysql_free_result($rs);

				// get Unique visitors
				$this->resetVar(1);
				$sql = "SELECT SQL_BIG_RESULT count(*) FROM `#__TFS_visits` LEFT JOIN `#__TFS_ipaddresses` ON (#__TFS_visits.ip_id=#__TFS_ipaddresses.id) WHERE #__TFS_ipaddresses.type=1 and #__TFS_visits.month=$i and #__TFS_visits.year=$this->y group by #__TFS_visits.ip_id";
				$this->resetVar(0);

				$this->MainFrame->_db->setQuery($sql);
			
				$rs = mysql_query($this->MainFrame->_db->_sql);

				$uv = mysql_num_rows($rs);
								
				if($uv == null)
				{
					$uv=0;
				}

				$tuv += $uv;

				mysql_free_result($rs);

				// get bots
				$this->resetVar(1);
				$sql = "SELECT SQL_BIG_RESULT count(*) FROM `#__TFS_visits` LEFT JOIN `#__TFS_ipaddresses` ON (#__TFS_visits.ip_id=#__TFS_ipaddresses.id) WHERE #__TFS_ipaddresses.type=2 and #__TFS_visits.month=$i and #__TFS_visits.year=$this->y";
				$this->resetVar(0);
	
				$this->MainFrame->_db->setQuery($sql);
			
				$rs = mysql_query($this->MainFrame->_db->_sql);
				
				$row = mysql_fetch_array($rs);

				$b = $row[0];

				if($b == null)
				{
					$b=0;
				}

				$tb += $b;
				
				mysql_free_result($rs);

				// get Unique bots
				$this->resetVar(1);
				$sql = "SELECT SQL_BIG_RESULT count(*) FROM `#__TFS_visits` LEFT JOIN `#__TFS_ipaddresses` ON (#__TFS_visits.ip_id=#__TFS_ipaddresses.id) WHERE #__TFS_ipaddresses.type=2 and #__TFS_visits.month=$i and #__TFS_visits.year=$this->y group by #__TFS_ipaddresses.browser";
				$this->resetVar(0);

				$this->MainFrame->_db->setQuery($sql);
			
				$rs = mysql_query($this->MainFrame->_db->_sql);
				
				$ub = mysql_num_rows($rs);
								
				if($ub == null)
				{
					$ub=0;
				}

				$tub += $ub;
				
				mysql_free_result($rs);

				// get Pages
				$this->resetVar(1);
				$sql = "SELECT SQL_BIG_RESULT count(*) FROM `#__TFS_page_request` WHERE month=$i and year=$this->y";
				$this->resetVar(0);

				$this->MainFrame->_db->setQuery($sql);
			
				$rs = mysql_query($this->MainFrame->_db->_sql);

				$row = mysql_fetch_array($rs);
				
				$p = $row[0];
								
				if($p == null)
				{
					$p=0;
				}

				//$tp += $p;
				
				mysql_free_result($rs);
				$row = NULL;
				
				// get purged Pages
				$this->resetVar(1);
				$sql = "SELECT SQL_BIG_RESULT sum(count) FROM `#__TFS_page_request_c` WHERE month=$i and year=$this->y";
				$this->resetVar(0);

				$this->MainFrame->_db->setQuery($sql);
			
				$rs = mysql_query($this->MainFrame->_db->_sql);

				$row = mysql_fetch_array($rs);
				
				$p += $row[0];
								
				if($p == null)
				{
					$p=0;
				}

				$tp += $p;
				
				mysql_free_result($rs);

				// get Referrers
				$this->resetVar(1);
				$sql = "SELECT SQL_BIG_RESULT count(*) FROM `#__TFS_referrer` WHERE month=$i and year=$this->y";
				$this->resetVar(0);

				$this->MainFrame->_db->setQuery($sql);
			
				$rs = mysql_query($this->MainFrame->_db->_sql);

				$row = mysql_fetch_array($rs);
				
				$r = $row[0];
								
				if($r == null)
				{
					$r=0;
				}

				$tr += $r;
				
				mysql_free_result($rs);
			
				$retval .= "<tr>";
				$retval .= "<td align=\"center\">$a[$i]</td>";
				$retval .= "<td align=\"center\">$uv</td>";
				$retval .= "<td align=\"center\">$v</td>";
				$retval .= "<td align=\"center\">";
				
				if (($uv != 0)&&($v != 0))
				{
					$retval .= number_format(round(($v/$uv),1),1);
				}
				else
				{
					$retval .= "0.0";
				}
				
				$retval .="</td>";
				$retval .= "<td align=\"center\">$ub</td>";
				$retval .= "<td align=\"center\">$b</td>";
				$retval .= "<td align=\"center\">$p</td>";
				$retval .= "<td align=\"center\">$r</td>";
				$retval .= "</tr>";
			}
			
				$retval .= "<tr>";
				$retval .= "<th align=\"center\">&nbsp;</th>";
				$retval .= "<th align=\"center\">$tuv</th>";
				$retval .= "<th align=\"center\">$tv</th>";
				$retval .= "<th align=\"center\">&nbsp;</th>";
				$retval .= "<th align=\"center\">$tub</th>";
				$retval .= "<th align=\"center\">$tb</th>";
				$retval .= "<th align=\"center\">$tp</th>";
				$retval .= "<th align=\"center\">$tr</th>";
				$retval .= "</tr>";
						 
			$retval .= '</table><br>';
			$retval .= '<center>[&nbsp;<a href="javascript:history.back(1)">Back</a>&nbsp;]</center>';
			
			return $retval;
		}

		function msummary()
		{

			$dm = array(0,31,28 + date('L',mktime('','','',$this->m,$this->d,$this->y)),31,30,31,30,31,31,30,31,30,31);
			
			$retval = '<table class="adminlist" cellspacing="0" width="100%"><tr>';
			$retval .= '<th align="center" nowrap>'.$this->language['tableheaders']['t01'].'</th>';
			$retval .= '<th align="center" nowrap>'.$this->language['tableheaders']['t03'].'</th>';
			$retval .= '<th align="center" nowrap>'.$this->language['tableheaders']['t04'].'</th>';
			$retval .= '<th align="center" nowrap>'.$this->language['tableheaders']['t05'].'</th>';
			$retval .= '<th align="center" nowrap>'.$this->language['tableheaders']['t06'].'</th>';
			$retval .= '<th align="center" nowrap>'.$this->language['tableheaders']['t07'].'</th>';
			$retval .= '<th align="center" nowrap>'.$this->language['tableheaders']['t08'].'</th>';
			$retval .= '<th align="center" nowrap>'.$this->language['tableheaders']['t09'].'</th>';
			$retval .= '</tr>';
				
			$tuv=0;
			$tv=0;
			$tub=0;
			$tb=0;
			$tp=0;
			$tr=0;
							
			for($i=1;$i <= $dm[$this->m];$i++)
			{
				// get visitors
				$this->resetVar(1);
				$sql = "SELECT SQL_BIG_RESULT count(*) FROM #__TFS_visits LEFT JOIN #__TFS_ipaddresses ON (#__TFS_visits.ip_id=#__TFS_ipaddresses.id) WHERE #__TFS_ipaddresses.type=1 and #__TFS_visits.day=$i and #__TFS_visits.month=$this->m and #__TFS_visits.year=$this->y";
				$this->resetVar(0);
	
				$this->MainFrame->_db->setQuery($sql);
			
				$rs = mysql_query($this->MainFrame->_db->_sql);
				
				$row = mysql_fetch_array($rs);
				
				$v = $row[0];

				if($v == null)
				{
					$v=0;
				}
				
				$tv += $v;
								
				mysql_free_result($rs);

				// get Unique visitors
				$this->resetVar(1);
				$sql = "SELECT SQL_BIG_RESULT count(*) FROM #__TFS_visits LEFT JOIN #__TFS_ipaddresses ON (#__TFS_visits.ip_id=#__TFS_ipaddresses.id) WHERE #__TFS_ipaddresses.type=1 and #__TFS_visits.day=$i and #__TFS_visits.month=$this->m and #__TFS_visits.year=$this->y group by #__TFS_visits.ip_id";
				$this->resetVar(0);

				$this->MainFrame->_db->setQuery($sql);
			
				$rs = mysql_query($this->MainFrame->_db->_sql);

				$uv = mysql_num_rows($rs);
								
				if($uv == null)
				{
					$uv=0;
				}

				$tuv += $uv;

				mysql_free_result($rs);

				// get bots
				$this->resetVar(1);
				$sql = "SELECT SQL_BIG_RESULT count(*) FROM #__TFS_visits LEFT JOIN #__TFS_ipaddresses ON (#__TFS_visits.ip_id=#__TFS_ipaddresses.id) WHERE #__TFS_ipaddresses.type=2 and #__TFS_visits.day=$i and #__TFS_visits.month=$this->m and #__TFS_visits.year=$this->y";	
				$this->resetVar(0);

				$this->MainFrame->_db->setQuery($sql);
			
				$rs = mysql_query($this->MainFrame->_db->_sql);

				$row = mysql_fetch_array($rs);
				
				$b = $row[0];

				if($b == null)
				{
					$b=0;
				}

				$tb += $b;
				
				mysql_free_result($rs);

				// get Unique bots
				$this->resetVar(1);
				$sql = "SELECT SQL_BIG_RESULT count(*) FROM #__TFS_visits LEFT JOIN #__TFS_ipaddresses ON (#__TFS_visits.ip_id=#__TFS_ipaddresses.id) WHERE #__TFS_ipaddresses.type=2 and #__TFS_visits.day=$i and #__TFS_visits.month=$this->m and #__TFS_visits.year=$this->y group by #__TFS_ipaddresses.browser";
				$this->resetVar(0);

				$this->MainFrame->_db->setQuery($sql);
			
				$rs = mysql_query($this->MainFrame->_db->_sql);
				
				$ub = mysql_num_rows($rs);
								
				if($ub == null)
				{
					$ub=0;
				}

				$tub += $ub;
				
				mysql_free_result($rs);

				// get Pages
				$this->resetVar(1);
				$sql = "SELECT SQL_BIG_RESULT count(*) FROM #__TFS_page_request WHERE day=$i and month=$this->m and year=$this->y";
				$this->resetVar(0);

				$this->MainFrame->_db->setQuery($sql);
			
				$rs = mysql_query($this->MainFrame->_db->_sql);

				$row = mysql_fetch_array($rs);
				
				$p = $row[0];
								
				if($p == null)
				{
					$p=0;
				}

				//$tp += $p;
				
				mysql_free_result($rs);
				$row = NULL;
				
				// get purged Pages
				$this->resetVar(1);
				$sql = "SELECT SQL_BIG_RESULT sum(count) FROM #__TFS_page_request_c WHERE day=$i and month=$this->m and year=$this->y";
				$this->resetVar(0);

				$this->MainFrame->_db->setQuery($sql);
			
				$rs = mysql_query($this->MainFrame->_db->_sql);

				$row = mysql_fetch_array($rs);
				
				$p += $row[0];
								
				if($p == null)
				{
					$p=0;
				}

				$tp += $p;
				
				mysql_free_result($rs);

				// get Referrers
				$this->resetVar(1);
				$sql = "SELECT SQL_BIG_RESULT count(*) FROM #__TFS_referrer WHERE day=$i and month=$this->m and year=$this->y";
				$this->resetVar(0);

				$this->MainFrame->_db->setQuery($sql);
			
				$rs = mysql_query($this->MainFrame->_db->_sql);

				$row = mysql_fetch_array($rs);
				
				$r = $row[0];
								
				if($r == null)
				{
					$r=0;
				}

				$tr += $r;
				
				mysql_free_result($rs);
							
				if ((date("w",strtotime("$this->y-$this->m-$i")) == 6)||(date("w",strtotime("$this->y-$this->m-$i")) == 0))
				{
					$cls='row0';
				}
				else
				{
					$cls='row1';
				}

				$retval .= "<tr class=\"$cls\">";
				$retval .= "<td align=\"center\">";
				
				if (strlen($i) == 1)
				{ 
					$retval .= "0$i";
				} 
				else
				{
					$retval .= $i;
				}
				
				$retval .="</td>";
				$retval .= "<td align=\"center\">$uv</td>";
				$retval .= "<td align=\"center\">$v</td>";
				$retval .= "<td align=\"center\">";

				if (($uv != 0)&&($v != 0))
				{
					$retval .= number_format(round(($v/$uv),1),1);
				}
				else
				{
					$retval .= "0.0";
				}

				$retval .= "</td>";
				$retval .= "<td align=\"center\">$ub</td>";
				$retval .= "<td align=\"center\">$b</td>";
				$retval .= "<td align=\"center\">$p</td>";
				$retval .= "<td align=\"center\">$r</td>";
				$retval .= "</tr>";
			}
			
				$retval .= "<tr>";
				$retval .= "<th align=\"center\">&nbsp;</th>";
				$retval .= "<th align=\"center\">&nbsp;</th>";
				$retval .= "<th align=\"center\">$tv</th>";
				$retval .= "<th align=\"center\">&nbsp;</th>";
				$retval .= "<th align=\"center\">&nbsp;</th>";
				$retval .= "<th align=\"center\">$tb</th>";
				$retval .= "<th align=\"center\">$tp</th>";
				$retval .= "<th align=\"center\">$tr</th>";
				$retval .= "</tr>";
		
			$retval .= '</table><br>';
			$retval .= '<center>[&nbsp;<a href="javascript:history.back(1)">Back</a>&nbsp;]</center>';
			
			return $retval;
		}
		
		function VisitInformation()
		{
			$retval = '<table class="adminlist" cellspacing="0" width="100%"><tr>';
			$retval .= '<th align="left">'.$this->language['tableheaders']['t10'].'</th>';
			$retval .= '<th align="left">'.$this->language['tableheaders']['t11'].'</th>';
			$retval .= '<th align="left">'.$this->language['tableheaders']['t12'].'</th>';
			$retval .= '<th align="left">'.$this->language['tableheaders']['t08'].'</th>';
			$retval .= '<th align="left">'.$this->language['tableheaders']['t13'].'</th>';
			$retval .= '<th align="left">'.$this->language['tableheaders']['t14'].'</th>';
			$retval .= '<th align="left">'.$this->language['tableheaders']['t15'].'</th>';
			$retval .= '</tr>';

			$this->resetVar(1);
			$sql = "SELECT SQL_BIG_RESULT #__TFS_ipaddresses.tld, #__TFS_topleveldomains.fullname, #__TFS_ipaddresses.nslookup, #__TFS_ipaddresses.system, #__TFS_ipaddresses.browser, #__TFS_visits.time,#__TFS_visits.id FROM #__TFS_ipaddresses LEFT JOIN #__TFS_topleveldomains ON (#__TFS_ipaddresses.tld = #__TFS_topleveldomains.tld) LEFT JOIN #__TFS_visits ON (#__TFS_ipaddresses.id = #__TFS_visits.ip_id) WHERE (#__TFS_ipaddresses.type != 2 and #__TFS_visits.day LIKE '$this->d' AND #__TFS_visits.month LIKE '$this->m' AND #__TFS_visits.year LIKE '$this->y') ORDER BY #__TFS_visits.time DESC";
			$this->resetVar(0);
	
			$this->MainFrame->_db->setQuery($sql);
		
			$rs = mysql_query($this->MainFrame->_db->_sql);
						
			while ($row = mysql_fetch_array($rs)) 
			{
				$vid = $row['id'];

				$sql = "SELECT SQL_BIG_RESULT count( * ) AS count FROM #__TFS_page_request WHERE #__TFS_page_request.ip_id = $vid";
				$this->MainFrame->_db->setQuery($sql);
				$rsCount = mysql_query($this->MainFrame->_db->_sql);
				
				$rowCount = mysql_fetch_array($rsCount);
				
				$retval .= '<tr>';
				$retval .= "<td align=\"left\" nowrap>&nbsp;$row[0]</td>";
				$retval .= "<td align=\"left\" nowrap>&nbsp;$row[1]</td>";
				$retval .= "<td align=\"left\" nowrap><a title=\"$row[2]\" href=\"index2.php?option=com_tfsformambo&task=r03a&d=$this->d&m=$this->m&y=$this->y&v=$vid\">";
				if(strlen($row[2]) > 45){ $retval .=substr($row[2],1,45);}else{ $retval .= $row[2];}
				$retval .="</a></td>";
				$retval .= "<td align=\"left\">$rowCount[0]</td>";
				$retval .= "<td align=\"left\">&nbsp;$row[3]</td>";
				$retval .= "<td align=\"left\" nowrap>&nbsp;$row[4]</td>";
				$retval .= "<td align=\"left\" nowrap>".$row[5]."</td>";				
				$retval .= '</tr>';
				
				mysql_free_result($rsCount);
			}    		

			$this->resetVar(1);
			
			mysql_free_result($rs);
								
			$retval .= '</table><br>';
			$retval .= '<center>[&nbsp;<a href="javascript:history.back(1)">Back</a>&nbsp;]</center>';
			
			return $retval;
		}

		function botsInformation()
		{		
			$retval = '<table class="adminlist" cellspacing="0" width="100%"><tr>';
			$retval .= '<th width="10%" align="left">'.$this->language['tableheaders']['t10'].'</th>';
			$retval .= '<th width="10%" align="left">'.$this->language['tableheaders']['t11'].'</th>';
			$retval .= '<th width="10%" align="left">'.$this->language['tableheaders']['t16'].'</th>';
			$retval .= '<th width="10%" align="left">'.$this->language['tableheaders']['t08'].'</th>';
			$retval .= '<th width="100%" align="left">'.$this->language['tableheaders']['t15'].'</th>';
			$retval .= '</tr>';
		
			$this->resetVar(1);
			$sql = "SELECT SQL_BIG_RESULT #__TFS_ipaddresses.tld, #__TFS_topleveldomains.fullname, #__TFS_ipaddresses.browser, #__TFS_visits.time, #__TFS_visits.id FROM #__TFS_ipaddresses LEFT JOIN #__TFS_topleveldomains ON (#__TFS_ipaddresses.tld = #__TFS_topleveldomains.tld) LEFT JOIN #__TFS_visits ON (#__TFS_visits.ip_id = #__TFS_ipaddresses.id) WHERE (#__TFS_ipaddresses.type = 2 AND #__TFS_visits.day LIKE '$this->d' AND #__TFS_visits.month LIKE '$this->m' AND #__TFS_visits.year LIKE '$this->y') ORDER BY #__TFS_visits.time DESC";
			$this->resetVar(0);
	
			$this->MainFrame->_db->setQuery($sql);
		
			$rs = mysql_query($this->MainFrame->_db->_sql);

			while ($row = mysql_fetch_array($rs)) 
			{

				$vid = $row['id'];

				$sql = "SELECT SQL_BIG_RESULT count( * ) AS count FROM #__TFS_page_request WHERE #__TFS_page_request.ip_id = $vid";
				$this->MainFrame->_db->setQuery($sql);
				$rsCount = mysql_query($this->MainFrame->_db->_sql);
				
				$rowCount = mysql_fetch_array($rsCount);
				
				$retval .= '<tr>';
				$retval .= "<td align=\"left\" nowrap>&nbsp;$row[0]</td>";
				$retval .= "<td align=\"left\" nowrap>&nbsp;$row[1]</td>";
				$retval .= "<td align=\"left\" nowrap><a href=\"index2.php?option=com_tfsformambo&task=r09a&d=$this->d&m=$this->m&y=$this->y&v=$vid\">&nbsp;$row[2]</a></td>";
				$retval .= "<td align=\"left\" nowrap>$rowCount[0]</td>";
				$retval .= "<td align=\"left\" nowrap>".$row[3]."</td>";				
				$retval .= '</tr>';
			
				mysql_free_result($rsCount);
				
			}    		
			
			mysql_free_result($rs);
					
			$retval .= '</table><br>';
			$retval .= '<center>[&nbsp;<a href="javascript:history.back(1)">Back</a>&nbsp;]</center>';
			
			return $retval;
		}

		function getVisitorsByTld()
		{		
			$totalnmb = 0;

			$retval = '<table class="adminlist" cellspacing="0" width="100%"><tr>';
		
			$retval .= '<th align="left">'.$this->language['tableheaders']['t17'].'</th>';
			$retval .= '<th align="center" width="20%">'.$this->language['tableheaders']['t04'].'</th>';
			$retval .= '<th align="left" width="5%">'.$this->language['tableheaders']['t18'].'</th>';
			$retval .= '<th align="left" width="5%">'.$this->language['tableheaders']['t19'].'</th>';
			$retval .= '<th align="left" width="100%">'.$this->language['tableheaders']['t11'].'</th>';
			
			$retval .= '</tr>';
			
			$this->resetVar(1);
			$sql = "SELECT SQL_BIG_RESULT count(*) AS numbers,#__TFS_ipaddresses.tld,#__TFS_topleveldomains.fullname FROM #__TFS_ipaddresses LEFT JOIN #__TFS_topleveldomains ON(#__TFS_ipaddresses.tld = #__TFS_topleveldomains.tld) LEFT JOIN #__TFS_visits ON(#__TFS_ipaddresses.id = #__TFS_visits.ip_id) WHERE ((#__TFS_visits.day LIKE '$this->d') AND (#__TFS_visits.month LIKE '$this->m') AND (#__TFS_visits.year LIKE '$this->y') AND (#__TFS_ipaddresses.type='1')) GROUP BY tld ORDER BY numbers DESC, #__TFS_topleveldomains.fullname ASC";
			$this->resetVar(0);
	
			$this->MainFrame->_db->setQuery($sql);
		
			$rs = mysql_query($this->MainFrame->_db->_sql);
			
			while ($row = mysql_fetch_array($rs)) 
			{
				$totalnmb += $row['numbers'];
			}    		
			
			if($totalnmb != 0)
			{
				mysql_data_seek($rs,0);
				
				while ($row = mysql_fetch_array($rs)) 
				{
					$retval .= '<tr>';
		
					if ($row[1] == '')
					{
						$retval .= "<td align=\"left\"><img src=\"../components/com_tfsformambo/images/unknown.png\"></td>";
					}
					else
					{
						$retval .= "<td align=\"left\"><img src=\"../components/com_tfsformambo/images/".$row[1].".png\"></td>";
					}
					
					$retval .= "<td align=\"center\" nowrap>&nbsp;$row[0]</td>";
	
					$retval .= "<td align=\"left\" nowrap>&nbsp;".round((($row[0]/$totalnmb)*100),1)."%</td>";
					$retval .= "<td align=\"left\" nowrap>&nbsp;$row[1]</td>";
					$retval .= "<td align=\"left\" nowrap>&nbsp;$row[2]</td>";
					$retval .= '</tr>';
	
				} //while		
			} // end if $totalnmb != 0
			
			$retval .='<tr><th>&nbsp;</th><th>&nbsp;'.$totalnmb.'</th><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th><tr>';

			mysql_free_result($rs);
		
			$retval .= '</table><br>';
			$retval .= '<center>[&nbsp;<a href="javascript:history.back(1)">Back</a>&nbsp;]</center>';
			
			return $retval;
		}

		function getPageHits()
		{

			$pc = 0;

			$totalnmb = 0;
				
			$retval = '<table class="adminlist" cellspacing="0" width="100%"><tr>';
			$retval .= '<th width="10%">'.$this->language['tableheaders']['t28'].'</th>';
			$retval .= '<th width="10%">'.$this->language['tableheaders']['t18'].'</th>';
			$retval .= '<th align="left" width="100%">'.$this->language['tableheaders']['t20'].'</th>';
			$retval .= '</tr>';
			
			$rettable = NULL;
			
			$sql = "SELECT SQL_BIG_RESULT page,page_id FROM #__TFS_pages";
			
			$this->MainFrame->_db->setQuery($sql);
		
			$rs = mysql_query($this->MainFrame->_db->_sql);
						
			while ($row = mysql_fetch_array($rs)) 
			{

				$this->resetVar(1);
				$sqla = "SELECT SQL_BIG_RESULT count(*) numbers FROM #__TFS_page_request WHERE ((#__TFS_page_request.page_id = $row[1]) AND (#__TFS_page_request.day LIKE '$this->d') AND (#__TFS_page_request.month LIKE '$this->m') AND (#__TFS_page_request.year LIKE '$this->y'))";
				$sqlb = "SELECT SQL_BIG_RESULT sum(count) FROM #__TFS_page_request_c WHERE ((#__TFS_page_request_c.day LIKE '$this->d') AND (#__TFS_page_request_c.month LIKE '$this->m') AND (#__TFS_page_request_c.year LIKE '$this->y') AND (#__TFS_page_request_c.page_id = $row[1]))";
				$this->resetVar(0);
							
				$this->MainFrame->_db->setQuery($sqla);
				$rsa = mysql_query($this->MainFrame->_db->_sql);
				$rowa = mysql_fetch_array($rsa);

				$this->MainFrame->_db->setQuery($sqlb);
				$rsb = mysql_query($this->MainFrame->_db->_sql);
				$rowb = mysql_fetch_array($rsb);
				
				if (($rowa[0] + $rowb[0]) > 0)
				{					
					$rettable[$row[0]]=($rowa[0] + $rowb[0]);
				}
				
				mysql_free_result($rsa);
				mysql_free_result($rsb);
			
			}    		

			mysql_free_result($rs);

			if($rettable)
			{
				arsort ($rettable);
	
				reset ($rettable);
				while (list ($key, $val) = each ($rettable))
				{
					$totalnmb+=$val;
				}						
	
				reset ($rettable);
				while (list ($key, $val) = each ($rettable))
				{
					$retval .= '<tr>';
					$retval .= "<td align=\"center\" nowrap>&nbsp;".$val."</td>";
					$retval .= "<td align=\"center\" nowrap>&nbsp;".round((($val/$totalnmb)*100),1)."%</td>";
					$retval .= "<td align=\"left\" nowrap>&nbsp;".$key."</td>";
					$retval .= "</tr>\n";
				} // while
									
			} // if $rettable
										
			$retval .='<tr>';
			$retval .='<th >&nbsp;'.$totalnmb.'</th>';
			$retval .='<th >&nbsp;</th>';
			$retval .='<th >&nbsp;</th>';
			$retval .='<tr>';
								
			$retval .= '</table><br>';
			$retval .= '<center>[&nbsp;<a href="javascript:history.back(1)">Back</a>&nbsp;]</center>';
			
			return $retval;
		}

		function getSystems()
		{
			$totalnmb = 0;
		
			$retval = '<table class="adminlist" cellspacing="0" width="100%"><tr>';
			$retval .= '<th width="10%">'.$this->language['tableheaders']['t28'].'</th>';
			$retval .= '<th width="10%">'.$this->language['tableheaders']['t18'].'</th>';
			$retval .= '<th align="left" width="100%">'.$this->language['tableheaders']['t13'].'</th>';
			$retval .= '</tr>';
			
			$this->resetVar(1);
			$sql = "SELECT SQL_BIG_RESULT #__TFS_ipaddresses.system,count(*) numbers FROM #__TFS_ipaddresses,#__TFS_visits WHERE ((#__TFS_ipaddresses.id = #__TFS_visits.ip_id) AND (#__TFS_visits.day LIKE '$this->d') AND (#__TFS_visits.month LIKE '$this->m') AND (#__TFS_visits.year LIKE '$this->y') AND (#__TFS_ipaddresses.type = 1)) GROUP BY #__TFS_ipaddresses.system ORDER BY numbers DESC, #__TFS_ipaddresses.system ASC";
			$this->resetVar(0);
	
			$this->MainFrame->_db->setQuery($sql);
		
			$rs = mysql_query($this->MainFrame->_db->_sql);

			while ($row = mysql_fetch_array($rs)) 
			{
				$totalnmb += $row[1];
			}    		

			if($totalnmb != 0)
			{
				mysql_data_seek($rs,0);
	
				while ($row = mysql_fetch_array($rs)) 
				{
					$retval .= "<tr><td align=\"center\" nowrap>&nbsp;$row[1]</td><td align=\"center\" nowrap>&nbsp;".round((($row[1]/$totalnmb)*100),1)."%</td><td align=\"left\" nowrap>&nbsp;$row[0]</td></tr>\n";
				} //while
			} // if $totalnmb != 0
						
			$retval .='<tr><th >&nbsp;'.$totalnmb.'</th><th >&nbsp;</th><th >&nbsp;</th><th >&nbsp;</th><tr>';

			mysql_free_result($rs);
			
			$retval .= '</table><br>';
			$retval .= '<center>[&nbsp;<a href="javascript:history.back(1)">Back</a>&nbsp;]</center>';
			
			return $retval;
		}

		function getBrowsers()
		{
		
			$retval = '<table class="adminlist" cellspacing="0" width="100%"><tr>';
			$retval .= '<th width="10%">'.$this->language['tableheaders']['t28'].'</th>';
			$retval .= '<th width="10%">'.$this->language['tableheaders']['t18'].'</th>';
			$retval .= '<th align="left" width="100%">'.$this->language['tableheaders']['t21'].'</th>';
			$retval .= '</tr>';
			
			$totalnmb = 0;
			
			$this->resetVar(1);
			$sql = "SELECT SQL_BIG_RESULT #__TFS_ipaddresses.browser,count(*) numbers FROM #__TFS_ipaddresses,#__TFS_visits WHERE ((#__TFS_visits.ip_id = #__TFS_ipaddresses.id) AND (#__TFS_ipaddresses.type =1) AND (#__TFS_visits.day LIKE '$this->d') AND (#__TFS_visits.month LIKE '$this->m') AND (#__TFS_visits.year LIKE '$this->y')) GROUP BY #__TFS_ipaddresses.browser ORDER BY numbers DESC, #__TFS_ipaddresses.browser ASC";
			$this->resetVar(0);
	
			$this->MainFrame->_db->setQuery($sql);
		
			$rs = mysql_query($this->MainFrame->_db->_sql);

			while ($row = mysql_fetch_array($rs)) 
			{
				$totalnmb += $row[1];
			}    		

			if($totalnmb != 0)
			{
				mysql_data_seek($rs,0);
	
				while ($row = mysql_fetch_array($rs)) 
				{
					$retval .= "<tr><td align=\"center\" nowrap>&nbsp;$row[1]</td><td align=\"center\" nowrap>&nbsp;".round((($row[1]/$totalnmb)*100),1)."%</td><td align=\"left\" nowrap>&nbsp;$row[0]</td></tr>\n";
				} //while		
			} // if %totalnmb !=0
			
			$retval .='<tr><th >&nbsp;'.$totalnmb.'</th><th >&nbsp;</th><th >&nbsp;</th><tr>';

			mysql_free_result($rs);
					
			$retval .= '</table><br>';
			$retval .= '<center>[&nbsp;<a href="javascript:history.back(1)">Back</a>&nbsp;]</center>';
			
			return $retval;
		}

		function getBots()
		{
			$retval = '<table class="adminlist" cellspacing="0" width="100%"><tr>';
			$retval .= '<th width="10%">'.$this->language['tableheaders']['t28'].'</th>';
			$retval .= '<th width="10%">'.$this->language['tableheaders']['t18'].'</th>';
			$retval .= '<th align="left" width="100%">'.$this->language['tableheaders']['t22'].'</th>';
			$retval .= '</tr>';
			
			$totalnmb = 0;
			
			$this->resetVar(1);
			$sql = "SELECT SQL_BIG_RESULT #__TFS_ipaddresses.browser,count(*) numbers FROM #__TFS_ipaddresses,#__TFS_visits WHERE ((#__TFS_visits.ip_id = #__TFS_ipaddresses.id) AND (#__TFS_ipaddresses.browser !='') AND (#__TFS_ipaddresses.type =2) AND (#__TFS_visits.day LIKE '$this->d') AND (#__TFS_visits.month LIKE '$this->m') AND (#__TFS_visits.year LIKE '$this->y')) GROUP BY #__TFS_ipaddresses.browser ORDER BY numbers DESC, #__TFS_ipaddresses.browser ASC";
			$this->resetVar(0);
	
			$this->MainFrame->_db->setQuery($sql);
		
			$rs = mysql_query($this->MainFrame->_db->_sql);

			while ($row = mysql_fetch_array($rs)) 
			{
				$totalnmb += $row[1];
			}    		
			
			if ($totalnmb != 0)
			{
				mysql_data_seek($rs,0);
	
				while ($row = mysql_fetch_array($rs)) 
				{
					$retval .= "<tr><td align=\"center\" nowrap>&nbsp;$row[1]</td><td align=\"center\" nowrap>&nbsp;".round((($row[1]/$totalnmb)*100),1)."%</td><td align=\"left\" nowrap>&nbsp;$row[0]</td></tr>\n";
				} //while		
			} // if $totalnmb !=0
			
			$retval .='<tr><th >&nbsp;'.$totalnmb.'</th><th >&nbsp;</th><th >&nbsp;</th><tr>';
			
			mysql_free_result($rs);

			$retval .= '</table><br>';
			$retval .= '<center>[&nbsp;<a href="javascript:history.back(1)">Back</a>&nbsp;]</center>';
			
			return $retval;
		}

		function getReferrers()
		{
		
			$retval = '<table class="adminlist" cellspacing="0" width="100%"><tr>';
			
			$totalnmb = 0;
			
				
			if($this->dom == ''){$this->dom='%';}
			
			$this->resetVar(1);
			if($this->dom == '%')
			{
				$sql = "SELECT SQL_BIG_RESULT domain, count(*) counter FROM #__TFS_referrer WHERE day LIKE '$this->d' AND month LIKE '$this->m' AND year LIKE '$this->y' AND domain LIKE '$this->dom' group by domain order by counter DESC, domain ASC";
			}
			else
			{
				$sql = "SELECT SQL_BIG_RESULT referrer, count(*) counter FROM #__TFS_referrer WHERE day LIKE '$this->d' AND month LIKE '$this->m' AND year LIKE '$this->y' AND domain LIKE '$this->dom' group by referrer order by counter DESC, referrer ASC";			
			}
			$this->resetVar(0);
			
			$this->MainFrame->_db->setQuery($sql);
		
			$rs = mysql_query($this->MainFrame->_db->_sql);

			if($this->dom == '%')
			{
				$retval .= '<th width="10%" nowrap>'.$this->language['tableheaders']['t28'].'</th>';
				$retval .= '<th width="10%">'.$this->language['tableheaders']['t18'].'</th>';
				$retval .= '<th align="left" width="100%">'.$this->language['tableheaders']['t23'].'</th>';
				$retval .= '</tr>';

				while ($row = mysql_fetch_array($rs)) 
				{
					$totalnmb += $row[1];
				}    		
				
				if($totalnmb != 0)
				{
					mysql_data_seek($rs,0);
	
					$this->resetVar(0);
					
					while ($row = mysql_fetch_array($rs)) 
					{
						$retval .= "<tr><td align=\"center\" nowrap>&nbsp;$row[1]</td><td align=\"center\" nowrap>&nbsp;".round((($row[1]/$totalnmb)*100),1)."%</td><td nowrap>&nbsp;<a href=\"index2.php?option=com_tfsformambo&task=r10&dom=$row[0]&d=$this->d&m=$this->m&y=$this->y\">$row[0]</a></td></tr>\n";
					}//while		

					$this->resetVar(1);

				} // if $totalnmb !=0				
				$retval .='<tr><th>&nbsp;'.$totalnmb.'</th><th>&nbsp;</th><th>&nbsp;</th><tr>';
			}
			else
			{
				$retval .= '<th width="10%" nowrap>'.$this->language['tableheaders']['t28'].'</th>';
				$retval .= '<th width="10%">'.$this->language['tableheaders']['t18'].'</th>';
				$retval .= '<th align="left" width="100%">'.$this->language['tableheaders']['t24'].'</th>';
				$retval .= '</tr>';

				while ($row = mysql_fetch_array($rs)) 
				{
					$totalnmb += $row[1];
				}    		
				
				if($totalnmb !=0)
				{
					mysql_data_seek($rs,0);
	
					while ($row = mysql_fetch_array($rs)) 
					{
						$retval .= "<tr><td align=\"center\" nowrap>&nbsp;$row[1]</td><td align=\"center\" nowrap>&nbsp;".round((($row[1]/$totalnmb)*100),1)."%</td><td width=\"100%\" nowrap><a href=\"$row[0]\">$row[0]</a></td></tr>\n";
					} //while		
				} // if $totalnmb !=0
				
				$retval .='<tr><th >&nbsp;'.$totalnmb.'</th><th >&nbsp;</th><th >&nbsp;</th><tr>';

			}			

			mysql_free_result($rs);
			
			$retval .= '</table><br>';
			$retval .= '<center>[&nbsp;<a href="javascript:history.back(1)">Back</a>&nbsp;]</center>';
			
			return $retval;
		}

		function getNotIdentified()
		{
			$retval = '<table class="adminlist" cellspacing="0" width="100%"><tr>';
			$retval .= '<th align="left" width="10%">'.$this->language['tableheaders']['t19'].'</th>';
			$retval .= '<th align="left" width="10%">'.$this->language['tableheaders']['t11'].'</th>';
			$retval .= '<th align="left" width="10%">'.$this->language['tableheaders']['t27'].'</th>';
			$retval .= '<th align="left" width="100%">'.$this->language['tableheaders']['t15'].'</th>';
			$retval .= '</tr>';
					
			$this->resetVar(1);
			$sql = "SELECT SQL_BIG_RESULT #__TFS_ipaddresses.tld, #__TFS_topleveldomains.fullname, #__TFS_ipaddresses.useragent, #__TFS_visits.time FROM #__TFS_ipaddresses, #__TFS_topleveldomains, #__TFS_visits WHERE (( #__TFS_ipaddresses.tld = #__TFS_topleveldomains.tld ) AND ( #__TFS_visits.ip_id = #__TFS_ipaddresses.id ) AND ( #__TFS_ipaddresses.type = 0) AND (#__TFS_visits.day LIKE '$this->d') AND (#__TFS_visits.month LIKE '$this->m') AND (#__TFS_visits.year LIKE '$this->y')) ORDER BY #__TFS_visits.time DESC";
			$this->resetVar(0);

			$this->MainFrame->_db->setQuery($sql);
		
			$rs = mysql_query($this->MainFrame->_db->_sql);

			while ($row = mysql_fetch_array($rs)) 
			{
				$retval .= '<tr>';
				$retval .= "<td nowrap>&nbsp;$row[0]</td>";
				$retval .= "<td nowrap>&nbsp;$row[1]</td>";
				$retval .= "<td nowrap>&nbsp;$row[2]</td>";
				$retval .= "<td nowrap>". date("d-m-Y H:i:s" ,$row[3])."</td>";				
				$retval .= '</tr>';
			}    		
			
			mysql_free_result($rs);
			
			$retval .= '</table><br>';
			$retval .= '<center>[&nbsp;<a href="javascript:history.back(1)">Back</a>&nbsp;]</center>';
			
			return $retval;
		}

		function getUnknown()
		{
			$retval = '<table class="adminlist" cellspacing="0" width="100%"><tr>';
			$retval .= '<th align="left" width="10%">'.$this->language['tableheaders']['t19'].'</th>';
			$retval .= '<th align="left" width="10%">'.$this->language['tableheaders']['t11'].'</th>';
			$retval .= '<th align="left" width="10%">'.$this->language['tableheaders']['t27'].'</th>';
			$retval .= '<th align="left" width="100%">'.$this->language['tableheaders']['t15'].'</th>';
			$retval .= '</tr>';
					
			$this->resetVar(1);
			$sql = "SELECT SQL_BIG_RESULT #__TFS_ipaddresses.tld, #__TFS_topleveldomains.fullname, #__TFS_ipaddresses.useragent, #__TFS_visits.time FROM #__TFS_ipaddresses, #__TFS_topleveldomains, #__TFS_visits WHERE ((#__TFS_ipaddresses.tld = #__TFS_topleveldomains.tld) AND (#__TFS_visits.ip_id = #__TFS_ipaddresses.id) AND (#__TFS_ipaddresses.browser LIKE 'Unknown%') AND (#__TFS_visits.day LIKE '$this->d') AND (#__TFS_visits.month LIKE '$this->m') AND (#__TFS_visits.year LIKE '$this->y')) ORDER BY #__TFS_visits.time DESC";
			$this->resetVar(0);
	
			$this->MainFrame->_db->setQuery($sql);
		
			$rs = mysql_query($this->MainFrame->_db->_sql);

			while ($row = mysql_fetch_array($rs)) 
			{
				$retval .= '<tr>';
				$retval .= "<td  nowrap>&nbsp;$row[0]</td>";
				$retval .= "<td  nowrap>&nbsp;$row[1]</td>";
				$retval .= "<td  nowrap>&nbsp;$row[2]</td>";
				$retval .= "<td nowrap>". date("d-m-Y H:i:s" ,$row[3])."</td>";				
				$retval .= '</tr>';
			}    		
			
			mysql_free_result($rs);
			
			$retval .= '</table><br>';
			$retval .= '<center>[&nbsp;<a href="javascript:history.back(1)">Back</a>&nbsp;]</center>';
			
			return $retval;
		}

		function moreVisitInfo()
		{
			$totalnmb = 0;
		
			$retval = '<table class="adminlist" cellspacing="0" width="100%"><tr>';
			$retval .= '<th align="left">'.$this->language['tableheaders']['t28'].'</th>';
			$retval .= '<th align="left" width="100%">'.$this->language['tableheaders']['t20'].'</th>';
			$retval .= '</tr>';
			
			$this->resetVar(1);
			$sql = "SELECT SQL_BIG_RESULT count( * ) AS count, #__TFS_pages.page FROM #__TFS_page_request LEFT JOIN #__TFS_pages ON #__TFS_pages.page_id = #__TFS_page_request.page_id WHERE #__TFS_page_request.ip_id = $this->vid GROUP BY #__TFS_pages.page";
			$this->resetVar(0);
			
			$this->MainFrame->_db->setQuery($sql);
		
			$rs = mysql_query($this->MainFrame->_db->_sql);

			if($rs)
			{
				while ($row = mysql_fetch_array($rs)) 
				{
					$retval .= "<tr><td nowrap>&nbsp;".$row['count']."</td><td nowrap>&nbsp;".$row['page']."</td></tr>\n";
				} //while
			}						

			$retval .='<tr><th >&nbsp;</th><th >&nbsp;</th><tr>';

			mysql_free_result($rs);
					
			$retval .= '</table><br>';
			$retval .= '<center>[&nbsp;<a href="javascript:history.back(1)">Back</a>&nbsp;]</center>';
			
			return $retval;
			
		}
		
		function getKeyWords()
		{

			$retval = '<table class="adminlist" cellspacing="0" width="100%"><tr>';
			
			$totalnmb = 0;
			
			if($this->dom == ''){$this->dom='%';}
			
			$this->resetVar(1);
			if($this->dom == '%')
			{
				$sql = "SELECT SQL_BIG_RESULT description, count(*) AS count FROM #__TFS_keywords LEFT JOIN #__TFS_search_engines ON ( #__TFS_keywords.searchid = #__TFS_search_engines.searchid ) WHERE YEAR(kwdate) LIKE '$this->y' AND MONTH(kwdate) LIKE '$this->m' AND DAYOFMONTH(kwdate) LIKE '$this->d' GROUP BY description ORDER BY count DESC";
			}
			else
			{
				$sql = "SELECT SQL_BIG_RESULT keywords, count(*) AS count FROM #__TFS_keywords LEFT JOIN #__TFS_search_engines ON ( #__TFS_keywords.searchid = #__TFS_search_engines.searchid ) WHERE YEAR(kwdate) LIKE '$this->y' AND MONTH(kwdate) LIKE '$this->m' AND DAYOFMONTH(kwdate) LIKE '$this->d' AND description LIKE '$this->dom' GROUP BY keywords ORDER BY count DESC";
			}
			$this->resetVar(0);
			
			$this->MainFrame->_db->setQuery($sql);
		
			$rs = mysql_query($this->MainFrame->_db->_sql);

			if($this->dom == '%')
			{
				$retval .= "\r\n\t\t<th width=\"10%\" nowrap>".$this->language['tableheaders']['t28']."</th>";
				$retval .= "\r\n\t\t<th width=\"10%\">".$this->language['tableheaders']['t18']."</th>";
				$retval .= "\r\n\t\t<th align=\"left\" width=\"100%\">".$this->language['tableheaders']['t25']."</th>";
				$retval .= "\r\n\t\t</tr>";

				while ($row = mysql_fetch_array($rs)) 
				{
					$totalnmb += $row['count'];
				}    		
				
				if($totalnmb != 0)
				{
					mysql_data_seek($rs,0);
	
					$this->resetVar(0);
					
					while ($row = mysql_fetch_array($rs)) 
					{
						$retval .= "\r\n\t<tr>\r\n\t\t<td align=\"center\" nowrap>&nbsp;$row[1]</td>\r\n\t\t<td align=\"center\" nowrap>&nbsp;".round((($row[1]/$totalnmb)*100),1)."%</td>\r\n\t\t<td align=\"left\" nowrap>&nbsp;<a href=\"index2.php?option=com_tfsformambo&task=r14&dom=$row[0]&d=$this->d&m=$this->m&y=$this->y\">$row[0]</a></td>\r\n\t</tr>\n";
					}//while		

					$this->resetVar(1);

				} // if $totalnmb !=0				
				$retval .='<tr><th >&nbsp;'.$totalnmb.'</th><th >&nbsp;</th><th >&nbsp;</th><tr>';
			}
			else
			{
				$retval .= "\r\n\t\t<th width=\"10%\" nowrap>".$this->language['tableheaders']['t28']."</th>";
				$retval .= "\r\n\t\t<th width=\"10%\">".$this->language['tableheaders']['t18']."</th>";
				$retval .= "\r\n\t\t<th align=\"left\" width=\"100%\">".$this->language['tableheaders']['t26']."</th>";
				$retval .= "\r\n\t</tr>";

				while ($row = mysql_fetch_array($rs)) 
				{
					$totalnmb += $row[1];
				}    		
				
				if($totalnmb !=0)
				{
					mysql_data_seek($rs,0);
	
					while ($row = mysql_fetch_array($rs)) 
					{
						$retval .= "<tr><td align=\"center\" nowrap>&nbsp;$row[1]</td><td align=\"center\" nowrap>&nbsp;".round((($row[1]/$totalnmb)*100),1)."%</td><td width=\"100%\" align=\"left\" nowrap>".wordwrap($row[0],100,"<br>")."</td></tr>\n";
					} //while		
				} // if $totalnmb !=0
				
				$retval .='<tr><th >&nbsp;'.$totalnmb.'</th><th >&nbsp;</th><th >&nbsp;</th><tr>';

			}			

			mysql_free_result($rs);
			
			$retval .= '</table><br>';
			$retval .= '<center>[&nbsp;<a href="javascript:history.back(1)">Back</a>&nbsp;]</center>';
			
			return $retval;

		}
		
		function GetConfiguration()
		{
			?>
				<form name="adminForm" method="post" action="index2.php">
				<input type="hidden" name="option" value="com_tfsformambo">
				<input type="hidden" name="task" value="">
				<input type="hidden" name="boxchecked" value="0">
				<table class="adminform" width="100%" border="0" cellspacing="5" cellpadding="0">
				  <tr> 
					<td nowrap>Online time </td>
					<td><select name="onlinetime">
					<?php
						echo $this->onlinetime != 10 ? '<option value="10">10</option>' : '<option selected value="10">10</option>';
						echo $this->onlinetime != 15 ? '<option value="15">15</option>' : '<option selected value="15">15</option>';
						echo $this->onlinetime != 20 ? '<option value="20">20</option>' : '<option selected value="20">20</option>';
						echo $this->onlinetime != 25 ? '<option value="25">25</option>' : '<option selected value="25">25</option>';
						echo $this->onlinetime != 30 ? '<option value="30">30</option>' : '<option selected value="30">30</option>';
					?>
					  </select></td>
					<td width="100%"> if visitor comesback in x minutes it is the same visitor, else he/she counts as a new visitor.
					  </td>
				  </tr>
				  <tr> 
					<td nowrap>Start option</td>
					<td><select name="startoption">
					<?php
						echo $this->startoption != 'r01' ? '<option value="r01">Year Summary</option>' : '<option selected value="r01">Year Summary</option>';
						echo $this->startoption != 'r02' ? '<option value="r02">Month Summary</option>' : '<option selected value="r02">Month Summary</option>';
						echo $this->startoption != 'r03' ? '<option value="r03">Visitors</option>' : '<option selected value="r03">Visitors</option>';
						echo $this->startoption != 'r04' ? '<option value="r04">Bots</option>' : '<option selected value="r04">Bots</option>';
						echo $this->startoption != 'r05' ? '<option value="r05">Vistors by Country</option>' : '<option selected value="r05">Vistors by Country</option>';
						echo $this->startoption != 'r06' ? '<option value="r06">Page Hits</option>' : '<option selected value="r06">Page Hits</option>';
						echo $this->startoption != 'r07' ? '<option value="r07">Systems</option>' : '<option selected value="r07">Systems</option>';
						echo $this->startoption != 'r08' ? '<option value="r08">Browsers</option>' : '<option selected value="r08">Browsers</option>';
						echo $this->startoption != 'r09' ? '<option value="r09">Bots/spiders</option>' : '<option selected value="r09">Bots/spiders</option>';
						echo $this->startoption != 'r10' ? '<option value="r10">Referrers</option>' : '<option selected value="r10">Referrers</option>';
						echo $this->startoption != 'r14' ? '<option value="r14">Search Engines</option>' : '<option selected value="r14">Search Engines</option>';
						echo $this->startoption != 'r11' ? '<option value="r11">Not identified visitors</option>' : '<option selected value="r11">Not identified visitors</option>';
						echo $this->startoption != 'r12' ? '<option value="r12">Unknown bots/spiders</option>' : '<option selected value="r12">Unknown bots/spiders</option>';
					?>
					  </select></td>
					<td>start option for TFSforMAMBO</td>
				  </tr>
				  <tr> 
					<td nowrap>Language</td>
					<td><select name="language">
					<?php
					$langdir = $this->MainFrame->_config->absolute_path.'/administrator/components/com_tfsformambo/language/';
					// Open a known directory, and proceed to read its contents
					if (is_dir($langdir))
					{
					   if ($dh = opendir($langdir))
					   {
						   while (($file = readdir($dh)) !== false)
						   {
						   		if(($file != '.') && ($file != '..'))
								{
									echo substr($file,0,2) != $this->langini ? '<option value="'.substr($file,0,2).'">'.substr($file,0,2).'</option>' : '<option selected value="'.substr($file,0,2).'">'.substr($file,0,2).'</option>';
								}
						   }
						   closedir($dh);
					   }
					}
					?>
					</select></td>
					<td>languages so far supported</td>
				  </tr>
				  <tr> 
					<td nowrap> time limit</td>
					<td><input type="text" name="timelimit" value="<?php echo $this->purgetime; ?>"></td>
					<td>time limit for summarise process</td>
				  </tr>
				</table>
			  </form>
		<?php
		}
		
		function GetInformation()
		{
			?>
				<table cellspacing="0" cellpadding="4" border="0" width="100%">
					<tbody>
					  <tr> 
						<td valign="top" class="sectionname">
					<span class="sectionname"><img align="middle" height="67" width="70" src="components/com_tfsformambo/images/tfsformambo.png">TFSforMAMBO information</span></td>
				  </tr>
				<tr>
				<td>
				<p>Thank you for using the TFSforMAMBO Component.<br>
				</p>
				<p>TFS stands for <strong>T</strong>wenty <strong>F</strong>our <strong>S</strong>even.</p>
				
        <p><br>
          I hope you enjoy working with TFSforMAMBO and have lots of visitors!,<br>
          <br>
          <br>
          <a href="mailto:caffeincoder@oplossing.net">Patrick Diender</a><br>
          <a href="http://www.oplossing.net" >www.oplossing.net</a><br>
          <br>
          To use TFSforMAMBO include these lines in your template<br>
        </p>
		
        <form name="form1" method="post" action="">
          <textarea name="textarea" cols="75" rows="5"><?php echo '<?PHP if(file_exists($mosConfig_absolute_path."/components/com_tfsformambo/tfsformambo.php")) 
{
require_once($mosConfig_absolute_path."/components/com_tfsformambo/tfsformambo.php");
}?>'; ?></textarea>
        </form>
			  </td>
					</tr>
					<tr> 
						<td class="small" valign="top">&nbsp;&nbsp;Version : 2.0-RC1</td>
					</tr>
					  <tr> 
						<td class="smallgrey" valign="top"> <div align="center"> <span class="smalldark"> 
							Oplossing.net ©2003 - 2004 All rights reserved. <br>
							<a href="http://www.oplossing.net">TFSforMAMBO</a> is Free 
							Software released under the GNU/GPL License. <br>
							</span></div></td>
					  </tr>
					</tbody>
				  </table>
  		<?php
		}

		function GetSummariseInfo()
		{
			?>
				<table cellspacing="0" cellpadding="4" border="0" width="100%">
					<tbody>
					  <tr> 
						<td valign="top" class="sectionname">
					<span class="sectionname"><img align="middle" height="67" width="70" src="components/com_tfsformambo/images/tfsformambo.png">TFSforMAMBO Summarise information</span></td>
				  </tr>
				<tr>
				
      <td> The summarise process will group the page requests from "old" visitors by 
        <ul>
			<li>page</li>
          	<li>hour</li>
          	<li>day</li>
          	<li>month</li>
          	<li>year</li>
        </ul>
		<p><strong>This process will only affect the possibility to see who visited 
          which page.</strong></p>
        <p>After this process you will not be able to see who visited which page 
          (url in visitors section of TFSforMAMBO)<br>
          By visitors who come after you have done this you can see which pages 
          they visited.<br>
          <br>
          This process will reduce the size of the TFSforMAMBO tables. </p></td>
					</tr>
					<tr> 
						<td class="small" valign="top">&nbsp;&nbsp;Version : 2.0-RC1</td>
					  </tr>
					  <tr> 
						<td class="smallgrey" valign="top"> <div align="center"> <span class="smalldark"> 
							Oplossing.net ©2003 - 2004 All rights reserved. <br>
							<a href="http://www.oplossing.net">TFSforMAMBO</a> is Free 
							Software released under the GNU/GPL License. <br>
							</span></div></td>
					  </tr>
					</tbody>
				  </table>
				<form name="adminForm" method="post" action="index2.php">
					<input type="hidden" name="option" value="com_tfsformambo">
					<input type="hidden" name="task" value="">
					<input type="hidden" name="boxchecked" value="0">
				</form>
				  
  		<?php
		}

		function GetUnInstallInfo()
		{
			?>
				<table cellspacing="0" cellpadding="4" border="0" width="100%">
					<tbody>
					  <tr> 
						<td valign="top" class="sectionname">
					<span class="sectionname"><img align="middle" height="67" width="70" src="components/com_tfsformambo/images/tfsformambo.png">TFSforMAMBO uninstall information</span></td>
				  </tr>
				<tr>
				
      <td valign="top"> If you want to fully uninstall the TFSforMAMBO component 
        press the "delete tables" button in the toolbar .<br>
          This will delete the TFSforMAMBO tables in the MOS database.<br><br>
          Then uninstall the TFSforMAMBO component in the components->install/uninstall 
          section.
        <br><br><br>
          If you are upgrading TFSforMAMBO (future) you can uninstall the TFSforMAMBO 
          component in the components->install/uninstall section and upgrade to the next version by installing the upgrade package.
				</td>
					</tr>
					<tr> 
						<td class="small" valign="top">&nbsp;&nbsp;Version : 2.0-RC1</td>
					  </tr>
					  <tr> 
						<td class="smallgrey" valign="top"> <div align="center"> <span class="smalldark"> 
							Oplossing.net ©2003 - 2004 All rights reserved. <br>
							<a href="http://www.oplossing.net">TFSforMAMBO</a> is Free 
							Software released under the GNU/GPL License. <br>
							</span></div></td>
					  </tr>
					</tbody>
				  </table>
				<form name="adminForm" method="post" action="index2.php">
					<input type="hidden" name="option" value="com_tfsformambo">
					<input type="hidden" name="task" value="">
					<input type="hidden" name="boxchecked" value="0">
				</form>
  		<?php
		}

		function DoSummariseTask()
		{
			$start = time();
	
			$sql = 'SELECT SQL_BIG_RESULT page_id,hour,day,month,year,count(*) as count from #__TFS_page_request group by page_id,hour,day,month,year';
			
			$this->MainFrame->_db->setQuery($sql);
		
			$rs = mysql_query($this->MainFrame->_db->_sql);
			
			// if php is not in safe mode than set max execution time
			if(!ini_get('safe_mode'))
			{
			set_time_limit($this->purgetime);
			}
			
			while ($row = mysql_fetch_array($rs)) 
			{
				$sql = "update #__TFS_page_request_c set count=count + ".$row['count']." where page_id=".$row['page_id']." and hour=".$row['hour']." and day=".$row['day']." and month=".$row['month']." and year=".$row['year'];
				$this->MainFrame->_db->setQuery($sql);
				mysql_query($this->MainFrame->_db->_sql);
				
				if (mysql_affected_rows() < 1)
				{
					$sql = "INSERT INTO #__TFS_page_request_c (page_id,hour,day,month,year,count) values (".$row['page_id'].",".$row['hour'].",".$row['day'].",".$row['month'].",".$row['year'].",".$row['count'].")";
					$this->MainFrame->_db->setQuery($sql);
					mysql_query($this->MainFrame->_db->_sql);
				}
			
				$sql = "DELETE FROM #__TFS_page_request where page_id=".$row['page_id']." and hour=".$row['hour']." and day=".$row['day']." and month=".$row['month']." and year=".$row['year'];
				$this->MainFrame->_db->setQuery($sql);
				mysql_query($this->MainFrame->_db->_sql);
	
				$end = time();
				
				if(($end - $start) > (($this->purgetime)-1))
				{
					$this->updatemsg = "Maximum execution time of ".$this->purgetime." seconds exceeded,<br>purge TFS again untill this message does not apear<br>";
				}				
			}
		
			$sql = "OPTIMIZE TABLE #__TFS_page_request";
			$this->MainFrame->_db->setQuery($sql);
			mysql_query($this->MainFrame->_db->_sql);
		
			if(($end - $start) < $this->purgetime)
			{
				$this->updatemsg = "Purge result OK";
			}
		}

		function DoUnInstallTask()
		{

			$sql = "DROP TABLE `#__TFS_bots`";
			$this->MainFrame->_db->setQuery($sql);
			mysql_query($this->MainFrame->_db->_sql);
	
			$sql = "DROP TABLE `#__TFS_browsers`";
			$this->MainFrame->_db->setQuery($sql);
			mysql_query($this->MainFrame->_db->_sql);
	
			$sql = "DROP TABLE `#__TFS_configuration`";
			$this->MainFrame->_db->setQuery($sql);
			mysql_query($this->MainFrame->_db->_sql);
	
			$sql = "DROP TABLE `#__TFS_ipaddresses`";
			$this->MainFrame->_db->setQuery($sql);
			mysql_query($this->MainFrame->_db->_sql);
	
			$sql = "DROP TABLE `#__TFS_iptocountry`";
			$this->MainFrame->_db->setQuery($sql);
			mysql_query($this->MainFrame->_db->_sql);
	
			$sql = "DROP TABLE `#__TFS_keywords`";
			$this->MainFrame->_db->setQuery($sql);
			mysql_query($this->MainFrame->_db->_sql);
	
			$sql = "DROP TABLE `#__TFS_page_request`";
			$this->MainFrame->_db->setQuery($sql);
			mysql_query($this->MainFrame->_db->_sql);
	
			$sql = "DROP TABLE `#__TFS_page_request_c`";
			$this->MainFrame->_db->setQuery($sql);
			mysql_query($this->MainFrame->_db->_sql);
	
			$sql = "DROP TABLE `#__TFS_pages`";
			$this->MainFrame->_db->setQuery($sql);
			mysql_query($this->MainFrame->_db->_sql);
	
			$sql = "DROP TABLE `#__TFS_referrer`";
			$this->MainFrame->_db->setQuery($sql);
			mysql_query($this->MainFrame->_db->_sql);
	
			$sql = "DROP TABLE `#__TFS_search_engines`";
			$this->MainFrame->_db->setQuery($sql);
			mysql_query($this->MainFrame->_db->_sql);
	
			$sql = "DROP TABLE `#__TFS_systems`";
			$this->MainFrame->_db->setQuery($sql);
			mysql_query($this->MainFrame->_db->_sql);
	
			$sql = "DROP TABLE `#__TFS_topleveldomains`";
			$this->MainFrame->_db->setQuery($sql);
			mysql_query($this->MainFrame->_db->_sql);
	
			$sql = "DROP TABLE `#__TFS_visits`";
			$this->MainFrame->_db->setQuery($sql);
			mysql_query($this->MainFrame->_db->_sql);
			
		}
		
		function TFSheader()
		{
			$this->resetVar(0);
			
			?>
			<table border="0" align="center" cellspacing="0" width="100%">
			  <tr>
				<td>
					<table class="adminlist" border="0" cellspacing="0" width="100%">
					<tr>	
						<td width="100%"> <span class="sectionname"><img align="middle" height="67" width="70" src="components/com_tfsformambo/images/tfsformambo.png">TFSforMAMBO <?php if($this->task == 'getconf'){ echo ' configuration';} if($this->task == 'uninstalltask'){ echo ' tables deleted !';} ?></span></td>
						<td><?php if(($this->task != 'getconf') && ($this->task != 'uninstalltask')){ ?>
								<form name="datequeryform" method="get" action="index2.php">
								<input name="option" type="hidden" id="option" value="com_tfsformambo">
								<table border="0" cellspacing="0" cellpadding="0">
								  <tr> 
									<td><select name="d">
										<!-- combo day here -->
										<?php $this->CreateDayCmb(); ?>
									  </select> </td>
									<td> <select name="m">
										<!-- combo month here -->
										<?php $this->CreateMonthCmb(); ?>
									  </select> </td>
									<td> <select name="y">
										<!-- combo year here -->
										<?php $this->CreateYearCmb(); ?>
									  </select> </td>
									<td> <div align="center"> 
										<input type="submit" name="Submit" value="Go">
										<!-- hidden value for display stats -->
										<input name="task" type="hidden" id="task" value="<?php echo substr($this->task,0,3); ?>">
									  </div></td>
								  </tr>
								</table>
							  </form><?php }else{echo '&nbsp;';} ?>			
						</td>
					</tr><?php if(($this->task != 'getconf') && ($this->task != 'uninstalltask')){ ?>
					<tr class="row0"><td><font color="#000000">version:<b> 
				  <?php $this->getdbversion(); ?>
				  </b></font>&nbsp;||&nbsp;<font color="#000000">size:<b> 
				  <?php $this->getdbsize(); ?>
				  Mb </b></font>&nbsp;||&nbsp;&copy; 2003 - 2004 Oplossing.net
				  </td>
				  <td nowrap align="right">
				  <?php echo ' language translation by: '.$this->language['translation']['by']; ?>
				  &nbsp;&nbsp;</td></tr>
					<tr><td colspan="2"><?php $this->menu(); ?></td></tr>        
				</table>
				<table class="adminlist" border="0" cellspacing="0" width="100%">
				  <tr> 
					<th> 
					  <!-- title of report here -->
					  <?php $this->DisplayTitle(); ?>
					</th>
				  </tr>
				</table>
				
		<?php
			$this->resetVar(1);

			}else {echo '</table>';}
		}
		
		function TFSfooter()
		{
			?>
			  </td>
			  </tr>
			</table>
			<?php
		}
		
		function listIpAddresses( &$rows, $pageNav, $search, $option ) 
		{
		?>
		<form action="index2.php" method="post" name="adminForm">
		  <table cellpadding="4" cellspacing="0" border="0" width="100%">
			<tr>
			  <td width="100%" class="sectionname"><img src="components/com_tfsformambo/images/tfsformambo.png" width="70" height="67" align="middle">TFSforMAMBO Exclude Manager</td> 
			  <td nowrap="nowrap">Display #</td>
			  <td> <?php echo $pageNav->writeLimitBox(); ?> </td>
			  <td>Search:</td>
			  <td> <input type="text" name="search" value="<?php echo $search;?>" class="inputbox" onChange="document.adminForm.submit();" />
			  </td>
			</tr>
		  </table>
		  <table cellpadding="4" cellspacing="0" border="0" width="100%" class="adminlist">
			<tr>
			  <th width="2%" class="title">#</td>
			  <th width="3%" class="title"> <input type="checkbox" name="toggle" value="" onClick="checkAll(<?php echo count($rows); ?>);" />
			  </th>
			  <th width="20%" class="title">ipaddress</th>
			  <th width="40%" class="title">nslookup</th>
			  <th width="15%" class="title">system</th>
			  <th width="15%" class="title">browser</th>
			  <th width="5%" class="title">exclude</th>
			</tr>
		<?php
				$k = 0;
				for ($i=0, $n=count( $rows ); $i < $n; $i++) {
					$row =& $rows[$i];
					$img = $row->exclude ? 'tick.png' : 'publish_x.png';
					$task = $row->exclude ? 'unexclude' : 'exclude';
		?>
			<tr class="<?php echo "row$k"; ?>">
			  <td><?php echo $i+1+$pageNav->limitstart;?></td>
			  <td><input type="checkbox" id="cb<?php echo $i;?>" name="cid[]" value="<?php echo $row->id; ?>" onClick="isChecked(this.checked);" /></td>
			  <td><?php echo $row->ip; ?></td>
			  <td><?php echo $row->nslookup; ?></td>
			  <td><?php echo $row->system; ?></td>
			  <td><?php echo $row->browser; ?></td>
			  <td width="10%"><a href="javascript: void(0);" onClick="return listItemTask('cb<?php echo $i;?>','<?php echo $task;?>')"><img src="images/<?php echo $img;?>" width="12" height="12" border="0" alt="" /></a></td>
			</tr>
			<?php $k = 1 - $k; } ?>
			<tr>
			  <th align="center" colspan="9"> <?php echo $pageNav->writePagesLinks(); ?></th>
			</tr>
			<tr>
			  <td align="center" colspan="9"> <?php echo $pageNav->writePagesCounter(); ?></td>
			</tr>
		  </table>
		  <input type="hidden" name="option" value="<?php echo $option;?>" />
		  <input type="hidden" name="task" value="" />
		  <input type="hidden" name="boxchecked" value="0" />
		</form>
		<?php 
		}	
	}
?>
