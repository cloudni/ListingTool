<%@ page language="java" import="java.util.*" pageEncoding="UTF-8"%>
<%@ include file="/common/taglibs.jsp"%>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<%@ include file="/common/meta.jsp"%>
<script type="text/javascript" src="${ctxPath}/js/tags/My97DatePicker/WdatePicker.js"></script>

<title>Item Tool</title>
</head>

<body>

<%@ include file="/common/top.jsp"%>

<div class="container" id="page">
<%@ include file="/common/header.jsp"%>
    
<div id="content">
	<!-- mainmenu -->
	<div class="breadcrumbs">
		<a href="${ctxPath}/index.shtml">${session.menu_home }</a> &raquo; 
		<a href="${ctxPath}/company/listCompany.shtml">${session.company_title }</a> &raquo; 
		<a href="${ctxPath}/company/toUpdateCompany.shtml?id=${company.id}">${company.name }</a> &raquo; 
		<a href="${ctxPath}/company/transaction/list.shtml">Finance</a> &raquo; 
		<span>View</span>
	</div><!-- breadcrumbs -->
	 <div class="span-5 last">
        <div id="sidebar">
        	<div class="portlet" id="yw2">
				<div class="portlet-decoration">
					<div class="portlet-title">${session.operations }</div>
				</div>
				<div class="portlet-content">
					<ul class="operations" id="yw3">
					<li><a href="${ctxPath}/company/listCompany.shtml">${session.company_title }</a></li>
					<li><a href="${ctxPath}/company/transaction/list.shtml">Finance</a></li>
					</ul>
				</div>
			</div>        
		</div><!-- sidebar -->
    </div>
<div class="span-19" style="margin-right: 0px; width: 800px;">
        <div id="content">
     
<style>
	table.detail-view th, table.detail-view td
	{
		font-size: 12px;
	}
</style>

<div class="borderBlock">
    <div>
        <div class="clearfix" style="border-top: 1px solid transparent;" align="center">
            <div id="search_input_panel" style="width: 100%; padding: 5px; margin: 0px; font-weight: bold;" align="center">
                Transaction ID:${transaction.paymentTransactionId }&nbsp;&nbsp;&nbsp;${transaction.status}
            </div>
        </div>
    </div>
</div>

<div style="clear: both; width: 100%; position: relative; top: -5px;">
	<div class="borderBlock">
		<div>
			<!-- <div style="background: #f6f7f8; border-bottom: 1px solid #e9eaed; font-size: 12px;">
				<div style="height: 36px; color: #9197a3; font-weight: normal;">
					<h1 style="color: #4e5665; font-weight: 700; padding-left: 14px; line-height: 38px; position: relative;">cghbs22</h1>
				</div>
			</div> -->
			<div style="display: block;">
				<table class="detail-view" id="yw0">
					<tr class="odd"><th>tranId:</th><td>${transaction.paymentTransactionId }</td></tr>
					<tr class="even"><th>tranType:</th><td>${transaction.type }</td></tr>
					<tr class="odd"><th>CreateTime:</th><td>${transaction.createTimeStr}</td></tr>
					<tr class="even"><th>CompleteTime:</th><td>${transaction.updateTimeStr}</td></tr>
				</table>			
			</div>
		</div>
	</div>
</div>

<div style="clear: both; width: 100%; position: relative; top: -5px;">
	<div class="borderBlock">
		<div>
			<div style="display: block;">
				<table class="detail-view" id="yw0">
					<tr class="odd"><th>Total:</th><td>${transaction.total }</td></tr>
					<tr class="even"><th>Fee:</th><td>${transaction.fee }</td></tr>
					<tr class="odd"><th>Net:</th><td>${transaction.net }</td></tr>
					<tr class="even"><th>Status:</th><td>${transaction.status}</td></tr>
				</table>			
			</div>
		</div>
	</div>
</div>

<div id="search_input_panel" style="width: 100%; margin: 0px;">
                <div class="container">
                	<input id="backButton" name="backButton" class="greenButton" type="button" value="back" name="yt0" style="font-size: 14px; width: 70px;"/>
                </div>
            </div>

<script>
    jQuery(function($) {
    	jQuery("#backButton").click(function() {
    		window.location.href = "${ctxPath }/company/transaction/list.shtml";
    	});
		
	});
</script>        </div><!-- content -->
    </div>

<script>
</script>
</div><!-- content -->
<%@ include file="/common/footer.jsp"%>
</div>
</body>
</html>
