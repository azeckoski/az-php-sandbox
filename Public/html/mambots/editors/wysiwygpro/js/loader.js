function wp_initAll() {
	var editors = document.getElementsByTagName("TEXTAREA")
	for (var i=0; i<editors.length; i++) {
		if (editors[i].className == "wpHtmlEditArea") {
			wp_editor(editors[i],eval("config_"+editors[i].id))
		}
	}
}
if (window.addEventListener) {
	window.addEventListener('load', wp_initAll, false)
} else if (window.attachEvent) {
	window.attachEvent('onload', wp_initAll)
} else {
	window.onload = wp_initAll
}