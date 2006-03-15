<SCRIPT language="Javascript1.2">
<!--


var isNS = (navigator.appName == "Netscape");
layerRef = (isNS) ? "document" : "document.all";
styleRef = (isNS) ? "" : ".style";

var queue = new Array();

var NUM_OF_TRAIL_PARTS = 5

for (x=1; x < 6; x++) {
	eval("trailSpriteFrame" + x + " = new Image(28,36);");
	eval("trailSpriteFrame" + x + ".src = 'trailgif" + x + ".gif';");
}


function trailSpriteObj(anID) {
	this.trailSpriteID = "trailSprite" + anID;
	this.imgRef = "trailSprite" + anID + "img";
	this.currentFrame = 1;
	this.animateTrailSprite = animateTrailSprite;
}

function animateTrailSprite() {
	if (this.currentFrame <6 ) {
		if (isNS) {
			eval("document." + this.trailSpriteID +".document['"+ this.imgRef + "'].src  =  trailSpriteFrame" + this.currentFrame + ".src");
		} else {
			eval("document['" + this.imgRef + "'].src  =  trailSpriteFrame" + this.currentFrame + ".src");
		}
		this.currentFrame ++;
	} else {
		eval(layerRef + '.' + this.trailSpriteID +  styleRef + '.visibility = "hidden"');
	}
}



function processAnim() {
	for(x=0; x < NUM_OF_TRAIL_PARTS; x++)
			queue[x].animateTrailSprite();
}

function processMouse(e) {
	currentObj = shuffleQueue();
	if (isNS) {
		eval("document." + currentObj + ".left = e.pageX - 10 ;");
		eval("document." + currentObj + ".top = e.pageY + 10;");
	} else {
		eval("document.all." + currentObj + ".style.pixelLeft = event.clientX + document.body.scrollLeft - 10 ;");
		eval("document.all." + currentObj + ".style.pixelTop = event.clientY + document.body.scrollTop + 10;");
	}
}

function shuffleQueue() {
	lastItemPos = queue.length - 1;
	lastItem = queue[lastItemPos];
	for (i = lastItemPos; i>0; i--)
		queue[i] = queue[i-1];
	queue[0] = lastItem;

	queue[0].currentFrame = 1;
	eval(layerRef + '.' + queue[0].trailSpriteID +  styleRef + '.visibility = "visible"');

	return 	queue[0].trailSpriteID;
}

function init() {

	for(x=0; x<NUM_OF_TRAIL_PARTS; x++)
		queue[x] = new trailSpriteObj(x+1) ;

	if (isNS) { document.captureEvents(Event.MOUSEMOVE); }
	document.onmousemove = processMouse;

	setInterval("processAnim();",25);
}
if (document.all||document.layers)
window.onload = init;

//-->
</SCRIPT>