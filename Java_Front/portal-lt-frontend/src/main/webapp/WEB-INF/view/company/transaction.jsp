<%@ page language="java" import="java.util.*" pageEncoding="UTF-8"%>
<%@ include file="/common/taglibs.jsp"%>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<%@ include file="/common/meta.jsp"%>
	<title>Item Tool - Finance Company</title>
	<script type="text/javascript" src="${ctxPath}/js/tags/My97DatePicker/WdatePicker.js"></script>
	<script type="text/javascript" src="${ctxPath}/js/bootstrap.min.js"></script> 
	<style>
		.alert {
		  padding: 15px;
		  margin-bottom: 20px;
		  border: 1px solid transparent;
		  border-radius: 4px;
		}
		
		.alert-danger {
		  color: #a94442;
		  background-color: #f2dede;
		  border-color: #ebccd1;
		}
		
		.alert-dismissable,
		.alert-dismissible {
		  padding-right: 35px;
		}
		.alert-dismissable .close,
		.alert-dismissible .close {
		  position: relative;
		  top: -2px;
		  right: -21px;
		  color: inherit;
		}
		
		.close {
		  float: right;
		  font-size: 21px;
		  font-weight: bold;
		  line-height: 1;
		  color: #000;
		  text-shadow: 0 1px 0 #fff;
		  filter: alpha(opacity=20);
		  opacity: .2;
		}
		.close:hover,
		.close:focus {
		  color: #000;
		  text-decoration: none;
		  cursor: pointer;
		  filter: alpha(opacity=50);
		  opacity: .5;
		}
		button.close {
		  -webkit-appearance: none;
		  padding: 0;
		  cursor: pointer;
		  background: transparent;
		  border: 0;
		}
	</style>
</head>

<body>
<%@ include file="/common/top.jsp"%>

<div class="container" id="page">
	<%@ include file="/common/header.jsp"%>
	<!-- mainmenu -->
			<div class="breadcrumbs">
				<a href="${phpPath}/site/index.html">${session.menu_home }</a> &raquo; 
				<a href="${phpPath}/company/view.html">${session.company_title }</a> &raquo; 
				<a href="${phpPath}/company/update.html">${company.name }</a> &raquo; 
				<span>${session.company_financa}</span>
			</div><!-- breadcrumbs -->
    
	    <div class="span-5 last">
        <div id="sidebar">
        <div class="portlet" id="yw2">
<div class="portlet-decoration">
<div class="portlet-title">${session.operations }</div>
</div>
<div class="portlet-content">
<ul class="operations" id="yw3">
<li><a href="${phpPath}/company/update.html">${session.company_update_menu }</a></li>
<li><a href="${phpPath}/company/view.html">${session.company_title }</a></li>
</ul></div>
</div>        </div><!-- sidebar -->
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
        background-image: url(${ctxPath}/themes/facebook/images/p8WLIWfshBr.png);
        background-repeat: no-repeat;
        background-size: auto;
        background-position: -28px -50px;
        bottom: -1px;
        height: 9px;
        margin-left: 0px;
        position: absolute;
        width: 17px;
    }
    
    .searchStyle {
    	height: 22px;
    }
</style>
<c:if test="${fn:indexOf(msg, 'error') == 0}">
<div style="clear: both; width: 100%; position: relative; top: 5px; ">
    <div class="alert alert-danger alert-dismissable" role="alert">
		<button class="close" type="button" data-dismiss="alert">&times;</button>
			<c:if test="${msg == 'error_withdraw' }">
				存款失败，请联系管理员！
			</c:if>
			<c:if test="${msg == 'error_deposit' }">
				取款失败，请联系管理员！
			</c:if>
    </div>
