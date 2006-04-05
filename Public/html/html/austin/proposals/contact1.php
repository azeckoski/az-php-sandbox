<?php



session_start();
if (isset($_POST['submit'])) {


$user_id=$_SESSION['user_id'];

include ('validate_contact.php');


if($title AND $inst AND $add AND $city AND $state AND $zip AND $country AND $phone){
//validate then end session
echo "valid";


$_SESSION['institution']=$_POST['institution'];
$_SESSION['otherInst']=$_POST['otherInst'];
$_SESSION['dept']=$_POST['dept'];
$_SESSION['address1']=$_POST['address1'];
$_SESSION['address2']=$_POST['address2'];
$_SESSION['city']=$_POST['city'];
$_SESSION['state']=$_POST['state'];
$_SESSION['otherState']=$_POST['otherState'];
$_SESSION['zip']=$_POST['zip'];
$_SESSION['country']=$_POST['country'];
$_SESSION['phone']=$_POST['phone'];
$_SESSION['fax']=$_POST['fax'];
$_SESSION['title']=$_POST['title'];



include("../includes/submit_contact2.php");
header("Location:confirmpage.php");

}

}




?>

<?php  require_once('../includes/cfp_header.inc'); 
echo $_SESSION['user_id'];

?>
              </td>
            <td valign="top" bgcolor="#FAFAFA" width="100%"><div classmain>
              <table width="100%"  border="0" cellspacing="0" cellpadding="0">
                <tr valign="top" bgcolor="#F1F1F1">
                                  </tr>
                <tr>
                                  </tr>
                <tr align="left" valign="top">
                  <td colspan="3" style=" border-top: 4px solid #FFFFFF; padding: 5px;"><div class="main">

                      <div class="componentheading">Call for Proposals -- Submission Form</div><table class="blog" cellpadding="0" cellspacing="0"><tr><td valign="top"><div>		
                   
			
		      <tr><td colspan=2>
             		     <form name="form1" method="post" action="<?php echo $_SERVER[PHP_SELF]; ?>">     
 
              <table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td width="11" height="25" background="http://www.sakaiproject.org/templates/247portal-b-brown2/images/shadowl.jpg"><div>
            </div></td>
            <td height="25" bgcolor="#F1F1F1" style="border-bottom: 1px solid #999999; border-top: 5px solid #FFFFFF;"><span class="pathway"><img src="http://www.sakaiproject.org/images/M_images/arrow.png" height="12" width="12" alt="arrow" />Step 1 - Select Format  &nbsp; &nbsp; <img src="http://www.sakaiproject.org/images/M_images/arrow.png" height="8" width="8" alt="arrow" /> Step 2- Complete Proposal Details &nbsp; &nbsp; <img src="http://www.sakaiproject.org/images/M_images/arrow.png" height="8" width="8" alt="arrow" /><strong>  Step 3- Contact Information &nbsp; &nbsp; </strong><img src="http://www.sakaiproject.org/images/M_images/arrow.png" height="8" width="8" alt="arrow" />  Step 4-Confirmation</span>

</td>
            
            <td width="11" height="25" align="right" background="http://www.sakaiproject.org/templates/247portal-b-brown2/images/shadowr.jpg">&nbsp;</td>
          </tr>
        </table></td></tr>
                          <tr><td colspan=2>
                             <?php 
if ($message) {
	echo "<div class=\"errors\" align=\"left\"><blockquote><font color=red><strong>Please provide the following information:</strong></font><ul class=small>";	
	foreach ($message as $key => $value) {
		echo $value;	
	}
	

	echo "</ul></blockquote></div> ";
}


?>
                          </td>                        </tr>
