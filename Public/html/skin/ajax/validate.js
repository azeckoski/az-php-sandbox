// AJAX validation script
// Created by Aaron Zeckoski (aaronz@vt.edu)
// Liscensed under the Educational 
//
// Helpful reference: http://www.w3schools.com/dhtml/dhtml_domreference.asp

// config variables
var sUrl = "ajax/validate.php?ajax=1"; // url is the relative processor page 
// processor will do the validation (include ?ajax=1 if using my php processor)
// Processor should return a string: passId|elementId|textMessage
// passId must equal gPass var value if valid and gFail var value if invalid
// Processor will be called with a get string, here is a sample:
// ajax=1&id=user&type=none&spec=undefined&val=asd&param3=undefined
var gPass = "ok"; // global - the response that indicates no problems
var gFail = "error"; // global - the response that indicates failure

// text message output
var gUseText = true; // set to false to not use text processing
var textReq = "Required";
var textVal = "Valid";
var textInv = "Invalid";
var bgColReq = "#FFCCCC";

// image paths and names
var gUseImages = true; // set to false to not use image processing
var imgBln = "ajax/images/blank.gif"; // a blank image file
var imgReq = "ajax/images/required.gif"; // a required image file (star)
var imgVal = "ajax/images/validated.gif"; // a validated image file (check)
var imgInv = "ajax/images/invalid.gif"; // an invalid image file (x mark)

// Include the required fields indicator message
var useRequiredMessage = true;
// just use the id on any field that can display text
/*****
	<div id="requiredMessage"></div>
*****/

// Basic form element sample
/******
	<img id="userImg" src="ajax/images/blank.gif" width="16" height="16"/>
	<input type="text" id="user" name="user" tabindex="1"/>
	<input type="hidden" id="userValidate" value="required none"/>
	<span id="userMsg"></span>
******/


/*
 * Handles the screen updates (most of them)
 * passId (this should be a pass=gPass or fail=gFail string)
 * elementId (this better be the id of the item being validated)
 * textMessage (optional - this is a text message to show the user)
 */
