<?php
//echo "start array<br />";

function echo_topics($value, $key) {




$topicID="topic_" .$key;
 echo" <div class=topic_row>  <div class=topic_type>$value</div><div class=topic_vote>
             <span> <input name=$topicID type=\"radio\" value=\"0\" ";
              if ($_POST[$topicID]=="0") { echo "checked"; } 
              echo">&nbsp;&nbsp;&nbsp;</span>
               <span> <input name=$topicID type=\"radio\" value=\"1\" ";
              if ($_POST[$topicID]=="1") { echo "checked"; } 
              echo">&nbsp;&nbsp;&nbsp;</span>
              <span><input name=$topicID type=\"radio\" value=\"2\"  ";
              if ($_POST[$topicID]=="2") { echo "checked"; } 
              echo">&nbsp;&nbsp;&nbsp;</span><span>
              <input name=$topicID type=\"radio\" value=\"3\"  ";
              if ($_POST[$topicID]=="3") { echo "checked"; } 
              echo">&nbsp;&nbsp;&nbsp;&nbsp;</span></div></div>  ";
}

$topic_area=array( 'Development', 
'Pedadgogy', 
	'Research Collaboration', 
	'Governance: Sakai Foundation', 
	'Teaching', 
	'Local Technical Support', 
	'Commercial Technical Support', 
	'Using Portfolios in the Classroom', 
	'Growing the Sakai Community', 
'Learning',
'Reflective Practice for Students and Faculty',
'Overview of Toolset (Melete, Samigo, OSP)',
'UI Development',
'Assessment of Student Learning',
'Assessment of Programs, Departments',
'Assessment of Institutions of Higher Education',
'For those New to Sakai',
'Faculty Development',
'Implementation: Pilot',
'Implementation: Production',
	'User Support', 
	'Instructional Design', 
	'Sakai Training for Faculty/Staff', 
	'Sakai Training for Students', 
	'Institutional Change', 
	'Licensing/Copyright', 
	'Visioning for the Future', 
	'QA' 
);


function echo_audience($value, $key) {




$audienceID="audience_" .$key;
 echo" <div class=topic_row>  <div class=topic_type>$value</div><div class=topic_vote>
           <span> <input name=$audienceID type=\"radio\" value=\"0\" ";
              if ($_POST[$audienceID]=="0") { echo "checked"; } 
              echo">&nbsp;&nbsp;&nbsp;</span>
               <span> <input name=$audienceID type=\"radio\" value=\"1\" ";
              if ($_POST[$audienceID]=="1") { echo "checked"; } 
              echo">&nbsp;&nbsp;&nbsp;</span>
              <span><input name=$audienceID type=\"radio\" value=\"2\"  ";
              if ($_POST[$audienceID]=="2") { echo "checked"; } 
              echo">&nbsp;&nbsp;&nbsp;</span><span>
              <input name=$audienceID type=\"radio\" value=\"3\"  ";
              if ($_POST[$audienceID]=="3") { echo "checked"; } 
              echo">&nbsp;&nbsp;&nbsp;&nbsp;</span></div></div>  ";
}

$audience=array(
'Developers',
'UI Developers',
'User Support',
'Faculty',
'Faculty Development',
'Librarian',
'Implementors',
'Instructional Designers',
'Managers',
'System Administrators',
'University Administration'
);

//echo "start functionDesc<br />";



//echo "start arraywalk<br />";


//echo "end arraywalk<br />";

?>