<tr>
      
                          <td valign="top" colspan="2"><span class="required">* </span>= Required fields
                          </td>
                        </tr>
                        <tr>
                          <td width="160px"><div align="right"><strong><span class="formLable"> First Name: </span><span class="required">*&nbsp;&nbsp;&nbsp;</span></strong></div></td>
                          <td align="left"><?php echo $_SESSION['firstname'] ;?></td>
                        </tr><tr>
                          <td><div align="right"><strong><span class="formLable"> Last Name: </span><span class="required">*&nbsp;&nbsp;&nbsp;</span></strong></div></td>
                          <td align="left"><?php echo $_SESSION['lastname'];?></td>
                        </tr>
                        
                         
                     <tr>
                          <td><div align="right"><strong><span class="formLable">Email:</span></strong> <span class="required">*&nbsp;&nbsp;&nbsp;</span> </div></td>
                          <td><?php echo $_SESSION['email1'];?></td>
                        </tr>
                      <tr><td colspan=2>  <br /></td></tr>
                      <tr>
                      <tr valign="top">
                          <td><div align="right"><strong><span class="formLable">Role:</span> </strong><span class="required">*&nbsp;&nbsp;&nbsp;</span><span class="small" align="left"><br />please select the role from the list which best describes<br /> your role within your organization</span></div></td>
                          <td>
                          
                          <div><br /><?php
// initialize or capture variable
$title = $_POST['title'];
?><select name="title">
<?php if (!$title==""){
echo "
 <option value=\"$title\" SELECTED>$title</option>";
 }  ?>
             <option value="">-- select --</option>
                              <option value="Developer/Programmer" selected>Developer/Programmer</option>
                              <option value="User Support">User Support</option>
                              <option value="UI Designer">UI designer</option>
                              <option value="Technical/Project Management">Technical/Project Management</option>
                              <option value="Systems Analyst or Analyst">Systems Analyst or Analyst</option>
                             <option value="General Management">General Management</option>
                               <option value="Pedagogy/Teaching Support">Pedagogy/Teaching Support</option>
                              <option value="Faculty">Faculty</option>
                              <option value="Librarian">Librarian</option>
                            </select>
                          
                          </td>
                        </tr>
                        <tr>
                          <td><div align="right"><br /><strong><span class="formLable"> Organization:</span></strong><span class="required">*&nbsp;&nbsp;&nbsp;</span> </div></td>
<td>
                        
<select name="institution">


                   <option value=""> --Select Organization--</option>
                              <option value="Albany Medical College" selected>Albany Medical College</option>
