<%@ page language="java" import="java.util.*" pageEncoding="UTF-8"%>
<%@ include file="/common/taglibs.jsp"%>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<%@ include file="/common/meta.jsp"%>
<title>Item Tool Manage - Transaction List</title>
<script type="text/javascript" src="${ctxPath}/js/tags/My97DatePicker/WdatePicker.js"></script>
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
		<a href="${phpPath }">Home</a> &raquo; 
		<span>Transaction List</span>
	</div><!-- breadcrumbs -->
	
	<div class="span-23">
			<div id="content">
				<a class="search-button" href="#">Advanced Search</a>
				<div class="search-form" style="display: none">
					<div class="wide form">
						<form id="searchForm" onsubmit="return validate();" action="${ctxPath }/company/transaction/list.shtml" method="post">
							<div class="row">
								<label for="companyName">Company</label> 
								<input name="companyName" id="companyName" type="text" value="${transaction.companyName }" />
							</div>
							<div class="row">
								<label for="paymentTransactionId">TranId</label> 
								<input name="paymentTransactionId" id="paymentTransactionId" type="text" value="${transaction.paymentTransactionId }"/>
							</div>
							<div class="row">
								<label for="tranType">TranType</label> 
								<select name="type" id="type">
									<option value="">All</option>
									<option value="1">Deposit</option>
									<option value="2">Withdraw</option>
									<option value="3">Freeze</option>
									<option value="4">Unfreeze</option>
									<option value="5">Deduction</option>
								</select>
							</div>
							<div class="row">
								<label for="total">Total</label> 
								<input name="totalMin" id="totalMin" type="text" value="${transaction.totalMin }"/>
								&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;
								<input name="totalMax" id="totalMax" type="text" value="${transaction.totalMax }"/>
							</div>
							<div class="row">
								<label for="date">Date</label> 
								from:<input name="createDateStart" id="createDateStart" type="text" value="${transaction.createDateStart }" onfocus="WdatePicker({isShowWeek:true})"/>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								to:<input  name="createDateEnd" id="createDateEnd" type="text" value="${transaction.createDateEnd }" onfocus="WdatePicker({isShowWeek:true})"/>
							</div>
							<div class="row buttons">
								<input type="submit" name="yt0" value="Search" />
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								<input type="button" name="clear" id="clear" value="Clear" />
							</div>
						</form>
					</div>
				</div>
				<div id="resource-string-grid" class="grid-view">
					<a href="${ctxPath }/company/transaction/toAdd.shtml" >添加</a>
					<table class="items">
						<thead>
							<tr>
								<th id="resource-string-grid_c0">
									<a class="sort-link" href="">Date</a>
								</th>
								<th id="resource-string-grid_c0">
									<a class="sort-link" href="">Company</a>
								</th>
								<th id="resource-string-grid_c0">
									<a class="sort-link" href="">tranType</a>
								</th>
								<th id="resource-string-grid_c0">
									<a class="sort-link" href="">paymentType</a>
								</th>
								<th id="resource-string-grid_c0">
									<a class="sort-link" href="">TranId</a>
								</th>
								<th id="resource-string-grid_c0">
									<a class="sort-link" href="">Status</a>
								</th>
								<th id="resource-string-grid_c0">
									<a class="sort-link" href="">Total</a>
								</th>
								<th id="resource-string-grid_c0">
									<a class="sort-link" href="">Fee</a>
								</th>
								<th id="resource-string-grid_c0">
									<a class="sort-link" href="">Net</a>
								</th>
								<th id="button-column" width="100px">Action</th>
							</tr>
						</thead>
						<tbody>
							<c:forEach items="${transactionList }" var="obj">
								<tr>
								    <td>${obj.createTimeStr }</td>
								    <td>${obj.companyName }</td>
								    <td>
								    	<c:if test="${obj.type == 1}">Paypal</c:if>
								    	<c:if test="${obj.type == 2}">System</c:if>
								    </td>
								    <td>
								    	<c:if test="${obj.paymentTransactionType == 1}">存款</c:if>
								    	<c:if test="${obj.paymentTransactionType == 2}">取款</c:if>
								    	<c:if test="${obj.paymentTransactionType == 3}">冻结</c:if>
								    	<c:if test="${obj.paymentTransactionType == 4}">解冻</c:if>
								    	<c:if test="${obj.paymentTransactionType == 5}">扣款</c:if>
								   </td>
								    <td>${obj.paymentTransactionId }</td>
								    <td>
								    	<c:if test="${obj.status == 1}">创建</c:if>
								    	<c:if test="${obj.status == 2}">成功</c:if>
								    	<c:if test="${obj.status == 3}">取消</c:if>
								    	<c:if test="${obj.status == 4}">失败</c:if>
								    </td>
								    <td><fmt:formatNumber value="${obj.total }" pattern="##.##" minFractionDigits="2" ></fmt:formatNumber></td>
									<td><fmt:formatNumber value="${obj.fee }" pattern="##.##" minFractionDigits="2" ></fmt:formatNumber></td>
								    <td><fmt:formatNumber value="${obj.net }" pattern="##.##" minFractionDigits="2" ></fmt:formatNumber></td>
								    <td><a href="${ctxPath }/company/transaction/view.shtml?id=${obj.id}">view</a>
								    	<c:if test="${obj.type == 2 && obj.status == 1 }">
								    		&nbsp;&nbsp;
								    		<a href="${ctxPath }/company/transaction/approveWithdraw.shtml?id=${obj.id}">同意退款</a>
								    	</c:if>
								    </td>
								</tr>
								</c:forEach>
						</tbody>
						<%@ include file="/common/page.jsp"%>
					</table>
				</div>
			</div>
			<!-- content -->
</div>

	<div class="clear"></div>
	<%@ include file="/common/footer.jsp"%><!-- footer -->
</div>

<script type="text/javascript">
/*<![CDATA[*/
jQuery(function($) {
	//初始化，如果带条件的查询返回时，展开查询条件
	if("${conditionSearchFlag}" == "true") {
		var tranType = "${transaction.type }";
		if(tranType != "") {
			$("select option[value='"+ tranType +"']").attr("selected","selected");
		}
		$('.search-form').toggle();
	}
	
	//展开收缩查询条件
	$('.search-button').click(function(){
		$('.search-form').toggle();
		return false;
	});
	
	//
	$("#clear").click(function() {
		$("input[type='text']").val("");
		$("select option:first").attr("selected","selected");
	});
	
});

function validate() {
	
}
/*]]>*/
</script>
</body>
</html>
