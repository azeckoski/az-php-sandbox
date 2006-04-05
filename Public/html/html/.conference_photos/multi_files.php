<?
function uploader($num_of_uploads=5, $file_types_array=array("jpg"), $max_file_size=1048576, $upload_dir=""){
  if(!is_numeric($max_file_size)){
   $max_file_size = 1048576;
  }
  if(!isset($_POST["submitted"])){
   $form = "<form action='".$PHP_SELF."' method='post' enctype='multipart/form-data'>Upload files:<br /><input type='hidden' name='submitted' value='TRUE' id='".time()."'><input type='hidden' name='MAX_FILE_SIZE' value='".$max_file_size."'>
   <table><tr class='small'><td align=center>Meeting/Event Name</td><td align=center>Who is in Photo?</td><td align=center>Other Details</td><td align=center>Select Image File to Upload</td></tr> ";
   for($x=0;$x<$num_of_uploads;$x++){

     $form .= "<table><tr>
     <td valign=top><input type='text' name='event' size='20' maxLength='70' id='event'></textarea></div></td>
     <td valign=top><div><input type='text' name='who' size='20' maxLength='60'></div></td>
     <td valign=top><div><textarea name=other' cols='20' rows='2' maxLength='150'></textarea></div></td>
     <td valign=top><div><input type='file' name='file[]'></div></td></tr></table>";
   }
   
   $form .= "<br /><table><tr><td><div>*Your Name:  &nbsp;&nbsp;<input type='text' name='name' size='30' maxlength='40' value='' /><br />
   *  email:<input type='text' name='email' size='30' maxlength='70' value=''/>
   <br />URL for additional Conference Photos:<br /><strong>http://</strong> <input type='text' name='url' size='50' maxlength='250' value='' /></div></td>
   <td width=30%><div class='small'><font color='red'>*</font><strong>Max. image size</strong>: $max_file_size.<br />
  <strong>Valid file types</strong>:<br />(";
     for($x=0;$x<count($file_types_array);$x++){
     if($x<count($file_types_array)-1){
       $form .= $file_types_array[$x].", ";
     }else{
       $form .= $file_types_array[$x].".";
     }
   }


  $form .=")</div></td></tr><tr><td><input type='submit' value='Upload'><br /></td></tr></table>";
     
  $form .= "</form>";
   echo($form);
   
   }else{
   foreach($_FILES["file"]["error"] as $key => $value){
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
             if(move_uploaded_file($_FILES["file"]["tmp_name"][$key], $upload_dir.$filename)){
               echo("File uploaded successfully. - <a href='".$upload_dir.$filename."' target='_blank'>".$filename."</a><br />");
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