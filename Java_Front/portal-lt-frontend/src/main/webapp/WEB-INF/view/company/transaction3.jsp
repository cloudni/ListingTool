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
		<a href="${phpPath }${phpPath }">首页</a> &raquo; 
		<a href="${phpPath }${phpPath }/company/index">公司</a> &raquo; 
		<a href="${phpPath }${phpPath }/company/1">上海吟泽信息技术有限公司</a> &raquo; 
		<span>Finance</span>
	</div><!-- breadcrumbs -->
	 <div class="span-5 last">
        <div id="sidebar">
        	<div class="portlet" id="yw2">
				<div class="portlet-decoration">
					<div class="portlet-title">操作</div>
				</div>
				<div class="portlet-content">
					<ul class="operations" id="yw3">
					<li><a href="${phpPath }${phpPath }/company/update">修改公司</a></li>
					<li><a href="${phpPath }${phpPath }/company/index">View</a></li>
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

    .tabTitle{
        border-right: 1px solid #9D9EA0; padding: 0px 15px 0px 15px;
    }

    .tabSelected{
        background-image: url(/themes/facebook/images/p8WLIWfshBr.png);
        background-repeat: no-repeat;
        background-size: auto;
        background-position: -28px -50px;
        bottom: -1px;
        height: 9px;
        left: 35%;
        margin-left: -8px;
        position: absolute;
        width: 17px;
        display: none;
    }
</style>

<div style="clear: both; width: 100%; position: relative; top: -5px;">
    <div class="borderBlock">
        <div>
            <div style="background: #f6f7f8; border-bottom: 1px solid #e9eaed; font-size: 12px;">
                <div style="height: 36px; color: #9197a3; font-weight: normal;">
                    <div style="color: #4e5665; font-weight: 700; padding-left: 14px; line-height: 38px; position: relative; background-color: #fff;">
                        <span class="tabTitle">上海吟泽信息技术有限公司<span id="point_angle" class="tabSelected" style="left: 13%;"></span></span>
                        <a id="transaction_detail_link" onclick="updateFinancePanel('transaction_detail');" class="tabTitle">Transaction Detail<span id="transaction_detail_point_angle" class="tabSelected" style="display: block;"></span></a>
                        <a id="deposit_link" onclick="updateFinancePanel('deposit');" class="tabTitle">Deposit<span id="deposit_point_angle" class="tabSelected" style="left: 49%;"></span></a>
                        <a id="withdraw_link" onclick="updateFinancePanel('withdraw');" class="tabTitle">Withdraw<span id="withdraw_point_angle" class="tabSelected" style="left: 60%;"></span></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="transaction_detail_tab" style="clear: both; width: 100%; position: relative; top: -5px; ">
	<!-- onsubmit="return validate()" -->
    <form id="searchForm" action="${ctxPath }/company/transaction/list.shtml" method="post">    
    <div class="borderBlock">
        <div>
            <div class="clearfix" style="border-top: 1px solid transparent;">
                <div id="search_input_panel" style="width: 100%; padding: 5px; margin: 0px;">
                    <div class="container">
                    	<div style="float:left;">
                     	<select name="searchType" id="searchType">
							<option value="all">请选择查询条件</option>
							<option value="1">tranId</option>
							<option value="2">Total</option>
							<option value="3">Date</option>
						</select>&nbsp;
						</div>
						<div style="float:left;">
							<div class="selectValue" id="1" style="display:none;"><input size="30" type="text" name="paymentTransactionId" id="transaction_id" value="${transaction.paymentTransactionId }"/></div>
							<div class="selectValue" style="display:none;">
								<input size="20" type="text" name="totalMin" id="transaction_totalMin" value="${transaction.totalMin }" maxlength="10"/>
								&nbsp;-&nbsp;<input size="20" type="text" name="totalMax" id="transaction_totalMax" value="${transaction.totalMax }" maxlength="10"/></div>
	                        <div class="selectValue" style="display:none;">
	                        	from:<input size="20" type="text" name="createDateStart" id="transaction_createDateStart" value="${transaction.createDateStart }" maxlength="20" onfocus="WdatePicker({isShowWeek:true})"/>
	                        	&nbsp;&nbsp;to:<input size="20" type="text" name="createDateEnd" id="transaction_createDateEnd" value="${transaction.createDateEnd }" maxlength="20" onfocus="WdatePicker({isShowWeek:true})"/></div>
						</div>
							
						<div>&nbsp;
							<input id="search_button" name="search_button" class="greenButton" 
								type="submit" value="搜索" name="yt0" style="font-size: 14px; width: 70px;"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </form>

    <div class="borderBlock">
        <div>
            <div style="display: block; padding: 5px;">
                <div>
                    <span style="font-size: 16px; font-weight: bold;">Account Balance: $${ company.balance} USD</span>
                </div>
                <table width="100%" cellspacing="0" cellpadding="0" style="border-bottom: 1px solid #e5ecf9;" >
                    <thead>
                    <tr>
                        <th>Date</th>
                        <th>tranType</th>
                        <th>TranId</th>
                        <th>Status</th>
                        <th>Total</th>
                        <th>Fee</th>
                        <th>Net</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
	                    <div id="yw0" class="list-view">
							<div class="items">
								<span class="empty"><c:if test="${empty transactionList}">没有找到数据</c:if>${msg }</span>
								<c:forEach items="${transactionList }" var="obj">
								<tr>
								    <td>${obj.createTimeStr }</td>
								    <td>${obj.transactionType }</td>
								    <td>${obj.paymentTransactionId }</td>
								    <td>${obj.status }</td>
								    <td>${obj.total }</td>
								    <td>${obj.fee }</td>
								    <td>${obj.net }</td>
								    <td></td>
								</tr>
								</c:forEach>
							</div>
						</div>                    
					</tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div id="deposit_tab" style="clear: both; width: 100%; position: relative; top: -5px; display: none;">
    <div class="borderBlock">
        <div>
        	<form id="searchForm" class="validateForm" method="post" action="${ctxPath }/company/transaction/deposit.shtml">
            <div style="display: block; padding: 5px;">
                <select name="type">
                    <option value="paypal">PayPal</option>
                    <option value="zhifubao">zhifubao</option>
                </select>
                <span style="padding: 0px 5px 0px 5px;">$</span><input type="text" size="60" name="total" class="required number"/>
                <input id="search_button" name="search_button" class="greenButton" type="submit" value="submit" name="yt0" style="font-size: 14px; width: 70px;"/>
            </div>
            </form>
        </div>
    </div>
