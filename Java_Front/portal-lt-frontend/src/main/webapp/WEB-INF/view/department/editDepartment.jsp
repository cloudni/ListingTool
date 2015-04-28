<%@ page language="java" import="java.util.*" pageEncoding="UTF-8"%>
<%@ include file="/common/taglibs.jsp"%>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<%@ include file="/common/meta.jsp"%>
<title>Item Tool - ${session.departments_create_menu }</title>
</head>

<body>
<%@ include file="/common/top.jsp"%>

<div class="container" id="page">
	<%@ include file="/common/header.jsp"%>
	<!-- mainmenu -->
			<div class="breadcrumbs">
<a href="${ctxPath}/index.shtml">${session.menu_home }</a> &raquo; <a href="${ctxPath}/department/listDepartment.shtml">${session.departments_title }</a> &raquo; <span id="navigateOP">${session.btn_create }</span></div><!-- breadcrumbs -->
    
    
	    <div class="span-5 last"> 
        <div id="sidebar">
        <div class="portlet" id="yw0">
<div class="portlet-decoration">
<div class="portlet-title">${session.operations }</div>
</div>
<div class="portlet-content">
<ul class="operations" id="yw1">
<li><a href="${ctxPath}/department/listDepartment.shtml">${session.departments_list_menu }</a></li>
</ul></div>
</div>        </div><!-- sidebar -->
    </div>
    <div class="span-19" style="margin-right: 0px; width: 800px;">
        <div id="content">
            
<div style="clear: both; width: 100%; position: relative; top: -5px;">
    <div class="borderBlock">
        <div>
            <div style="background: #f6f7f8; border-bottom: 1px solid #e9eaed; font-size: 12px;">
                <div style="height: 36px; color: #9197a3; font-weight: normal;">
                    <h1 style="color: #4e5665; font-weight: 700; padding-left: 14px; line-height: 20px; position: relative; font-size: 12px;">${session.departments_create_menu }</h1>
                </div>
            </div>
            <div style="display: block; padding: 0px 10px 0px 10px;">
                

<style>
    .treeList{
        width: 90%;
        height: 450px;
        border: 1px solid rgb(163, 163, 163);
    }
</style>

<div class="form">

    <form id="form" action="${ctxPath}/department/addDepartment.shtml" method="post">
    <p class="note">${session.warning }</p>

    
    <div class="container">
        <div class="row left span-3">
            <label style="padding-top: 5px;" for="Department_name" class="required">${session.name } <span class="required">*</span></label>
        </div>
        <div class="row left">
            <input size="60" maxlength="30" name="name" id="departmentName" type="text" value="${department.name }" class="required" />
            <input size="60" maxlength="30" name="id" id="id" type="hidden" value="${department.id }" />
        </div>
        <div class="row buttons prepend-1 left"  id="departmentButt">
            <input class="greenButton" style="font-size: 12px; width: 50px;" type="submit" name="yt0" value="${session.btn_create }" id="opBtn" />
        </div>
    </div>

    <div class="container">
        <div class="row left span-3">
            <label style="padding-top: 5px;" for="Department_parent_id">${session.higher_department }</label>
        </div>
        <div class="row left span-5">
            <select class="span4" name="parentId" id="parentId">
        		<c:forEach var="department" items="${departmentList }">
        			<option value="${department.id }">${department.name }</option>
        		</c:forEach>
			</select>
		</div>
    </div>
    
    <div class="container" style="width: 100%">
        <div class="left" style="width: 340px;">
            <div class="row">
                <label style="">${session.selected }${session.user_title }:</label>
            </div>
            <div class="row">
                <select style="width: 90%; height: 150px;" multiple="multiple" name="departmentIds" id="changeDepartment">
                	<c:forEach var="user" items="${userListByDepartmentId }" varStatus="step">
                		<option value="${user.id}">${user.username }</option>
					</c:forEach>
				</select>
			</div>
        </div>
        
        <div class="left" style="width: 40px; padding-top: 80px;">
            <input onclick="departmentRemoveUser();" style="margin-left: -11px;" name="yt1" type="button" value="=&gt;" /><br />
            <input onclick="departmentAddUser();" style="margin-left: -11px;" name="yt2" type="button" value="&lt;=" />
        </div>
        
        <div class="left" style="width: 340px;">
            <div class="row">
                <label style="">${session.every }${session.user_title }:</label>
            </div>
            <div class="row" >
                <select style="width: 90%; height: 150px;" multiple="multiple" name="department_id[]" id="department_id">
                	<c:forEach var="user" items="${userList }" varStatus="step">
                		<option value="${user.id}">${user.username }</option>
					</c:forEach>
				</select>   
			</div>
        </div>
    </div>
    <div style="width: 100%;clear: both;">
        <div class="row">
            <label id="department_error_msg" style="display: block; color: red;">&nbsp;</label>        </div>
    </div>
    <div>
        <input id="userId" size="60" maxlength="255" style="display: none" name="userIds" type="text" />        <input id="removeId" size="60" maxlength="255" style="display: none" name="removeIds" type="text" />    </div>
    </form>
