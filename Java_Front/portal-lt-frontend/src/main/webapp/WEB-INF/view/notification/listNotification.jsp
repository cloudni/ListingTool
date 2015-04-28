<%@ page language="java" import="java.util.*" pageEncoding="UTF-8"%>
<%@ include file="/common/taglibs.jsp"%>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<%@ include file="/common/meta.jsp"%>
<title>Item Tool - ${session.notification_title }</title>
</head>

<body>
	<%@ include file="/common/top.jsp"%>

<div class="container" id="page">
	<%@ include file="/common/header.jsp"%>
	<!-- mainmenu -->
			<div class="breadcrumbs">
<a href="${ctxPath}/index.shtml">${session.menu_home }</a> &raquo; <span>${session.notification_title }</span></div><!-- breadcrumbs -->
	
    
	
<div style="clear: both; width: 100%; position: relative; top: -5px;">
    <div class="borderBlock">
        <div>
            <div style="background: #f6f7f8; border-bottom: 1px solid #e9eaed; font-size: 12px;">
                <div style="height: 36px; color: #9197a3; font-weight: normal;">
                    <h1 style="color: #4e5665; font-weight: 700; padding-left: 14px; line-height: 20px; position: relative; font-size: 12px;">Notifications</h1>
                </div>
            </div>
            <div style="display: block;">
                <div class="grid-view">
                    <table class="items" width="100%">
                        <tr>
                            <th>${session.title }</th>
                            <th>Content</th>
                            <th>Company</th>
                            <th>Is New</th>
                            <th>Create Time</th>
                        </tr>
                        <div id="yw0" class="list-view">
<div class="summary">Displaying 1-1 of 1 result.</div>

<div class="items">

<c:forEach var="notification" items="${notificationList }" varStatus="step">
<tr>
    <td><a href="${ctxPath}/notification/getNotification.shtml?id=${notification.id}">${notification.title }</a></td>
    <td>${notification.content }</td>
    <td>${notification.companyName }</td>
    <td>${notification.isNew==1?"No":"Yes" }</td>
    <td>${notification.createTimeUtc }</td>
</tr>
</c:forEach>
</div>
<div class="keys" style="display:none" title="${phpPath }/notification"><span>1</span></div>
</div>                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

	<div class="clear" style="height: 20px;%"></div>

    <%@ include file="/common/footer.jsp"%>

</div><!-- page -->
<script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

    ga('create', 'UA-60681293-1', 'auto');
    ga('send', 'pageview');

</script>
<script type="text/javascript" src="/assets/6caa43f1/listview/jquery.yiilistview.js"></script>
<script type="text/javascript">
/*<![CDATA[*/
jQuery(function($) {
jQuery('#yw0').yiiListView({'ajaxUpdate':['yw0'],'ajaxVar':'ajax','pagerClass':'pager','loadingClass':'list-view-loading','sorterClass':'sorter','enableHistory':false});
});
/*]]>*/
</script>
</body>
</html>

