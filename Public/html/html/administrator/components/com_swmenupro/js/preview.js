function changePreviewColor(counter){
var temp_x ;

  if (document.getElementById) {
     temp_x = document.getElementById('CPCP_Input_RGB').value;
	for(i=0;i<counter;i++)
			{
			document.getElementById('preview_back'+i).bgColor = temp_x;
			}
}
}

function doPreview(i){

  if (document.getElementById) {

	  var temp_parent = document.getElementById('isparent'+i).value;

				if(temp_parent==0){
				doMainPreview(i);
				} else{
				doSubPreview(i);
				}
		
		}
  
}

function doImageChange(){
var temp_x= document.getElementById('autoattrib').value;

if(temp_x=="image1" || temp_x=="image2"){
		PreviewImageSelector.select('globalimage');
	}
}

function applyattrib(temp_attrib,i){

  if (document.getElementById) {
			var temp_globalimage=document.getElementById('globalimage').src;
				if(temp_attrib=='image1'){
					if (temp_globalimage.substring(temp_globalimage.length-12, temp_globalimage.length)!='no_image.gif')
					{
					document.getElementById('menuimage1'+i).src = temp_globalimage;
					document.getElementById('menuimage1'+i+'hidden').value = document.getElementById('globalimagehidden').value;
					}else{
					document.getElementById('menuimage1'+i).src = "components/com_swmenupro/images/blank.png";
					document.getElementById('menuimage1'+i+'hidden').value = "";
					}
				
				}else if (temp_attrib=='image2'){
				if (temp_globalimage.substring(temp_globalimage.length-12, temp_globalimage.length)!='no_image.gif')
					{
					document.getElementById('menuimage2'+i).src = temp_globalimage;
					document.getElementById('menuimage2'+i+'hidden').value = document.getElementById('globalimagehidden').value;
					}else{
					document.getElementById('menuimage2'+i).src = "components/com_swmenupro/images/blank.png";
					document.getElementById('menuimage2'+i+'hidden').value = "";
					}
				}else if (temp_attrib=='showname'){
				document.getElementById('showname'+i+'image').src = 'images/tick.png';
				document.getElementById('showname'+i).value = 1;
				}else if (temp_attrib=='dontshowname'){
				document.getElementById('showname'+i+'image').src = 'images/publish_x.png';
				document.getElementById('showname'+i).value = 0;
				}else if (temp_attrib=='imageleft'){
				document.getElementById('imagealign'+i).value = 'left';
				}else if (temp_attrib=='imageright'){
				document.getElementById('imagealign'+i).value = 'right';
				}else if (temp_attrib=='islink'){
				document.getElementById('targetlevel'+i+'image').src = 'images/tick.png';
				document.getElementById('targetlevel'+i).value = 1;
				}else if (temp_attrib=='isnotlink'){
				document.getElementById('targetlevel'+i+'image').src = 'images/publish_x.png';
				document.getElementById('targetlevel'+i).value = 0;
				}
				doPreview(i)
		}
  
}


function doMainPreviewOver(i){
 if (document.getElementById) {
  var temp_element = document.getElementById('mainpreview'+i);
  var temp_image = document.getElementById('imagepreview'+i);
  temp_image.src= document.getElementById('menuimage2'+i).src;
  

	//if((!temp_image.src) || ((temp_image.src.substring(temp_image.src.length-12, temp_image.src.length)=='no_image.gif')) || ((temp_image.src.substring(temp_image.src.length-6, temp_image.src.length)=='images'))){
		//  temp_image.width=0;
		 // temp_image.height=0;
	//	  temp_image.style.visibility="hidden";
		 
	  //}else{
		 //temp_image.width= document.getElementById('menuimage2'+i).width;
		 //temp_image.height= document.getElementById('menuimage2'+i).height;
		// temp_image.style.visibility="visible";
	  //}
 

	
	temp_element.style.fontWeight = document.getElementById('font_weight_over').value+'';
	
	temp_element.style.color =  document.getElementById('main_font_color_over').value.substring(0,7);	
	temp_element.style.backgroundColor = document.getElementById('main_over').value.substring(0,7);
	temp_element.style.backgroundImage = "URL('../"+document.getElementById('main_back_image_over').value+"')";
	temp_element.style.border = document.getElementById('main_border_over').value;
		}
  
}

function doMainPreviewOut(i){
 if (document.getElementById) {
  var temp_element = document.getElementById('mainpreview'+i);
  var temp_image = document.getElementById('imagepreview'+i);
  temp_image.src= document.getElementById('menuimage1'+i).src;
  

	//if((!temp_image.src) || ((temp_image.src.substring(temp_image.src.length-12, temp_image.src.length)=='no_image.gif')) || ((temp_image.src.substring(temp_image.src.length-6, temp_image.src.length)=='images'))){
		//  temp_image.width=0;
		 // temp_image.height=0;
	//	  temp_image.style.visibility="hidden";
		 
	  //}else{
		 //temp_image.width= document.getElementById('menuimage2'+i).width;
		 //temp_image.height= document.getElementById('menuimage2'+i).height;
		// temp_image.style.visibility="visible";
	  //}
 

	
	temp_element.style.fontWeight = document.getElementById('font_weight').value+'';
	temp_element.style.color =  document.getElementById('main_font_color').value.substring(0,7);	
	temp_element.style.backgroundColor = document.getElementById('main_back').value.substring(0,7);
	temp_element.style.backgroundImage = "URL('../"+document.getElementById('main_back_image').value+"')";
	temp_element.style.border = document.getElementById('main_border').value;
	
		}
  
}

