var ga_track_id;

var src = document.scripts[document.scripts.length - 1].src;
var args = src.substr(src.indexOf("?") + 1).split("&");
for ( var i = 0; i < args.length; i++) {
    var j = args[i].indexOf("=");
    if (j > -1 && args[i].substr(0, j) == 'ga_track_id') {
    	ga_track_id = args[i].substr(j + 1);
    	break;
    }
}
var oHead = document.getElementsByTagName('head').item(0);
var oScript= document.createElement("script");
oScript.type = "text/javascript";
oScript.async=1;
oScript.src="http://www.google-analytics.com/ga.js";
oScript.onload = oScript.onreadystatechange = function() {
	if(!/*@cc_on!@*/0 || this.readyState == "loaded" || this.readyState == "complete") {
        _gat._getTracker(ga_track_id)._trackPageview();
    }
}
oHead.appendChild( oScript);