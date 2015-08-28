<%@ page language="java" import="java.util.*" pageEncoding="UTF-8"%>
<%@ include file="/common/taglibs.jsp"%>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title>ebay</title>
<script type="text/javascript">
	(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	})(window,document,'script','//www.google-analytics.com/analytics.js','ga');
	
	ga('create', '${ga_track_id}', 'auto');
	ga('send', 'pageview');
    
	var href = window.location.href;
	if (href.indexOf("?") > 0) {
	    href = "&" + href.substring(href.indexOf("?") + 1, href.length);
	} else {
		href = "";
	}
	window.location.href="http://www.ebay.com/itm/${itemId}?referrer=" + escape(document.referrer) + href;
</script>
</head>

<body>
</body>
</html>
