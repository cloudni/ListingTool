<%@ page language="java" import="java.util.*" pageEncoding="UTF-8"%>
<%@ include file="/common/taglibs.jsp"%>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<%@ include file="/common/meta.jsp"%>
<title>Item Tool Manage - View Transaction</title>
</head>

<body>

	<div id="ajaxloading">
		<div>
			<img src="/images/load.gif" align="absmiddle" /><span>Data is
				loading</span>
		</div>
	</div>

	<div class="container" id="page">
		<%@ include file="/common/top.jsp"%>

		<!-- mainmenu -->
		<div class="breadcrumbs">
			<a href="${phpPath }">Home</a> &raquo; 
			<a href="${ctxPath }/company/transaction/list.shtml">Transaction List</a> &raquo;
			<span>Transaction Detail</span>
		</div>
		<!-- breadcrumbs -->
		<div class="span-19">
			<div id="content">

				<h1>View transaction</h1>

				<table class="detail-view" id="yw0">
					<tr class="odd"><th>交易日期:</th><td>${transaction.createTimeStr}</td></tr>
					<tr class="even"><th>类型:</th>
						<td><c:if test="${transaction.paymentTransactionType == 1 }">存款</c:if>
							<c:if test="${transaction.paymentTransactionType == 2 }">取款</c:if>
							<c:if test="${transaction.paymentTransactionType == 3 }">冻结</c:if>
							<c:if test="${transaction.paymentTransactionType == 4 }">解冻</c:if>
							<c:if test="${transaction.paymentTransactionType == 5 }">扣款</c:if>
						</td></tr>
					<tr class="odd"><th>状态:</th>
						<td><c:if test="${transaction.status == 1}">创建</c:if>
							<c:if test="${transaction.status == 2}">成功</c:if>
							<c:if test="${transaction.status == 3}">取消</c:if>
							<c:if test="${transaction.status == 4}">失败</c:if>
						</td></tr>
					<tr class="even">
						<th>备注:</th>
						<td>${transaction.contents}
						</td>
					</tr>
					<tr class="odd"><th>金额:</th><td>
						<c:if test="${transaction.paymentTransactionType == 2 || transaction.paymentTransactionType == 3 || transaction.paymentTransactionType == 5 }"><span style="color: red"></c:if>
							$<fmt:formatNumber value="${transaction.net }" pattern="##.##" minFractionDigits="2" ></fmt:formatNumber>
						<c:if test="${transaction.paymentTransactionType == 2 || transaction.paymentTransactionType == 3 || transaction.paymentTransactionType == 5 }"></span></c:if>
					</td></tr>
					<tr class="even"><th>交易扣款:</th><td>$<fmt:formatNumber value="${transaction.fee }" pattern="##.##" minFractionDigits="2" ></fmt:formatNumber></td></tr>
					<tr class="odd"><th>合计:</th><td>
						<c:if test="${transaction.paymentTransactionType == 2 || transaction.paymentTransactionType == 3 || transaction.paymentTransactionType == 5 }"><span style="color: red"></c:if>
							$<fmt:formatNumber value="${transaction.total }" pattern="##.##" minFractionDigits="2" ></fmt:formatNumber>
						<c:if test="${transaction.paymentTransactionType == 2 || transaction.paymentTransactionType == 3 || transaction.paymentTransactionType == 5 }"></span></c:if>	
					</td></tr>
				</table>
			</div>
			<!-- content -->
		</div>

		<div class="clear"></div>

		<%@ include file="/common/footer.jsp"%><!-- footer -->

	</div>
	<!-- page -->

	<script type="text/javascript">
		/*<![CDATA[*/
		jQuery(function($) {
			
		});
		/*]]>*/
	</script>
</body>
</html>
