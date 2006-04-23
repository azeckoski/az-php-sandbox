<?php
/*
 * Created on March 16, 2006 by @author aaronz
 * Modified from code by Susan Hardin (shardin@umich.edu)
 * Aaron Zeckoski (aaronz@vt.edu) - Virginia Tech (http://www.vt.edu/)
 */
?>
<?php
require_once '../include/tool_vars.php';

$PAGE_NAME = "Call for Proposals";
$Message = "";

// connect to database
require '../sql/mysqlconnect.php';

// check authentication
require $ACCOUNTS_PATH.'include/check_authentic.php';

// login if not autheticated
$AUTH_MESSAGE = "You must login to register or submit a proposal for the $CONF_NAME conference. If you do not have an account, please create one.";
require $ACCOUNTS_PATH.'include/auth_login_redirect.php';

// bring in the form validation code
require $ACCOUNTS_PATH.'ajax/validators.php';

// bring in inst and conf data
require '../registration/include/getInstConf.php';



// get the passed message if there is one
if($_GET['msg']) {
	$Message .= "<br/>" . $_GET['msg'];
}

// First get the list of proposals for this user for the current conf 

$filter_users_sql = "and CP.users_pk='$User->pk' ";

// (maybe limit this using a search later on)
$sql = "select U1.firstname, U1.lastname, U1.email, U1.institution, " .
	"U1.firstname||' '||U1.lastname as fullname, CV.vote, " .
	"CP.* from conf_proposals CP left join users U1 on U1.pk = CP.users_pk " .
	"left join conf_proposals_vote CV on CV.conf_proposals_pk = CP.pk " .
	"and CV.users_pk='$User->pk' " .
	"where CP.confID = '$CONF_ID' "  . 
	$filter_users_sql . $filter_edits_sql . $sqlsorting . $mysql_limit;

//print "SQL=$sql<br/>";
$result = mysql_query($sql) or die("Query failed ($sql): " . mysql_error());
$items = array();

// put all of the query results into an array first
while($row=mysql_fetch_assoc($result)) { $items[$row['pk']] = $row; }

// Define the array of items to validate and the validation strings
$vItems = array();
$vItems['type'] = "required";


// writing data and other good things happen here
$completed = false;
if ($_POST['save']) { // saving the form

	// DO SERVER SIDE VALIDATION
	$errors = 0;
	$validationOutput = ServerValidate($vItems, "return");
	if ($validationOutput) {
		$errors++;
		$Message = "<fieldset><legend>Validation Errors</legend>".
			"<b style='color:red;'>Please fix the following errors:</b><br/>".
			$validationOutput."</fieldset>";
	}

	if ($errors == 0) {
		//all required information provided
		$type=$_POST['type'];
		$new=$_POST['new'];
			header("Location: edit_proposal.php?type=$type&amp;edit=0&amp;new=$new");
	}
}

?>


