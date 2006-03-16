// AJAX validation script
// Created by Aaron Zeckoski (aaronz@vt.edu)
// Copyright (c) 2006 Aaron Zeckoski, Virginia Tech
// Licensed under the Educational Community License version 1.0
// http://www.opensource.org/licenses/ecl1.php
// Some code from other javascript projects
// Helpful reference: http://www.w3schools.com/dhtml/dhtml_domreference.asp

// config variables
var ajaxPath = "/accounts/ajax/"; // must the relative path from the web root
var gProcUrl = ajaxPath + "validate.php?ajax=1"; // url is the relative processor page 
// processor will do the validation (include ?ajax=1 if using my php processor)
// Processor should return a string: passId|elementId|textMessage
// passId must equal gPass var value if valid and gFail var value if invalid
// Processor will be called with a get string, here is a sample:
// ajax=1&id=user&type=none&spec=undefined&val=asd&param3=undefined
var gPass = "ok"; // global - the response that indicates no problems
var gFail = "error"; // global - the response that indicates failure
var gClear = "clear"; // global - the response that indicates clear
var gSeparator = ":"; // this is the separator used in the validate value field

// Include the required fields indicator message
var useRequiredMessage = true;
// just use the id on any field that can display text
/*****
	<div id="requiredMessage"></div>
*****/

// If you want to alert people without a popup alert, you can define
// an errorMessage item as shown below, the error output will go there instead
/*****
	<div id="errorMessage"></div>
*****/

// Basic form element sample
// validation rules shown are "required", "email", and "unique sql check"
/******
	<img id="emailImg" src="ajax/images/blank.gif" width="16" height="16"/>
	<input type="text" name="email" tabindex="2"/>
	<input type="hidden" name="emailValidate" value="required:email:uniquesql;new;users;email"/>
	<span id="emailMsg"></span>
******/

// text message output
var gUseText = true; // display text messages
var gRequiredText = false; // display required text in text message boxes on form load (gUseTest must be on)
var gPositiveText = false; // display valid messages as returned from validation code
var textReq = "Required";
var textVal = "Valid";
var textInv = "Invalid";
var bgColReq = "#FFCCCC";

// image paths and names
var gUseImages = true; // set to false to not use image processing
var imagePath = ajaxPath + "images/";
var imgBln = imagePath + "blank.gif"; // a blank image file
var imgReq = imagePath + "required.gif"; // a required image file (star)
var imgVal = imagePath + "validated.gif"; // a validated image file (check)
var imgInv = imagePath + "invalid.gif"; // an invalid image file (x mark)
var imgExc = imagePath + "exclaim.gif"; // an exclaimation mark image

// these vars are for the wacky way we associate validation codes with an item
var gFailCode = "red"; // this is the failure code to check for
var gPassCode = "green"; // this is the passcode to check for
var gInitialCheck = true; // do an initial check of the fields (needed if prepopulating)



// this handles error message to the user
// sending this a blank will clear out the error message
function errorAlert(myMessage) {
	var errorMsgObject=document.getElementById("errorMessage");
	if (errorMsgObject != null) {
		if(myMessage == "") {
			errorMsgObject.innerHTML = "";
		} else {
			if(gUseImages) {
				errorMsgObject.innerHTML = "<img src='" + imgExc + "'><span style='vertical-align:top;'>" + myMessage + "</span>";
			} else {
				errorMsgObject.innerHTML = "ERROR: " + myMessage;
				errorMsgObject.backgroundColor = bgColReq; // this may not work for some tags
			}
			errorMsgObject.style.color = "red";
		}
	} else {
		if(message != "") { // blank message does not get sent to the user
			// use the old standby
			alert("Error: " + myMessage);
		}
	}
}


/*
 * Handles the screen updates (most of them)
 * passId (this should be a pass=gPass or fail=gFail string)
 * elementId (this better be the id of the item being validated)
 * textMessage (optional - this is a text message to show the user)
 */
