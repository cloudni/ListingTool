<%@ page language="java" import="java.util.*" pageEncoding="UTF-8"%>
<%@ include file="/common/taglibs.jsp"%>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<%@ include file="/common/meta.jsp"%>
<title>Item Tool - ${session.departments_title }</title>

    <script type="text/javascript">
    function initTab(){
    	var form1 = $("#queryForm");
    	var pagebean = new PageBean(form1);
    	pagebean.setTableId("listTable");
    	pagebean.setFootId("foot1");
    	pagebean.setCallback(callback);
    	setPagebeanObj(pagebean);
    	pagebean.doPage();
    }

    function callback(data){
    	trimJsonArray(data);//把字段的null值变味空""
    	$("#listBody tr:not(:first)").remove();
    	$.each(data, function(index, item) {
    		var id=item.id;
    		var name=item.name;
    		var higherDepartmentName=item.higherDepartmentName;
    		var id=item.id;
    		
    		var html="<tr>";
    		html+="<td><a href='"+base+"/department/getDepartment.shtml?id="+id+"'>"+id+"</a></td>"+
    			  "<td>"+name+"</td>"+
    			  "<td>"+higherDepartmentName+"</td>"+
    			  "<td><a href='${ctxPath}/department/getDepartment.shtml?id="+id+"'>${session.btn_view }</a>&nbsp;|&nbsp;"+
    			  "<a href='${ctxPath}/department/toUpdateDepartment.shtml?id="+id+"'>${session.btn_edit }</a>&nbsp;|&nbsp;"+
    			  "<a href='javascript:confirmDel("+id+");' id='delete'>${session.btn_delete }</a>&nbsp;|&nbsp;</td>"+
    			  "</tr>";
    			$("#listBody").append(html);
    	});
    }
    
    $(document).ready(function() {
    	//initTab();
    });
    </script>
</head>

<body>
<%@ include file="/common/top.jsp"%>

<div class="container" id="page">
	<%@ include file="/common/header.jsp"%>
	<!-- mainmenu -->
			<div class="breadcrumbs">
<a href="${ctxPath}/index.shtml">${session.menu_home }</a> &raquo; <span>${session.departments_title }</span></div><!-- breadcrumbs -->
	
    
    
    
	    <div class="span-5 last">
        <div id="sidebar">
        <div class="portlet" id="yw2">
<div class="portlet-decoration">
<div class="portlet-title">${session.operations }</div>
</div>
<div class="portlet-content">
<ul class="operations" id="yw3">
<li><a href="${ctxPath}/department/toAddDepartment.shtml">${session.departments_create_menu }</a></li>
</ul></div>
</div>        </div><!-- sidebar -->
    </div>
    <div class="span-19" style="margin-right: 0px; width: 800px;">
        <div id="content">

<form action="${ctxPath}/department/listModeDepartment.shtml" id="queryForm" name="queryForm" method="post">
	<input type="hidden" name="pageNo"  id="pageNo" value="1">
	<input type="hidden" name="pageSize" value="5">
</input>
            
<div style="clear: both; width: 100%; position: relative; top: -5px;">
    <div class="borderBlock">
        <div>
            <div style="background: #f6f7f8; border-bottom: 1px solid #e9eaed; font-size: 12px;">
                <div style="height: 36px; color: #9197a3; font-weight: normal;">
                    <h1 style="color: #4e5665; font-weight: 700; padding-left: 14px; line-height: 20px; position: relative; font-size: 12px;">${session.departments_title }</h1>
                </div>
            </div>
            <div style="display: block;">
                <div class="grid-view">
                    <table class="items" width="100%" id="listTable">
                    	<thead>
                        <tr>
                            <th>${session.id }</th>
                            <th>${session.name }</th>
                            <th>${session.higher_department }</th>
                            <th>${session.action }</th>
                        </tr>
                        </thead>
<div id="yw0" class="list-view">
<div class="summary"></div>
<div class="items">
<tbody id="listBody">
<c:forEach var="department" items="${departmentList }" varStatus="step">
	<tr>
    <td><a href="${ctxPath}/department/getDepartment.shtml?id=${department.id}">${department.id }</a></td>
    <td>${department.name }</td>
    <td></td>
    <td>
        <a href="${ctxPath}/department/getDepartment.shtml?id=${department.id}">${session.btn_view }</a>&nbsp;|&nbsp;
        <a href="${ctxPath}/department/toUpdateDepartment.shtml?id=${department.id}">${session.btn_edit }</a>&nbsp;|&nbsp;
        <a href="javascript:confirmDel('${department.id }');" id="delete">${session.btn_delete }</a>    </td>
	</tr>
</c:forEach>
</tbody>
</div>
</div>                    

<%@ include file="/common/page.jsp"%>
</table>
							
							<!---翻页-->
							<!-- <div class="page fr m10" id="foot1"></div> -->
                </div>
            </div>
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

    function confirmDel(departmentId){
    	var count = $("#listBody tr").length;
    	if(count<=1){
    		alert("最后一个部门不能删除！");
    	}else{
    		deleteObject(departmentId,'${ctxPath}/department/deleteDepartment.shtml','你确定要删除这个部门吗?');
    	}
    }
</script>
<script type="text/javascript" src="/assets/6caa43f1/listview/jquery.yiilistview.js"></script>
<script type="text/javascript">
/*<![CDATA[*/
/* jQuery(function($) {
jQuery('#yw0').yiiListView({'ajaxUpdate':['yw0'],'ajaxVar':'ajax','pagerClass':'pager','loadingClass':'list-view-loading','sorterClass':'sorter','enableHistory':false});
jQuery('body').on('click','#yt0',function(){if(confirm('你确定要删除这个部门吗?')) {jQuery.yii.submitForm(this,'${phpPath }/department/delete/4',{});return false;} else return false;});
}); */
/*]]>*/
</script>
</body>
</html>

