<%@ page language="java" import="java.util.*" pageEncoding="UTF-8"%>
<%@ include file="/common/taglibs.jsp"%>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<%@ include file="/common/meta.jsp"%>
<title>Item Tool - ${session.company_update_menu }</title>
</head>

<body>

<div id="ajaxloading">
    <div>
        <img src="/images/load.gif" align="absmiddle" /><span>Data is loading</span>
    </div>
</div>

<%@ include file="/common/top.jsp"%>

<div class="container" id="page">
	<%@ include file="/common/header.jsp"%>
	<!-- mainmenu -->
			<div class="breadcrumbs">
<a href="${ctxPath}/index.shtml">${session.menu_home }</a> &raquo; <a href="${ctxPath}/company/listCompany.shtml">${session.company_title }</a> &raquo; <a href="${ctxPath}/company/getCompany.shtml?id=${company.id }">${company.name }</a> &raquo; <span>${session.btn_update }</span></div><!-- breadcrumbs -->
    
    
	    <div class="span-5 last">
        <div id="sidebar">
        <div class="portlet" id="yw0">
<div class="portlet-decoration">
<div class="portlet-title">${session.operations }</div>
</div>
<div class="portlet-content">
<ul class="operations" id="yw1">
<li><a href="${ctxPath}/company/listCompany.shtml">${session.company_view_menu }</a></li>
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
					<h1 style="color: #4e5665; font-weight: 700; padding-left: 14px; line-height: 20px; position: relative; font-size: 12px;">${company.name }</h1>
				</div>
			</div>
			<div style="display: block; padding: 0px 10px 0px 10px;">
				
<div class="form">

<form id="form" action="${ctxPath}/company/updateCompany.shtml" method="post">
	<p class="note">${session.warning }</p>

	
	<div class="row">
		<label for="Company_name" class="required">${session.name } <span class="required">*</span></label>
		<input size="60" maxlength="256" name="name" id="Company_name" type="text" value="${company.name }" class="required" />
		<input size="60" maxlength="256" name="id" id="Company_id" type="hidden" value="${company.id }" />
		</div>

	<div class="row">
		<label for="Company_phone">${session.phone_number }</label>
		<input size="60" maxlength="256" name="phone" id="Company_phone" type="text" value="${company.phone }" />
	</div>

	<div class="row">
		<label for="Company_country">${session.country }</label>
		<input size="60" maxlength="256" name="country" id="Company_country" type="text" value="${company.country }" />
	</div>

	<div class="row buttons">
		<input class="greenButton" style="font-size: 12px; width: 70px;" type="submit" name="yt0" value="保存" />
	</div>

</form>
</div><!-- form -->			</div>
		</div>
	</div>
</div>
        </div><!-- content -->
    </div>

	<div class="clear" style="height: 20px;%"></div>

    <%@ include file="/common/footer.jsp"%>
</div><!-- page -->
</body>
</html>

