/* 
 * AJAX validation script
 * Created by Aaron Zeckoski (aaronz@vt.edu)
 * Copyright (c) 2006 Aaron Zeckoski, Virginia Tech
 * Licensed under the Educational Community License version 1.0
 * http://www.opensource.org/licenses/ecl1.php
 * Some code from other javascript projects
 * Helpful reference: http://www.w3schools.com/dhtml/dhtml_domreference.asp
 */

// config variables
var ajaxPath = "/accounts/ajax/"; // must be the relative path from the web root
var ajaxValidateUrl = ajaxPath + "validate.php?ajax=1"; // url is the relative processor page 
// processor will do the validation (include ?ajax=1 if using my php processor)
// Processor should return a string: passId|elementId|textMessage
// passId must equal gPass var value if valid and gFail var value if invalid
// Processor will be called with a get string, here is a sample:
// ajax=1&id=user&val=asdf&rule1=required&rule2=nospaces
var gPass = "ok"; // global - the response that indicates no problems
var gFail = "error"; // global - the response that indicates failure
var gClear = "clear"; // global - the response that indicates clear
var gSeparator = ":"; // this is the separator used in the validate value field
var iSeparator = ";"; // this is the separator used inside items in the validate field
var gInitialCheck = true; // do an initial check of the fields (needed if prepopulating)

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
// rules enforced in this script: required, focus, nospaces, password, match;elementID
/******
	<img id="emailImg" src="ajax/images/blank.gif" width="16" height="16" alt="validation" />
	<input type="text" name="email" tabindex="2"/>
	<input type="hidden" name="emailValidate" value="required:email:uniquesql;users;email"/>
	<span id="emailMsg"></span>
******/

// use the -other- capabilities (allows users to enter an other value when a list
// is not complete, you just have to include an item in the list
// with a value of (vOtherCode) and add an item as shown below
// NOTE: You may want to add extra validation rules for the input field
var vUseOther = true;
var vOtherCode = "-other-";
/******
<input style="display:none;" type="text" id="emailOther" size="30" maxlength="100" value="" />
******/

// SPECIAL CASE: Multiple checkboxes
// if you want to add a rule to validate that a certain number of checkboxes are
// selected in a group of checkboxes, you can associate them by name (like radio buttons)
// and then add the "multiple;#" rule where # is a natural number
// NOTE: This can only be used on checkboxes and "required" must be included
// NOTE: The form will submit with these checkboxes named <name># (e.g. multiCheck1 for the first one)
// Optional: You can set the values that will be appended to the <name> of each checkbox
// using multiCheckRename as shown below (use ':' as a separator)
// Example shows a set of 4 checkboxes which will validate if at least 2 are checked
/******
	<img id="multiCheckImg" src="images/blank.gif" width="16" height="16" alt="validation indicator" />
	<input type="checkbox" name="multiCheck" value="1" /> checkbox 1 <br/>
	<input type="checkbox" name="multiCheck" value="2" /> checkbox 2 <br/>
	<input type="checkbox" name="multiCheck" value="3" /> checkbox 3 <br/>
	<input type="checkbox" name="multiCheck" value="4" /> checkbox 4 <br/>
	<input type="hidden" id="multiCheckValidate" value="required:multiple;2"/>
	<input type="hidden" id="multiCheckRename" value="one:two:three:four"/>
	<span id="multiCheckMsg"></span>
******/
var multipleCheckItems=new Array(); // global array to hold the list of root multipleCheck item

// POPUP DIVS
var ajaxTipsDataUrl = ajaxPath + "tips.php?ajax=1"; // url is the relative processor page 
var defaultPopWidth = 240; // default pixels width of popup divs

// Popup tip sample
// Putting the mouse over the item identified with (tipid)Activate will
// display a popup div with the data inside the div identified by (tipid)
// The popup div will appear near the activate item
// Any class or style my be specified, display:none should always be included
// Pass parameters using a hidden input identified by (tipid)Params as shown
/***
<span id="tipActivate">Activate Item Text</span>
<input type="hidden" id="tipParams" value="header;Header text:ajax;table;column;id" />
<div id="tip" style="display:none;width:200px;">
	This is my awesome tip
</div>
***/


