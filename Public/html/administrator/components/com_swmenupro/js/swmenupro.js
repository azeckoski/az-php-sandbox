/**
* swmenupro v1.5
* http://swonline.biz
* Copyright 2004 Sean White
* DHTML Menu Component for Mambo Open Source
* Mambo Open Source is Free Software
* Released under GNU/GPL License: http://www.gnu.org/copyleft/gpl.html
**/

function getOffsets (evt) {
  var target = evt.target;
  if (typeof target.offsetLeft == 'undefined') {
    target = target.parentNode;
  }
  var pageCoords = getPageCoords(target);
  var eventCoords = {
    x: window.pageXOffset + evt.clientX,
    y: window.pageYOffset + evt.clientY
  };
  var offsets = {
    offsetX: eventCoords.x - pageCoords.x,
    offsetY: eventCoords.y - pageCoords.y
  }
  return offsets;
}

function getPageCoords (element) {
  var coords = {x : 0, y : 0};
  while (element) {
    coords.x += element.offsetLeft;
    coords.y += element.offsetTop;
    element = element.offsetParent;
  }
  return coords;
}


var pcol="#a0a0a0";
var qtr=new Array();
var rd=new Array();
rd[0]=new Array(0,1,0);
rd[1]=new Array(-1,0,0);
rd[2]=new Array(0,0,1);
rd[3]=new Array(0,-1,0);
rd[4]=new Array(1,0,0);
rd[5]=new Array(0,0,-1);
rd[6]=new Array(255,1,1);


function reLod(){
  qtr[0]=-180;
  qtr[1]=360;
  qtr[2]=180;
  qtr[3]=0;
}


//populate color radians
var col=new Array(360);
for (i=0;i< 6;i++){
   for (j=0;j<60;j++){
      col[60*i+j]=new Array(3);
      for (k=0;k<3;k++){
        col[60*i+j][k]=rd[6][k];
        rd[6][k]+=(rd[i][k]*4);
      }
   }
}


function xyOff(evt) {
  if (typeof evt.offsetX == 'undefined') {
    var evtOffsets = getOffsets(evt);
    ox = evtOffsets.offsetX;
    oy = evtOffsets.offsetY;
  } else {
    ox = evt.offsetX;
    oy = evt.offsetY;
  }
  ox = 4*ox;
  oy = 4*oy;
  reLod();
  nr=0;
  oxm=ox-512;
  oym=oy-512;
  oxflg=(oxm<0?0:1);
  oyflg=(oym<0?0:1);
  qsel=2*oxflg+oyflg;
  absx=Math.abs(oxm);
  absy=Math.abs(oym);
  deg=absx*45/absy;
  if (absx>absy) {
     deg=90-(absy*45/absx);
  }
  deg1=Math.floor(Math.abs(qtr[qsel]-deg));
  oxm=Math.abs(ox-512);
  oym=Math.abs(oy-512);
  rd1=Math.sqrt(Math.pow(oym,2)+Math.pow(oxm,2));
  if (oy==512&&ox==512) {
     pcol='000000';
  } else {
     for (i=0;i<3;i++){
         rd2=col[deg1][i]*rd1/256;
         if (rd1>256){
            rd2+=Math.floor(rd1-256);
         }
         if (rd2>255){
            rd2=255;
         }
         nr=256*nr+Math.floor(rd2);
     }
     pcol=nr.toString(16);
     while (pcol.length<6) {
        pcol='0'+pcol;
     }
  }
  pcol='#'+pcol.toUpperCase();

  if (document.getElementById){
     document.getElementById('CPCP_ColorCurrent').style.backgroundColor=pcol;
     document.getElementById('CPCP_ColorSelected').innerHTML=pcol;
  }
  if (document.layers) {
     document.layers['CPCP_Wheel'].document.forms[0].elements[0].value=pcol;
     document.layers['CPCP_ColorSelected'].bgColor=pcol;
  }
  return false;
}


function wrtVal(){
  if (document.getElementById) {
     document.getElementById('CPCP_Input').style.background = pcol;
     document.getElementById('CPCP_Input_RGB').value = pcol;
     document.getElementById('CPCP_Input_RGB').select();
  }
  if (document.layers) {
     document.layers['CPCP_Input'].bgColor=pcol;
     document.layers['CPCP_Input_RGB'].value=pcol;
     document.layers['CPCP_Input_RGB'].select();
  }
}

