var site_id;
var category_id;
var secondary_category_id;
var company_id;
var store_id;
var src = document.scripts[document.scripts.length - 1].src;
var args = src.substr(src.indexOf("?") + 1).split("&");//alert("args.length:" + args.length);
for ( var i = 0; i < args.length; i++) {
    var j = args[i].indexOf("=");
    if (j > -1 && args[i].substr(0, j) == 'site_id') {
    	site_id = args[i].substr(j + 1);
    } else if (j > -1 && args[i].substr(0, j) == 'category_id') {
    	category_id = args[i].substr(j + 1);
    } else if (j > -1 && args[i].substr(0, j) == 'secondary_category_id') {
    	secondary_category_id = args[i].substr(j + 1);
    } else if (j > -1 && args[i].substr(0, j) == 'company_id') {
    	company_id = args[i].substr(j + 1);
    } else if (j > -1 && args[i].substr(0, j) == 'store_id') {
    	store_id = args[i].substr(j + 1);
    }
}

var itemtool_tag_params = {
        platform: 1,
        site_id: site_id,
        category_id: category_id,
    	secondary_category_id:secondary_category_id,
    	company_id:company_id,
    	store_id:store_id
    };

var google_conversion_id = 947969982;
var google_custom_params = window.itemtool_tag_params;
var google_remarketing_only = true;

document.write("<sc" + "ript type=" + "'tex" + "t/jav" + "ascript'" + " src='//www.googl"+"eadser"+"vices.com/pagead/conve"+"rsion.j"+"s'>" + "<" + "/sc" + "ript>");
document.write("<nos"+"cript><div style='display:inline;'><img height='1' width='1' style='border-style:none;' alt='' src='//googleads.g.doubleclick.net/pagead/viewthroughconversion/947969982/?value=0&amp;guid=ON&amp;script=0'\/><\/div><\/nos"+"cript>");

/**关于facebook的pixel代码**/
var scriptDom = document.createElement("script");

scriptDom.innerHTML = "!function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?"
	+"n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;"
	+"n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;"
	+"t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,"
	+"document,'script','//connect.facebook.net/en_US/fbevents.js');"
	+"fbq('init', '1483556448626613');"
	+"fbq('track', 'PageView');";

var noscriptDom = document.createElement("noscript");
noscriptDom.innerHTML = "<img height=\"1\" width=\"1\" style=\"display:none\" src=\"https://www.facebook.com/tr?id=1483556448626613&ev=PageView&noscript=1\"/>";

var headerDom = document.getElementsByTagName('head')[0];

headerDom.appendChild(scriptDom);
headerDom.appendChild(noscriptDom);