</div>

<div id="withdraw_tab" style="clear: both; width: 100%; position: relative; top: -5px; display: none;">
    <div class="borderBlock">
        <div>
        	<form id="form" method="post" action="${ctxPath }/company/transaction/withdraw.shtml">
            <div style="display: block; padding: 5px;">
                <div>
                    <span>to PayPal Account: </span><input type="text" size="60" name="email" class="required" maxlength="100"/>
                </div>
                <div style="padding-top: 7px;">
                    <span style="padding: 0px 5px 0px 5px;">$</span>
                    <input type="text" size="60" name="total" class="required number" maxlength="10"/>
                </div>
                <div style="padding-top: 7px;">
                    <textarea style="width: 69%" rows="5" ></textarea>
                </div><br />
                <input id="search_button" name="search_button" class="greenButton" 
						type="submit" value="submit" name="yt0" style="font-size: 14px; width: 70px;"/>
			</div>
            </form>
        </div>
    </div>
</div>

<script>
    function updateFinancePanel(id)
    {
        if(id == 'transaction_detail')
        {
            $("#transaction_detail_tab").css("display", "");
            $("#deposit_tab").css("display", "none");
            $("#withdraw_tab").css("display", "none");
            $("#transaction_detail_point_angle").css("display", "");
            $("#deposit_point_angle").css("display", "none");
            $("#withdraw_point_angle").css("display", "none");
        }
        else if(id == 'deposit')
        {
            $("#transaction_detail_tab").css("display", "none");
            $("#deposit_tab").css("display", "");
            $("#withdraw_tab").css("display", "none");
            $("#transaction_detail_point_angle").css("display", "none");
            $("#deposit_point_angle").css("display", "");
            $("#withdraw_point_angle").css("display", "none");
        }
        else if(id == 'withdraw')
        {
            $("#transaction_detail_tab").css("display", "none");
            $("#deposit_tab").css("display", "none");
            $("#withdraw_tab").css("display", "");
            $("#transaction_detail_point_angle").css("display", "none");
            $("#deposit_point_angle").css("display", "none");
            $("#withdraw_point_angle").css("display", "");
        }
    }
    
    jQuery(function($) {
		var searchType = "${transaction.searchType}";
		jQuery("#searchType option").each(function(){
			if(searchType == jQuery(this).val()) {
				jQuery(this).attr("selected", "selected");
				
				jQuery(".selectValue:eq(" + (searchType -1) +")").css("display", "");
			}
		});
		
		jQuery("#searchType").change(function() {
			var selected_value = jQuery(this).children('option:selected').val(); //alert(jQuery(".selectValue:eq(0)").css("display"));
			if(selected_value == "all") {
				jQuery(".selectValue").css("display", "none").find("input").val("");
			} else {
				var divObj = jQuery(".selectValue:eq(" + (selected_value-1) +")");
				divObj.css("display", "");
				divObj.siblings().css("display", "none").find("input").val("");
			}
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
