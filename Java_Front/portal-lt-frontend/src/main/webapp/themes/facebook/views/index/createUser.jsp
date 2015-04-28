<%@ page language="java" import="java.util.*" pageEncoding="UTF-8"%>
<%@ include file="/common/taglibs.jsp"%>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<%@ include file="/common/meta.jsp"%>
<title>Item Tool - 新建用户</title>
</head>

<body>

<%@ include file="/common/top.jsp"%>

<div class="container" id="page">
	<%@ include file="/common/header.jsp"%>

<!-- mainmenu -->
<div class="breadcrumbs">
<a href="${phpPath }">首页</a> &raquo; <a href="${phpPath }/user/index">用户列表</a> &raquo; <span>新建</span></div><!-- breadcrumbs -->
    

<div class="span-5 last">
        <div id="sidebar">
        <div class="portlet" id="yw0">
<div class="portlet-decoration">
<div class="portlet-title">操作</div>
</div>
<div class="portlet-content">
<ul class="operations" id="yw1">
<li><a href="${ctxPath}/themes/facebook/views/index/listUser.jsp">用户列表</a></li>
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
                    <h1 style="color: #4e5665; font-weight: 700; padding-left: 14px; line-height: 38px; position: relative;">新建用户</h1>
                </div>
            </div>
            <div style="display: block; padding: 0px 10px 0px 10px;">
                
<div class="form">

<form id="user-form" action="${phpPath }/user/create" method="post">
    <p class="note">带<span class="required"> * </span> 字段是必填项</p>

	
	<div class="row">
		<label for="User_email" class="required">邮箱 <span class="required">*</span></label>		<input size="60" maxlength="256" name="User[email]" id="User_email" type="text" />			</div>

	<div class="row">
		<label for="User_username" class="required">用户名 <span class="required">*</span></label>		<input size="60" maxlength="256" name="User[username]" id="User_username" type="text" />			</div>

	<div class="row">
		<label for="User_password" class="required">密&nbsp;&nbsp;码 <span class="required">*</span></label>		<input size="60" maxlength="256" name="User[password]" id="User_password" type="password" />			</div>

    <div class="row">
        <label for="User_password_repeat">再一次输入密码</label>        <input size="60" maxlength="256" name="User[password_repeat]" id="User_password_repeat" type="password" />            </div>

	<div class="row hide">
		<label for="User_company_id">公司名称</label>		<input name="User[company_id]" id="User_company_id" type="text" value="0" />			</div>
    <div class="row">
        <label for="User_department_id">所属部门</label>        <select class="span4" name="User[department_id]" id="User_department_id">
<option value="1">Main Department</option>
</select>
            </div>

	<div class="row buttons">
		<input class="greenButton" style="font-size: 14px; width: 70px;" type="submit" name="yt0" value="新建" />	</div>

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