<option value="Arizona State University">Arizona State University</option>
<option value="Australian National Academy">Australian National Academy</option>
<option value="Boston University School of Management">Boston University School of Management</option>
<option value="Brown University ">Brown University </option>
<option value="Carleton College">Carleton College</option>
<option value="Carnegie Foundation for the Advancement of Teaching">Carnegie Foundation for the Advancement of Teaching</option>
<option value="Carnegie Mellon University">Carnegie Mellon University</option>
<option value="Cerritos Community College">Cerritos Community College</option>
<option value="Coast Community College District (Coastline Community College)">Coast Community College District (Coastline Community College)</option>
<option value="Columbia University">Columbia University</option>
<option value="Cornell University">Cornell University</option>
<option value="Dartmouth College">Dartmouth College</option>
<option value="Edgenics">Edgenics</option>
<option value="Florida Community College at Jacksonville">Florida Community College at Jacksonville</option>
<option value="Foothill-De Anza Community College District">Foothill-De Anza Community College District</option>
<option value="Franklin University ">Franklin University </option>
<option value="Georgetown University">Georgetown University</option>
<option value="Harvard University">Harvard University</option>
<option value="Hosei University IT Research Center">Hosei University IT Research Center</option>
<option value="Indiana University">Indiana University</option>
<option value="Johns Hopkins University">Johns Hopkins University</option>
<option value="Lancaster University">Lancaster University</option>
<option value="Loyola University, Chicago">Loyola University, Chicago</option>
<option value="Luebeck University of Applied Sciences">Luebeck University of Applied Sciences</option>
<option value="Maricopa County Community College District ">Maricopa County Community College District </option>
<option value="Marist College">Marist College</option>
<option value="MIT">MIT</option>
<option value="Monash University">Monash University</option>
<option value="Nagoya University">Nagoya University</option>
<option value="New York University">New York University</option>
<option value="Northeastern University">Northeastern University</option>
<option value="North-West University (SA)">North-West University (SA)</option>
<option value="Northwestern University">Northwestern University</option>
<option value="Ohio State University">Ohio State University</option>
<option value="Pennsylvania State University">Pennsylvania State University</option>
<option value="Portand State University">Portand State University</option>
<option value="Princeton University">Princeton University</option>
<option value="Rice University">Rice University</option>
<option value="Ringling School of Art and Design">Ringling School of Art and Design</option>
<option value="Roskilde University (Denmark)">Roskilde University (Denmark)</option>
<option value="Rutgers University">Rutgers University</option>
<option value="Simon Fraser University">Simon Fraser University</option>
<option value="Stanford University">Stanford University</option>
<option value="State University of New York System Administration">State University of New York System Administration</option>
<option value="Stockholm University">Stockholm University</option>
<option value="SURF/University of Amsterdam ">SURF/University of Amsterdam </option>
<option value="Syracuse University">Syracuse University</option>
<option value="Texas State University - San Marcos">Texas State University - San Marcos</option>
<option value="Tufts University">Tufts University</option>
<option value="Universidad Politecnica de Valencia (Spain)">Universidad Politecnica de Valencia (Spain)</option>
<option value="Universitat de Lleida (Spain)">Universitat de Lleida (Spain)</option>
<option value="University of Arizona">University of Arizona</option>
<option value="University of British Columbia">University of British Columbia</option>
<option value="University of California, Office of the Chancellor">University of California, Office of the Chancellor</option>
<option value="University of California Berkeley">University of California Berkeley</option>
<option value="University of California, Davis">University of California, Davis</option>
<option value="University of California, Los Angeles">University of California, Los Angeles</option>
<option value="University of California, Merced">University of California, Merced</option>
<option value="University of California, Santa Barbara">University of California, Santa Barbara</option>
<option value="University of Cambridge, CARET">University of Cambridge, CARET</option>
<option value="University of Cape Town, SA">University of Cape Town, SA</option>
<option value="University of Colorado at Boulder">University of Colorado at Boulder</option>
<option value="University of Delaware">University of Delaware</option>
<option value="University of Hawaii">University of Hawaii</option>
<option value="University of Hull">University of Hull</option>
<option value="University of Illinois at Urbana-Champaign">University of Illinois at Urbana-Champaign</option>
<option value="University of Melbourne">University of Melbourne</option>
<option value="University of Michigan">University of Michigan</option>
<option value="University of Minnesota">University of Minnesota</option>
<option value="University of Missouri">University of Missouri</option>
<option value="University of Nebraska">University of Nebraska</option>
<option value="University of Oklahoma">University of Oklahoma</option>
<option value="University of South Africa (UNISA)">University of South Africa (UNISA)</option>
<option value="University of Texas at Austin">University of Texas at Austin</option>
<option value="University of Toronto, Knowledge Media Design Institute">University of Toronto, Knowledge Media Design Institute</option>
<option value="University of Virginia">University of Virginia</option>
<option value="University of Washington">University of Washington</option>
<option value="University of Wisconsin, Madison">University of Wisconsin, Madison</option>
<option value="Virginia Polytechnic Institute and State University">Virginia Polytechnic Institute and State University</option>
<option value="Weber State University">Weber State University</option>
<option value="Whitman College">Whitman College</option>
<option value="Yale University">Yale University</option>

                              <option value="Embanet">Embanet</option>
                              <option value="HarvestRoad">HarvestRoad</option>
                              <option value="IBM">IBM</option>
                              <option value="JustStudents">JustStudents</option>
                              <option value="Ostrakon">Ostrakon </option>
                              <option value="The rSmart Group">The rSmart Group</option>
                              <option value="Sun Microsystems">Sun Microsystems</option>

                              <option value="Sunguard SCT">Sunguard SCT </option>
                              <option value="Unicon">Unicon</option>
                              <option value="UNISYS">UNISYS</option>
                            </select>
                            <br /></td>
                        </tr>
                        
                        <tr>
                          <td><div align="right"></div></td>
                          <td class="small">
                            If <strong><em>Other</em></strong> please enter here:
                          <input type="text" name="otherInst" size="20" maxlength="40" value="<?php echo $_POST['otherInst'];?>" /></td>
                        </tr>
                                              <tr><td colspan=2>  <br /></td></tr>

                       
                        <tr>
                          <td><div align="right"><strong><span class="formLable">Department</span>:&nbsp;&nbsp;&nbsp;</strong> </div></td>
                          <td><input type="text" name="dept" size="30" maxlength="30" value="my department"/></td>
                        </tr>
                        <tr>
                          <td><div align="right"><strong><span class="formLable"> Address 1</span>: </strong><span class="required">*&nbsp;&nbsp;&nbsp;</span> </div></td>
                          <td><input type="text" name="address1" size="30" maxlength="30" value="University Avenue" /></td>
                        </tr>
                        <tr>
                          <td><div align="right"><strong><span class="formLable">Address 2: </span>&nbsp;&nbsp;&nbsp;</strong></div></td>
                          <td><input type="text" name="address2" size="30" maxlength="30"  value="<?php echo $_POST['address2'];?>"/></td>
                        </tr>
                        <tr>
                          <td><div align="right"><strong><span class="formLable">Town/City:</span> <span class="required">*&nbsp;&nbsp;&nbsp;</span></strong></div></td>
                          <td><input type="text" name="city" size="30" maxlength="30" value="Wiartin" /></td>
                        </tr>
                        <tr>
                          <td><div align="right"><strong><span class="formLable">State/Province:</span> <span class="required">*</span></strong></div></td>
                          <td>
                          
                           <?php                         
                          