</div>
</c:if>
 <div style="clear: both; width: 100%; position: relative; top: -5px;">
    <div class="borderBlock">
         <div style="background: #f6f7f8; border-bottom: 1px solid #e9eaed; font-size: 12px;">
             <div style="height: 36px; color: #9197a3; font-weight: normal;background-color: #fff;">
                 <div style="color: #4e5665; font-weight: 700; padding:0 14px; line-height: 38px; position: relative; background-color: #fff; float: left;">
                     <span style="padding: 0 15px">&nbsp;${company.name }<span id="point_angle" style="left: 13%;"></span></span>
                 </div>
                 <div style="line-height: 38px; position: relative; float: left;">
                 	<span style="border-right: 1px solid #9d9ea0;"></span>
                 </div>
                 <div style="color: #4e5665; font-weight: 700; padding:0 14px; line-height: 38px; position: relative; background-color: #fff; float: left; text-align: center;">
                     <a id="transaction_detail_link" onclick="updateFinancePanel('transaction_detail');">${session.transaction_detail }<span id="transaction_detail_point_angle" class="tabSelected" style="left: 48%;alight: block;"></span></a>
                 </div>
                 <div style="line-height: 38px; position: relative; float: left;">
                 	<span style="border-right: 1px solid #9d9ea0;"></span>
                 </div>
                 <div style="color: #4e5665; font-weight: 700; padding:0 14px; line-height: 38px; position: relative; background-color: #fff; float: left; text-align: center;">
                     <a id="deposit_link" onclick="updateFinancePanel('deposit');">${session.deposit }<span id="deposit_point_angle" class="tabSelected" style="left: 40%; display: none;"></span></a>
                 </div>
                 <div style="line-height: 38px; position: relative; float: left;">
                 	<span style="border-right: 1px solid #9d9ea0;"></span>
                 </div>
                 <div style="color: #4e5665; font-weight: 700; padding:0 14px; line-height: 38px; position: relative; background-color: #fff; float: left; text-align: center;">
                     <a id="withdraw_link" onclick="updateFinancePanel('withdraw');">${session.withdraw }<span id="withdraw_point_angle" class="tabSelected" style="left: 40%; display: none;"></span></a>
                 </div>
                 <div style="line-height: 38px; position: relative; float: left;">
                 	<span style="border-right: 1px solid #9d9ea0;"></span>
                 </div>
             </div>
         </div>
    </div>
</div>

