// Created and modified from various code by Aaron Zeckoski (aaronz@vt.edu)

// config variables
var sUrl = "ajax/validate.php?ajax=1"; // url is the relative processor page which will do the checking (include ?ajax=1)
var gPass = "ok"; // global - the response that indicates no problems
var gFail = "error"; // global - the response that indicates failure
var textRequired = "Required";

// image paths and names
var imgBln = "ajax/images/blank.gif"; // a blank image file
var imgReq = "ajax/images/required.gif"; // a required image file (star)
var imgVal = "ajax/images/validated.gif"; // a validated image file (check)
var imgInv = "ajax/images/invalid.gif"; // an invalid image file (x mark)

// global variables
var gErrors = 0; // global - error count

// Basic form element sample
/******
<img id="userImg" src="ajax/images/blank.gif" width="16" height="16"/>
<input id="user" type="text" name="user" tabindex="1"/>
<input id="userValidate" type="hidden" value="validate required none"/>
<span id="userMsg"></span>
******/

// setup up the handlers on all appropriate form elements
window.onload = attachFormHandlers;

function attachFormHandlers()
{
	for (var f=0; f<document.forms.length; f++) {
		var items = document.forms[f].elements;
		for (var i=0; i<items.length; i++) {
			if (items[i].type.toLowerCase() == "submit") {
				// handle submit differently
				//items[i].disabled = true; // disable submit by default
			} else {
				validateItem = document.getElementById(items[i].id + "Validate");
				if (validateItem != null) {
					if (validateItem.value.match(" required ")) {
						// this is required so add the images or the text
						if ((var imgObject=document.getElementById(items[i].id + "Img")) != null) {
							imgObject.src = imgReq;
							alert("Found image object:"+items[i].id);
						} else if ((var msgObject=document.getElementById(items[i].id + "Msg")) != null) {
							msgObject.innerHtml = textRequired;
						} else {
							// no image or text object, go with setting color of item
							items[i].style.backgroundColor = "#FFCCCC";
						}
					}
					items[i].style.fontVariant = "";
					items[i].onchange = function(){return validateMe(this);} //attach the onchange to each form field
					//items[i].onblur = function(){return validateMe(this);} //attach the onblur to each form field
				}
			}
		}
		// attach the validate function to all form submit actions
		document.forms[f].onsubmit = function(){return validate(this);}
	}	
}

// get the http request object in a browser safe way
function createRequestObject(){
	var request_o; //declare the variable to hold the object.
	var browser = navigator.appName; //find the browser name
	if(browser == "Microsoft Internet Explorer"){
		/* Create the object using MSIE's method */
		request_o = new ActiveXObject("Microsoft.XMLHTTP");
	}else{
		/* Create the object using other browser's method */
		request_o = new XMLHttpRequest();
	}
	return request_o; //return the object
}

/* The variable http will hold our new XMLHttpRequest object. */
var http = createRequestObject();


/* validateMe is called with onblur each time the user leaves the input box
 * passed into it is the value entered, the rules (which you can extend), 
 * and the id of the area the results will show in
 */
function validateMe(objInput) {
	
	sRules = objInput.className.split(' '); // get all the rules from the input box classname

	// only items with validate oe valid should go through this check
	if (sRules[0] != "validate" && sRules[0] != "valid") { return; }
	
	vReq = sRules[1]; // is field required or optional
	vType = sRules[2]; // additional validation rules (ie. email, date, unique)
    vParams = "&param3=" + sRules[3] + "&param4=" + sRules[4] + "&param5=" + sRules[5] + "&param6=" + sRules[6];

	vVal = objInput.value; //get value inside of input field

	//sends the rules and value to be validated
	var vUrl = sUrl + "&id=" + (objInput.id) + "&req=" + (vReq) + "&type=" + (vType) + "&val="+ (vVal) + (vParams);
	http.open("GET", vUrl, true);
  
	http.onreadystatechange = handleHttpResponse; 	// handle what to do with the feedback 
	http.send(null);
}


// handle the response from the validation page
// proper format is passId|elementId|textMessage
function handleHttpResponse() {
    if(http.readyState == 4) {
    		var rText = http.responseText;
    		if (rText != "") {
			sResults = rText.split("|"); // set to the feedback from the processor page
			if (sResults[0] == gPass || sResults[0] == gFail) {
				checkError(sResults[0],sResults[1],sResults[2]);
			} else {
				document.write("Invalid responsetext: " + rText);
			}
		}
  	}
}

function checkError(passId, elementId, textMessage) {
	var origItemId = elementId.replace("Msg","");
	var origItem = document.getElementById(origItemId);
	if (passId == gPass) {
		var item = document.getElementById(elementId);
		item.innerHTML = "" + textMessage;
		item.style.color = "black";
		origItem.style.fontVariant = "normal"; // normal = valid
		origItem.style.backgroundColor = "";
	} else if (passId == gFail) {
		// failed validation
		var item = document.getElementById(elementId);
		item.innerHTML = "" + textMessage;
		item.style.color = "red";
		origItem.style.fontVariant = ""; // blank = unvalidated
		gErrors++; // increment the error count
	} else {
		document.write("Failed to check Error");
	}
}

// validates the elements for this form only
function validate(formObj) {
	gErrors = 0; // reset the global error count
	//alert(" errors = " + gErrors);

	var items = formObj.elements;
	//alert ("Items="+items.length);
	for (var i=0; i<items.length; i++) {
		// if the class name of this element has validate first, check it
		//alert(" validate " + items[i].id + ": check="+items[i].style.fontVariant);
		var check = items[i].className.split(' ');
		if (check[0] == "validate") {
			if (items[i].style.fontVariant == "") {
				gErrors++;
				items[i].style.backgroundColor = "#FFCCCC";
				//validateMe(items[i]); // for some reason this breaks the javascript if I try to run it?
			} else {
				items[i].style.backgroundColor = "";
			}
		}
	}

	if (gErrors > 0) {
		//if there are any errors give a message
		alert ("Please make sure all fields are properly completed\n(" + gErrors + " invalid fields highlighted in red)");
		return false;
	} else {
		return true;
	}
}