$state = $_POST['state'];
?><select name="state">
<?php if (!$state==""){
echo "
 <option value=\"$state\" SELECTED>$state</option>";
 }  ?>
                              <option value="">State/Province</option>
                              <option value="">----United States----</option>
                              <option value="AL" selected> Alabama</option>
                              <option value="AK"> Alaska</option>
                              <option value="AZ"> Arizona</option>
                              <option value="AR"> Arkansas</option>
                              <option value="CA"> California</option>
                              <option value="CO"> Colorado</option>
                              <option value="CT"> Connecticut</option>
                              <option value="DE"> Delaware</option>
                              <option value="DC"> District of Columbia</option>
                              <option value="FL"> Florida</option>
                              <option value="GA"> Georgia</option>
                              <option value="HI"> Hawaii</option>
                              <option value="ID"> Idaho</option>
                              <option value="IL"> Illinois</option>
                              <option value="IN"> Indiana</option>
                              <option value="IA"> Iowa</option>
                              <option value="KS"> Kansas</option>
                              <option value="KY"> Kentucky</option>
                              <option value="LA"> Louisiana</option>
                              <option value="ME"> Maine</option>
                              <option value="MD"> Maryland</option>
                              <option value="MA"> Massachusetts</option>
                              <option value="MI"> Michigan</option>
                              <option value="MN"> Minnesota</option>
                              <option value="MS"> Mississippi</option>
                              <option value="MO"> Missouri</option>
                              <option value="MT"> Montana</option>
                              <option value="NE"> Nebraska</option>
                              <option value="NV"> Nevada</option>
                              <option value="NH"> New Hampshire</option>
                              <option value="NJ"> New Jersey</option>
                              <option value="NM"> New Mexico</option>
                              <option value="NY"> New York</option>
                              <option value="NC"> North Carolina</option>
                              <option value="ND"> North Dakota</option>
                              <option value="OH"> Ohio</option>
                              <option value="OK"> Oklahoma</option>
                              <option value="OR"> Oregon</option>
                              <option value="PA"> Pennsylvania</option>
                              <option value="RI"> Rhode Island</option>
                              <option value="SC"> South Carolina</option>
                              <option value="SD"> South Dakota</option>
                              <option value="TN"> Tennessee</option>
                              <option value="TX"> Texas</option>
                              <option value="UT"> Utah</option>
                              <option value="VT"> Vermont</option>
                              <option value="VA"> Virginia</option>
                              <option value="WA"> Washington</option>
                              <option value="WV"> West Virginia</option>
                              <option value="WI"> Wisconsin</option>
                              <option value="WY"> Wyoming</option>
                              <option value="">&nbsp;</option>
                              <option value="">----US Territories----</option>
                              <option value="AS"> America Samoa</option>
                              <option value="GU"> Guam</option>
                              <option value="MH"> Marshall Islands</option>
                              <option value="MP"> Northern Mariana Islands</option>
                              <option value="PW"> Palau</option>
                              <option value="PR"> Puerto Rico</option>
                              <option value="VI"> Virgin Islands</option>
                              <option value="">&nbsp;</option>
                              <option value="">----Canada----</option>
                              <option value="AB"> Alberta</option>
                              <option value="BC"> British Columbia</option>
                              <option value="MB"> Manitoba</option>
                              <option value="NB"> New Brunswick</option>
                              <option value="NF"> Newfoundland</option>
                              <option value="NWT"> Northwest Territories</option>
                              <option value="NS"> Nova Scotia</option>
                              <option value="NU"> Nunavut</option>
                              <option value="ON"> Ontario</option>
                              <option value="PE"> Prince Edward Island</option>
                              <option value="PQ"> Quebec</option>
                              <option value="SK"> Saskatchewan</option>
                              <option value="YT"> Yukon Territory</option>
                           
                            </select></td>
                        </tr>
                        <tr>
                          <td><div align="right">  </div></td>
                          <td class="small">If <strong><em>Other</em></strong> please enter here:
                            <input type="text" name="otherState" size="30" maxlength="30"  value="<?php echo $_POST['otherState'];?>" />
                            <br />                            </td>
                        </tr>
                        <tr>
                          <td><div align="right"><strong><span class="formLable">Zip/Postal Code:</span> <span class="required">*&nbsp;&nbsp;&nbsp;</span></strong> </div></td>
                          <td><input type="text" name="zip" size="10" maxlength="15"  value="48109" /></td>
                        </tr>
                        <tr>
                          <td><div align="right"><strong><span class="formLable">Country: </span><span class="required">*&nbsp;&nbsp;&nbsp;</span></strong> </div></td>
                          <td>
                             <?php                         
                          