function doSubPreviewOver(i){
if (document.getElementById) {
  var temp_element = document.getElementById('subpreview'+i);
  var temp_image = document.getElementById('imagepreview'+i);
  temp_image.src= document.getElementById('menuimage2'+i).src;
  

	//if((!temp_image.src) || ((temp_image.src.substring(temp_image.src.length-12, temp_image.src.length)=='no_image.gif')) || ((temp_image.src.substring(temp_image.src.length-6, temp_image.src.length)=='images'))){
		 // temp_image.width=0;
		 // temp_image.height=0;
		 // temp_image.style.visibility="hidden";
		 
	//  }else{
		 //temp_image.width= document.getElementById('menuimage2'+i).width;
		 //temp_image.height= document.getElementById('menuimage2'+i).height;
		// temp_image.style.visibility="visible";
	//  }
	
	temp_element.style.fontWeight = document.getElementById('font_weight_over').value+'';
	temp_element.style.color =  document.getElementById('sub_font_color_over').value.substring(0,7);	
	temp_element.style.backgroundColor = document.getElementById('sub_over').value.substring(0,7);
	temp_element.style.backgroundImage = "URL('../"+document.getElementById('sub_back_image_over').value+"')";
	temp_element.style.border = document.getElementById('sub_border_over').value;
	
		}
  
}

function doSubPreviewOut(i){
if (document.getElementById) {
  var temp_element = document.getElementById('subpreview'+i);
  var temp_image = document.getElementById('imagepreview'+i);
  temp_image.src= document.getElementById('menuimage1'+i).src;
  

	//if((!temp_image.src) || ((temp_image.src.substring(temp_image.src.length-12, temp_image.src.length)=='no_image.gif')) || ((temp_image.src.substring(temp_image.src.length-6, temp_image.src.length)=='images'))){
		 // temp_image.width=0;
		 // temp_image.height=0;
		 // temp_image.style.visibility="hidden";
		 
	//  }else{
		 //temp_image.width= document.getElementById('menuimage2'+i).width;
		 //temp_image.height= document.getElementById('menuimage2'+i).height;
		// temp_image.style.visibility="visible";
	//  }
	
	temp_element.style.fontWeight = document.getElementById('font_weight').value+'';
	temp_element.style.color =  document.getElementById('sub_font_color').value.substring(0,7);	
	temp_element.style.backgroundColor = document.getElementById('sub_back').value.substring(0,7);
	temp_element.style.backgroundImage = "URL('../"+document.getElementById('sub_back_image').value+"')";
	temp_element.style.border = document.getElementById('sub_border').value;
	
		}
  
}


function doMainPreview(i){
if (document.getElementById) {
  var temp_element = document.getElementById('mainpreview'+i);
  var temp_image = document.getElementById('imagepreview'+i);
 
  var temp_div = document.getElementById('maindivpreview'+i);
  var temp_name = document.getElementById('showname'+i).value;
   var temp_table = document.getElementById('maintablepreview'+i);
 // var myImage= new array();
	//var myImage[i] = new Image;

	//myImage[i].src = document.getElementById('menuimage2'+i).src;
	//var myImage2[i] = new Image;

	//myImage2[i].src = document.getElementById('menuimage1'+i).src;
	
	
	temp_image.src= document.getElementById('menuimage1'+i).src;
	
	
	//if (temp_image.src.substring(temp_image.src.length-9, temp_image.src.length)=='blank.png')
	//{
	//temp_image.align= "right";
	//}else{
	temp_image.align= document.getElementById('imagealign'+i).value;
	//}


	//temp_image.width= document.getElementById('menuimage1'+i).width;
	//temp_image.height= document.getElementById('menuimage1'+i).height;

	  if(temp_name=='0'){
		 temp_div.style.visibility="hidden";
		 //temp_div.style.position="absolute";
	  }else{
		  temp_div.style.visibility="visible";
		  //temp_div.style.position="relative";
	  }

	  if((!temp_image.src) || ((temp_image.src.substring(temp_image.src.length-12, temp_image.src.length)=='no_image.gif')) || ((temp_image.src.substring(temp_image.src.length-6, temp_image.src.length)=='images'))){
		 // temp_image.width=0;
		//  temp_image.height=0;
		  temp_image.style.visibility="hidden";
		 
	  }else{
		 
		 temp_image.style.visibility="visible";
	  }

	 temp_element.style.padding = document.getElementById('main_padding').value;
	temp_element.style.fontFamily = document.getElementById('font_family').value;
	temp_element.style.fontWeight = document.getElementById('font_weight').value;
	temp_element.style.fontSize = document.getElementById('main_font_size').value + 'px';
	temp_element.style.color =  document.getElementById('main_font_color').value.substring(0,7);
	temp_element.style.backgroundColor = document.getElementById('main_back').value.substring(0,7);
	temp_element.style.backgroundImage = "URL('../"+document.getElementById('main_back_image').value+"')";
	temp_element.style.textAlign =  document.getElementById('main_align').value;	
	
	if (document.getElementById('main_width').value != 0)
	{
		temp_table.width = document.getElementById('main_width').value + 'px';
	}
	
	if (document.getElementById('main_height').value != 0)
	{
		temp_element.height = document.getElementById('main_height').value + 'px';
	}
	
	temp_element.style.cursor = "pointer";
	temp_element.style.border = document.getElementById('main_border').value;
	
		}
  
}