function checkNumberSyntax(temp_name,temp_box,temp_minimum,temp_maximum,temp_default){
var temp_x = document.getElementById(temp_box);
var temp_message;
  if(!IsNumeric(temp_x.value)||(temp_x.value=="")||(temp_x.value > temp_maximum)||(temp_x.value < temp_minimum)){

alert("You need to input a valid number for "+temp_name+" between "+temp_minimum+" and "+temp_maximum);
  temp_x.value = temp_default;
  }
}


function IsNumeric(sText)
{
   var ValidChars = "0123456789-";
   var IsNumber=true;
   var Char;

 
   for (i = 0; i < sText.length && IsNumber == true; i++) 
      { 
      Char = sText.charAt(i); 
      if (ValidChars.indexOf(Char) == -1) 
         {
         IsNumber = false;
         }
      }
   return IsNumber;
   }



function trim(value) {
   var temp = value;
   var obj = /^(\s*)([\W\w]*)(\b\s*$)/;
   if (obj.test(temp)) { temp = temp.replace(obj, '$2'); }
   var obj = / /g;
   while (temp.match(obj)) { temp = temp.replace(obj, ""); }
   return temp;
}




function doMainPadding(){
var padtop = trim(document.getElementById('main_pad_top').value);
var padright = trim(document.getElementById('main_pad_right').value);
var padbottom = trim(document.getElementById('main_pad_bottom').value);
var padleft = trim(document.getElementById('main_pad_left').value);

document.getElementById('main_padding').value = padtop+'px '+padright+'px '+padbottom+'px '+padleft+'px ';
}

function doSubPadding(){

var padtop = trim(document.getElementById('sub_pad_top').value);
var padright = trim(document.getElementById('sub_pad_right').value);
var padbottom = trim(document.getElementById('sub_pad_bottom').value);
var padleft = trim(document.getElementById('sub_pad_left').value);

document.getElementById('sub_padding').value = padtop+'px '+padright+'px '+padbottom+'px '+padleft+'px ';
}


function doMainBorder(){
var mainwidth = trim(document.getElementById('main_border_width').value);
var mainstyle = trim(document.getElementById('main_border_style').value);
var maincolor = trim(document.getElementById('main_border_color').value);

document.getElementById('main_border').value = mainwidth+'px '+mainstyle+' '+maincolor;

var mainwidth = trim(document.getElementById('main_border_over_width').value);
var mainstyle = trim(document.getElementById('main_border_over_style').value);
var maincolor = trim(document.getElementById('main_border_color_over').value);

document.getElementById('main_border_over').value = mainwidth+'px '+mainstyle+' '+maincolor;
}

function doSubBorder(){
var mainwidth = trim(document.getElementById('sub_border_width').value);
var mainstyle = trim(document.getElementById('sub_border_style').value);
var maincolor = trim(document.getElementById('sub_border_color').value);

document.getElementById('sub_border').value = mainwidth+'px '+mainstyle+' '+maincolor;

var mainwidth = trim(document.getElementById('sub_border_over_width').value);
var mainstyle = trim(document.getElementById('sub_border_over_style').value);
var maincolor = trim(document.getElementById('sub_border_color_over').value);

document.getElementById('sub_border_over').value = mainwidth+'px '+mainstyle+' '+maincolor;
}


function checkColorSyntax(temp_name,temp_box,temp_default){
temp_x = document.getElementById(temp_box);
var validChar = '0123456789ABCDEF';
var temp_message;
var temp_error = 0; 

var re = new RegExp (' ', 'gi') ;


 temp_x.value = temp_x.value.replace(re, '') ;
 document.getElementById(temp_box + '_box').bgColor = temp_x.value;
 
}


function swapValue(temp_name, i){

var temp_x ;
var temp_y ;

  if (document.getElementById) {
     temp_x = document.getElementById(temp_name).value;
     if (temp_x == 1){
		document.getElementById(temp_name).value = 0;
		document.getElementById(temp_name+'image').src = 'images/publish_x.png';
		
  }else{
	  document.getElementById(temp_name).value = 1;
	  document.getElementById(temp_name+'image').src = 'images/tick.png';
	
  }
 
  doPreview(i)
	
  }
}



function copyColor(temp_box){
var temp_x ;

  if (document.getElementById) {
     temp_x = document.getElementById('CPCP_Input_RGB').value;
     document.getElementById(temp_box).value = temp_x;
	 document.getElementById(temp_box + '_box').bgColor = temp_x;
	
  }
}

function copyBackImage(temp_box){
var temp_x ;

  if (document.getElementById) {
	 temp_x = document.getElementById(temp_box).value;
	 document.getElementById(temp_box + '_box').background = temp_x;
	  
  }
}