<div id="transaction_detail_tab" style="clear: both; width: 100%; position: relative; top: -5px; ">
	<form id="searchForm" class="validateForm" action="${ctxPath }/company/transaction/list.shtml" method="post">    
    <div class="borderBlock">
        <div>
        	<div></div>
            <div class="clearfix" style="border-top: 1px solid transparent;">
                <div id="search_input_panel" style="width: 100%; padding: 5px; margin: 0px;">
                    <div class="container">
                    	<div style="float:left;">
	                     	<select name="searchType" id="searchType" class="searchStyle" style="height: 22px;">
								<option value="all">${session.select_condition }</option>
								<option value="1">${session.transactionId }</option>
								<option value="2">${session.total }</option>
								<option value="3">${session.date }</option>
							</select>&nbsp;
						</div>
						<div style="float:left;">
							<div class="selectValue" id="1" style="display:none;">
								<input size="30" type="text" class="searchStyle"
									name="paymentTransactionId" id="transaction_id" value="${transaction.paymentTransactionId }" maxlength="20"/></div>
							<div class="selectValue" style="display:none;">
								<input size="20" type="text" class="searchStyle number" style="text-align:right"
									name="totalMin" id="transaction_totalMin" value="<fmt:formatNumber value="${transaction.totalMin }" pattern="##.##" minFractionDigits="2" />" maxlength="10"/>
								&nbsp;-&nbsp;<input size="20" type="text" class="searchStyle number" style="text-align:right"
									name="totalMax" id="transaction_totalMax" value="<fmt:formatNumber value="${transaction.totalMax }" pattern="##.##" minFractionDigits="2" />" maxlength="10"/></div>
	                        <div class="selectValue" style="display:none;">
	                        	${session.date_from }:<input size="20" type="text" class="searchStyle"
	                        		name="createDateStart" id="transaction_createDateStart" value="${transaction.createDateStart }" maxlength="20" 
	                        		onfocus="WdatePicker({maxDate:'#F{$dp.$D(\'transaction_createDateEnd\')}'})"/>
	                        	&nbsp;&nbsp;${session.date_to }:<input size="20" type="text" class="searchStyle"
	                        		name="createDateEnd" id="transaction_createDateEnd" value="${transaction.createDateEnd }" maxlength="20" 
	                        		onfocus="WdatePicker({minDate:'#F{$dp.$D(\'transaction_createDateStart\')}'})"/></div>
						</div>
							
						<div>&nbsp;
							<input id="search_button" name="search_button" class="greenButton" 
								type="submit" value="${session.btn_search }" name="yt0" style="font-size: 14px; width: 70px;"/>
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
                <table width="100%" cellspacing="0" cellpadding="0" style="border-bottom: 1px solid #e5ecf9;" >
                    <thead>
                    <tr>
                        <th style="width: 110px;">${session.date }</th>
                        <th>${session.type }</th>
                        <th style="width: 150px;">${session.transaction_relation }</th>
                        <th>${session.status }</th>
                        <th style="text-align: right;">${session.total }</th>
                        <th style="text-align: right;">${session.fee }</th>
                        <th style="text-align: right;">${session.net }</th>
                        <th>${session.action }</th>
                    </tr>
                    </thead>
                    <tbody>
	                    <div id="yw0" class="list-view">
							<div class="items">
									<span style="font-size: 13px;font-weight:bold;">${session.account_alance }: $<fmt:formatNumber value="${ company.balance + company.authorizeAmount}" pattern="##.##" minFractionDigits="2" />&nbsp;(${session.company_authorize_amount }: $<fmt:formatNumber value="${ company.authorizeAmount}" pattern="##.##" minFractionDigits="2" />)
								</span>
								<br/><br/>
								<span class="empty"><c:if test="${empty transactionList}">${session.no_data }</c:if></span>
								<c:forEach items="${transactionList }" var="obj">
								<tr>
								    <td>${obj.createTimeStr }</td>
								    <td>${obj.paymentTransactionTypeName }</td>
								    <td>${obj.campaignName }</td>
								    <td>${obj.statusName }</td>
								    <td style="text-align: right;">
								    	<c:if test="${obj.paymentTransactionType == 2 || obj.paymentTransactionType == 3 || obj.paymentTransactionType == 5 }"><span style="color: red"></c:if>
								    		$<fmt:formatNumber value="${obj.total }" pattern="##.##" minFractionDigits="2" ></fmt:formatNumber>
								    	<c:if test="${obj.paymentTransactionType == 2 || obj.paymentTransactionType == 3 || obj.paymentTransactionType == 5 }"></span></c:if>	
								    </td>
								    <td style="text-align: right;">
									    <c:if test="${obj.fee  > 0}"><span style="color: red"></c:if>
									    	$<fmt:formatNumber value="${obj.fee }" pattern="##.##" minFractionDigits="2" ></fmt:formatNumber>
								    	<c:if test="${obj.fee  > 0}"></span></c:if>
								    </td>
								    <td style="text-align: right;">
								    	<c:if test="${obj.paymentTransactionType == 2 || obj.paymentTransactionType == 3 || obj.paymentTransactionType == 5 }"><span style="color: red"></c:if>
								    		$<fmt:formatNumber value="${obj.net }" pattern="##.##" minFractionDigits="2" ></fmt:formatNumber>
								    	<c:if test="${obj.paymentTransactionType == 2 || obj.paymentTransactionType == 3 || obj.paymentTransactionType == 5 }"></span></c:if>			
								    </td>
								    <td><a href="${ctxPath }/company/transaction/view.shtml?id=${obj.id}">&nbsp;&nbsp;${session.view }</a></td>
								</tr>
								</c:forEach>
							</div>
						</div>                    
					</tbody>
					<%@ include file="/common/page.jsp"%>
                </table>
            </div>
        </div>
    </div>
</div>

<div id="deposit_tab" style="clear: both; width: 100%; position: relative; top: -5px; display: none;">
    <div class="borderBlock">
        <div>
            <div style="background: #f6f7f8; border-bottom: 1px solid #e9eaed; font-size: 12px;">
                <div style="height: 36px; color: #9197a3; font-weight: normal;">
                    <h1 style="color: #4e5665; font-weight: 700; padding-left: 14px; line-height: 20px; position: relative; font-size: 12px;">${session.deposit }</h1>
                </div>
            </div>
            <div style="display: block; padding: 0px 10px 0px 10px;">
                
		<div class="form">
        	<form id="depositForm" class="validateForm" method="post" action="${ctxPath }/company/transaction/deposit.shtml">
            <p class="note">${session.warning }</p>
               <div class="row">
					<label for="">${session.payment_way }:</label>
					<select name="paymentTransactionType" style="width: 150px;">
                    	<option value="1">Paypal</option>
                    	<!-- <option value="zhifubao">${session.alipay }</option> -->
                	</select>
				</div>
				
				<div class="row">
					<label for="">${session.amount_$ }:<span class="required">*</span></label>		
					<input type="text" size="60" name="total" class="required number" style="text-align:right;width: 80px;"/>
				</div>
				
				<div class="row buttons">
					<input class="greenButton" style="font-size: 14px; width: 70px;" type="submit" name="yt0" value="${session.btn_submit }" />
				</div>
				
            </form>
        </div></div>
        </div>
    </div>
</div>