$country = $_POST['country'];
?><select name="country">
<?php if (!$country==""){
echo "
 <option value=\"$country\" SELECTED>$country</option>";
 }  ?>
                          
                              <option value="">Country</option>
                              <option value="US" selected>United States</option>
                              <option value="CA">Canada</option>
                              <option value="AL">Albania</option>
                              <option value="DZ">Algeria</option>
                              <option value="AI">Anguilla</option>
                              <option value="AR">Argentina</option>
                              <option value="AU">Australia</option>
                              <option value="AT">Austria</option>
                              <option value="BS">Bahamas</option>
                              <option value="BH">Bahrain</option>
                              <option value="BD">Bangladesh</option>
                              <option value="BE">Belgium</option>
                              <option value="BM">Bermuda</option>
                              <option value="BR">Brazil</option>
                              <option value="BN">Brunei</option>
                              <option value="BG">Bulgaria</option>
                              <option value="KY">Cayman Islands</option>
                              <option value="CL">Chile</option>
                              <option value="CN">China</option>
                              <option value="CO">Colombia</option>
                              <option value="CR">Costa Rica</option>
                              <option value="HR">Croatia</option>
                              <option value="DK">Denmark</option>
                              <option value="DJ">Djibouti</option>
                              <option value="EC">Ecuador</option>
                              <option value="EG">Egypt</option>
                              <option value="ET">Ethiopia</option>
                              <option value="FL">Falkland Islands (Malvinas)</option>
                              <option value="FJ">Fiji</option>
                              <option value="FI">Finland</option>
                              <option value="FR">France</option>
                              <option value="PF">French Polynesia</option>
                              <option value="DE">Germany</option>
                              <option value="GE">Georgia</option>
                              <option value="GR">Greece</option>
                              <option value="GU">Guam</option>
                              <option value="GT">Guatemala</option>
                              <option value="HK">Hong Kong</option>
                              <option value="HU">Hungary</option>
                              <option value="IN">India</option>
                              <option value="ID">Indonesia</option>
                              <option value="IE">Ireland</option>
                              <option value="IL">Israel</option>
                              <option value="IT">Italy</option>
                              <option value="JP">Japan</option>
                              <option value="JO">Jordan</option>
                              <option value="KR">Korea</option>
                              <option value="KW">Kuwait</option>
                              <option value="LV">Latvia</option>
                              <option value="LB">Lebanon</option>
                              <option value="LU">Luxembourg</option>
                              <option value="MO">Macau</option>
                              <option value="MY">Malaysia</option>
                              <option value="MT">Malta</option>
                              <option value="MX">Mexico</option>
                              <option value="MA">Morocco</option>
                              <option value="NL">Netherlands</option>
                              <option value="AN">Netherlands Antilles</option>
                              <option value="NZ">New Zealand</option>
                              <option value="NI">Nicaragua</option>
                              <option value="NG">Nigeria</option>
                              <option value="NF">Norfolk Island</option>
                              <option value="NO">Norway</option>
                              <option value="OM">Oman</option>
                              <option value="PK">Pakistan</option>
                              <option value="PA">Panama</option>
                              <option value="PN">Papua New Guinea</option>
                              <option value="PY">Paraguay</option>
                              <option value="PE">Peru</option>
                              <option value="PH">Philippines</option>
                              <option value="PL">Poland</option>
                              <option value="PT">Portugal</option>
                              <option value="QA">Qatar</option>
                              <option value="PA">Republic of Panama</option>
                              <option value="RO">Romania</option>
                              <option value="RU">Russia</option>
                              <option value="SC">Seychelles</option>
                              <option value="SA">Saudi Arabia</option>
                              <option value="SG">Singapore</option>
                              <option value="ZA">South Africa</option>
                              <option value="ES">Spain</option>
                              <option value="SE">Sweden</option>
                              <option value="CH">Switzerland</option>
                              <option value="SY">Syria</option>
                              <option value="TW">Taiwan</option>
                              <option value="TZ">Tanzania</option>
                              <option value="TH">Thailand</option>
                              <option value="TN">Tunisia</option>
                              <option value="TR">Turkey</option>
                              <option value="TC">Turks and Caicos Islands</option>
                              <option value="TM">Turkmenistan</option>
                              <option value="UG">Uganda</option>
                              <option value="GB">United Kingdom</option>
                              <option value="AE">United Arab Emirates</option>
                              <option value="UY">Uruguay</option>
                              <option value="UZ">Uzbekistan</option>
                              <option value="VE">Venezuela</option>
                              <option value="VN">Vietnam</option>
                              <option value="YE">Yemen</option>
                              <option value="ZW">Zimbabwe</option>
                            </select></td>
                        </tr>
                        <tr>
                          <td><div align="right"><strong><span class="formLable">Phone: </span><span class="required">*&nbsp;&nbsp;&nbsp;</span></strong> </div></td>
                          <td><span class="style1">use: xxx-xxx-xxxx </span><br />
                            <input type="text" name="phone" size="20" maxlength="15" value="555-519-5555"/></td>
                        </tr>
                        <tr>
                          <td><div align="right"><span class="formLable"><strong>Fax:</strong>&nbsp;&nbsp;&nbsp;</span></div></td>
                          <td><span class="style1">use: xxx-xxx-xxxx </span><br />
                            <input type="text" name="fax" size="20"  maxlength="15" value="<?php echo $_POST['fax'];?>"/></td>
                        </tr>
                        
                               
                        <tr>
                          <td colspan=2><br /></td> </tr>
                      
                      <tr><td></td><td>
                             Click submit to complete the proposal submission process.  <br /><br /> <input type="submit" name="submit" value="Submit my proposals" />
                              <br />
                           </div> </td>
                        </tr>
                      </tbody>
                    </table>
                  </form>
                                  
<?php  require_once('../includes/footer.inc'); 
?>