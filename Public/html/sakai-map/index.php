<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
  <?php
        $file=$_REQUEST[file];
	if ( ! $file ) {
		// $file = "data.php";
		$file = "data.xml";
	}

	$lat=$_REQUEST[lat];
	$lng=$_REQUEST[lng];
	$stat=$_REQUEST[status];
	$txt=$_REQUEST[text];
	$title=$_REQUEST[title];
	$color=$_REQUEST[color];
	$country=$_REQUEST[country];

	$filtercolor=$_REQUEST[filtercolor];

	// Demand all parameters
	if ( ! $lat || ! $lng || ! $stat || ! $txt || ! $title || ! $color || ! $country) {
	 	$lat = null;
	}

	$domtext = null;

	if ( $lat != null ) {
	  $domtext = "<markers>\n<marker lat=\"".$lat."\" lng=\"".$lng."\"\n"
	    . " status=\"".$stat."\"\n" 
	    . "  text=\"".$txt."\" title=\"".$title."\"\n"
	    . " color=\"".$color."\" country=\"".$country."\"  />\n"
	    . "</markers>\n";
	 }
?>

    <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
    <title>Sakai World</title>
    <script src="http://maps.google.com/maps?file=api&amp;v=2&amp;key=ABQIAAAAt2FEkOMaprvGohcmOYlhphT8pzdJ7dqRnCk1Ozev5zYCLwJOXBQDNhuil2W5jNTPuntOUPZ7GZaxtg"
      type="text/javascript"></script>
    <script type="text/javascript">
    //<![CDATA[
   var filtercolor = null;

    function load() {

    <?
    if ( $filtercolor ) {
    	echo("filtercolor = '".$filtercolor."';\n");
    }
    ?>
      if (GBrowserIsCompatible()) {
        var map = new GMap2(document.getElementById("map"));
	GEvent.addListener(map, 'click', function(overlay, point) {
	if (overlay) {
   		// map.removeOverlay(overlay);
  	} else if (point) {
  		var latLngStr = '(' + point.y + ', ' + point.x + ')';
  		document.getElementById("message2").innerHTML = latLngStr;
 	}
											});
	map.addControl(new GLargeMapControl());
	map.addControl(new GMapTypeControl());
        map.setCenter(new GLatLng(23.563987128451217, 10.8984375), 2);

String.prototype.wordWrap = function(m, delim, linebreak){
	var i, j, s, r = this.split(delim);
	var retval = "";
	var line = "";
	// alert(r);
	if(m > 0) for(i in r){
	        if ( line.length > m ) {
			if ( retval.length > 0 ) {
				retval = retval + linebreak;
			}
			retval = retval + line;
			line = "";
		}
		if ( line.length > 0 ) {
			line = line + delim;
		}
	        line = line + r[i];
	}
	if ( line.length > 0 ) {
		retval = retval + delim + line;
	}
	return retval;
}

function createMarker(point, element) {

  var color = element.getAttribute("color");
  if ( ! color ) { 
  	color="white";
  }

  var icon = new GIcon();
  icon.image = "http://labs.google.com/ridefinder/images/mm_20_"+color+".png";
  icon.shadow = "http://labs.google.com/ridefinder/images/mm_20_shadow.png";
  icon.iconSize = new GSize(12, 20);
  icon.shadowSize = new GSize(22, 20);
  icon.iconAnchor = new GPoint(6, 20);
  icon.infoWindowAnchor = new GPoint(5, 1);

  var output = "";

  if ( element.getAttribute("text") ) {
  	output = output +element.getAttribute("text").wordWrap(20, " ", "<br>", false)+"<br>";
  }

  if ( element.getAttribute("status") ) {
  	output = output + "Status: " + element.getAttribute("status").wordWrap(20, " ", "<br>", false)+"<br>";
  }

  if ( element.getAttribute("title") ) {
  	output = output + "<a href="+element.getAttribute("title")+" target=_new>"+element.getAttribute("title")+"</a><br>";
  }

  if ( element.getAttribute("country") ) {
  	output = output + "<img src=\"flags/"+element.getAttribute("country").toLowerCase()+".gif\"> ";
  }

  var marker = new GMarker(point,icon);
  GEvent.addListener(marker, "click", function() {
    map.setCenter(marker.getPoint());
    marker.openInfoWindowHtml(output);
  });

  return marker;
}


GDownloadUrl("<? echo($file); ?>", function(data, responseCode) {

  var xml = GXml.parse(
<?
  if ( $domtext != null ) {
  	echo("'".str_replace("\n"," ",$domtext)."'");
  } else {
  	echo("data");
  }
?>
);

  var markers = xml.documentElement.getElementsByTagName("marker");
  for (var i = 0; i < markers.length; i++) {
    
    var color = markers[i].getAttribute("color");
    if ( filtercolor && color ) {
      // if ( i < 5 ) alert("fc, c = "+filtercolor+":"+color);
      if ( filtercolor.toLowerCase() != color.toLowerCase() && color.toLowerCase() != "white" ) continue;
    }

    var point = new GLatLng(parseFloat(markers[i].getAttribute("lat")),
                            parseFloat(markers[i].getAttribute("lng")));

    map.addOverlay(createMarker(point,markers[i]));
  }
});

      }
    }

    //]]>
    </script>
  </head>
	  <body onload="load()" onunload="GUnload()">
	      <?
	      if ( $domtext != null ) {
	      	echo ("<pre>\n");
		echo("Testing this Text\n");
	    	echo(str_replace("<","&lt;",$domtext));
		echo ("</pre>\n");
		echo ("<hr>\n");
	      }
	      ?>
	    <center>
	    <a href=index.php> Show All </a> |
	    <img src="http://labs.google.com/ridefinder/images/mm_20_blue.png"> 
	    <a href=index.php?filtercolor=blue> Production </a> |
	    <img src="http://labs.google.com/ridefinder/images/mm_20_purple.png"> 
	    <a href=index.php?filtercolor=purple> Pilots </a> |
	    <img src="http://labs.google.com/ridefinder/images/mm_20_green.png"> 
	    <a href=index.php?filtercolor=green> Partners: Academic </a> |
	    <img src="http://labs.google.com/ridefinder/images/mm_20_orange.png"> 
	    <a href=index.php?filtercolor=orange> Partners: Commercial Affiliates </a> |
	    <img src="http://labs.google.com/ridefinder/images/mm_20_red.png"> 
	    <a href=index.php?filtercolor=red> Community Servers </a>
	    <!--
	    | <img src="http://labs.google.com/ridefinder/images/mm_20_yellow.png"> 
	    <a href=index.php?filtercolor=yellow> Sakai Servers </a> 
	    -->
	    <br>
	    <br>
	    <div id="map" style="width: 1000px; height: 600px"></div>
	    <hr>
	    </center>
	    <b>Updating the map</b>
	    <br><br>
	    To add entries to the map, construct an XML element that includes the following attributes and values:<br>
	    
	    <ul>
	     <li>lat (latitude)</li>
	     <li>lng (longitude)</li>
	     <li>title (site URL)</li>
	     <li>country (country code)</li>
	     <li>text (organization name)</li>
	     <li>color (icon: blue=production, purple=pilot, green=partner, orange=commercial affiliate, red=community server)</li>
	    </ul>
	    
	    The chunk of XML should resemble the following:    
		<pre>
		&lt;marker lat="41.19221885042551" lng="-111.94313049316406" title="http://sakai.weber.edu" country="us" status="production" text="Weber State University" color="blue" />
		</pre>
		You can test a single entry by putting the values on the commmand line as follows:
		<pre>
		http://www.sakaiproject.org/sakai-map/index.php?color=green&amp;lat=41.192&amp;lng=-111.943&amp;status=pilot&amp;text=Weber%20State&amp;title=http://www.weber.edu&amp;country=us
		</pre>
		An organization may submit more than one entry.  Indeed, some Sakai organizations have multiple entries indicating, for instance, their partner status, their pilot/production status and their hosting of a community server.
		Once you are satisfied with your XML send your entry/entries to <a href="mailto:arwhyte@sakaifoundation.org">Anthony Whyte</a>, Sakai Community Liaison.  
		
		<!--  Remove Chuck's analytics
		<script src="http://www.google-analytics.com/urchin.js" type="text/javascript">
		</script>
		<script type="text/javascript">
		_uacct = "UA-423997-1";
		urchinTracker();
		</script>
		-->
  </body>
</html>
