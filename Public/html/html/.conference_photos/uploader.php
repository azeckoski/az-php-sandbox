<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Sakai Project: SEPP Conference Facebook</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta name="description" content=",Sakai - www.sakaiproject.org, Community Source Software for Education.">
<meta name="keywords" content=",sakai, sakaiproject.org, sakaiproject, Sakai, Community Source, Open Source, open-open, educational software, collaborative">
<meta name="robots" content="index, follow">
<link href="template_css.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="facebook2.css" type="text/css"/>
<style type="text/css">
#help p{ width:300px;
}#help a{font-size: 10px;
}
.theading{
font-weight: bold;
}
</style>
</head>
<body>
<table bgcolor="#ffffff" border="0" cellpadding="0" cellspacing="0">
  <tbody>
  
    <tr>
      <td class="mainHeader" width="100%">
      <table width="100%" border="0" cellpadding="0" cellspacing="0">
          <tbody>
            <tr>
              <td width=160px><a href="../index.php"><img src="../conferenceJune_05/regindex_files/logoslate160x89.jfif" alt="Sakai Logo" border="0"></a> </td>
              <td id=confHeader><div id=header>
<img src="../images/stories/conf_albumJune05/conf4.jpg"></div></td>
            </tr>
          </tbody>
        </table>
       </td>
    </tr>
    
    <tr>
      <td>
       <table id="searchBar1" bgcolor="#f3f3f3" border="0" width="100%">
          <tbody>
            <tr>
              <td class="searchBar"><span class="pathway"> <img src="../conferenceJune_05/regindex_files/arrow.png" height="9" width="9"> <span class="pathway"><a href="http://www.sakaiproject.org/index.php?option=com_content&task=view&id=243&Itemid=477">SEPP Conference</a> <img src="../conferenceJune_05/regindex_files/arrow.png" alt="arrow"> <a href="index.php">Conference Album </a> </span></td>
               <td class="searchBar" valign=top align="right">
                  <form method="post" action="searchConf.php">
                    <label> Search Conference Album</label>
                    <input type="text" name="searchword" size="15" maxlength="40" value="<?php echo $_POST['searchword']?>" />
                    <input type="submit" value="go" />
                  </form>
                </td>
             </tr>
          </tbody>
        </table>
      </td>
    </tr>
    
    
    <tr class="mainPageContent">
      <td>
       <table border="0" cellpadding="0" cellspacing="0" width="500px">
         <tbody>
            <tr align="center" valign="top">
           
    		<td class="centerContent">
 			 <div id=photos>

             <div>	<p> <span class=goback><a href=index.php>Return to Conference Photos</a></span> </p></div>
		
	
<?


