package com.lt.dao.po;

import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpSession;

import org.apache.commons.lang.StringUtils;
import org.springframework.web.context.request.RequestContextHolder;
import org.springframework.web.context.request.ServletRequestAttributes;

import com.lt.dao.model.Transaction;
import com.lt.platform.util.lang.StringUtil;
import com.lt.platform.util.time.DateFormatUtil;

public class TransactionPO extends Transaction
{
	private String searchType;
	private String createDateStart;
	private String createDateEnd;
	
	private String createTimeStr;
	private String updateTimeStr;
	private Integer createDateStartInteger;
	private Integer createDateEndInteger;
	
	private Double totalMin;
	private Double totalMax;
	
	private String paymentId;
	
	private String email;
	
	private String companyName;
	
	private Boolean isManagerPage;//是否管理平台查询，true为是
	
	private String typeName;
	private String statusName;
	private String paymentTransactionTypeName;
	
	/**
	 * 交易渠道
	 */
	public static final int TYPE_PAYPAL = 1;//paypal
	public static final int TYPE_SYSTEM = 2;//系统
	public static final int TYPE_GOOGLE_ADWORDS = 3;//google
	
	/**
	 * 交易类型：存款和取款
	 */
	public static final int PAYMENT_TYPE_DEPOSIT = 1;//存款
	public static final int PAYMENT_TYPE_WITHDRAW = 2;//取款
	public static final int PAYMENT_TYPE_FREEZE = 3;//冻结
	public static final int PAYMENT_TYPE_UNFREEZE = 4;//解冻
	public static final int PAYMENT_TYPE_DEDUCTION = 5;//扣款
	
	/**
	 * 交易状态
	 */
	public static final int STATE_CREATE = 1;//创建
	public static final int STATE_SUCCESS = 2;//成功
	public static final int STATE_CANCEL = 3;//取消
	public static final int STATE_FAIL = 4;//失败
	
	public boolean isConditionSearch() {
		if(StringUtil.isNotBlank(createDateStart) || StringUtil.isNotBlank(createDateEnd) 
				|| totalMin != null || totalMax != null || StringUtil.isNotBlank(companyName) 
				|| this.getCompanyId() != null || StringUtil.isNotBlank(email)
				|| this.getType() != null
				|| StringUtil.isNotBlank(this.getPaymentTransactionId())) {
			return true;
		}
		return false;
	}
	
	//getter and setter
	public String getSearchType()
	{
		return searchType;
	}
	public void setSearchType(String searchType)
	{
		this.searchType = searchType;
	}
	public String getCreateDateStart()
	{
		return createDateStart;
	}
	public void setCreateDateStart(String createDateStart)
	{
		this.createDateStart = createDateStart;
		if(StringUtils.isNotBlank(createDateStart)) {
			createDateStartInteger = DateFormatUtil.converStrToInteger(createDateStart +" 00:00:00");
		}
	}
	
	public String getCreateDateEnd()
	{
		return createDateEnd;
	}
	public void setCreateDateEnd(String createDateEnd)
	{
		this.createDateEnd = createDateEnd;
		
		if(StringUtils.isNotBlank(createDateEnd)) {
			createDateEndInteger = DateFormatUtil.converStrToInteger(createDateEnd + " 23:59:59");
		}
	}
	public Double getTotalMin()
	{
		return totalMin;
	}
	public void setTotalMin(Double totalMin)
	{
		this.totalMin = totalMin;
	}
	public Double getTotalMax()
	{
		return totalMax;
	}
	public void setTotalMax(Double totalMax)
	{
		this.totalMax = totalMax;
	}
	public String getEmail()
	{
		return email;
	}
	public void setEmail(String email)
	{
		this.email = email;
	}
	public String getCreateTimeStr()
	{
		if(getCreateTimeUtc() != null && getCreateTimeUtc() > 0)
		{
			createTimeStr = DateFormatUtil.convertIntegerToString(getCreateTimeUtc());
		}
		return createTimeStr;
	}
	public String getUpdateTimeStr()
	{	
		if(getUpdateTimeUtc() != null && getUpdateTimeUtc() > 0)
		{
			updateTimeStr = DateFormatUtil.convertIntegerToString(getUpdateTimeUtc());
		}
		return updateTimeStr;
	}
	public void setUpdateTimeStr(String updateTimeStr)
	{
		this.updateTimeStr = updateTimeStr;
	}
	public void setCreateTimeStr(String createTimeStr)
	{
		this.createTimeStr = createTimeStr;
	}
	public String getPaymentId()
	{
		return paymentId;
	}
	public void setPaymentId(String paymentId)
	{
		this.paymentId = paymentId;
	}
	public Integer getCreateDateStartInteger()
	{
		return createDateStartInteger;
	}
	public void setCreateDateStartInteger(Integer createDateStartInteger)
	{
		this.createDateStartInteger = createDateStartInteger;
	}
	public Integer getCreateDateEndInteger()
	{
		return createDateEndInteger;
	}
	public void setCreateDateEndInteger(Integer createDateEndInteger)
	{
		this.createDateEndInteger = createDateEndInteger;
	}
	public String getCompanyName()
	{
		return companyName;
	}
	public void setCompanyName(String companyName)
	{
		this.companyName = companyName;
	}

	public Boolean getIsManagerPage()
	{
		return isManagerPage;
	}

	public void setIsManagerPage(Boolean isManagerPage)
	{
		this.isManagerPage = isManagerPage;
	}

	public String getTypeName()
	{
		return typeName;
	}

	public void setTypeName(String typeName)
	{
		this.typeName = typeName;
	}

	public String getStatusName()
	{
		return statusName;
	}

	public void setStatusName(String statusName)
	{
		this.statusName = statusName;
	}

	public String getPaymentTransactionTypeName()
	{
		return paymentTransactionTypeName;
	}

	public void setPaymentTransactionTypeName(String paymentTransactionTypeName)
	{
		this.paymentTransactionTypeName = paymentTransactionTypeName;
	}
}