function checkError(passId, elementId, textMessage, changeMessage) {
	var item = document.getElementById(elementId); // the item being validated
	if (item == null) { // failed to retrieve item
		alert("ERROR: Failed to get item by id:" + elementId);
		return false;
	}
	var validateItem = document.getElementById(elementId + "Validate");
	if (validateItem == null) { // items without a validator should not be sent here
		alert("ERROR: Failed to get validate item for id:" + elementId);
		return false;
	}
	
	if (passId == gPass) { // validation passed
		if(gUseImages) {
			var imgObject=document.getElementById(item.id + "Img");
			if (imgObject != null) {
				imgObject.src = imgVal; // this is valid
			}
		}
		if(gUseText) {
			var msgObject=document.getElementById(item.id + "Msg");
			if (msgObject != null) {
				if (changeMessage) {
					if (textMessage == "") {
						msgObject.innerHTML = textVal;
					} else {
						msgObject.innerHTML = textMessage;
					}
				}
				msgObject.style.color = ""; // should reset to default color
			}
		}

		item.style.backgroundColor = "";
		validateItem.defaultValue = gPass;
	} else if (passId == gFail) { // failed validation
		if(gUseImages) {
			var imgObject=document.getElementById(item.id + "Img");
			if (imgObject != null) {
				imgObject.src = imgInv;
			}
		}
		if(gUseText) {
			var msgObject=document.getElementById(item.id + "Msg");
			if (msgObject != null) {
				if (changeMessage) {
					if (textMessage == "") {
						msgObject.innerHTML = textInv;
					} else {
						msgObject.innerHTML = textMessage;
					}
				}
				msgObject.style.color = "red";
			}
		}

		item.style.backgroundColor = bgColReq;
		validateItem.defaultValue = gFail;
	} else {
		alert("ERROR: Invalid return options:\n" + passId +"|"+ elementId +"|"+ textMessage);
	}
}


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
				var validateItem = document.getElementById(items[i].id + "Validate");
				if (validateItem != null) {
					// do some extra stuff for required items
					if (validateItem.value.match(/^required.*$/)) { // check if required at start
						// this is required so add the images or the text
						if(gUseImages) {
							var imgObject=document.getElementById(items[i].id + "Img");
							if (imgObject != null) {
								imgObject.src = imgReq;
							}
						}
						if(gUseText) {
							var msgObject=document.getElementById(items[i].id + "Msg");
							if (msgObject != null) {
								msgObject.innerHTML = textReq;
							}
						} else {
							// no image or text object, go with setting color of item
							items[i].style.backgroundColor = bgColReq;
						}
					}
					// attach handlers and set variant holder
					validateItem.defaultValue = gFail; // start out as failed
					items[i].onchange = function(){return validateMe(this);} //attach the onchange to each form field
					//items[i].onblur = function(){return validateMe(this);} //attach the onblur to each form field
				}
			}
		}
		// attach the validate function to all form submit actions
		document.forms[f].onsubmit = function(){return validate(this);}
	}
	
	// do some other stuff on form load
	if (useRequiredMessage) {
		var reqMsgObject=document.getElementById("requiredMessage");
		if (reqMsgObject != null) {
			if(gUseImages) {
				reqMsgObject.innerHTML = "<img src='" + imgReq + "'> = Required fields";
			} else if(gUseText) {
				reqMsgObject.innerHTML = "Required fields marked as '" + textReq + "'";
			} else {
				reqMsgObject.innerHTML = "Required fields are highlighted";
				reqMsgObject.backgroundColor = bgColReq; // this may not work for some tags
			}
		}
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
var http = createRequestObject;


// handle the response from the validation page
// proper format is passId|elementId|textMessage
function handleHttpResponse() {
    if(http.readyState == 4) {
    		var rText = http.responseText;
    		if (rText != "") {
			var sResults = rText.split("|"); // set to the feedback from the processor page
			if (sResults[0] == gPass || sResults[0] == gFail) {
				checkError(sResults[0],sResults[1],sResults[2],true);
			} else {
				alert("ERROR: Invalid responsetext: " + rText);
			}
		}
  	}
}


/* validateMe is called with onblur each time the user leaves the input box
 * passed into it is the value entered, the rules (which you can extend), 
 * and the id of the area the results will show in
 */
function validateMe(objInput) {
	alert("validate on " + objInput.id);
	//var sRules = objInput.className.split(' '); // get all the rules from the input box classname
	var validateItem = document.getElementById(objInput.id + "Validate");
	if (validateItem == null) { return; } // no validation on this object
	
	if (validateItem.value.match(/^required.*$/)) { // check if required is the first word
		if (objInput.value == "") {
			// required field is blank
			if(gUseText) {
				checkError(gFail, objInput.id, textReq, true);
			} else {
				checkError(gFail, objInput.id, "", false);
			}
			return; // exit, no need to do more validation
		} else {
			// required field is set
			if(gUseText) {
				checkError(gPass, objInput.id, textVal, true);
			} else {
				checkError(gPass, objInput.id, "", false);
			}
		}
	}

	var sRules = validateItem.value.split(' '); // split the validation field, first item = required or optional
	var vText = sRules[1]; // text validation rules (ie. email, date, time)
	var vSpec = sRules[2]; // special validation rules (ie. unique)
	var vVal = objInput.value; //get value inside of input field
	
	// if the text or special validations are not set then don't bug the server
	if(!sRules[1] && !sRules[2]) { return; }

	// get additional params and pass them on
	var i = 1;
    var vParams = ""; //"&param3=" + sRules[3] + "&param4=" + sRules[4] + "&param5=" + sRules[5] + "&param6=" + sRules[6];
	while (sRules[i+2]) {
		vParams = vParams + "&param" + i + "=" + sRules[i+2];
		i++;
		if (i > 10) { break; }
	}

	//sends the rules and value to be validated
	var vUrl = sUrl + "&id=" + (objInput.id) + "&type=" + (vText) + "&spec=" + (vSpec) + "&val="+ (vVal) + (vParams);
	http.open("GET", vUrl, true);
	http.onreadystatechange = handleHttpResponse; 	// handle what to do with the feedback 
	http.send(null);
}


// validates the elements for this form only
// called by form submit
function validate(formObj) {
	var countErrors = 0;

	var items = formObj.elements;
	//alert ("Items="+items.length);
	for (var i=0; i<items.length; i++) {
		// if there is a validateItem for this object then check it		
		var validateItem = document.getElementById(items[i].id + "Validate");
		if (validateItem != null) {
			if (validateItem.defaultValue == gPass) {
				checkError(gPass, items[i].id, "", false);
			} else {
				// assume failure if pass not found
				//alert("Failure found: " + items[i].id + ":" + validateItem.defaultValue);
				checkError(gFail, items[i].id, "", false);
				countErrors++;
			}
		}
	}

	if (countErrors > 0) {
		//if there are any errors give a message
		alert("Please make sure all fields are properly completed\n(" + 
			countErrors + " invalid fields indicated)");
		return false;
	} else {
		return true;
	}
}