function uploader($num_of_uploads=3, $file_types_array=array("jpg", "gif", "png", "bmp"), $max_file_size=1048576, $upload_dir="../images/stories/conf_albumJune05/"){
  if(!is_numeric($max_file_size)){
   $max_file_size = 1048576;
  }
  
  if(!isset($_POST["submitted"])){
   $form = "<form action='".$PHP_SELF."' method='post' enctype='multipart/form-data'>Upload files:<br />
   <input type='hidden' name='submitted' value='TRUE' id='".time()."'><input type='hidden' name='MAX_FILE_SIZE' value='".$max_file_size."'>";


      $form .= "<br /><table><tr><td><div><strong>Name:  &nbsp;&nbsp;*</strong><input type='text' name='name' size='30' maxlength='40' value='' />
      <br /><br /><strong>Email:  &nbsp;&nbsp;*</strong><input type='text' name='email' size='30' maxlength='70' value=''/>
   <br /></div></td><td><div id=help><p><strong>Need help?</strong><br />If you experience problems adding your photos
			or if you need to make changes after they are published, please email 
			<a href='mailto:shardin@umich.edu'>Susan Hardin</a></p></div></td></tr><tr><td><div><br /><strong>URL for my other conference photos:</strong><br />
   http:// <input type='text' name='url' size='30' maxlength='250' value='' /></div></td></tr></table>";
    $form .= "<br /><table class=theading><tr><td align=center>Meeting/Event</td>
    <td align=center>Who is in photo?</td>
    <td align=center>Other Details</td><td align=center>Select Image to Upload</td></tr>";


 for($x=0;$x<$num_of_uploads;$x++){
  $form.="<tr>
  <td valign=top><div><input type='text' name='event[]' size='20' maxLength='70' id='event'></textarea></div></td>
     <td valign=top><div><input type='text' name='who[]' size='20' maxLength='60'></div></td>
     <td valign=top><div><textarea name='other[]' cols='20' rows='2' maxLength='150'></textarea></div></td>
     <td valign=top><div><input type='file' name='file[]'></div></td></tr>";
     }
   $form .= "<table><table><tr><td colspan=3><div><input type='submit' value='Upload'><br />
  
   <br />Valid file type(s): ";
   
   for($x=0;$x<count($file_types_array);$x++){
     if($x<count($file_types_array)-1){
       $form .= $file_types_array[$x].", ";
     }else{
       $form .= $file_types_array[$x].".";
     }
   }
   $form .= "</div></td></tr></table></form>";
   echo($form);
  }else{
  
    if (!$_POST['name'])
         $errors .= "<li> Name<br></li>";
		 
		 
      if (!$_POST['email'])
         $errors .= "<li> Email<br></li>";
		 
   // if (!checkdate($_POST['month'], $_POST['day'], $_POST['year']))

   //   $errors .= "<li> Invalid Date<br></li>";
         
  
 
 // if there are any errors, display them
      if ($errors)  {
		die("<div id=box style=height:300px;><div class=errors><p><strong>Upload Incomplete</strong></p>
		  			<p>Please use your browser's Back button to provide the following information: <br /></p>

			<blockquote><ul> $errors
		  </ul></blockquote><br><br></div></div>");
		  }
		  
		  include ('check_email.php');

   foreach($_FILES["file"]["error"] as $key => $errors){
   
    if($_FILES["file"]["name"][$key]!=""){
       if($value==UPLOAD_ERR_OK){
         $origfilename = $_FILES["file"]["name"][$key];
         $filename = explode(".", $_FILES["file"]["name"][$key]);
         $filenameext = $filename[count($filename)-1];
         unset($filename[count($filename)-1]);
         $filename = implode(".", $filename);
         $filename = substr($filename, 0, 15).".".$filenameext;
         $file_ext_allow = FALSE;
         for($x=0;$x<count($file_types_array);$x++){
           if($filenameext==$file_types_array[$x]){
             $file_ext_allow = TRUE;
           }
         }
         if($file_ext_allow){
           if($_FILES["file"]["size"][$key]<$max_file_size){
           
           
           
           
           $time=time(0);
           $filename=$time.'-'.$filename;
           
             if(move_uploaded_file($_FILES["file"]["tmp_name"][$key], $upload_dir.$filename)){
               echo("File uploaded successfully. - <a href='".$filename."' target='_blank'>".$filename."</a><br />");
               
               
           $dbFile=$upload_dir.$filename;

   require "facebook_db.php";

$password='pass';

$date=$_POST['year'] .'-' . $_POST['month'].'-' . $_POST['day'];

$url=$_POST['url'].'http://';


$register="INSERT INTO conference_album values ('',
		'$_POST[name]', 
		'$_POST[email]',
		'{$_POST[event][$key]}',
		'2005-10-01',
		'{$_POST[who][$key]}',
		'$dbFile',
		'{$_POST[other][$key]}',
		'$url',
		'$password'
		)";
		
		$result = mysql_query($register) or die(mysql_error("
		<p>There was a problem with the submission form submission.
		Please try to submit the entry again. 
		 If you continue to have problems, please report the problem to the 
		 <a href=\"mailto:shardin@umich.edu\">sakaiproject.org webmaster</a>."));    
               
               
               
               
               
               
               
               
               
               
               
             }else{
               echo($origfilename." was not successfully uploaded<br />");
             }
           }else{
             echo($origfilename." was too big, not uploaded<br />");
           }
         }else{
           echo($origfilename." had an invalid file extension, not uploaded<br />");
         }
       }else{
         echo($origfilename." was not successfully uploaded<br />");
       }
     }
     
     
   }
  }
}

uploader();
?>
         </div>
        </td> 
       </tr>
      </tbody>
     </table>
    </td>
   </tr>
      
   <tr>
    <td>
     <table>
      <tbody>
       <tr>
          <td colspan=2 height=200px></td>
       </tr>

	    <tr class="creditsHere">
           <td align="center" valign="top">
              <div><p><span class="small">Contact 
              <a href="mailto:sakaiproject_webmaster@umich.edu">--Webmaster</a></span><br></p> 
              </div>
           </td>
        </tr>
       </tbody>
      </table>
     
    </td>
  </tr>
  </tbody>
</table>
</body>
</html>