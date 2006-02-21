<?php 
if (isset($_POST[submit])) {

include_once('validate.php');



	
if ($f AND $l AND $e1 AND $e1 AND $e3 AND $s AND $t) {
		//all required information provided
		
session_start();

$_SESSION['firstname']= $_POST['firstname'];
$_SESSION['lastname']=$_POST['lastname'];
$_SESSION['email1']=$_POST['email1'];


//set presentation and demo values to 0 (none have been submitted yet)

		
$_SESSION['num_pres']='0';
$_SESSION['num_demo']='0';


//finished with the database entry stuff - no errors

//go to presentation page 
if($_POST['type']=="presentation")
header("Location:presentation.php");
if($_POST['type']=="demo")
header("Location:demo.php");
}




}
 //show form 

?>
<?php  require_once('../includes/header.inc'); 
?>            </td>
            <td valign="top" bgcolor="#FAFAFA" width="100%"><div classmain>
              <table width="100%"  border="0" cellspacing="0" cellpadding="0">
                <tr valign="top" bgcolor="#F1F1F1">
                                  </tr>
                <tr>
                                  </tr>
                <tr align="left" valign="top">
                  <td colspan="3" style=" border-top: 4px solid #FFFFFF; padding: 5px;"><div class="main">

                      <div class="componentheading">Call for Proposals -- Submission Form</div><table class="blog" cellpadding="0" cellspacing="0"><tr><td valign="top"><div>		
                   
			<div>
			
		     <form name="form1" method="post" action="<?php echo $_SERVER[PHP_SELF]; ?>">     
              <table >   <tr><td colspan=2>
              
              <table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td width="11" height="25" background="http://www.sakaitest.org/templates/247portal-b-brown2/images/shadowl.jpg"><div>
            </div></td>
            <td height="25" bgcolor="#F1F1F1" style="border-bottom: 1px solid #999999; border-top: 5px solid #FFFFFF;"><span class="pathway"><img src="http://www.sakaitest.org/images/M_images/arrow.png" height="12" width="12" alt="arrow" /><strong>Step 1 - Select Format </strong> &nbsp; &nbsp; <img src="http://www.sakaitest.org/images/M_images/arrow.png" height="8" width="8" alt="arrow" />  Step 2- Complete Proposal Details &nbsp; &nbsp; <img src="http://www.sakaitest.org/images/M_images/arrow.png" height="8" width="8" alt="arrow" />  Step 3- Contact Information &nbsp; &nbsp; <img src="http://www.sakaitest.org/images/M_images/arrow.png" height="8" width="8" alt="arrow" />  Step 4-Confirmation</span>

</td>
            
            <td width="11" height="25" align="right" background="http://www.sakaitest.org/templates/247portal-b-brown2/images/shadowr.jpg">&nbsp;</td>
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
                          </td></tr>
                       <tr><td valign="top" colspan="2"><span class="required">* </span><span class="small">= Required fields</span>
                          </td></tr>
                        
                        <tr><td colspan=2>
                        <table><tr>
           		  <td width="55%"><div><strong><span class="formLable">First Name</span>:</strong> <span class="required">*</span> 
           		  <input type="text" name="firstname" size="20" maxlength="20" value="<?php echo $_POST['firstname'];?>" /> </div>
           		   <br /><div ><strong><span class="formLable">Last Name</span>:</strong> <span class="required">*</span> 
                     <input type="text" name="lastname" size="20" maxlength="20" value="<?php echo $_POST['lastname'];?>" /></div>
                    
                       </td>
                       <td width="45%">
                       <div align="right"><strong><span class="formLable">Email:</span></strong> <span class="required">*</span> 
                        <input type="text" name="email1" size="20" maxlength="65" value="<?php echo $_POST['email1'];?>" /></div>  
                     <br />   <div align="right"><strong><span class="formLable">Confirm Email:</span></strong> <span class="required">*</span> 
                         <input type="text" name="email2" size="20" maxlength="65" value="<?php echo $_POST['email2'];?>" /></div></td>
                        </tr>
                        </table></td></tr>
            
                         <tr valign="top"> 
                         <td colspan="2"><br /><span class="required">*</span><strong>Select the type of proposal to be submitted:  </strong><br />You will have the opportunity to submit additional proposals after you complete your first proposal form.  </td>
                         </tr>
                         <tr valign="top"> 
                         <td colspan=2 width=100%><table width=100%><tr valign=top><td width=50%><input name="type" type="radio" value="demo">&nbsp;&nbsp; <strong>Conference Presentation</strong>
                         <blockquote>Presentation formats include:  panel, workshop, discussion, lecture, and showcase (posters).  Presentations will take place at 
              the conference hotel, during the conference's daytime schedule for December 7, 8, and 9. </blockquote></td><td width=50%>  
              <input name="type" type="radio" value="demo">&nbsp;&nbsp; <strong>Technology Demo</strong><blockquote>Technology Demos will take place during on Thursday, December 7th, at the Technology Demos 
              and Reception at the UT-Austin campus.</blockquote> 
                       
                          </td></tr></table></td>
                        </tr>
                        <tr>
                          <td></td><td><br />
<input type="submit" name="submit" value="continue" />
                            
                              <br />
                           </td>
                        </tr>
                    </table>
                  </form><?php  require_once('../includes/footer.inc'); 
?>