<!-- // INCLUDE THE HTML HEAD -->
<?php include $ACCOUNTS_PATH.'include/top_header.php';  ?>
<script type="text/javascript" src="/accounts/ajax/validate.js"></script>
<!-- // INCLUDE THE HEADER -->
<?php include '../include/header.php';  ?>

	<table width="100%" class="blog" cellpadding="0" cellspacing="0">
	  <tr>
	    <td valign="top"><div class="componentheading">Call for Proposals</div></td>
	  </tr>
	  <tr>
		  <td height="25" bgcolor="#ffffff" style=" border-top: 5px solid #FFFFFF;">
		  	<span class="pathway">
		  		<img src="../include/images/arrow.png" height="12" width="12" alt="arrow" />
		  		<span class="activestep">Start &nbsp; &nbsp; &nbsp;</span>
		  		<img src="../include/images/arrow.png" height="8" width="8" alt="arrow" />Proposal Details &nbsp; &nbsp; &nbsp; 
		  		<img src="../include/images/arrow.png" height="8" width="8" alt="arrow" />Contact Information&nbsp; &nbsp; &nbsp; 
		  		<img src="../include/images/arrow.png" height="8" width="8" alt="arrow" />Confirmation
		  	</span>
		  </td>
	  </tr>
	</table>

	<div id="cfp"><!-- start form section -->
	<form name="form1" id="form1" method="post" action="<?= $_SERVER['PHP_SELF'] ?>" >
	  <input type="hidden" name="save" value="1" />
	   <input type="hidden" name="new" value="" />
	  <table width="100%" cellpadding="0" cellspacing="0">
		<?php if ($items) { // user has submitted a previous proposal   	
			 // now dump the data we currently have
			$line = 0;  ?>
		<tr>
		 <td colspan=2>
			<div style="padding:5px; margin:0px; background: #ffffff;">
				<input type="hidden" name="new" value="1" /><strong>Your Vancouver conference proposals: </strong>
		   		<ul>
				<?php 
				foreach ($items as $item) { // loop through all of the proposal items
					$line++;
					$pk = $item['pk'];
				
					  ?>
					
					<li><?=  $item['title'] ?> ( <a style="color:#336699;" href="<?= "edit_proposal.php" . "?pk=" . $item['pk'] . "&amp;edit=1" ."&amp;type=". $item['type'] ; ?>"> edit </a> | 
						<a style="color:#336699;" href="<?=  "edit_proposal.php" . "?pk=" . $item['pk'] . "&amp;delete=1" ."&amp;type=". $item['type'] ; ?>"> delete </a>)&nbsp; &nbsp;<br/></li>
					<?php  }  ?>
				</ul>
			 </div>
		  </td>
	   </tr> <?php } ?>
	   <tr>
	      <td valign="top" colspan="2" style="padding:0px;">
	      	<div id="requiredMessage"></div>
	      </td>
	   </tr>
	   <tr valign="top">
	      <td colspan="2" style="border:0; padding-bottom:0px;">
	        	<img id="typeImg" src="/accounts/ajax/images/blank.gif" width="16" height="16" /><strong>Select a proposal type:</strong>
			<input type="hidden" id="typeValidate" value="<?= $vItems['type'] ?>" /><span id="typeMsg"></span>
		 </td>
	   </tr>
	   <tr>
	     <td valign="top" width="50%">
	      	<input name="type" type="radio" value="presentation" <?php if ($_POST['type']=="presentation") echo "checked" ?> />&nbsp;&nbsp;<strong>Conference Presentation</strong>
			<div style="padding:0px 10px;">
					Presentation formats include: panel, workshop, discussion, and lecture. 
					Presentations will take place at the conference hotel, during the conference's 
					daytime schedule for May 30 through June 2nd.
				</div>
			</td>
	        <td valign="top" width="50%">
	        		<input name="type" type="radio" value="demo" <?php if ($_POST['type']=="demo") echo "checked" ?> />	&nbsp;&nbsp;<strong>Technology Demo</strong>
				<div style="padding:0px 10px;">
					Technology Demos will take place on Thursday, June 1st. 
					[<a href="http://www.sakaiproject.org/index.php?option=com_content&amp;task=blogcategory&amp;id=173&amp;Itemid=523" target=blank>more information</a>]
				</div>
			</td>
	      </tr>
	      <tr>
	         <td colspan=2 style="text-align:center;">
			   	<input type="submit" name="submit" value="Continue" />
		     </td>
		 </tr>
      </table>
   </form>
</div> <!-- end cfp -->
	
         <div style="margin:16px;"></div> <!-- SPACER -->
	
      </div> <!-- end  content_main  -->
   </div> <!-- end container-inner -->
</div> <!--end of outer left -->

	 <div id=outerright><!-- start outerright -->
		 <div id=rightcol> <!--start rightcol -->
		   <div class="componentheading">More Info...</div>
		   <div class="contentheading">What will you need to provide?</div>
		   <div class="contentpaneopen">
	 	     <div><a href="http://www.sakaiproject.org/index.php?option=com_content&amp;task=blogcategory&amp;id=170&amp;Itemid=519" target=blank> PROPOSAL SUBMISSION GUIDELINES </a><br /> <br />
	 	    	</div>
	 	    	<p>Preview a <a href="http://sakaiproject.org/vancouver/sakai_vancouverCFP.pdf" title="not available yet...">sample proposal form</a> and instructions for completing this Call for Proposal submission process. </p>
	 	  </div>  
	 	  <div class="contentheading">Review Previous Conference Sessions</div>
	 	  <div class="contentpaneopen"><a title="" href="http://www.sakaiproject.org/index.php?option=com_content&amp;task=blogcategory&amp;id=161&amp;Itemid=497" target="blank"> 
	 	    	  <img style="margin: 0px 10px 0px 0px;" width="100" height="61" border="1" title="" alt="" src="../include/images/agenda.gif" /><br />
	 	 	  </a> Review the sessions offered at the Sakai Austin Conference (December 2005)<br />
	 	  </div>
	     </div> <!--end rightcol -->
	  </div> <!-- end outerright -->
	  
</div><!-- end containerbg -->


<?php include '../include/footer.php'; // Include the FOOTER ?>