function doPreviewWindow() {

var content = "?main_width=" + trim(document.adminForm.main_width.value);


if (document.adminForm.menustyle.value !="clickmenu")
{
	content+= "&level2_sub_left=" +  trim(document.adminForm.level2_sub_left.value);
	content+= "&level1_sub_left=" +  trim(document.adminForm.level1_sub_left.value);
}


content+= "&sub_padding=" +  document.adminForm.sub_padding.value;
content+= "&main_padding=" +  document.adminForm.main_padding.value;

content+= "&main_border_color=" + trim(document.adminForm.main_border_color.value);
content+= "&main_border_width=" + trim(document.adminForm.main_border_width.value);
content+= "&main_border_style=" + trim(document.adminForm.main_border_style.value);

content+= "&main_back=" +  trim(document.adminForm.main_back.value);
content+= "&main_over=" +  trim(document.adminForm.main_over.value);

content+= "&main_back_image=" +  trim(document.adminForm.main_back_image.value);
content+= "&main_back_image_over=" +  trim(document.adminForm.main_back_image_over.value);
content+= "&sub_back_image=" +  trim(document.adminForm.sub_back_image.value);
content+= "&sub_back_image_over=" +  trim(document.adminForm.sub_back_image_over.value);

content+= "&main_font_color=" +  trim(document.adminForm.main_font_color.value);
content+= "&main_font_color_over=" +  trim(document.adminForm.main_font_color_over.value);
content+= "&main_font_size=" +  trim(document.adminForm.main_font_size.value);

content+= "&sub_align=" +  trim(document.adminForm.sub_align.value);
content+= "&main_align=" +  trim(document.adminForm.main_align.value);

content+= "&font_family=" + trim(document.adminForm.font_family.value);
content+= "&font_weight=" +  trim(document.adminForm.font_weight.value);
content+= "&font_weight_over=" +  trim(document.adminForm.font_weight_over.value);


content+= "&menustyle=" +  document.adminForm.menustyle.value;	

if(document.adminForm.menustyle.value !="treemenu"){

content+= "&main_height=" + trim(document.adminForm.main_height.value);
content+= "&sub_width=" +  trim(document.adminForm.sub_width.value);

content+= "&sub_back=" +  trim(document.adminForm.sub_back.value);
content+= "&sub_over=" +  trim(document.adminForm.sub_over.value);

content+= "&sub_border_color=" + trim(document.adminForm.sub_border_color.value);
content+= "&sub_border_width=" + trim(document.adminForm.sub_border_width.value);
content+= "&sub_border_style=" + trim(document.adminForm.sub_border_style.value);







content+= "&sub_border_color_over=" + trim(document.adminForm.sub_border_color_over.value);
content+= "&sub_border_over_width=" + trim(document.adminForm.sub_border_over_width.value);
content+= "&sub_border_over_style=" + trim(document.adminForm.sub_border_over_style.value);

content+= "&main_border_color_over=" + trim(document.adminForm.main_border_color_over.value);
content+= "&main_border_over_width=" + trim(document.adminForm.main_border_over_width.value);
content+= "&main_border_over_style=" + trim(document.adminForm.main_border_over_style.value);


content+= "&sub_font_color=" +  trim(document.adminForm.sub_font_color.value);
content+= "&sub_font_size=" +  trim(document.adminForm.sub_font_size.value);






content+= "&sub_height=" +  trim(document.adminForm.sub_height.value);
content+= "&sub_font_color_over=" +  trim(document.adminForm.sub_font_color_over.value);



content+= "&sub_font_family=" +  trim(document.adminForm.sub_font_family.value);



if (document.adminForm.menustyle.value !="clickmenu")
{
content+= "&position=" +  trim(document.adminForm.position.value);
content+= "&orientation=" +  trim(document.adminForm.orientation.value);
content+= "&level2_sub_top=" +  trim(document.adminForm.level2_sub_top.value);
content+= "&specialB=" +  trim(document.adminForm.specialB.value);
content+= "&level1_sub_top=" +  trim(document.adminForm.level1_sub_top.value);
}

content+= "&specialA=" +  trim(document.adminForm.specialA.value);

}


content = replaceSubstring(content, '#', '');
//content = replaceSubstring(content, '/', '');

window.open('components/com_swmenupro/preview.php' + content , 'win1', 'status=no,toolbar=no,scrollbars=auto,titlebar=no,menubar=no,resizable=yes,width=600,height=500,directories=no,location=no');
}

