<?
// header("Content-Type: application/vnd.google-earth.kml+xml");
$file="data.xml";
$drC=fopen($file,"r");
$log=fopen("doc.log","w");
$drData=fread($drC,filesize($file));
//parse the xml data
$xml_parser = xml_parser_create();
// use case-folding so we are sure to find the tag in $map_array
xml_parser_set_option($xml_parser, XML_OPTION_CASE_FOLDING, true);
xml_parse_into_struct($xml_parser,$drData,$vals,$index);
// $fh =fopen("doc.kml","w");
$fh =fopen("php://stdout","w");
$xmlpre="<?xml version=\"1.0\" encoding=\"UTF-8\"?>
<kml xmlns=\"http://www.google.com/earth/kml/2\">
<Document>
  <name>sakaiearth.kmz</name>
  <Style id=\"khStyle662\">
    <LineStyle id=\"khLineStyle665\">
    </LineStyle>
    <PolyStyle id=\"khPolyStyle664\">
    </PolyStyle>
    <IconStyle id=\"khIconStyle666\">
      <icon>
        <href>root://icons/palette-3.png</href>
        <x>192</x>
        <w>32</w>
        <h>32</h>
      </icon>
    </IconStyle>
    <LabelStyle id=\"khLabelStyle668\">
    </LabelStyle>
  </Style>";
print $xmlpre;
 $folders=array("Sakai");
//build a list of types
foreach($vals as $key=>$value) {
  if ($value['tag']=="MARKER") {
    if (strlen($value['attributes']['STATUS'])) {
	  //fwrite($log, $value['attributes']['STATUS']."\n");
      $folder=strtolower($value['attributes']['STATUS']);
	  if (!in_array($folder,$folders)) {
	    $folders[] =  $folder;
	    fwrite($log, "found new folder: ". $folder."\n");
	  }
	  $folders[$folder][]=$value;
	} else {
      fwrite($log, "putting ".$value['attributes']['TEXT']."in general folder \n");
	  $folders['Sakai'][]=$value;
	}
  }
}
//do this for each one
foreach($folders as $key1=>$value1) {
  // fwrite($log, "got a folder".$value1[0]['TEXT']."\n");
  //print_r($value);
  
  if (is_array($value1)) {
//open the new folder
  print "<Folder>\n";
  print "<name>".$key1."</name>";
  foreach($value1 as $key=>$value) {
    fwrite($log, "this is ".$value['attributes']['TEXT']."\n");
 
$place="<Placemark>
    <description>".$value['attributes']['TEXT']." - ".$value['attributes']['STATUS']."</description>
    <name>".$value['attributes']['TITLE']."</name>
    <LookAt>
      <longitude>".$value['attributes']['LNG']."</longitude>
      <latitude>".$value['attributes']['LAT']."</latitude>
      <range>3000.00</range>
      <tilt>0</tilt>
      <heading>0</heading>
    </LookAt>
    <styleUrl>#khStyle662</styleUrl>
    <Point>
      <coordinates>".$value['attributes']['LNG'].",".$value['attributes']['LAT']."</coordinates>
    </Point>
  </Placemark>";
 print $place;
  }
  //close the folder
  print "</Folder>\n";
      }
}
$xmlpost="</Document>
</kml>";
  print $xmlpost;
fclose($fh);
//fclose($drData);
?> 