<div id="withdraw_tab" style="clear: both; width: 100%; position: relative; top: -5px; display: none;">
    <div class="borderBlock">
        <div>
            <div style="background: #f6f7f8; border-bottom: 1px solid #e9eaed; font-size: 12px;">
                <div style="height: 36px; color: #9197a3; font-weight: normal;">
                    <h1 style="color: #4e5665; font-weight: 700; padding-left: 14px; line-height: 20px; position: relative; font-size: 12px;">${session.withdraw }</h1>
                </div>
            </div>
            <div style="display: block; padding: 0px 10px 0px 10px;">
                
		<div class="form">
        	<form id="form" onsubmit="return validate();" method="post" action="${ctxPath }/company/transaction/withdraw.shtml">
        	
        		<div><br/>
                    <span style="font-size: 13px;">${session.account_alance }: $<fmt:formatNumber value="${ company.balance}" pattern="##.##" minFractionDigits="2" /> USD</span>
                </div>
                
        	<input type="hidden" id="company_balance" value="${company.balance}"/>
        	<p class="note">${session.warning }</p>
	       		<div class="row">
					<label for="">${session.payment_way }:</label>
					<select name="paymentTransactionType" style="width: 150px;">
	                   	<option value="1">Paypal</option>
	                   	<!-- <option value="zhifubao">${session.alipay }</option> -->
	               	</select>
			   </div>
               <div class="row">
					<label for="paypal_account">${session.paypal_account }:<span class="required">*</span></label>		
					<input type="text" size="60" name="email" class="required email" style="width: 400px;"/>
				</div>
				
				<div class="row">
					<label for="">${session.amount_$ }:<span class="required">*</span></label>		
					<input type="text" size="60" name="total" id="withdraw_total" class="required number" style="text-align:right;width: 80px;"/>
				</div>
				
				<!-- <div class="row">
					<textarea style="width: 50%" rows="5"></textarea>
				</div> -->
				
				<div class="row">
                            <div style="margin-right: 8px; margin-bottom: 10px; ">
                                <div>
                                    <div style="background: white; -webkit-border-radius: 5px; display: inline-block; position: relative;">
                                        <div class="placeholder" style="font-size: 20px; top: 5px; padding: 8px 10px; -webkit-box-sizing: border-box; overflow: hidden;text-overflow: ellipsis; white-space: nowrap;">Note</div>
                                        <textarea name="contents" style="font-size: 18px; padding: 8px 10px; border-color: #bdc7d8; -webkit-border-radius: 5px; margin: 0; background-color: transparent; position: relative; border: 1px solid #bdc7d8;-webkit-user-select: text;-webkit-rtl-ordering: logical;width: 400px;" rows="5" cols="39" onkeyup="changeInputBackground(this);" onfocus="focusWarningIcon(this);"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
				
				<div class="row buttons">
					<input class="greenButton" style="font-size: 14px; width: 70px;" type="submit" name="yt1" value="${session.btn_submit }" />
				</div>
            </form>
        </div><!-- form -->            </div>
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
    
    //提交申请退款前的校验
    function validate() {
    	var withdraw_total = $("#withdraw_total").val();
    	var company_balance = $("#company_balance").val();
    	
    	if(parseFloat(withdraw_total) >= parseFloat(company_balance)) {
    		alert("退款金额不能大于账户余额");
    		return false;
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

    function blurWarningIcon(obj, err)
    {
        $("div[id^='tooltip']").css('display', 'none');
        if($(obj).val().length <= 0 || err == true)
        {
            $(obj).css('border-color', '#8b0300');
            $(obj.parentNode.parentNode.childNodes[3]).css('display', '');
        }
        else
        {
            $(obj).css('border-color', '#bdc7d8');
            $(obj.parentNode.parentNode.childNodes[3]).css('display', 'none');
        }
    }

    function changeInputBackground(obj)
    {
        if($(obj).val().length > 0)
            $(obj).css('background-color', '#fff');
        else
            $(obj).css('background-color', 'transparent');
    }

    function CheckInputSignUpName(oInput)
    {
        if('' != oInput.value.replace(/[a-zA-Z_0-9]{1,20}/,''))
        {
            oInput.value = oInput.value.match(/[a-zA-Z_0-9]{1,20}/) == null ? '' :oInput.value.match(/[a-zA-Z_0-9]{1,20}/);
        }
    }
</script>        </div><!-- content -->
    </div>

	<div class="clear" style="height: 20px;"></div>

    <%@ include file="/common/footer.jsp"%>

</div><!-- page -->
</body>
</html>

