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