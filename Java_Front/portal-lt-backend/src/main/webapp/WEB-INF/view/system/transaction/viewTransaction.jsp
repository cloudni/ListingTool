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
					<tr class="odd">
						<th>ID:</th>
						<td>${transaction.id}</td>
					</tr>
					<tr class="even">
						<th>Company:</th>
						<td>${company.name }</td>
					</tr>
					<tr class="odd">
						<th>TranType:</th>
						<td>${transaction.type}</td>
					</tr>
					<tr class="even">
						<th>TranId:</th>
						<td>${transaction.paymentTransactionId }</td>
					</tr>
					<tr class="odd">
						<th>CreateTime:</th>
						<td>${transaction.createTimeStr}</td>
					</tr>
					<tr class="even">
						<th>CompleteTime:</th>
						<td>${transaction.updateTimeStr}</td>
					</tr>
					<tr class="odd">
						<th>Total:</th>
						<td>${transaction.total }</td>
					</tr>
					<tr class="even">
						<th>Fee:</th>
						<td>${transaction.fee }</td>
					</tr>
					<tr class="odd">
						<th>Net:</th>
						<td>${transaction.net }</td>
					</tr>
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