</div><!-- form --><!-- form -->

<script>
    function addUserId(){
        var to=document.getElementById("changeDepartment");
        var userId="";
        for(var i=0;i<to.length;i++)
        {
            userId+=to.options[i].value+",";
        }
        $("#userId").val(userId);
    }
    addUserId();
    function departmentAddUser()
    {
        var from=document.getElementById("department_id");
        var to=document.getElementById("changeDepartment");
        if(from.length>0)
        {
            var selectValue="";
            var length=from.length;
            var arrays=new Array();
            for(i=0;i<from.length;i++)
            {
                if(from.options[i].selected)
                {
                    selectValue+=from.options[i].value+",";
                    to.options.add(new Option(from.options[i].text,from.options[i].value));
                    arrays.push(from.options[i].value);
                }

            }
            for(t=0;t<arrays.length;t++)
            {
                for(s=0;s<from.length;s++)
                {
                    if(from.options[s].value == arrays[t])
                    {
                        from.options.remove(s);
                    }
                }
            }
            var userId="";
            for(i=0;i<to.length;i++)
            {
                userId+=to.options[i].value+",";
            }
            $("#userId").val(userId);
        }

    }
    function departmentRemoveUser()
    {
        var from=document.getElementById("changeDepartment");
        var to=document.getElementById("department_id");
        if(from.length>0)
        {
            var selectValue="";
            var arrays=new Array();
            for(i=0;i<from.length;i++)
            {
                if(from.options[i].selected)
                {
                    selectValue+=from.options[i].value+",";
                    to.options.add(new Option(from.options[i].text,from.options[i].value));
                    arrays.push(from.options[i].value);

                }
            }
            for(t=0;t<arrays.length;t++)
            {
                for(s=0;s<from.length;s++)
                {
                    if(from.options[s].value == arrays[t])
                    {
                        from.options.remove(s);
                    }
                }
            }
            var userId="";
            for(i=0;i<from.length;i++)
            {
                userId+=from.options[i].value+",";
            }
            $("#userId").val(userId);
            $("#removeId").val(selectValue);
        }
    }

    /* function validate()
    {
        var error = '';
        if($("#Department_name").val().length < 6 || $("#Department_name").val().length > 30)
        {
            error += 'Unknow Message Code'+"\n";
            $("#Department_name").focus();
        }

        if(error.length>0) { alert(error); return false; } else return true;
    }  onsubmit=" return validate()"*/

</script>            </div>
        </div>
    </div>
</div>
        </div><!-- content -->
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

    jQuery(function($) {
    	var id="${department.id}";
    	if(null!=id && ""!=id){
    		$("#department-form").attr("action","${ctxPath}/department/updateDepartment.shtml");
    		$("#opBtn").val("${session.btn_update }");
    		$("#navigateOP").text("${session.btn_update }");
    	}
    });
</script>
</body>
</html>

