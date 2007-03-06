///////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////
//                                                      ///////
//                        Wasp                          ///////
//                     Version 2.0                      ///////
//       (Formerly known as: Wimpy AV Single Play)      ///////
//                                                      ///////
//         by Mike Gieson <info@wimpyplayer.com>        ///////
//                                                      ///////
//        Available at http://www.wimpyplayer.com       ///////
//                 ©2002-2006 plaino                    ///////
//                                                      ///////
///////////////////////////////////////////////////////////////
//
// This product includes software developed by Macromedia, Inc.
// 
// Macromedia(r) Flash(r) JavaScript Integration Kit
// Portions noted as part of the JavaScript Integration Kit
// are Copyright (c) 2005 Macromedia, inc. All rights reserved.
// http://www.macromedia.com/go/flashjavascript/
// 
// Macromedia(r) Flash(r) JavaScript Integration Kit Created by:
// 
// Christian Cantrell
// http://weblogs.macromedia.com/cantrell/
// mailto:cantrell@macromedia.com
// 
// Mike Chambers
// http://weblogs.macromedia.com/mesh/
// mailto:mesh@macromedia.com
// 
// Macromedia
// 
/////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////
////////////                                     ////////////
////////////              OPTIONS                ////////////
////////////                                     ////////////
/////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////
//
// Set locations of files:
// 
// waspSWFfilename
// You can change the name of the wasp.swf file here.
// Obviously, if you change the name here, then you will have to 
// change the name of the actual file in your wasp folder too.
waspSWFfilename = "wasp.swf";
//
// Default Image:
// 
// defaultImage
// Allows you to set a default graphic if the player is does not 
// startOnLoad automatically. Also, if the player is not set to 
// loop, the image defined here will show up once the video is complete.
// 
// The graphic will automatically be size to the same dimensions as the video window.
// When the image is clicked the video current video (if defined) will start to play.
//
// Example:
//defaultImage = "http://www/path/to/graphic.jpg";
defaultImage = "video_cover.jpg";
//
// waspHTMLtemplateFilename
// This is the page that is used when a pop up window is called. 
// This file should be located in the wasp installation folder.
// You can change the name of the waspTemplate.html file here.
// Obviously, if you change the name here, then you will have to 
// change the name of the actual file in your wasp folder too.
waspHTMLtemplateFilename = "waspPopup.html";
//
// startPlayingOnload
// Setting this to "yes" will start to play automatically.
// Setting this to "no" will force the user to click the 
// "play" button to start playing the video
//startPlayingOnload = "no";
startPlayingOnload = "yes";
//
// transparentBkgd 
// This will anable you to "see through" the player and display 
// the HTML (or table) backgournd image or color.
transparentBkgd = "yes";
//
// bkgdColor
// If not using a transparent background, this will be the 
// background color of the video window.
bkgdColor = "#000000";
//
// popUpHelp
// Setting this to "yes" will display little yellow "help" 
// boxes when the user hoovers over the control functions.
// Setting this to "no" will disable this feature.
popUpHelp = "yes";
//
// loopTrack
// Setting thei to "yes" will cause the video to repeat 
// once it has reached the end, and continue to loop 
// until the user clicks stop.
// Setting this to "no" will cause the video to 
// disappear once it has finished. 
loopTrack = "no";
//
// theVolume
// You can controll the initial volume setting when 
// the player loads. The range is 0-100, where 0 is 
// no sound and 100 is full volume
theVolume = "100";
//
// controllocation
// You can place the playback controls above or below 
// the video. To place the controls above the video, 
// set this to "top" - to place the controls below the video, 
// set this to "bottom"
//controllocation = "top";
controllocation = "bottom";
//
// bufferSeconds
// Causes the video to load for a certain number of seconds 
// before starting to play. A higher value can minimize the 
// "stutter" effect users might have with slower connections, 
// or larger files.
bufferSeconds = 3;
//
// videoSmoothing
// Specifies whether the video should be smoothed 
// (interpolated) when it is scaled.
//videoSmoothing = "yes";
videoSmoothing = "no";
//
// videoDeblocking
// Setting this to "yes" can degrade overall playback performance 
// for less powerful PCs. Leave at "" to allow the end user's 
// system to manage the filter automatically.
//videoDeblocking = "yes";
//videoDeblocking = "no";
videoDeblocking = "";
//
//
/////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////
////////////                                     ////////////
////////////   NO FURTHER CONFIGURATION NEEDED   ////////////
////////////                                     ////////////
/////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////
////////////                                     ////////////
////////////     IN OTHER WORDS, DON'T EDIT      ////////////
////////////     ANYTHING BELOW HERE UNLESS      ////////////
////////////   YOU'RE FAMILIAR WITH JAVASCRIPT   ////////////
////////////                                     ////////////
/////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////
//
function waspPopup (filename, width, height){
	var rnum = (Math.round((Math.random()*1000000)+1));
	var padControls = height+15
	var theURL = waspHTMLtemplateFilename+'?theFile='+filename+'&wW='+width+'&wH='+padControls;
	var winName = 'wasp'+rnum;
	var extras = 'width='+width+',height='+padControls
	window.open(theURL,winName,extras);
}
function writeSWFcode(fileSWF, fileIN, theWidth, theHeight){
	//
	myuid = new Date().getTime();
	myuid = "wasp" + myuid
	flashProxy = new FlashProxy(myuid, waspSWFfilename);
	//
	var perpix = new String(theHeight);
	if(perpix.indexOf("%") > (-1)){
		var padControls = theHeight;
	} else {
		var padControls = theHeight+15;
	}
	var queryString = '';
	queryString += "theFile="+fileIN;
	//
	js2wasp_param = '<param name="flashvars" value="lcId='+myuid+'"/>';
	js2wasp_embed = 'flashvars="lcId='+myuid+'" ';
	//
	if(transparentBkgd == "yes"){
		var tptBkgd_param = '<param name="wmode" value="transparent" />';
		var tptBkgd_embed = 'wmode="transparent" ';
	} else {
		var tptBkgd_param = "";
		var tptBkgd_embed = "";
	}
	if(startPlayingOnload == "yes"){
		queryString += '&startPlayingOnload='+startPlayingOnload;
	}
	if(popUpHelp == "no"){
		queryString += '&popUpHelp='+popUpHelp;
	}
	if(loopTrack == "yes"){
		queryString += '&loopTrack='+loopTrack;
	}
	if(controllocation == "top"){
		queryString += '&controllocation='+controllocation;
	}
	if(theVolume != 100 && theVolume > 0 && theVolume < 100){
		queryString += '&theVolume='+theVolume;
	}
	if(bufferSeconds > 3){
		queryString += '&bufferSeconds='+bufferSeconds;
	}
	if(defaultImage != ""){
		queryString += '&defaultImage='+defaultImage;
	}
	if(videoDeblocking == "yes" || videoDeblocking == "no"){
		queryString += "&videoDeblocking="+videoDeblocking;
	}
	if(videoSmoothing == "yes"){
		queryString += "&videoSmoothing="+videoSmoothing;
	}
	var flashCode = '';
	var newlineChar = "\n";
	flashCode += '<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab// - version=7,0,0,0" width="'+theWidth+'" height="'+padControls+'" name="'+myuid+'" id="'+myuid+'">'+newlineChar;
	flashCode += '<param name="movie" value="'+fileSWF+'?'+queryString+'" />'+newlineChar;
	flashCode += '<param name="loop" value="false" />'+newlineChar;
	flashCode += '<param name="menu" value="false" />'+newlineChar;
	flashCode += '<param name="quality" value="high" />'+newlineChar;
	flashCode += '<param name="scale" value="noscale" />'+newlineChar;
	flashCode += '<param name="salign" value="lt" />'+newlineChar;
	flashCode += '<param name="bgcolor" value="'+bkgdColor+'" />'+newlineChar;
	flashCode += tptBkgd_param;
	flashCode += js2wasp_param;
	flashCode += '<embed src="'+fileSWF+'?'+queryString+'" width="'+theWidth+'" height="'+padControls+'" bgcolor="'+bkgdColor+'" loop="false" menu="false" quality="high" scale="noscale" salign="lt" id="'+myuid+'" align="middle" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" '+tptBkgd_embed+js2wasp_embed+'/></object>'+newlineChar;
	// To reveal the source HTML, uncomment below:
	//document.write('<br><textarea name="textarea" cols="40" rows="10">'+flashCode+'</textarea><br>')+newlineChar;
	document.write(flashCode);
}
function wasp(){
	startPlayingOnload = "yes";
	var qsParm = new Array();
	var query = window.location.search.substring(1);
	var parms = query.split('&');
	for (var i=0; i<parms.length; i++) {
		var pos = parms[i].indexOf('=');
		if (pos > 0) {
			var key = parms[i].substring(0,pos);
			var val = parms[i].substring(pos+1);
			qsParm[key] = val;
		}
	}
	var fileSWFsend = waspSWFfilename;
	var fileINsend = qsParm['theFile'];
	writeSWFcode(fileSWFsend, fileINsend, "100%", "100%");
}
function waspEmbed(theFileIN, theWidthIN, theHeightIN){
	var fileSWFsend = waspSWFfilename;
	var fileINsend = theFileIN;
	writeSWFcode(fileSWFsend, fileINsend, theWidthIN, theHeightIN);
}
function wasp_loadAndPlay(theFileIN){
	flashProxy.call('js_wasp_loadAndPlay', theFileIN);
}
/*
The following code is part of the Flash / JavaScript Integration Kit:
http://www.macromedia.com/go/flashjavascript/
*/
function Exception(name, message){
    if (name)
        this.name = name;
    if (message)
        this.message = message;
}
Exception.prototype.setName = function(name){
    this.name = name;
}
Exception.prototype.getName = function(){
    return this.name;
}
Exception.prototype.setMessage = function(msg){
    this.message = msg;
}
Exception.prototype.getMessage = function(){
    return this.message;
}
function FlashProxy(uid, proxySwfName){
    this.uid = uid;
    this.proxySwfName = proxySwfName;
    this.flashSerializer = new FlashSerializer(false);
}
FlashProxy.prototype.call = function(){
    if (arguments.length == 0)
    {
        throw new Exception("Flash Proxy Exception",
                            "The first argument should be the function name followed by any number of additional arguments.");
    }
    var qs = 'lcId=' + escape(this.uid) + '&functionName=' + escape(arguments[0]);
    if (arguments.length > 1)
    {
        var justArgs = new Array();
        for (var i = 1; i < arguments.length; ++i)
        {
            justArgs.push(arguments[i]);
        }
        qs += ('&' + this.flashSerializer.serialize(justArgs));
    }
    var divName = '_flash_proxy_' + this.uid;
    if(!document.getElementById(divName))
    {
        var newTarget = document.createElement("div");
        newTarget.id = divName;
        document.body.appendChild(newTarget);
    }
    var target = document.getElementById(divName);
    var ft = new FlashTag(this.proxySwfName, 1, 1);
    ft.setVersion('6,0,65,0');
    ft.setFlashvars(qs);
    target.innerHTML = ft.toString();
}
FlashProxy.callJS = function(){
    var functionToCall = eval(arguments[0]);
    var argArray = new Array();
    for (var i = 1; i < arguments.length; ++i)
    {
        argArray.push(arguments[i]);
    }
    functionToCall.apply(functionToCall, argArray);
}
function FlashSerializer(useCdata){
    this.useCdata = useCdata;
}
FlashSerializer.prototype.serialize = function(args){
    var qs = new String();

    for (var i = 0; i < args.length; ++i)
    {
        switch(typeof(args[i]))
        {
            case 'undefined':
                qs += 't'+(i)+'=undf';
                break;
            case 'string':
                qs += 't'+(i)+'=str&d'+(i)+'='+escape(args[i]);
                break;
            case 'number':
                qs += 't'+(i)+'=num&d'+(i)+'='+escape(args[i]);
                break;
            case 'boolean':
                qs += 't'+(i)+'=bool&d'+(i)+'='+escape(args[i]);
                break;
            case 'object':
                if (args[i] == null)
                {
                    qs += 't'+(i)+'=null';
                }
                else if (args[i] instanceof Date)
                {
                    qs += 't'+(i)+'=date&d'+(i)+'='+escape(args[i].getTime());
                }
                else // array or object
                {
                    try
                    {
                        qs += 't'+(i)+'=xser&d'+(i)+'='+escape(this._serializeXML(args[i]));
                    }
                    catch (exception)
                    {
                        throw new Exception("FlashSerializationException",
                                            "The following error occurred during complex object serialization: " + exception.getMessage());
                    }
                }
                break;
            default:
                throw new Exception("FlashSerializationException",
                                    "You can only serialize strings, numbers, booleans, dates, objects, arrays, nulls, and undefined.");
        }

        if (i != (args.length - 1))
        {
            qs += '&';
        }
    }

    return qs;
}
FlashSerializer.prototype._serializeXML = function(obj){
    var doc = new Object();
    doc.xml = '<fp>'; 
    this._serializeNode(obj, doc, null);
    doc.xml += '</fp>'; 
    return doc.xml;
}
FlashSerializer.prototype._serializeNode = function(obj, doc, name){
    switch(typeof(obj))
    {
        case 'undefined':
            doc.xml += '<undf'+this._addName(name)+'/>';
            break;
        case 'string':
            doc.xml += '<str'+this._addName(name)+'>'+this._escapeXml(obj)+'</str>';
            break;
        case 'number':
            doc.xml += '<num'+this._addName(name)+'>'+obj+'</num>';
            break;
        case 'boolean':
            doc.xml += '<bool'+this._addName(name)+' val="'+obj+'"/>';
            break;
        case 'object':
            if (obj == null)
            {
                doc.xml += '<null'+this._addName(name)+'/>';
            }
            else if (obj instanceof Date)
            {
                doc.xml += '<date'+this._addName(name)+'>'+obj.getTime()+'</date>';
            }
            else if (obj instanceof Array)
            {
                doc.xml += '<array'+this._addName(name)+'>';
                for (var i = 0; i < obj.length; ++i)
                {
                    this._serializeNode(obj[i], doc, null);
                }
                doc.xml += '</array>';
            }
            else
            {
                doc.xml += '<obj'+this._addName(name)+'>';
                for (var n in obj)
                {
                    if (typeof(obj[n]) == 'function')
                        continue;
                    this._serializeNode(obj[n], doc, n);
                }
                doc.xml += '</obj>';
            }
            break;
        default:
            throw new Exception("FlashSerializationException",
                                "You can only serialize strings, numbers, booleans, objects, dates, arrays, nulls and undefined");
            break;
    }
}
FlashSerializer.prototype._addName= function(name){
    if (name != null)
    {
        return ' name="'+name+'"';
    }
    return '';
}
FlashSerializer.prototype._escapeXml = function(str){
    if (this.useCdata)
        return '<![CDATA['+str+']]>';
    else
        return str.replace(/&/g,'&amp;').replace(/</g,'&lt;');
}
function FlashTag(src, width, height){
    this.src       = src;
    this.width     = width;
    this.height    = height;
    this.version   = '7,0,14,0';
    this.id        = null;
    this.bgcolor   = 'ffffff';
    this.flashVars = null;
}
FlashTag.prototype.setVersion = function(v){
    this.version = v;
}
FlashTag.prototype.setId = function(id){
    this.id = id;
}
FlashTag.prototype.setBgcolor = function(bgc){
    this.bgcolor = bgc;
}
FlashTag.prototype.setFlashvars = function(fv){
    this.flashVars = fv;
}
FlashTag.prototype.toString = function(){
    var ie = (navigator.appName.indexOf ("Microsoft") != -1) ? 1 : 0;
    var flashTag = new String();
    if (ie)
    {
        flashTag += '<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" ';
        if (this.id != null)
        {
            flashTag += 'id="'+this.id+'" ';
        }
        flashTag += 'codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version='+this.version+'" ';
        flashTag += 'width="'+this.width+'" ';
        flashTag += 'height="'+this.height+'">';
        flashTag += '<param name="movie" value="'+this.src+'"/>';
        flashTag += '<param name="quality" value="high"/>';
        flashTag += '<param name="bgcolor" value="#'+this.bgcolor+'"/>';
        if (this.flashVars != null)
        {
            flashTag += '<param name="flashvars" value="'+this.flashVars+'"/>';
        }
        flashTag += '</object>';
    }
    else
    {
        flashTag += '<embed src="'+this.src+'" ';
        flashTag += 'quality="high" '; 
        flashTag += 'bgcolor="#'+this.bgcolor+'" ';
        flashTag += 'width="'+this.width+'" ';
        flashTag += 'height="'+this.height+'" ';
        flashTag += 'type="application/x-shockwave-flash" ';
        if (this.flashVars != null)
        {
            flashTag += 'flashvars="'+this.flashVars+'" ';
        }
        if (this.id != null)
        {
            flashTag += 'name="'+this.id+'" ';
        }
        flashTag += 'pluginspage="http://www.macromedia.com/go/getflashplayer">';
        flashTag += '</embed>';
    }
    return flashTag;
}
FlashTag.prototype.write = function(doc){
    doc.write(this.toString());
}
