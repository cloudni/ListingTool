<%@ page language="java" import="java.util.*" pageEncoding="UTF-8"%>
<%@ include file="/common/taglibs.jsp"%>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<%@ include file="/common/meta.jsp"%>
<title>Item Tool Manage - Admin ResourceString</title>
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
<a href="${phpPath }">Home</a> &raquo; <a href="${phpPath }/resourceString/index">Resource Strings</a> &raquo; <span>Manage</span></div><!-- breadcrumbs -->
	
    
    
    
	<div class="span-19">
	<div id="content">
		
<h1>Manage Resource Strings</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<a class="search-button" href="#">Advanced Search</a><div class="search-form" style="display:none">

<div class="wide form">

<form id="yw0" action="${phpPath }/resourceString/admin" method="get">
	<div class="row">
		<label for="ResourceString_id">ID</label>		<input name="ResourceString[id]" id="ResourceString_id" type="text" />	</div>

	<div class="row">
		<label for="ResourceString_key">Key</label>		<input size="60" maxlength="100" name="ResourceString[key]" id="ResourceString_key" type="text" />	</div>

	<div class="row">
		<label for="ResourceString_language">Language</label>		<input name="ResourceString[language]" id="ResourceString_language" type="text" />	</div>

	<div class="row">
		<label for="ResourceString_environment">Environment</label>		<input name="ResourceString[environment]" id="ResourceString_environment" type="text" />	</div>

	<div class="row">
		<label for="ResourceString_message">Message</label>		<textarea rows="6" cols="50" name="ResourceString[message]" id="ResourceString_message"></textarea>	</div>

	<div class="row">
		<label for="ResourceString_create_time_utc">Create Time Utc</label>		<input name="ResourceString[create_time_utc]" id="ResourceString_create_time_utc" type="text" />	</div>

	<div class="row">
		<label for="ResourceString_create_admin_id">Create Admin</label>		<input name="ResourceString[create_admin_id]" id="ResourceString_create_admin_id" type="text" />	</div>

	<div class="row">
		<label for="ResourceString_update_time_utc">Update Time Utc</label>		<input name="ResourceString[update_time_utc]" id="ResourceString_update_time_utc" type="text" />	</div>

	<div class="row">
		<label for="ResourceString_update_admin_id">Update Admin</label>		<input name="ResourceString[update_admin_id]" id="ResourceString_update_admin_id" type="text" />	</div>

	<div class="row buttons">
		<input type="submit" name="yt0" value="Search" />	</div>

</form>
</div><!-- search-form --></div><!-- search-form -->

