<%@ page language="java" import="java.util.*" pageEncoding="UTF-8"%>
<%@ include file="/common/taglibs.jsp"%>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<%@ include file="/common/meta.jsp"%>
<title>Item Tool Manage - Login</title>
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
<form id="login-form" action="${ctxPath}/login.shtml" method="post">
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
