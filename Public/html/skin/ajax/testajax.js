var problemArray = new Array();

function dispSubmit(field,action){
    if(problemArray.length != 0){
        for(var i = 0; i < problemArray.length; i++){
            if(problemArray[i] == field){    
                place = i;
                break;
            }else{
                place = -12;
            }
        }
    }else{
        place = -50;
    }
    if(action == "add" && place < 0){
        problemArray.splice(problemArray.length,0,field);
    }else if(action == "remove" && place >= 0){
        problemArray.splice(place,1);
    }
     <!--DISPLAY ERROR OR SUBMIT BUTTION-->
    if(problemArray.length != 0){
        document.getElementById('submitholder').innerHTML = "There seems to be a problem with one or more of your fields";
    }else{
        document.getElementById('submitholder').innerHTML = '<input type="submit" name="Submit" value="Submit" />';
    }
} 


<!--TRIM ALL LEADING AND FOLLOWING WHITESPACE IN A STRING-->
function trimString (str) {
  return str.replace(/^s+/g, '').replace(/s+$/g, '');
}

<!--HIGHLIGHT EMPTY FIELDS THAT ARE REQUIRED-->
function hiliteRequired(startValFROM,place){
    <!--DEFINE THE ID'S OF THE REQUIRED FIELDS-->
    var requiredFields = new Array()
        requiredFields[0] = "userfield"
        requiredFields[1] = "emailfield"
        requiredFields[2] = "testfield"
        requiredFields[3] = "testoption"
    
    var pos = requiredFields.length;
    for(var i = 0; i < requiredFields.length; i++){
        if(requiredFields[i] == startValFROM){
            pos = i;
        }else{
            if (pos > place){
                pos = place;
            }else{
                pos = pos;
            }
        }
    }
    <!--HIGHLIGHT EMPTY FIELDS-->
    for(var x = 0; x < pos; x++){
        if(trimString(document.getElementById(requiredFields[x]).value) == ""){
            document.getElementById(requiredFields[x]).className = 'skipped';
            dispSubmit(requiredFields[x],'add');
        }else if(document.getElementById(requiredFields[x]).className != "error"){
            document.getElementById(requiredFields[x]).className = 'noclass';
            dispSubmit(requiredFields[x],'remove');
        }
    }
    <!--FIX FOR IF THE USER WERE TO NAVIGATE THE FORM IN REVERSE-->
    for(var y = 0; y < requiredFields.length; y++){
        if(trimString (document.getElementById(requiredFields[y]).value) != "" && document.getElementById(requiredFields[y]).className != "error"){
            document.getElementById(requiredFields[y]).className = 'noclass';
            dispSubmit(requiredFields[y],'remove');
        }
    }
}


<!--AJAX-->
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

function validateForm(txtfield){
    var url = 'testajax.php?field=';
    var url2;
    var username = document.getElementById('userfield').value;
    var email = document.getElementById('emailfield').value;
    
    if (txtfield == "userfield"){
        url2 = txtfield+unescape("%26userfield=")+username;
    }else if(txtfield == "emailfield"){
        url2 = txtfield+unescape("%26emailfield=")+email;
    }

    url += url2;
    http.open('get', url);
    http.onreadystatechange = handleResponse;
    http.send(null);
}

function handleResponse() {
    if(http.readyState == 4){
        var response = http.responseText;
        var UPDATE = new Array();
        <!--LOOP THROUGH THE RESPONSES-->
        if(response.indexOf('|' != -1)) {
            UPDATE = response.split('|');
            if(UPDATE[1] != '!error'){
                document.getElementById(UPDATE[0]).className = 'error';
                document.getElementById(UPDATE[0]+'_container').innerHTML = UPDATE[1];
                dispSubmit(UPDATE[0],'add');
            }else if(UPDATE[1] == '!error'){
                if(document.getElementById(UPDATE[0]).className != 'skipped'){
                    document.getElementById(UPDATE[0]).className = 'noclass';
                }
                document.getElementById(UPDATE[0]+'_container').innerHTML = "";
                if(trimString(document.getElementById(UPDATE[0]+'_container').value) != ""){
                    dispSubmit(UPDATE[0],'remove');
                }
            }
        }
    }
}
<!--END AJAX--> 
