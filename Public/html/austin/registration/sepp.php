<?phpsession_start();$_SESSION['firstname']= $_POST['firstname'];$_SESSION['lastname']=$_POST['lastname'];$_SESSION['email1']=$_POST['email1'];if (isset($_POST['submit'])) {include ('validate_email.php');if ($valid) {include ('validate_sreg.php');if($valid AND $title AND $inst AND $add AND $city AND $state AND $zip AND $country AND $phone AND $hotelInfo AND $contactInfo AND $jasig AND $shirt){//validate then end session$_SESSION['badge']=$_POST['badge'];$_SESSION['institution']=$_POST['institution'];$_SESSION['otherInst']=$_POST['otherInst'];$_SESSION['dept']=$_POST['dept'];$_SESSION['address1']=$_POST['address1'];$_SESSION['address2']=$_POST['address2'];$_SESSION['city']=$_POST['city'];$_SESSION['state']=$_POST['state'];$_SESSION['otherState']=$_POST['otherState'];$_SESSION['zip']=$_POST['zip'];$_SESSION['country']=$_POST['country'];$_SESSION['phone']=$_POST['phone'];$_SESSION['fax']=$_POST['fax'];$_SESSION['shirt']=$_POST['shirt'];$_SESSION['special']=$_POST['special'];$_SESSION['hotelInfo']=$_POST['hotelInfo'];$_SESSION['contactInfo']=$_POST['contactInfo'];$_SESSION['jasig']=$_POST['jasig'];$_SESSION['ospi']=$_POST['ospi'];$_SESSION['title']=$_POST['title'];include("../includes/submit_reg2.php");}}}?><?php  require_once('../includes/reg_header.inc'); ?>					                             <td colspan="2"                   style=" border-top: 4px solid #FFFFFF; padding: 5px;">                                                                                             		     <form name="form1" method="post" action="<?php echo $_SERVER[PHP_SELF]; ?>">                       <table class="blog" cellpadding="0" cellspacing="0">                                            <tr>                      <td valign="top" colspan=2>                      <div class="componentheading">SEPP Member Registration Form</div>                      </td></tr>                   						                   <tr>                                                    <td colspan=2 >                                                    <br /><strong>This form is for use by SEPP Members only. </strong><br /> Not a Member?  Please use our <a href="https://sakaiproject.org/austin/registration/public.php">Non-Member Registration form.</a> <br />                          <br /><strong>Not sure if your organization is a Sakai Partner?</strong><br /> Check the conference registration page for a <a href="http://www.sakaiproject.org/index.php?option=com_content&task=blogcategory&id=160&Itemid=496">recently updated list of Sakai Partners</a><br />                              <br />                 </td>                </tr>                                           <?php if ($message) {	echo "<tr><td colspan=2> <div class=\"errors\" align=\"left\"><blockquote><font color=red><strong>Please check the following information:</strong></font><ul class=small>";		foreach ($message as $key => $value) {		echo $value;		}	echo "</ul></blockquote></div>     </td>                        </tr> ";}?>                     <tr>                                <td valign="top" colspan="2"><span class="required">* </span>= Required fields                          </td>                        </tr>                                                <tr>                          <td width="160px"><div align="right"><strong><span class="formLable"> First Name: </span><span class="required">*</span></strong></div></td>                          <td align="left">  <input type="text" name="firstname" size="30" maxlength="20" value="<?php echo $_POST['firstname'];?>" /></td>                        </tr>                                                <tr>                          <td><div align="right"><strong><span class="formLable"> Last Name: </span><span class="required">*</span></strong></div></td>                          <td align="left">  <input type="text" name="lastname" size="30" maxlength="20" value="<?php echo $_POST['lastname'];?>" /></td>                        </tr>                                               <tr>                          <td><div align="right"><br /><strong><span class="formLable"> Name Badge Name:</span><span class="required">*</span></strong><span class="small" align="left"><br />(for conference name badge, if different from above)</span></div></td>                          <td align="left">  <input type="text" name="badge" size="30" maxlength="20" value="<?php echo $_POST['badge'];?>" /></td>                        </tr>                                                 <tr>                          <td><div align="right"><br /><strong><span class="formLable">Email:</span></strong> <span class="required">*</span> </div></td>                          <td><input type="text" name="email1" size="30" maxlength="30" value="<?php echo $_POST['email1'];?>" /></td>                        </tr>                                                <tr>                          <td><div align="right"><strong><span class="formLable">Confirm Email:</span></strong> <span class="required">*</span> </div></td>                          <td><input type="text" name="email2" size="30" maxlength="30" value="<?php echo $_POST['email2'];?>" /></td>                        </tr>                                              <tr><td colspan=2>  <br /></td></tr>                                                                  <tr valign="top">                          <td><div align="right"><strong><span class="formLable">Role:</span> </strong><span class="required">*</span>                          <span class="small" align="left"><br />please select the role from the list which best describes<br /> your role within your organization</span></div></td>                          <td>                                                    <div><br /><?php// initialize or capture variable$title = $_POST['title'];?><select name="title"><?php if (!$title==""){echo " <option value=\"$title\" SELECTED>$title</option>"; }  ?>             <option value="">-- select --</option>                              <option value="Developer/Programmer">Developer/Programmer</option>                              <option value="User Support">User Support</option>                              <option value="UI Designer">UI designer</option>                              <option value="Technical/Project Management">Technical/Project Management</option>                              <option value="Systems Analyst or Analyst">Systems Analyst or Analyst</option>                             <option value="General Management">General Management</option>                               <option value="Pedagogy/Teaching Support">Pedagogy/Teaching Support</option>                              <option value="Faculty">Faculty</option>                              <option value="Librarian">Librarian</option>                            </select>                          </div>                          </td>                        </tr>                                                                        <tr>                          <td><div align="right"><br /><strong><span class="formLable"> Organization:</span></strong><span class="required">*</span> </div></td><td>                        <select name="institution">                   <option value=""> --Select Organization--</option>                              <option value="Albany Medical College">Albany Medical College</option><option value="Arizona State University">Arizona State University</option><option value="Australian National Academy">Australian National University</option><option value="Boston University School of Management">Boston University School of Management</option><option value="Brown University ">Brown University </option><option value="Carleton College">Carleton College</option><option value="Carnegie Foundation for the Advancement of Teaching">Carnegie Foundation for the Advancement of Teaching</option><option value="Carnegie Mellon University">Carnegie Mellon University</option><option value="Cerritos Community College">Cerritos Community College</option><option value="Charles Sturt University">Charles Sturt University</option><option value="Coast Community College District (Coastline Community College)">Coast Community College District (Coastline Community College)</option><option value="Columbia University">Columbia University</option><option value="Cornell University">Cornell University</option><option value="Dartmouth College">Dartmouth College</option><option value="Edgenics">Edgenics</option><option value="Florida Community College at Jacksonville">Florida Community College at Jacksonville</option><option value="Foothill-De Anza Community College District">Foothill-De Anza Community College District</option><option value="Franklin University ">Franklin University </option><option value="Georgetown University">Georgetown University</option><option value="Harvard University">Harvard University</option><option value="Hosei University IT Research Center">Hosei University IT Research Center</option><option value="Indiana University">Indiana University</option><option value="Johns Hopkins University">Johns Hopkins University</option><option value="Lancaster University">Lancaster University</option><option value="Loyola University, Chicago">Loyola University, Chicago</option><option value="Luebeck University of Applied Sciences">Luebeck University of Applied Sciences</option><option value="Maricopa County Community College District ">Maricopa County Community College District </option><option value="Marist College">Marist College</option><option value="MIT">MIT</option><option value="Monash University">Monash University</option><option value="Nagoya University">Nagoya University</option><option value="New York University">New York University</option><option value="Northeastern University">Northeastern University</option><option value="North-West University (SA)">North-West University (SA)</option><option value="Northwestern University">Northwestern University</option><option value="Ohio State University">Ohio State University</option><option value="Pennsylvania State University">Pennsylvania State University</option><option value="Portand State University">Portand State University</option><option value="Princeton University">Princeton University</option><option value="Rice University">Rice University</option><option value="Ringling School of Art and Design">Ringling School of Art and Design</option><option value="Roskilde University (Denmark)">Roskilde University (Denmark)</option><option value="Rutgers University">Rutgers University</option><option value="Simon Fraser University">Simon Fraser University</option><option value="Stanford University">Stanford University</option><option value="State University of New York System Administration">State University of New York System Administration</option><option value="Stockholm University">Stockholm University</option><option value="SURF/University of Amsterdam ">SURF/University of Amsterdam </option><option value="Syracuse University">Syracuse University</option><option value="Texas State University - San Marcos">Texas State University - San Marcos</option><option value="Tufts University">Tufts University</option><option value="University College Dublin">University College Dublin</option><option value="Universidad Politecnica de Valencia (Spain)">Universidad Politecnica de Valencia (Spain)</option><option value="Universitat de Lleida (Spain)">Universitat de Lleida (Spain)</option><option value="University of Arizona">University of Arizona</option><option value="University of British Columbia">University of British Columbia</option><option value="University of California, Office of the Chancellor">University of California, Office of the Chancellor</option><option value="University of California Berkeley">University of California Berkeley</option><option value="University of California, Davis">University of California, Davis</option><option value="University of California, Los Angeles">University of California, Los Angeles</option><option value="University of California, Merced">University of California, Merced</option><option value="University of California, Santa Barbara">University of California, Santa Barbara</option><option value="University of Cambridge, CARET">University of Cambridge, CARET</option><option value="University of Cape Town, SA">University of Cape Town, SA</option><option value="University of Chicago">University of Chicago</option><option value="University of Colorado at Boulder">University of Colorado at Boulder</option><option value="University of Delaware">University of Delaware</option><option value="University of Hawaii">University of Hawaii</option><option value="University of Hull">University of Hull</option><option value="University of Illinois at Urbana-Champaign">University of Illinois at Urbana-Champaign</option><option value="University of Limerick">University of Limerick</option><option value="University of Melbourne">University of Melbourne</option><option value="University of Michigan">University of Michigan</option><option value="University of Minnesota">University of Minnesota</option><option value="University of Missouri">University of Missouri</option><option value="University of Nebraska">University of Nebraska</option><option value="University of North Texas">University of North Texas</option><option value="University of Oklahoma">University of Oklahoma</option><option value="University of South Africa (UNISA)">University of South Africa (UNISA)</option><option value="University of Texas at Austin">University of Texas at Austin</option><option value="University of Toronto, Knowledge Media Design Institute">University of Toronto, Knowledge Media Design Institute</option><option value="University of Virginia">University of Virginia</option><option value="University of Washington">University of Washington</option><option value="University of Wisconsin, Madison">University of Wisconsin, Madison</option><option value="Virginia Polytechnic Institute and State University">Virginia Polytechnic Institute and State University</option><option value="Weber State University">Weber State University</option><option value="Whitman College">Whitman College</option><option value="Yale University">Yale University</option>                              <option value="Embanet">Embanet</option>                              <option value="HarvestRoad">HarvestRoad</option>                              <option value="IBM">IBM</option>                              <option value="JustStudents">JustStudents</option>                              <option value="Ostrakon">Ostrakon </option>                              <option value="The rSmart Group">The rSmart Group</option>                              <option value="Sun Microsystems">Sun Microsystems</option>                              <option value="Sunguard SCT">Sunguard SCT </option>                              <option value="Unicon">Unicon</option>                              <option value="UNISYS">UNISYS</option>                            </select>                            <br />                            </td>                        </tr>                                                <tr>                          <td><div align="right"></div></td>                          <td class="small">                            If <strong><em>Other</em></strong> please enter here:                          <input type="text" name="otherInst" size="20" maxlength="40" value="<?php echo $_POST['otherInst'];?>" /></td>                        </tr>                                                                                              <tr><td colspan=2>  <br /></td></tr>                                               <tr>                          <td><div align="right"><strong><span class="formLable">Department</span>:</strong> </div></td>                          <td><input type="text" name="dept" size="30" maxlength="30" value="<?php echo $_POST['dept'];?>" /></td>                        </tr>                                                                        <tr>                          <td><div align="right"><strong><span class="formLable"> Address 1</span>: </strong><span class="required">*</span> </div></td>                          <td><input type="text" name="address1" size="30" maxlength="30" value="<?php echo $_POST['address1'];?>" /></td>                        </tr>                                                                        <tr>                          <td><div align="right"><strong><span class="formLable">Address 2: </span></strong></div></td>                          <td><input type="text" name="address2" size="30" maxlength="30"  value="<?php echo $_POST['address2'];?>"/></td>                        </tr>                                                                        <tr>                          <td><div align="right"><strong><span class="formLable">Town/City:</span> <span class="required">*</span></strong></div></td>                          <td><input type="text" name="city" size="30" maxlength="30" value="<?php echo $_POST['city'];?>" /></td>                        </tr>                                                                        <tr>                          <td><div align="right"><strong><span class="formLable">State/Province:</span> <span class="required">*</span></strong></div></td>                          <td>                                                     <?php                                                   $state = $_POST['state'];?><select name="state"><?php if (!$state==""){echo " <option value=\"$state\" SELECTED>$state</option>"; }  ?>                              <option value="">State/Province</option>                              <option value="">----United States----</option>                              <option value="AL"> Alabama</option>                              <option value="AK"> Alaska</option>                              <option value="AZ"> Arizona</option>                              <option value="AR"> Arkansas</option>                              <option value="CA"> California</option>                              <option value="CO"> Colorado</option>                              <option value="CT"> Connecticut</option>                              <option value="DE"> Delaware</option>                              <option value="DC"> District of Columbia</option>                              <option value="FL"> Florida</option>                              <option value="GA"> Georgia</option>                              <option value="HI"> Hawaii</option>                              <option value="ID"> Idaho</option>                              <option value="IL"> Illinois</option>                              <option value="IN"> Indiana</option>                              <option value="IA"> Iowa</option>                              <option value="KS"> Kansas</option>                              <option value="KY"> Kentucky</option>                              <option value="LA"> Louisiana</option>                              <option value="ME"> Maine</option>                              <option value="MD"> Maryland</option>                              <option value="MA"> Massachusetts</option>                              <option value="MI"> Michigan</option>                              <option value="MN"> Minnesota</option>                              <option value="MS"> Mississippi</option>                              <option value="MO"> Missouri</option>                              <option value="MT"> Montana</option>                              <option value="NE"> Nebraska</option>                              <option value="NV"> Nevada</option>                              <option value="NH"> New Hampshire</option>                              <option value="NJ"> New Jersey</option>                              <option value="NM"> New Mexico</option>                              <option value="NY"> New York</option>                              <option value="NC"> North Carolina</option>                              <option value="ND"> North Dakota</option>                              <option value="OH"> Ohio</option>                              <option value="OK"> Oklahoma</option>                              <option value="OR"> Oregon</option>                              <option value="PA"> Pennsylvania</option>                              <option value="RI"> Rhode Island</option>                              <option value="SC"> South Carolina</option>                              <option value="SD"> South Dakota</option>                              <option value="TN"> Tennessee</option>                              <option value="TX"> Texas</option>                              <option value="UT"> Utah</option>                              <option value="VT"> Vermont</option>                              <option value="VA"> Virginia</option>                              <option value="WA"> Washington</option>                              <option value="WV"> West Virginia</option>                              <option value="WI"> Wisconsin</option>                              <option value="WY"> Wyoming</option>                              <option value="">&nbsp;</option>                              <option value="">----US Territories----</option>                              <option value="AS"> America Samoa</option>                              <option value="GU"> Guam</option>                              <option value="MH"> Marshall Islands</option>                              <option value="MP"> Northern Mariana Islands</option>                              <option value="PW"> Palau</option>                              <option value="PR"> Puerto Rico</option>                              <option value="VI"> Virgin Islands</option>                              <option value="">&nbsp;</option>                              <option value="">----Canada----</option>                              <option value="AB"> Alberta</option>                              <option value="BC"> British Columbia</option>                              <option value="MB"> Manitoba</option>                              <option value="NB"> New Brunswick</option>                              <option value="NF"> Newfoundland</option>                              <option value="NWT"> Northwest Territories</option>                              <option value="NS"> Nova Scotia</option>                              <option value="NU"> Nunavut</option>                              <option value="ON"> Ontario</option>                              <option value="PE"> Prince Edward Island</option>                              <option value="PQ"> Quebec</option>                              <option value="SK"> Saskatchewan</option>                              <option value="YT"> Yukon Territory</option>                                                       </select></td>                        </tr>                                                                        <tr>                          <td><div align="right">  </div></td>                          <td class="small">If <strong><em>Other</em></strong> please enter here:                            <input type="text" name="otherState" size="30" maxlength="30"  value="<?php echo $_POST['otherState'];?>" />                            <br />                            </td>                        </tr>                                                                        <tr>                          <td><div align="right"><strong><span class="formLable">Zip/Postal Code:</span> <span class="required">*</span></strong> </div></td>                          <td><input type="text" name="zip" size="10" maxlength="15"  value="<?php echo $_POST['zip'];?>" /></td>                        </tr>                                                                        <tr>                          <td><div align="right"><strong><span class="formLable">Country: </span><span class="required">*</span></strong> </div></td>                          <td>                             <?php                                                   $country = $_POST['country'];?><select name="country"><?php if (!$country==""){echo " <option value=\"$country\" SELECTED>$country</option>"; }  ?>                                                        <option value="">Country</option>                              <option value="US">United States</option>                              <option value="CA">Canada</option>                              <option value="AL">Albania</option>                              <option value="DZ">Algeria</option>                              <option value="AI">Anguilla</option>                              <option value="AR">Argentina</option>                              <option value="AU">Australia</option>                              <option value="AT">Austria</option>                              <option value="BS">Bahamas</option>                              <option value="BH">Bahrain</option>                              <option value="BD">Bangladesh</option>                              <option value="BE">Belgium</option>                              <option value="BM">Bermuda</option>                              <option value="BR">Brazil</option>                              <option value="BN">Brunei</option>                              <option value="BG">Bulgaria</option>                              <option value="KY">Cayman Islands</option>                              <option value="CL">Chile</option>                              <option value="CN">China</option>                              <option value="CO">Colombia</option>                              <option value="CR">Costa Rica</option>                              <option value="HR">Croatia</option>                              <option value="DK">Denmark</option>                              <option value="DJ">Djibouti</option>                              <option value="EC">Ecuador</option>                              <option value="EG">Egypt</option>                              <option value="ET">Ethiopia</option>                              <option value="FL">Falkland Islands (Malvinas)</option>                              <option value="FJ">Fiji</option>                              <option value="FI">Finland</option>                              <option value="FR">France</option>                              <option value="PF">French Polynesia</option>                              <option value="DE">Germany</option>                              <option value="GE">Georgia</option>                              <option value="GR">Greece</option>                              <option value="GU">Guam</option>                              <option value="GT">Guatemala</option>                              <option value="HK">Hong Kong</option>                              <option value="HU">Hungary</option>                              <option value="IN">India</option>                              <option value="ID">Indonesia</option>                              <option value="IE">Ireland</option>                              <option value="IL">Israel</option>                              <option value="IT">Italy</option>                              <option value="JP">Japan</option>                              <option value="JO">Jordan</option>                              <option value="KR">Korea</option>                              <option value="KW">Kuwait</option>                              <option value="LV">Latvia</option>                              <option value="LB">Lebanon</option>                              <option value="LU">Luxembourg</option>                              <option value="MO">Macau</option>                              <option value="MY">Malaysia</option>                              <option value="MT">Malta</option>                              <option value="MX">Mexico</option>                              <option value="MA">Morocco</option>                              <option value="NL">Netherlands</option>                              <option value="AN">Netherlands Antilles</option>                              <option value="NZ">New Zealand</option>                              <option value="NI">Nicaragua</option>                              <option value="NG">Nigeria</option>                              <option value="NF">Norfolk Island</option>                              <option value="NO">Norway</option>                              <option value="OM">Oman</option>                              <option value="PK">Pakistan</option>                              <option value="PA">Panama</option>                              <option value="PN">Papua New Guinea</option>                              <option value="PY">Paraguay</option>                              <option value="PE">Peru</option>                              <option value="PH">Philippines</option>                              <option value="PL">Poland</option>                              <option value="PT">Portugal</option>                              <option value="QA">Qatar</option>                              <option value="PA">Republic of Panama</option>                              <option value="RO">Romania</option>                              <option value="RU">Russia</option>                              <option value="SC">Seychelles</option>                              <option value="SA">Saudi Arabia</option>                              <option value="SG">Singapore</option>                              <option value="ZA">South Africa</option>                              <option value="ES">Spain</option>                              <option value="SE">Sweden</option>                              <option value="CH">Switzerland</option>                              <option value="SY">Syria</option>                              <option value="TW">Taiwan</option>                              <option value="TZ">Tanzania</option>                              <option value="TH">Thailand</option>                              <option value="TN">Tunisia</option>                              <option value="TR">Turkey</option>                              <option value="TC">Turks and Caicos Islands</option>                              <option value="TM">Turkmenistan</option>                              <option value="UG">Uganda</option>                              <option value="GB">United Kingdom</option>                              <option value="AE">United Arab Emirates</option>                              <option value="UY">Uruguay</option>                              <option value="UZ">Uzbekistan</option>                              <option value="VE">Venezuela</option>                              <option value="VN">Vietnam</option>                              <option value="YE">Yemen</option>                              <option value="ZW">Zimbabwe</option>                            </select></td>                        </tr>                                                                        <tr>                          <td><div align="right"><strong><span class="formLable">Phone: </span><span class="required">*</span></strong> </div></td>                          <td><span class="style1">use: xxx-xxx-xxxx </span><br />                            <input type="text" name="phone" size="20" maxlength="15" value="<?php echo $_POST['phone'];?>"/></td>                        </tr>                                                                        <tr>                          <td><div align="right"><span class="formLable"><strong>Fax:</strong></span></div></td>                          <td><span class="style1">use: xxx-xxx-xxxx </span><br />                            <input type="text" name="fax" size="20"  maxlength="15" value="<?php echo $_POST['fax'];?>"/></td>                        </tr>                                              <tr><td colspan=2>  <br /><hr style="color:#eee; width:60%; align:center" /></td></tr>                                                                  <tr>                          <td valign=top></td><td><span class="formLable"><br /><strong>Special Needs:</strong></span><br />                                                       We are committed to making our conference activities accessible<br />                              and enjoyable for everyone.&nbsp; If you have any type of special needs<br />                             (i.e. dietary or accessibility), please provide your information here.<br />                              <input type="text" name="special" size="30" maxlength="60" value="<?php echo $_POST['special'];?>" /><br /><br /></td>                        </tr>                                                                                                                <tr><td colspan=2> <hr style="color:#eee; width:60%; align:center" /><br /></td></tr>                                                                  <tr>                         <tr><td></td>                          <td valign=top><span class="formLable"><strong><span class="required">*</span> T-Shirt size:</strong></span> <br />                                                                    <?php                                  $shirt = $_POST['shirt'];?> <select name="shirt"><?php if (!$shirt==""){echo " <option value=\"$shirt\" SELECTED>$shirt</option>"; }  ?>                           <option value="">-- Select T-Shirt Size --</option>                              <option value="Small">Small</option>                              <option value="Medium">Medium</option>                              <option value="Large">Large</option>                              <option value="X-Large">X-Large</option>                              <option value="XX-Large">XX-Large</option>                              <option value="XXX-Large">XXX-Large</option>                            </select></td>                        </tr>                                                                           <tr><td colspan=2>  <br /><hr style="color:#eee; width:60%; align:center" /><br /></td></tr>                                                                                          <tr><td></td>                          <td><span class="formLable">                            <div align="left">                              <strong> Are you staying at the conference hotel, the<br /> Austin Hilton on 4th St.?</strong></div>                            </span></td></tr>                                                                                 <tr><td></td>                         <td>                            <input type="radio" name="hotelInfo" value="Y" <?php if ($_POST['hotelInfo']=="Y") echo "checked" ?>/>                            Yes                            <input type="radio" name="hotelInfo" value="N" <?php if ($_POST['hotelInfo']=="N") echo "checked" ?>/>                            No <br />                          </td>                        </tr>                                                                           <tr><td colspan=2> <br /><hr style="color:#eee; width:60%; align:center" /><br /></td></tr>                      <tr>                        <tr><td></td>                                                  <td><span class="formLable">                            <div align="left"><br />                              <strong><span class="required">*</span> Will you be attending the JA-SIG conference<br /> in Austin, December 4-6, 2005?</strong><br />&nbsp;&nbsp;&nbsp;                              <input type="radio" name="jasig" value="Y" <?php if ($_POST['jasig']=="Y") echo "checked" ?> />                              Yes                              <input type="radio" name="jasig" value="N" <?php if ($_POST['jasig']=="N") echo "checked" ?>/>                              No<br />                              <br />                            </div>                            </span></td>                        </tr>                                                                     <tr><td></td>                                                 <tr><td colspan=2><hr style="color:#eee; width:60%; align:center" /><br /></td>                         </tr>                                                                        <tr>                          <td></td><td><span class="formLable">                            <div align="left"><br />                              <strong><span class="required">*</span> May we include your contact information<br /> on the attendee list?</strong><br />&nbsp;&nbsp;&nbsp;                         <input type="radio" name="contactInfo" value="Y" <?php if ($_POST['contactInfo']=="Y") echo "checked" ?> />                              Yes                         <input type="radio" name="contactInfo" value="N" <?php if ($_POST['contactInfo']=="N") echo "checked" ?> />                              No<br />                              <br />                            </div>                            </span></td>                        </tr>                                                 <tr><td colspan=2>  <br /><hr style="color:#eee; width:60%; align:center" /><br /></td></tr>                                           <tr>                          <td colspan=2><br /></td> </tr>                                            <tr><td></td>                      <td>                             Click submit to complete registration.  You will receive an online confirmation, and will also be sent a confirmation email. <br /><br /> <input type="submit" name="submit" value="Submit Registration" />                              <br />                            </td>                        </tr>                                            </table>                  </form>                                    </td>                                  <?php  require_once('../includes/footer.inc'); ?>