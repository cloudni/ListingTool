<%@ page language="java" import="java.util.*" pageEncoding="UTF-8"%>
<%@ include file="/common/taglibs.jsp"%>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<%@ include file="/common/meta.jsp"%>
<title>Item Tool Manage - View ResourceString</title>
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
<a href="${phpPath }">Home</a> &raquo; <a href="${phpPath }/resourceString/index">Resource Strings</a> &raquo; <span>2</span></div><!-- breadcrumbs -->
	
    
    
    
	<div class="span-19">
	<div id="content">
		
<h1>View ResourceString #2</h1>

<table class="detail-view" id="yw0"><tr class="odd"><th>ID</th><td>2</td></tr>
<tr class="even"><th>Key</th><td>signIn_title</td></tr>
<tr class="odd"><th>Language</th><td>2</td></tr>
<tr class="even"><th>Environment</th><td>0</td></tr>
<tr class="odd"><th>Message</th><td>SignIn</td></tr>
<tr class="even"><th>Create Time Utc</th><td>1416798064</td></tr>
<tr class="odd"><th>Create Admin</th><td>1</td></tr>
<tr class="even"><th>Update Time Utc</th><td>1416798064</td></tr>
<tr class="odd"><th>Update Admin</th><td>1</td></tr>
</table>	</div><!-- content -->
</div>

	<div class="clear"></div>

	<%@ include file="/common/footer.jsp"%><!-- footer -->

</div><!-- page -->

<script type="text/javascript">
/*<![CDATA[*/
jQuery(function($) {
jQuery('body').on('click','#yt0',function(){if(confirm('Are you sure you want to delete this item?')) {jQuery.yii.submitForm(this,'${phpPath }/resourceString/delete/2',{});return false;} else return false;});
});
/*]]>*/
</script>
</body>
</html>