<div id="resource-string-grid" class="grid-view">
<div class="summary">Displaying 1-10 of 344 results.</div>
<table class="items">
<thead>
<tr>
<th id="resource-string-grid_c0"><a class="sort-link" href="${phpPath }/resourceString/admin?ResourceString_sort=id">ID</a></th><th id="resource-string-grid_c1"><a class="sort-link" href="${phpPath }/resourceString/admin?ResourceString_sort=key">Key</a></th><th id="resource-string-grid_c2"><a class="sort-link" href="${phpPath }/resourceString/admin?ResourceString_sort=language">Language</a></th><th id="resource-string-grid_c3"><a class="sort-link" href="${phpPath }/resourceString/admin?ResourceString_sort=environment">Environment</a></th><th id="resource-string-grid_c4"><a class="sort-link" href="${phpPath }/resourceString/admin?ResourceString_sort=message">Message</a></th><th id="resource-string-grid_c5"><a class="sort-link" href="${phpPath }/resourceString/admin?ResourceString_sort=create_time_utc">Create Time Utc</a></th><th class="button-column" id="resource-string-grid_c6">&nbsp;</th></tr>
<tr class="filters">
<td><input name="ResourceString[id]" type="text" /></td><td><input name="ResourceString[key]" type="text" maxlength="100" /></td><td><input name="ResourceString[language]" type="text" /></td><td><input name="ResourceString[environment]" type="text" /></td><td><input name="ResourceString[message]" type="text" /></td><td><input name="ResourceString[create_time_utc]" type="text" /></td><td>&nbsp;</td></tr>
</thead>
<tbody>
<tr class="odd">
<td>1</td><td>signIn_title</td><td>1</td><td>0</td><td>登录</td><td>1416798043</td><td class="button-column"><a class="view" title="View" href="${ctxPath }/detail.shtml"><img src="${ctxPath}/images/gridview/view.png" alt="View" /></a></td></tr>
<tr class="even">
<td>2</td><td>signIn_title</td><td>2</td><td>0</td><td>SignIn</td><td>1416798064</td><td class="button-column"><a class="view" title="View" href="${phpPath }/resourceString/2"><img src="${ctxPath}/images/gridview/view.png" alt="View" /></a></td></tr>
<tr class="odd">
<td>3</td><td>signIn_forgot_password</td><td>1</td><td>0</td><td>忘记密码</td><td>1416809184</td><td class="button-column"><a class="view" title="View" href="${phpPath }/resourceString/3"><img src="${ctxPath}/images/gridview/view.png" alt="View" /></a></td></tr>
</tbody>
</table>
<div class="pager">Go to page: <ul id="yw1" class="yiiPager"><li class="first hidden"><a href="${phpPath }/resourceString/admin">&lt;&lt; First</a></li>
<li class="previous hidden"><a href="${phpPath }/resourceString/admin">&lt; Previous</a></li>
<li class="page selected"><a href="${phpPath }/resourceString/admin">1</a></li>
<li class="page"><a href="${phpPath }/resourceString/admin?ResourceString_page=2">2</a></li>
<li class="page"><a href="${phpPath }/resourceString/admin?ResourceString_page=3">3</a></li>
<li class="page"><a href="${phpPath }/resourceString/admin?ResourceString_page=4">4</a></li>
<li class="page"><a href="${phpPath }/resourceString/admin?ResourceString_page=5">5</a></li>
<li class="page"><a href="${phpPath }/resourceString/admin?ResourceString_page=6">6</a></li>
<li class="page"><a href="${phpPath }/resourceString/admin?ResourceString_page=7">7</a></li>
<li class="page"><a href="${phpPath }/resourceString/admin?ResourceString_page=8">8</a></li>
<li class="page"><a href="${phpPath }/resourceString/admin?ResourceString_page=9">9</a></li>
<li class="page"><a href="${phpPath }/resourceString/admin?ResourceString_page=10">10</a></li>
<li class="next"><a href="${phpPath }/resourceString/admin?ResourceString_page=2">Next &gt;</a></li>
<li class="last"><a href="${phpPath }/resourceString/admin?ResourceString_page=35">Last &gt;&gt;</a></li></ul></div><div class="keys" style="display:none" title="${phpPath }/resourceString/admin"><span>1</span><span>2</span><span>3</span><span>4</span><span>5</span><span>6</span><span>7</span><span>8</span><span>9</span><span>10</span></div>
</div>	</div><!-- content -->
</div>

	<div class="clear"></div>

	<%@ include file="/common/footer.jsp"%><!-- footer -->

</div><!-- page -->

<script type="text/javascript" src="/assets/6caa43f1/gridview/jquery.yiigridview.js"></script>
<script type="text/javascript">
/*<![CDATA[*/
jQuery(function($) {

$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#resource-string-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});

jQuery(document).on('click','#resource-string-grid a.delete',function() {
	if(!confirm('Are you sure you want to delete this item?')) return false;
	var th = this,
		afterDelete = function(){};
	jQuery('#resource-string-grid').yiiGridView('update', {
		type: 'POST',
		url: jQuery(this).attr('href'),
		success: function(data) {
			jQuery('#resource-string-grid').yiiGridView('update');
			afterDelete(th, true, data);
		},
		error: function(XHR) {
			return afterDelete(th, false, XHR);
		}
	});
	return false;
});
jQuery('#resource-string-grid').yiiGridView({'ajaxUpdate':['resource-string-grid'],'ajaxVar':'ajax','pagerClass':'pager','loadingClass':'grid-view-loading','filterClass':'filters','tableClass':'items','selectableRows':1,'enableHistory':false,'updateSelector':'{page}, {sort}','filterSelector':'{filter}','pageVar':'ResourceString_page'});
});
/*]]>*/
</script>
</body>
</html>
