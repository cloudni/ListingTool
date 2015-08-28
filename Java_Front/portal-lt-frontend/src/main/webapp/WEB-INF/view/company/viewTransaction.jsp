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
		<a href="${phpPath}/site/index.html">${session.menu_home }</a> &raquo; 
		<a href="${phpPath}/company/view.html">${session.company_title }</a> &raquo; 
		<a href="${phpPath}/company/update.html">${company.name }</a> &raquo; 
		<a href="${ctxPath}/company/transaction/list.shtml">${session.company_financa}</a> &raquo; 
		<span>${session.transaction_finance_view }</span>
	</div><!-- breadcrumbs -->
	 <div class="span-5 last">
        <div id="sidebar">
        	<div class="portlet" id="yw2">
				<div class="portlet-decoration">
					<div class="portlet-title">${session.operations }</div>
				</div>
				<div class="portlet-content">
					<ul class="operations" id="yw3">
					<li><a href="${phpPath}/company/view.html">${session.company_title }</a></li>
					<li><a href="${ctxPath}/company/transaction/list.shtml">${session.company_financa}</a></li>
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
                ${session.transaction_finance_view }
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
					<tr class="odd"><th>${session.date }:</th><td>${transaction.createTimeStr}</td></tr>
					<tr class="even"><th>${session.type }:</th><td>${transaction.paymentTransactionTypeName }</td></tr>
					<tr class="odd"><th>${session.status }:</th><td>${transaction.statusName}</td></tr>
					<tr class="even">
						<th>${session.transaction_remark}:</th>
						<td>${transaction.contents}
						</td>
					</tr>
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
					<tr class="odd"><th>${session.net }:</th><td>
						<c:if test="${transaction.paymentTransactionType == 2 || transaction.paymentTransactionType == 3 || transaction.paymentTransactionType == 5 }"><span style="color: red"></c:if>
							$<fmt:formatNumber value="${transaction.net }" pattern="##.##" minFractionDigits="2" ></fmt:formatNumber>
						<c:if test="${transaction.paymentTransactionType == 2 || transaction.paymentTransactionType == 3 || transaction.paymentTransactionType == 5 }"></span></c:if>
					</td></tr>
					<tr class="even"><th>${session.fee }:</th><td>$<fmt:formatNumber value="${transaction.fee }" pattern="##.##" minFractionDigits="2" ></fmt:formatNumber></td></tr>
					<tr class="odd"><th>${session.total }:</th><td>
						<c:if test="${transaction.paymentTransactionType == 2 || transaction.paymentTransactionType == 3 || transaction.paymentTransactionType == 5 }"><span style="color: red"></c:if>
							$<fmt:formatNumber value="${transaction.total }" pattern="##.##" minFractionDigits="2" ></fmt:formatNumber>
						<c:if test="${transaction.paymentTransactionType == 2 || transaction.paymentTransactionType == 3 || transaction.paymentTransactionType == 5 }"></span></c:if>	
					</td></tr>
				</table>			
			</div>
		</div>
	</div>
</div>

<div id="search_input_panel" style="width: 100%; margin: 0px;">
                <div class="container">
                	<input id="backButton" name="backButton" class="greenButton" type="button" value="${session.button_back }" name="yt0" style="font-size: 14px; width: 70px;"/>
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