function markField(passId, elementId, textMessage, changeMessage, sweepCheck) {
	//alert("doing check:"+elementId);
	var item = document.getElementById(elementId); // the item being validated
	if (item == null) { // failed to retrieve item
		alert("ERROR: Failed to get item by id:" + elementId);
		return false;
	}
	var validateItem = document.getElementById(item.name + "Validate");
	if (validateItem == null) { // items without a validator should not be sent here
		alert("ERROR: Failed to get validate item for name:" + item.name);
		return false;
	}

	// if doing a sweep check then we do not want to mark things as wrong
	if (sweepCheck && passId == gFail) { passId = gClear; }
	
	if (passId == gPass) { // validation passed
		if(gUseImages) {
			var imgObject=document.getElementById(item.name + "Img");
			if (imgObject != null) {
				imgObject.src = imgVal; // this is valid
			}
		}
		if(gUseText) {
			var msgObject=document.getElementById(item.name + "Msg");
			if (msgObject != null) {
				if (changeMessage) {
					if (gPositiveText) {
						if (textMessage == "") {
							msgObject.innerHTML = textVal;
						} else {
							msgObject.innerHTML = textMessage;
						}
					} else {
						// if positive text off then just clear the error text
						msgObject.innerHTML = "";
					}
				}
				msgObject.style.color = ""; // should reset to default color
			}
		}

		item.style.backgroundColor = "";
		validateItem.style.color = gPassCode;
	} else if (passId == gFail) { // failed validation
		if(gUseImages) {
			var imgObject=document.getElementById(item.name + "Img");
			if (imgObject != null) {
				imgObject.src = imgInv;
			}
		}
		if(gUseText) {
			var msgObject=document.getElementById(item.name + "Msg");
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
		validateItem.style.color = gFailCode;
		// put user back on that item when validation fails
		item.focus();
	} else if (passId == gClear) { // cleared, reset item back to initial state
		var itemRequired = validateItem.value.match(/^required.*$/); // true/false
		if(gUseImages) {
			var imgObject=document.getElementById(item.name + "Img");
			if (imgObject != null) {
				if (itemRequired) {
					imgObject.src = imgReq;
				} else {
					imgObject.src = imgBln;
				}
			}
		}
		if(gUseText) {
			var msgObject=document.getElementById(item.name + "Msg");
			if (msgObject != null) {
				if (changeMessage) {
					if (itemRequired && gRequiredText) {
						msgObject.innerHTML = textReq;
					} else {
						if (textMessage != "") {
							msgObject.innerHTML = textMessage;
						}
					}
				}
				msgObject.style.color = "";
			}
		}
		item.style.backgroundColor = "";

		// no image or text object, go with setting color of item
		if(itemRequired && !gUseImages && !gUseText) {
			item.style.backgroundColor = bgColReq;
		}
		
		// reset the validate codes to initial states
		if (itemRequired) {
			validateItem.style.color = gFailCode;
		} else {
			validateItem.style.color = gPassCode;
		}
	} else {
		alert("ERROR: Invalid return options:\n" + passId +"|"+ elementId +"|"+ textMessage);
	}
}

// This attachs all the nice handlers to the form elements
// it also handles some initialization
function attachFormHandlers()
{
	for (var f=0; f<document.forms.length; f++) {
		var items = document.forms[f].elements;
		for (var i=0; i<items.length; i++) {
			if (items[i].type.toLowerCase() == "submit") {
				// handle submit differently
				//items[i].disabled = true; // disable submit by default
			} else {
				var validateItems = document.getElementsByName(items[i].name + "Validate");
				var validateItem = validateItems[0];
				if (validateItem != null) {
					if (validateItems.length > 1) {
						alert("FAILURE: bad naming in form, you MUST use unique names for validated fields");
						return;
					}
					validateItem.id = validateItem.name; // set the id to the name

					// handle the different element types
					if (items[i].type.toLowerCase() == "radio") {
						// have to handle radiobuttons in a special way
						
						// if this is the first button in this set then process, otherwise skip it
						var thisItems = document.getElementsByName(items[i].name);
						if (items[i] == thisItems[0]) {
							var k = 0;
							if (thisItems.length == 1) {
								// only one so set the id and move on
								items[i].id = items[i].name;
							} else {
								// multiple items so set id by position encountered
								for (var j=0; j<thisItems.length; j++) {
									thisItems[j].id = items[i].name + j;
									if (thisItems[j].checked) { k = j; } // marked the checked item
								}
							}
							// do validate on one of the buttons only
							//alert("matched:" + k + ":" + thisItems[k].id);
							validateObject(thisItems[k]);
						}
					} else {
						items[i].id = items[i].name; // set the id to the name
						
						// do the initial validation check
						validateObject(items[i]);
					}

					// do the focus check, set focus on this item if specified
					if (validateItem.value.match("focus")) {
						items[i].focus();
					}

					// attach handlers to items
					if (items[i].type.toLowerCase() == "radio" || items[i].type.toLowerCase() == "checkbox") {
						// attach onclick handlers to checkboxes and radio buttons
						items[i].onclick = function(){return validateObject(this);}
					} else {
						//attach the onchange to each form field
						items[i].onchange = function(){return validateObject(this);}
						//items[i].onblur = function(){return validateObject(this);}
					}
				}
			}
		}
		// attach the validate function to all form submit actions
		document.forms[f].onsubmit = function(){return validate(this);}
	}

	// initial check is complete
	gInitialCheck = false;

	// do some other stuff on form load
	if (useRequiredMessage) {
		var reqMsgObject=document.getElementById("requiredMessage");
		if (reqMsgObject != null) {
			if(gUseImages) {
				reqMsgObject.innerHTML = "<img src='" + imgReq + "'><span style='vertical-align:top;'> = Required fields</span>";
			} else if(gUseText) {
				reqMsgObject.innerHTML = "Required fields marked as '" + textReq + "'";
			} else {
				reqMsgObject.innerHTML = "Required fields are highlighted";
				reqMsgObject.backgroundColor = bgColReq; // this may not work for some tags
			}
		}
	}
}

// setup up the handlers on all appropriate form elements
window.onload = attachFormHandlers;


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


// This is the new XMLHttpRequest object (must use () at end of function)
//var http = createRequestObject();

// handle the response from the validation page
// proper format is passId|elementId|textMessage
/***
function handleHttpResponse() {
    if(http.readyState == 4) {
    		var rText = http.responseText;
    		if (rText != "") {
			var sResults = rText.split("|"); // set to the feedback from the processor page
			if (sResults[0] == gPass || sResults[0] == gFail || sResults[0] == gClear) {
				markField(sResults[0],sResults[1],sResults[2],true,false);
			} else {
				alert("ERROR: Invalid responsetext: " + rText);
			}
		}
  	}
}
***/

//Called with event triggers, this does the basic required validation and 
//passes other validation to the server side script via the AJAX call
// Validation Rules: (not comprehensive)
// required (must be the first rule always)
// text validation rules (ie. email, date, time)
// special validation rules (ie. unique)
function validateObject(objInput) {
	var localCheck = false;
	var localText = "";
	//alert("valuecheck="+objInput.value);
	
	var validateItem = document.getElementById(objInput.name + "Validate");
	if (validateItem == null) { // items without a validator should not be sent here
		alert("ERROR: Failed to get validate item for name:" + objInput.name);
		return false;
	}

	// do any local javascript checks
	
	// do a blank check first
	var isBlank = false;
	if (objInput.value == "" || 
		(objInput.type.toLowerCase() == "checkbox" && !objInput.checked) || 
		(objInput.type.toLowerCase() == "radio" && !objInput.checked) ) {
		isBlank = true;
	}	

	// now do a required check
	var isRequired = validateItem.value.match(/^required.*$/); // check if required is the first word
	if (isBlank) {
		if (isRequired) {
			if(gUseText && gRequiredText) {
				markField(gFail, objInput.id, textReq, true, gInitialCheck);
			} else {
				markField(gFail, objInput.id, "", false, gInitialCheck);
			}
			return; // exit, no need to do more validation
		} else {
			// reset the field to clear happy state, only change msg text if outside the initial stage
			markField(gClear, objInput.id, "", !gInitialCheck, false);
			return; // no need to continue, the field is empty
		}
	} else {
		if (isRequired) {
			// required field is set
			localCheck = true; // passed the local check
			localText = textVal;
		} else {
			//alert("non-req:" + objInput.id +":"+ objInput.value);
		}
	}

	// get additional validations and pass them on
	var vFields = validateItem.value.split(gSeparator);
	var i = 1;
    var vParams = ""; //  stores the params in get string ready form
	for(var j=0; j<vFields.length; j++) {
		var field = vFields[j];
		if(field == "required" || field == "focus") { continue; } // skip required and focus flags
		vParams = vParams + "&rule" + i + "=" + encodeURIComponent(field);
		i++;
	}

	var vVal = encodeURIComponent(objInput.value); //get value inside of input field
	
	// if no serverside validations are set then don't bug the server
	if(vParams == "") {
		// send to passed to check error and exit
		//alert("no params!"+objInput.id);
		if (localCheck) { // passed local checks (if failed, we should not get here)
			if(gUseText) {
				markField(gPass, objInput.id, localText, true, gInitialCheck);
			} else {
				markField(gPass, objInput.id, "", false, gInitialCheck);
			}
		}
		return;
	}

	//sends the rules and value to be validated
	var vUrl = gProcUrl + "&id=" + objInput.id + "&val="+ vVal + vParams;
	//alert("sending: " + vUrl);
	var http = createRequestObject(); // create the http object
	http.open("GET", vUrl, true);
	// assign the function dynamically
	http.onreadystatechange = function () {
	    if(http.readyState == 4) {
	    		var rText = http.responseText;
	    		if (rText != "") {
				var sResults = rText.split("|"); // set to the feedback from the processor page
				if (sResults[0] == gPass || sResults[0] == gFail || sResults[0] == gClear) {
					markField(sResults[0],sResults[1],sResults[2],true,false);
				} else {
					alert("ERROR: Invalid responsetext: " + rText);
				}
			}
	  	}
	}
	http.send(null); // send (set POST to null)
	delete(http); // clear the http object
}


// validates the elements for this form only, called by form submit
function validate(formObj) {
	var countErrors = 0;
	var firstError;

	var items = formObj.elements;
	//alert ("Items="+items.length);
	for (var i=0; i<items.length; i++) {
		// if there is a validateItem for this object then check it		
		var validateItem = document.getElementById(items[i].name + "Validate");
		if (validateItem != null) {
			if (validateItem.style.color == gPassCode) {
				markField(gPass, items[i].id, "", false, false);
			} else {
				// assume failure if pass not found
				//alert("Failure found: " + items[i].name + ":" + validateItem.style.color);
				markField(gFail, items[i].id, "", false, false);
				// special handling for radio button error counting
				if (items[i].type.toLowerCase() == "radio") {
					// count the first item only
					if (items[i].id == items[i].name + "0") { countErrors++; }
				} else {
					countErrors++;
				}
				if (countErrors == 1) {
					firstError = items[i]; // save the first item with an error
				}
			}
		}
	}

	if (countErrors > 0) {
		firstError.focus(); // set the focus on the first invalid field
		// send an alert to the user if there are errors remaining
		errorAlert("Please make sure all fields are properly completed\n (" + 
			countErrors + " invalid fields indicated)");
		return false;
	} else {
		return true;
	}
}
