<%@ page language="java" import="java.util.*" pageEncoding="UTF-8"%>
<%@ include file="/common/taglibs.jsp"%>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<%@ include file="/common/meta.jsp"%>
<title>Item Tool - ${session.user_create_title }</title>
</head>
<body>

<%@ include file="/common/top.jsp"%>

<div class="container" id="page">
	<%@ include file="/common/header.jsp"%>

<!-- mainmenu -->
<div class="breadcrumbs">
<a href="${ctxPath}/index.shtml">${session.menu_home }</a> &raquo; <a href="${ctxPath}/user/listUser.shtml">${session.user_list_label }</a> &raquo; <span id="navigateOP">${session.btn_create }</span></div><!-- breadcrumbs -->
    

<div class="span-5 last">
        <div id="sidebar">
        <div class="portlet" id="yw0">
<div class="portlet-decoration">
<div class="portlet-title">${session.operations }</div>
</div>
<div class="portlet-content">
<ul class="operations" id="yw1">
<li><a href="${ctxPath}/user/listUser.shtml">${session.user_list_label }</a></li>
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
                    <h1 style="color: #4e5665; font-weight: 700; padding-left: 14px; line-height: 20px; position: relative; font-size: 12px;">${session.user_create_title }</h1>
                </div>
            </div>
            <div style="display: block; padding: 0px 10px 0px 10px;">
                
<div class="form">

<form class="formToCheck" id="form" action="${ctxPath}/user/addUser.shtml" method="post">
    <p class="note">${session.warning }</p>

	<div class="row">
		<label for="User_email">${session.email } <span class="required">*</span></label>		
		<input size="60" maxlength="256" name="email" id="email" type="text" value="${user.email }" class="required email" />
		<input size="60" maxlength="256" name="id" id="id" type="hidden" value="${user.id }" />			
	</div>

	<div class="row">
		<label for="User_username">${session.user_name } <span class="required">*</span></label>		
		<input size="60" maxlength="256" name="username" id="username" type="text" value="${user.username }" class="required" />			
	</div>

	<div class="row">
		<label for="User_password">${session.password }<span class="required">*</span></label>		
		<input size="60" maxlength="256" name="password" id="password" type="password" value="${user.password }" class="required" />			
	</div>

    <div class="row">
        <label for="User_password_repeat">${session.input_password_repeat }</label>        
        <input size="60" maxlength="256" name="passwordRepeat" id="passwordRepeat" type="password" equalTo="#password" />            
       </div>

	<div class="row hide">
		<label for="User_company_id">${session.company_name }</label>		
		<input name="companyId" id="companyId" type="text" value="1" />			
	</div>
    <div class="row">
        <label for="User_department_id">${session.under_department }</label>        
        <select class="span4" name="departmentId" id="departmentId">
        	<c:forEach var="department" items="${departmentList }">
        		<option value="${department.id }">${department.name }</option>
        	</c:forEach>
		</select>
            </div>

	<div class="row buttons">
		<input class="submit greenButton" style="font-size: 14px; width: 70px;" type="submit" name="yt0" value="${session.btn_create }" id="opBtn" />
	</div>

</form>
</div><!-- form -->            </div>
        </div>
    </div>
</div>

        </div><!-- content -->
    </div>
<%@ include file="/common/footer.jsp"%>
</div>
</body>
</html>
