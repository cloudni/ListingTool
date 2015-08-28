<%@ page language="java" import="java.util.*" pageEncoding="UTF-8"%>
<%@ include file="/common/taglibs.jsp"%>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<%@ include file="/common/meta.jsp"%>
<title>Item Tool Manage - Login</title>

<script type="text/javascript">
//document.write("<sc" + "ript type=" + "'tex" + "t/jav" + "ascript'" + " src='//transaction.itemtool.com/portal-lt-backend/js/ga.min.j" + "s?ga_track_id=UA-64641328-2'>" + "<" + "/sc" + "ript>");

/* var _hmt = _hmt || [];
(function() {
  var hm = document.createElement("script");
  hm.src = "//hm.baidu.com/hm.js?00a7e2ca584d2d1aff310e209cdd985d";
  var s = document.getElementsByTagName("script")[0]; 
  s.parentNode.insertBefore(hm, s);
})(); */

//var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
    //document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
    //document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
    //document.write('<script src="http://www.google-analytics.com/ga.js"><\/script>');
    
    //var oHead = document.getElementsByTagName('HEAD').item(0);

    //var pageTracker = _gat._getTracker("UA-64599108-1");
    //pageTracker._setDomainName('itemtool.com');
    //pageTracker._setVar("cumstome_64599108");
    //pageTracker._setCustomVar(1, "cus_key1", "cus_value1", null);
    //pageTracker._trackPageview();
    
    
    //var otherTracker = _gat._getTracker('UA-64641328-2');
    //otherTracker._trackPageview();
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	})(window.top,top.document,'script','//www.google-analytics.com/analytics.js','ga');
	
/* 	ga('create', "UA-64641328-6", 'auto', {'name': 'newTracker'});
	ga('newTracker.send', 'pageview');
     ga('create', "UA-64641328-6", 'auto');
    ga('send', 'pageview'); */ 
    
    ga('create', "UA-64641328-6", 'auto', {'name': 'newTracker','allowLinker': true});
    ga('newTracker.send', 'pageview');

</script>
</head>

<body>

<div id="ajaxloading">
    <div>
        <img src="/images/load.gif" align="absmiddle" /><span>Data is loading</span>
    </div>
</div>

<div class="container" id="page">

	<%@ include file="/common/top.jsp"%>
	<!-- mainmenu -->
			<div class="breadcrumbs">
<a href="${phpPath }">Home</a> &raquo; <span>Login</span></div><!-- breadcrumbs -->
	
    
    
    
	<div id="content">
	
<h1>Login</h1>

<p>Please fill out the following form with your login credentials:${login_invalid_error}</p>

<div class="form">
<a target="_blank" href="http://transaction.itemtool.com/portal-lt-backend/common/adwords/tracking.shtml?itemId=151462870210&ga_track_id=UA-64641328-2">http://www.ebay.com/itm/151462870210</a>
<form id="login-form" action="${ctxPath}/login.shtml" method="post">
    <!-- <iframe id="iframe1" width="1000px"
        src="http://vi.vipr.ebaydesc.com/ws/eBayISAPI.dll?ViewItemDescV4&item=151462870210&tid=10&category=15630&seller=noblestyle2014&excSoj=1&excTrk=1&lsite=0&ittenable=false&domain=ebay.com&descgauge=1">
    </iframe> -->
	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<div class="row">
		<label for="SignInForm_username" class="required">Username <span class="required">*</span></label>		<input name="userName" id="SignInForm_username" type="text" />		<div class="errorMessage" id="SignInForm_username_em_" style="display:none"></div>	</div>

	<div class="row">
		<label for="SignInForm_password" class="required">Password <span class="required">*</span></label>		<input name="password" id="SignInForm_password" type="password" />		<div class="errorMessage" id="SignInForm_password_em_" style="display:none"></div>
	</div> 

	<div class="row rememberMe">
		<input id="ytSignInForm_rememberMe" type="hidden" value="0" name="SignInForm[rememberMe]" /><input name="SignInForm[rememberMe]" id="SignInForm_rememberMe" value="1" type="checkbox" />		<label for="SignInForm_rememberMe">Remember me next time</label>		<div class="errorMessage" id="SignInForm_rememberMe_em_" style="display:none"></div>	</div>
    
	<div class="row buttons">
		<input type="submit" name="yt0" value="Login" />	</div>

</form></div><!-- form -->
</div><!-- content -->

	<div class="clear"></div>

	<%@ include file="/common/footer.jsp"%><!-- footer -->

</div><!-- page -->

<script type="text/javascript">
/*<![CDATA[*/
jQuery(function($) {
jQuery('#login-form').yiiactiveform({'validateOnSubmit':true,'attributes':[{'id':'SignInForm_username','inputID':'SignInForm_username','errorID':'SignInForm_username_em_','model':'SignInForm','name':'username','enableAjaxValidation':false,'clientValidation':function(value, messages, attribute) {

if(jQuery.trim(value)=='') {
	messages.push("Username cannot be blank.");
}

}},{'id':'SignInForm_password','inputID':'SignInForm_password','errorID':'SignInForm_password_em_','model':'SignInForm','name':'password','enableAjaxValidation':false,'clientValidation':function(value, messages, attribute) {

if(jQuery.trim(value)=='') {
	messages.push("Password cannot be blank.");
}

}},{'id':'SignInForm_rememberMe','inputID':'SignInForm_rememberMe','errorID':'SignInForm_rememberMe_em_','model':'SignInForm','name':'rememberMe','enableAjaxValidation':false,'clientValidation':function(value, messages, attribute) {

if(jQuery.trim(value)!='' && value!="1" && value!="0") {
	messages.push("Remember me next time must be either 1 or 0.");
}

}}],'errorCss':'error'});
});
/*]]>*/
</script>
</body>
</html>