function replaceSubstring(inputString, fromString, toString) {
   // Goes through the inputString and replaces every occurrence of fromString with toString
   var temp = inputString;
   if (fromString == "") {
      return inputString;
   }
   if (toString.indexOf(fromString) == -1) { // If the string being replaced is not a part of the replacement string (normal situation)
      while (temp.indexOf(fromString) != -1) {
         var toTheLeft = temp.substring(0, temp.indexOf(fromString));
         var toTheRight = temp.substring(temp.indexOf(fromString)+fromString.length, temp.length);
         temp = toTheLeft + toString + toTheRight;
      }
   } else { // String being replaced is part of replacement string (like "+" being replaced with "++") - prevent an infinite loop
      var midStrings = new Array("~", "`", "_", "^", "#");
      var midStringLen = 1;
      var midString = "";
      // Find a string that doesn't exist in the inputString to be used
      // as an "inbetween" string
      while (midString == "") {
         for (var i=0; i < midStrings.length; i++) {
            var tempMidString = "";
            for (var j=0; j < midStringLen; j++) { tempMidString += midStrings[i]; }
            if (fromString.indexOf(tempMidString) == -1) {
               midString = tempMidString;
               i = midStrings.length + 1;
            }
         }
      } // Keep on going until we build an "inbetween" string that doesn't exist
      // Now go through and do two replaces - first, replace the "fromString" with the "inbetween" string
      while (temp.indexOf(fromString) != -1) {
         var toTheLeft = temp.substring(0, temp.indexOf(fromString));
         var toTheRight = temp.substring(temp.indexOf(fromString)+fromString.length, temp.length);
         temp = toTheLeft + midString + toTheRight;
      }
      // Next, replace the "inbetween" string with the "toString"
      while (temp.indexOf(midString) != -1) {
         var toTheLeft = temp.substring(0, temp.indexOf(midString));
         var toTheRight = temp.substring(temp.indexOf(midString)+midString.length, temp.length);
         temp = toTheLeft + toString + toTheRight;
      }
   } // Ends the check to see if the string being replaced is part of the replacement string or not
   return temp; // Send the updated string back to the user
} // Ends the "replaceSubstring" function




var manager = new ImageManager('components/com_swmenupro/ImageManager','en');
		
		ImageSelector = 
		{
			
			update : function(params)
			{
				if(this.field && this.field.src != null)
				{
					if((params.f_file) && (params.f_file.substring(params.f_file.length-12, params.f_file.length)!='no_image.gif')){
					this.field.src = "../modules/mod_swmenupro/images" + params.f_file; //params.f_url
					//document.getElementById('imagepreview'+this.field.name.substring(10,11)).width = params.f_width ;
					//document.getElementById('imagepreview'+this.field.name.substring(10,11)).height = params.f_height;
					this.field2.value = "modules/mod_swmenupro/images" + params.f_file; //params.f_url
					}else{
					this.field.src = "components/com_swmenupro/images/blank.png"; //params.f_url
					this.field2.value = "";
					}
					doPreview(this.field.name.substring(10,11));
					
				}
			},
			
			select: function(textfieldID)
			{
				this.field = document.getElementById(textfieldID);
				this.field2 = document.getElementById(textfieldID+"hidden");
				manager.popManager(this);	
			}
		};	

		PreviewImageSelector = 
		{
			
			update : function(params)
			{
				if(this.field && this.field.src != null)
				{
					if(params.f_file){
					this.field.src = "../modules/mod_swmenupro/images" + params.f_file; //params.f_url
					this.field2.value = "modules/mod_swmenupro/images" + params.f_file; //params.f_url
					}else{
					this.field.src = "../modules/mod_swmenupro/images/no_image.gif"; //params.f_url
					this.field2.value = "";
					}
					
				}
			},
			
			select: function(textfieldID)
			{
				this.field = document.getElementById(textfieldID);
				this.field2 = document.getElementById(textfieldID+"hidden");
				manager.popManager(this);	
			}
		};	

		BackgroundSelector = 
		{
			
			update : function(params)
			{
				if(this.field )
				{
					
					this.field.background = "../modules/mod_swmenupro/images" + params.f_file; //params.f_url
					this.field2.value = "modules/mod_swmenupro/images" + params.f_file; //params.f_url

				}
			},
			
			select: function(textfieldID)
			{
				this.field = document.getElementById(textfieldID+'_box');
				this.field2 = document.getElementById(textfieldID);
				manager.popManager(this);	
			}
		};	
