<%@ page language="java" import="java.util.*" pageEncoding="UTF-8"%>
<%@ include file="/common/taglibs.jsp"%>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<%@ include file="/common/meta.jsp"%>
<title>Item Tool - ${session.user_view_label }</title>
</head>

<body>
<%@ include file="/common/top.jsp"%>

<div class="container" id="page">
	<%@ include file="/common/header.jsp"%>
	<!-- mainmenu -->
			<div class="breadcrumbs">
<a href="${ctxPath}/index.shtml">${session.menu_home }</a> &raquo; <a href="${ctxPath}/user/listUser.shtml">${session.user_title }</a> &raquo; <span>${user.username }</span></div><!-- breadcrumbs -->
	
    
    
    
	    <div class="span-5 last">
        <div id="sidebar">
        <div class="portlet" id="yw1">
<div class="portlet-decoration">
<div class="portlet-title">${session.action }</div>
</div>
<div class="portlet-content">
<ul class="operations" id="yw2">
<li><a href="${ctxPath}/user/listUser.shtml">${session.user_list_label }</a></li>
<li><a href="${ctxPath}/user/toAddUser.shtml">${session.user_create_label }</a></li>
<li><a href="${ctxPath}/user/toUpdateUser.shtml?id=${user.id}">${session.user_update_label }</a></li>
<li><a href="javascript:deleteObject('${user.id }','${ctxPath}/user/deleteUser.shtml','你确定你要删除这个用户吗?');" id="delete">${session.user_delete_label }</a></li>
</ul></div>
</div>        </div><!-- sidebar -->
    </div>
    <div class="span-19" style="margin-right: 0px; width: 800px;">
        <div id="content">
            
<style>
	table.detail-view th, table.detail-view td
	{
		font-size: 12px;
	}
</style>

<div style="clear: both; width: 100%; position: relative; top: -5px;">
	<div class="borderBlock">
		<div>
			<div style="background: #f6f7f8; border-bottom: 1px solid #e9eaed; font-size: 12px;">
				<div style="height: 36px; color: #9197a3; font-weight: normal;">
					<h1 style="color: #4e5665; font-weight: 700; padding-left: 14px; line-height: 38px; position: relative;">${user.username }</h1>
				</div>
			</div>
			<div style="display: block;">
				<table class="detail-view" id="yw0"><tr class="odd"><th>${session.email }</th><td>${user.email }</td></tr>
<tr class="even"><th>${session.user_name }</th><td>${user.username }</td></tr>
<tr class="odd"><th>${session.departments_title }</th><td><span class="null">${user.departmentName==null?'${session.no_setting }':user.departmentName }</span></td></tr>
<tr class="even"><th>Unknow  Message  Code</th><td>${user.lastLoginTimeUtc }</td></tr>
</table>			</div>
		</div>
	</div>
</div>



        </div><!-- content -->
    </div>

	<div class="clear" style="height: 20px;%"></div>

    <%@ include file="/common/footer.jsp"%>
</div><!-- page -->
<script>
    /* (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

    ga('create', 'UA-60681293-1', 'auto');
    ga('send', 'pageview'); */

</script>
</body>
</html>