// text message output
var gUseText = true; // display text messages
var gRequiredText = false; // display required text in text message boxes on form load (gUseText must be on)
var gPositiveText = false; // display valid messages as returned from validation code
var textReq = "Required";
var textVal = "Valid";
var textInv = "Invalid";
var bgColReq = "#FFCCCC"; // background color for required or error fields

// image paths and names
var vUseImages = true; // set to false to not use image processing
var vImagePath = ajaxPath + "images/";
var imgBln = vImagePath + "blank.gif"; // a blank image file
var imgReq = vImagePath + "required.gif"; // a required image file (star)
var imgVal = vImagePath + "validated.gif"; // a validated image file (check)
var imgInv = vImagePath + "invalid.gif"; // an invalid image file (x mark)
var imgExc = vImagePath + "exclaim.gif"; // an exclaimation mark image

// Holds the mouse position
var mousePosX = 0, mousePosY = 0;


// this handles the error message to the user
// sending this a blank will clear out the error message
function errorAlert(myMessage) {
	var errorMsgObject=document.getElementById("errorMessage");
	if (errorMsgObject != null) {
		if(myMessage == "") {
			errorMsgObject.innerHTML = "";
		} else {
			if(vUseImages) {
				errorMsgObject.innerHTML = "<img src='" + imgExc + "'><span style='vertical-align:top;'>" + myMessage + "</span>";
			} else {
				errorMsgObject.innerHTML = "ERROR: " + myMessage;
				errorMsgObject.backgroundColor = bgColReq; // this may not work for some tags
			}
			errorMsgObject.style.color = "red";
		}
	} else {
		if(myMessage != "") { // blank message does not get sent to the user
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

	// is this field required
	var isRequired = validateItem.value.match(gSeparator + "required" + gSeparator);

	// if doing a sweep check then we do not want to mark things as wrong
	if (sweepCheck && passId == gFail) { passId = gClear; }
	
	if (passId == gPass) { // validation passed
		if(vUseImages) {
			var imgObject=document.getElementById(item.name + "Img");
			if (imgObject != null) {
				imgObject.src = imgVal; // this is valid

                var requiredImgObject=document.getElementById(item.name+"RequiredImg");
                if (requiredImgObject==null) {
                	requiredImgObject=document.createElement('img');
                	requiredImgObject.setAttribute('id',item.name+"RequiredImg");
                	requiredImgObject.setAttribute('height','16');
                	requiredImgObject.setAttribute('width','16');
                	requiredImgObject.setAttribute('src',imgBln);
                	imgObject.parentNode.insertBefore(requiredImgObject,imgObject);
                }
				if (isRequired) {
                    // insert the required image to the left of the validation image if it's not already there
                	requiredImgObject.src = imgReq;
				}
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
		validateItem.className = gPass;
	} else if (passId == gFail) { // failed validation
		if(vUseImages) {
			var imgObject=document.getElementById(item.name + "Img");
			if (imgObject != null) {
				imgObject.src = imgInv;

                var requiredImgObject=document.getElementById(item.name+"RequiredImg");
                if (requiredImgObject==null) {
                	requiredImgObject=document.createElement('img');
                	requiredImgObject.setAttribute('id',item.name+"RequiredImg");
                	requiredImgObject.setAttribute('height','16');
                	requiredImgObject.setAttribute('width','16');
                	requiredImgObject.setAttribute('src',imgBln);
                	imgObject.parentNode.insertBefore(requiredImgObject,imgObject);
                }
				if (isRequired) {
                    // insert the required image to the left of the validation image if it's not already there
                	requiredImgObject.src = imgReq;
				}
			}

		}
		if(gUseText) {
			var msgObject=document.getElementById(item.name + "Msg");
			if (msgObject != null) {
				if (changeMessage || !sweepCheck) {
					if (textMessage == "") {
						if (isRequired) {
							msgObject.innerHTML = textReq;
						} else {
							msgObject.innerHTML = textInv;
						}
					} else {
						msgObject.innerHTML = textMessage;
					}
				}
				msgObject.style.color = "red";
			}
		}

		item.style.backgroundColor = bgColReq;
		validateItem.className = gFail;
		// put user back on that item when validation fails
		item.focus();
	} else if (passId == gClear) { // cleared, reset item back to initial state
		if(vUseImages) {
			var imgObject=document.getElementById(item.name + "Img");
			if (imgObject != null) {
				// blank out "required" images prepopulated in validation image slots
				var imgRegExp = new RegExp(imgReq+"$");
				if (imgRegExp.test(imgObject.src)) {
				  imgObject.src = imgBln;
				}

                var requiredImgObject=document.getElementById(item.name+"RequiredImg");
                if (requiredImgObject==null) {
                	requiredImgObject=document.createElement('img');
                	requiredImgObject.setAttribute('id',item.name+"RequiredImg");
                	requiredImgObject.setAttribute('height','16');
                	requiredImgObject.setAttribute('width','16');
                	requiredImgObject.setAttribute('src',imgBln);
                	imgObject.parentNode.insertBefore(requiredImgObject,imgObject);
                }
				if (isRequired) {
                    // insert the required image to the left of the validation image if it's not already there
                	requiredImgObject.src = imgReq;
				} 
			}
		}
		if(gUseText) {
			var msgObject=document.getElementById(item.name + "Msg");
			if (msgObject != null) {
				if (changeMessage) {
					if (isRequired && gRequiredText) {
						msgObject.innerHTML = textReq;
					} else {
						msgObject.innerHTML = textMessage;
					}
				}
				msgObject.style.color = "";
			}
		}
		item.style.backgroundColor = "";

		// no image or text object, go with setting color of item
		if(isRequired && !vUseImages && !gUseText) {
			item.style.backgroundColor = bgColReq;
		}
		
		// reset the validate codes to initial states
		if (isRequired) {
			validateItem.className = gFail;
		} else {
			validateItem.className = gClear;
		}
	} else {
		alert("ERROR: Invalid return options:\n" + passId +"|"+ elementId +"|"+ textMessage);
		return false;
	}
	return true;
}

// This attachs all the nice handlers to the form elements
// it also handles some initialization
function attachValidateHandlers() {
	for (var f=0; f<document.forms.length; f++) {
		//alert("form:"+document.forms[f].name+":"+document.forms[f].elements.length);
		var itemCount = document.forms[f].elements.length;
		//alert("form:"+document.forms[f].name+":"+itemCount);
		if (document.forms[f] == document.forms[f].elements) { // this is to handle the stupid form error
			itemCount = 250;
		}
		for (var i=0; i<itemCount; i++) {
			var thisElement = document.forms[f][i];
			// skip certain items
			if (thisElement == null || thisElement.type == null || 
				thisElement.type.toLowerCase() == "hidden") { continue; }
			if (thisElement.type.toLowerCase() == "submit") {
				// handle submit differently - handler attached to the form submit
				if (!thisElement.tabIndex) {
					thisElement.tabIndex = 50;
				}
			} else {
				//alert("item:" + thisElement.name);
				var validateItem = document.getElementById(thisElement.name + "Validate");
				if (validateItem != null) {
					// if the validation value is blank then skip this item
					if (validateItem.value == "") { continue; }
					//alert("validation: "+thisElement.name);

					// cleanup the validate string
					validateItem.value = gSeparator + validateItem.value + gSeparator;

					// do the focus check, set focus on this item if specified
					if (validateItem.value.match(gSeparator+"focus"+gSeparator)) {
						thisElement.focus();
						// handle focus only
						if (validateItem.value == gSeparator+"focus"+gSeparator) {
							validateItem.value = "";
						}
					}

					// handle the different element types & check for multiple checkbox validation
					if (thisElement.type.toLowerCase() == "radio" || 
							validateItem.value.match(gSeparator+"multiple"+iSeparator)) {
						// have to handle radiobuttons in a special way
						// multiple checkboxes are marked the same way

						// if this is the first button in this set then process, otherwise skip it
						var thisItems = document.getElementsByName(thisElement.name);
						if (thisElement == thisItems[0]) {
							var k = 0;
							if (thisItems.length == 1) {
								// only one so set the id and move on
								thisElement.id = thisElement.name;
							} else {
								// put this in the multipleCheckItems array if it multiple
								if (validateItem.value.match(gSeparator+"multiple"+iSeparator)) {
									multipleCheckItems.push(thisElement.name);
								}

								// multiple items so set id by position encountered
								for (var j=0; j<thisItems.length; j++) {
									thisItems[j].id = thisElement.name + j;
									if (thisItems[j].checked) { k = j; } // marked the checked item
								}
							}
							// do validate on one of the buttons only
							//alert("matched:" + k + ":" + thisItems[k].id);
							if (gInitialCheck) { validateObject(thisItems[k]); }
						}
					} else {
						thisElement.id = thisElement.name; // set the id to the name
						//alert("validation: "+thisElement.id+":"+thisElement.name);
						// do the initial validation check
						if (gInitialCheck) { validateObject(thisElement); }
					}

					// attach handlers to items
					if (thisElement.type.toLowerCase() == "radio" || thisElement.type.toLowerCase() == "checkbox") {
						// attach onclick handlers to checkboxes and radio buttons
						thisElement.onclick = function(){return validateObject(this);}
					} else {
						//attach the onchange to each form field
						thisElement.onchange = function(){return validateObject(this);}
						//thisElement.onblur = function(){return validateObject(this);}

						// handle "other" fields
						var otherItem = document.getElementById(thisElement.name + "Other");
						if (otherItem != null) {
							otherItem.onchange = function(){return validateObject(this);}
						}
					}
					
					// attach handlers to images or text
					if(vUseImages) {
						var imgObject=document.getElementById(thisElement.name + "Img");
						if (imgObject != null) {
							imgObject.onclick = function(){return validateImg(this);}
						}
					} else if(gUseText) {
						var msgObject=document.getElementById(thisElement.name + "Msg");
						if (msgObject != null) {
							msgObject.onclick = function(){return validateMsg(this);}
						}
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
			if(vUseImages) {
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



function clearAllPopDivs() {
	// TODO - do something
}

function getMouseCoords(e) {
	// get the mouse position in a browser safe way
	var e = window.event;
	if (e.pageX || e.pageY) {
		mousePosX = e.pageX;
		mousePosY = e.pageY;
	} else if (e.clientX || e.clientY) {
		mousePosX = e.clientX + document.body.scrollLeft;
		mousePosY = e.clientY + document.body.scrollTop;
	}
}

function findPosX(obj) {
    var curleft = 0;
    if (obj.offsetParent) {
        while (1) {
            curleft+=obj.offsetLeft;
            if (!obj.offsetParent) { break; }
            obj=obj.offsetParent;
        }
    } else if (obj.x) {
        curleft+=obj.x;
    }
    return curleft;
}

function findPosY(obj) {
    var curtop = 0;
    if (obj.offsetParent) {
        while (1) {
            curtop+=obj.offsetTop;
            if (!obj.offsetParent) { break; }
            obj=obj.offsetParent;
        }
    } else if (obj.y) {
        curtop+=obj.y;
    }
    return curtop;
}


function showPopDiv(activatorItem) {
	// show the item on the page with this id
	var item = document.getElementById(activatorItem.id.replace("Activate",""));
	if (item == null) {
		alert("showPopDiv: Cannot find item by id: "+itemId);
		return false;
	}

	// browser safe window width and height
	var winWidth = 0, winHeight = 0;
	if( typeof( window.innerWidth ) == 'number' ) {
		//Non-IE
		winWidth = window.innerWidth;
		winHeight = window.innerHeight;
	} else if( document.documentElement && ( document.documentElement.clientWidth || document.documentElement.clientHeight ) ) {
		//IE 6+ in 'standards compliant mode'
		winWidth = document.documentElement.clientWidth;
		winHeight = document.documentElement.clientHeight;
	} else if( document.body && ( document.body.clientWidth || document.body.clientHeight ) ) {
		//IE 4 compatible
		winWidth = document.body.clientWidth;
		winHeight = document.body.clientHeight;
	}

	// width = activatorItem.offsetWidth;
	// height = activatorItem.offsetHeight;

	// setting the look if not already done
    if(!item.style.backgroundColor) item.style.backgroundColor = "white";
	if(!item.style.textAlign) item.style.textAlign = "left";
	if(!item.style.border) item.style.border = "3px solid #999999";
	if(!item.style.width) item.style.width = defaultPopWidth + "px";

	// get position for the popdiv from the activator
	var posX = findPosX(activatorItem);
	var origX = posX;

	var posY = findPosY(activatorItem);
	var origY = posY;

	// handle any params
	var fixX = 0, fixY = 0;
	var paramsItem = document.getElementById(item.id+"Params");
	if (paramsItem != null) {
		var params = paramsItem.value.split(gSeparator);
		paramsItem.value = ""; // clear the params
		for(var j=0; j<params.length; j++) {
			if(params[j] == "") { continue; } // skip blank
			if(params[j].match("header" + iSeparator + ".*")) {
				// handle the header request
				var splitItems = params[j].split(iSeparator);
				item.innerHTML = "<div style='color:white;background:darkblue;padding:2px;font-weight:bold;'>" +
					splitItems[1] + "</div><div style='padding:2px;'>" + item.innerHTML + "</div>";
			} else if(params[j].match("fixX" + iSeparator + ".*")) {
				// this allows us to make absolute div positioning work
				// if trapped in a parent container
				var splitItems = params[j].split(iSeparator);
				fixX = splitItems[1];
				paramsItem.value += params[j] + gSeparator;
			} else if(params[j].match("fixY" + iSeparator + ".*")) {
				// this allows us to make absolute div positioning work
				// if trapped in a parent container
				var splitItems = params[j].split(iSeparator);
				fixY = splitItems[1];
				paramsItem.value += params[j] + gSeparator;
			} else if(params[j].match("ajax" + iSeparator + ".*")) {
				// TODO: handle the AJAX request
				paramsItem.value += params[j] + gSeparator;
			} else {
				// do nothing
			}
		}
	}

	// try to correct for being too close to the edges
	if ( posX > (winWidth * 0.52) ) { // move it to the left
		itemWidth = item.style.width.replace(/px|em/,"");
		if (isNaN(itemWidth)) { itemWidth = defaultPopWidth; }
		posX = posX - itemWidth - 20;
	} else { // move to the right edge+
		posX += activatorItem.offsetWidth + 10;
	}
	posX = posX - fixX;

	if ( posY > (winHeight * 0.80) ) { // move it up
		posY = (winHeight * 0.65);
	} else if (posY < 50) { // move it down
		posY = posY + 50;
	} else {
		posY = posY - 20;
	}
	posY = posY - fixY;

	//alert("x:"+posX+"y:"+posY+" ww:"+(winWidth * 0.52));

	// settings for visibility of the object
	item.style.position = "absolute";
	item.style.zIndex = "999999999";
    item.style.filter = "alpha(opacity=100)";
	item.style.top = posY + "px";
	item.style.left = posX + "px";
	item.style.display = "";
	item.style.visibility = "visible";
}

function hidePopDiv(activatorItem) {
	// hide the item on the page with this id
	var item = document.getElementById(activatorItem.id.replace("Activate",""));
	if (item == null) {
		alert("showPopDiv: Cannot find item by id: "+itemId);
		return false;
	}

	item.style.display = "none";
	item.style.visibility = "hidden";
}

function attachPopDivHandlers() {
	var divs = document.getElementsByTagName('div');
	for (var i = 0; i < divs.length; i++) {
		var thisElement = divs.item(i);
		if (thisElement.id) {
			var activatorItem = document.getElementById(thisElement.id + "Activate");
			if (activatorItem != null) {
				//alert("Found pop div: "+thisElement.id);
				thisElement.style.display = "none"; // hide it in case it is not already hidden
				var itemId = thisElement.id;
				activatorItem.onmouseover = function(){return showPopDiv(this);}
				activatorItem.onmouseout = function(){return hidePopDiv(this);}
			}
		}
	}
	document.getElementsByTagName("body").item(0).onclick = function(){return clearAllPopDivs();}
}

// attach the handlers to the form
function attachFormHandlers(){
	attachValidateHandlers();
	attachPopDivHandlers();
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

// This is the way to create the new XMLHttpRequest object (must use () at end of function)
//var http = createRequestObject();

// simple passthroughs to the validateObject call
// allows a validate to be called from its Img
function validateImg(objInput) {
	var mainObject=document.getElementById(objInput.id.replace("Img",""));
	if (mainObject != null) {
		return validateObject(mainObject);
	}
	return false;
}

// allows a validate to be called from its Msg
function validateMsg(objInput) {
	var mainObject=document.getElementById(objInput.id.replace("Msg",""));
	if (mainObject != null) {
		return validateObject(mainObject);
	}
	return false;
}


//Called with event triggers, this does the basic required validation and 
//passes other validation to the server side script via the AJAX call
// Validation Rules: (not comprehensive)
// required (must be the first rule always)
// text validation rules (ie. email, date, time)
// special validation rules (ie. unique)
function validateObject(objInput) {
	var localCheck = false;
	var localText = "";
	//alert("valuecheck: "+objInput.id+" ("+objInput.id+") = "+objInput.value);

	// do the "other" checking first
	if (vUseOther) {
		var otherItem = document.getElementById(objInput.name + "Other");
		if (!objInput.name) {
			otherItem = document.getElementById(objInput.id + "Other");
		}
		if (otherItem != null && otherItem != objInput) {
			// this is original with an other item
			if (objInput.value == vOtherCode) {
				// switch to the other item
				otherItem.style.display = "";
				otherItem.name = objInput.name;
				objInput.style.backgroundColor = "#CCCCCC";
				objInput.name = "";
				// reset object to the current item
				objInput = otherItem;
				objInput.focus();
			} else {
				// if the other item is visible then switch
				if (otherItem.style.display != "none") {
					// switch back to the original item
					objInput.style.backgroundColor = "";
					objInput.name = otherItem.name;
					otherItem.style.display = "none";
					otherItem.name = "";
				}
			}
		}
	}


	// get the validation item for this object
	var validateItem = document.getElementById(objInput.name + "Validate");
	if (validateItem == null) { // items without a validator should not be sent here
		alert("ERROR: Failed to get validate item for name:" + objInput.name + ":" + objInput.id);
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

	// setup the isReq variable
	var isRequired = validateItem.value.match(gSeparator + "required" + gSeparator);
	var reqMessage = "Required";

	// special multiple checkbox handling if there are multiple items
	if (validateItem.value.match(gSeparator+"multiple"+iSeparator)) {
		isRequired = true;
		var thisItems = document.getElementsByName(objInput.name);
		if (thisItems.length > 1) {
			// get the required number of items checked
			var startSub = validateItem.value.indexOf(gSeparator+"multiple"+iSeparator) + 
				(gSeparator+"multiple"+iSeparator).length;
			var multiValue = validateItem.value.substring(startSub, 
				validateItem.value.indexOf(gSeparator, startSub));

			// make sure this is a natural number or reassign it
			if (multiValue.match(/^[0-9]*$/) == null) { multiValue = 1; }

			// multiple items so loop through them
			var k=0;
			for (var j=0; j<thisItems.length; j++) {
				if (thisItems[j].checked) { k++; }
			}

			reqMessage = "Select at least " + multiValue;
			if (k < multiValue) {
				isBlank = true;
			} else {
				isBlank = false;
			}
		}
	}

	// now do the required check
	if (isBlank) {
		if (isRequired) {
			if(gRequiredText) {
				markField(gFail, objInput.id, textReq, true, gInitialCheck);
			} else {
				markField(gFail, objInput.id, reqMessage, false, gInitialCheck);
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

	// loop through the validation checks
	var vFields = validateItem.value.split(gSeparator);
	var i = 1;
    var vParams = ""; //  stores the params in get string ready form
	for(var j=0; j<vFields.length; j++) {
		var field = vFields[j];
		if(field == "required" || field == "focus" || field == "") {
			continue;
		} else if (field == "password" || field == "nospaces") {
			// now do a nospaces or password check
			if (objInput.value.match(/[\s]/g)) {
				// found spaces
				markField(gFail, objInput.id, "Invalid: no spaces allowed", true, gInitialCheck);
				return false;
			} else {
				localCheck = true; // passed the local check
				localText = "Valid password";
				continue;
			}
		} if (field.match("match" + iSeparator)) {
			// now do a matching check
			var splitItems = field.split(iSeparator);
			var matchItem = document.getElementById(splitItems[1]);
			if (matchItem != null) {
				if(matchItem.value == objInput.value) {
					localCheck = true; // passed the local check
					localText = "Items match";
					continue;
				} else {
					markField(gFail, objInput.id, "Invalid: items do not match", true, gInitialCheck);
					return false;
				}
			} else {
				alert("Invalid match itemId: " + matchId);
				return false;
			}
		}

		// take unhandled validations and pass them on
		vParams = vParams + "&rule" + i + "=" + encodeURIComponent(field);
		i++;
	}

	var vVal = encodeURIComponent(objInput.value); // encode value inside of input field

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
	var vUrl = ajaxValidateUrl + "&id=" + objInput.id + "&val="+ vVal + vParams;
	//alert("sending: " + vUrl);
	var http = createRequestObject(); // create the http object
	http.open("GET", vUrl, true);
	// assign the function dynamically
	http.onreadystatechange = function () {
		// handle the response from the validation page
		// proper format is passId|elementId|textMessage
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
	return true; // true if sent to the server
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
			// if the validation value is blank then skip this item
			if (validateItem.value == "") { continue; }

			if (validateItem.className == gPass) {
				// Mark field as passed
				markField(gPass, items[i].id, "", false, false);
			} else if (validateItem.className == gClear) {
				// Reset field to initial state
				markField(gClear, items[i].id, "", false, false);
			} else {
				// assume failure if pass not found
				//alert("Failure found: " + items[i].name + ":" + validateItem.className);
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
		// no errors so rename the multiple checkboxes
		for (var k in multipleCheckItems) {
			var thisItems = document.getElementsByName(multipleCheckItems[k]);
			if (thisItems.length > 1) {
				var itemsRenames = new Array();

				// put the items ids in an array first
				var itemsArray = new Array();
				for (var j=0; j<thisItems.length; j++) {
					itemsArray.push(thisItems[j].id);
					itemsRenames.push(j + 1); // default rename values
				}

				// try to get the rename elements and put them in the array
				var renameObject = document.getElementById(multipleCheckItems[k] + "Rename");
				if (renameObject != null) {
					var splitResult = renameObject.value.split(gSeparator);
					for (var x=0; x<itemsArray.length; x++) {
						itemsRenames[x] = splitResult[x];
					}
				}

				// we have to have an extra array like this because the items are removed
				// from the elements array when they are renamed in firefox
				for (var x in itemsArray) {
					var itemToRename = document.getElementById(itemsArray[x]);
					itemToRename.name = itemToRename.name + itemsRenames[x];
				}
			}
		}
		// submit the form
		return true;
	}
}
