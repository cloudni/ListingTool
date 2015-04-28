<%@ page language="java" import="java.util.*" pageEncoding="UTF-8"%>
<%@ include file="/common/taglibs.jsp"%>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<%@ include file="/common/meta.jsp"%>
<title>Item Tool Manage - Add Transaction</title>
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
			<a href="${ctxPath }/company/transaction/list.shtml">Transaction List</a> &raquo;
			<span>Transaction Add</span>
		</div>
		<!-- breadcrumbs -->
		<form id="addForm" class="validateForm" action="${ctxPath }/company/transaction/add.shtml" method="post">
		<div class="span-19">
			<div id="content">

				<h1>View transaction</h1>

				<table class="detail-view" id="yw0">
					<tr class="even">
						<th>Company:<span class="required">*</span></th>
						<td>
							<select name="companyId" id="company_name" class="required">
								<option value="">请选择</option>
								<c:forEach items="${companyList }" var="obj">
									<option value="${obj.id }">${obj.name }</option>
								</c:forEach>
							</select>
						</td>
					</tr>
					<tr class="odd">
						<th>type:<span class="required">*</span></th>
						<td>
							<select name="type" id="type" class="required">
								<option value="2">system</option>
							</select>
						</td>
					</tr>
					<tr class="even">
						<th>TranType:<span class="required">*</span></th>
						<td>
							<select name="transactionType" id="transactionType" class="required">
								<option value="1">deposit</option>
								<!-- <option value="withdraw">withdraw</option> -->
							</select>
						</td>
					</tr>
					<tr class="odd">
						<th>Total:<span class="required">*</span></th>
						<td><input type="text" name="total" id="transaction_total" value="${transaction.total }" class="required"/></td>
					</tr>
					<tr class="even">
						<th>Remark:</th>
						<td>
	                          <textarea rows="5" cols="50" name="contents"></textarea>
						</td>
					</tr>
				</table>
				
				<div class="row buttons">
					<input type="submit" name="yt0" value="Submit" />	
				</div>
			</div>
		</div>
		</form>
		<div class="clear"></div>

		<%@ include file="/common/footer.jsp"%><!-- footer -->

	</div>
	<!-- page -->

	<script type="text/javascript">
		/*<![CDATA[*/
		jQuery(function($) {
			
		});
		/*]]>*/
		
		function changeInputBackground(obj)
	    {
	        if($(obj).val().length > 0)
	            $(obj).css('background-color', '#fff');
	        else
	            $(obj).css('background-color', 'transparent');
	    }
			
		 function focusWarningIcon(obj)
	    {
	        changeInputBackground(obj);
	        if($(obj.parentNode.parentNode.childNodes[3]).css('display') != 'none')
	        {
	            $("#"+$(obj).attr('tooltip')).css('display', 'block');
	        }
	        $(obj).css('border-color', '#bdc7d8');
	        $(obj.parentNode.parentNode.childNodes[3]).css('display', 'none');
	    }
	</script>
</body>
</html>
