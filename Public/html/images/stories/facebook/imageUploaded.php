<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN""http://www.w3.org/TR/html4/loose.dtd"><html><head><meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"><title>Untitled Document</title></head><body><form name="form1" method="post" action="" enctype="multipart/form-data"> <input type="file" name="imagefile"> <br> <input type="submit" name="Submit" value="Submit"> <?php if(isset( $Submit )) { //If the Submitbutton was pressed do: if ($_FILES['imagefile']['type'] == "image/gif"){          copy ($_FILES['imagefile']['tmp_name'], "files/".$_FILES['imagefile']['name'])      or die ("Could not copy");   echo "";          echo "Name: ".$_FILES['imagefile']['name']."";          echo "Size: ".$_FILES['imagefile']['size']."";          echo "Type: ".$_FILES['imagefile']['type']."";          echo "Copy Done....";          }  else {             echo "<br><br>";             echo "Could Not Copy, Wrong Filetype (".$_FILES['imagefile']['name'].")<br>";         } }  ?> </form>  </body></html></body></html>