function doSubPreview(i){
if (document.getElementById) {
  var temp_element = document.getElementById('subpreview'+i);
  var temp_image = document.getElementById('imagepreview'+i);
  var temp_div = document.getElementById('maindivpreview'+i);
  var temp_name = document.getElementById('showname'+i).value;
  var temp_table = document.getElementById('subtablepreview'+i);

	temp_image.src= document.getElementById('menuimage1'+i).src;
	//if (temp_image.src.substring(temp_image.src.length-9, temp_image.src.length)=='blank.png')
	//{
	//temp_image.align= "right";
	//}else{
	temp_image.align= document.getElementById('imagealign'+i).value;
	//}
	

	 if(temp_name=='0'){
		 temp_div.style.visibility="hidden";
			//temp_div.style.position="absolute";
	  }else{
		  temp_div.style.visibility="visible";
		//  temp_div.style.position="relative";
	  }

	  if((!temp_image.src) || ((temp_image.src.substring(temp_image.src.length-12, temp_image.src.length)=='no_image.gif')) || ((temp_image.src.substring(temp_image.src.length-6, temp_image.src.length)=='images'))){
		 // temp_image.width=0;
		 // temp_image.height=0;
		  temp_image.style.visibility="hidden";
		 
	  }else{
		 //temp_image.width= document.getElementById('menuimage1'+i).width;
		 //temp_image.height= document.getElementById('menuimage1'+i).height;
		 temp_image.style.visibility="visible";
	  }
	temp_element.style.padding = document.getElementById('sub_padding').value;
	temp_element.style.fontFamily = document.getElementById('sub_font_family').value;
	temp_element.style.fontWeight = document.getElementById('font_weight').value;
	temp_element.style.fontSize = document.getElementById('sub_font_size').value + 'px';
	temp_element.style.color =  document.getElementById('sub_font_color').value.substring(0,7);	
	temp_element.style.backgroundColor = document.getElementById('sub_back').value.substring(0,7);
	temp_element.style.backgroundImage = "URL('../"+document.getElementById('sub_back_image').value+"')";
	temp_element.style.textAlign =  document.getElementById('sub_align').value;	
	if (document.getElementById('sub_width').value != 0)
	{
		temp_table.width = document.getElementById('sub_width').value + 'px';
	}
	
	if (document.getElementById('sub_height').value != 0)
	{
		temp_element.height = document.getElementById('sub_height').value + 'px';
	}
	temp_element.style.border = document.getElementById('sub_border').value;
	temp_element.style.cursor = "pointer";
	temp_element.style.filter = "alpha(opacity='"+document.getElementById('specialA').value+"')";
		
		}
  
}

function doAutoAssign(counter){

var temp_attrib ;
var temp_assign ;

  if (document.getElementById) {
     temp_assign = document.getElementById('autoassign').value;
	 temp_attrib = document.getElementById('autoattrib').value;

     switch(temp_assign)
	  {
		case('all'):
			for(i=0;i<counter;i++)
			{
			applyattrib(temp_attrib,i);
			
			}
		break

		case('selected'):
			for(i=0;i<counter;i++)
			{
			var temp_parent = document.getElementById('cb'+i).checked;

				if(temp_parent){
				applyattrib(temp_attrib,i);
				}	
			}
		break

		case('main'):
			for(i=0;i<counter;i++)
			{
			var temp_parent = document.getElementById('isparent'+i).value;

				if(temp_parent==0){
				applyattrib(temp_attrib,i);
				}	
			}
		break

		case('sub'):
			for(i=0;i<counter;i++)
			{
			var temp_parent = document.getElementById('isparent'+i).value;

				if(temp_parent){
				applyattrib(temp_attrib,i);
				}
			}
		break

		case('parent'):
			for(i=0;i<counter;i++)
			{
			var temp_parent = document.getElementById('numchildren'+i).value;

				if(temp_parent != 0){
				applyattrib(temp_attrib,i);
				}
			}
		break		
		}
	}
}