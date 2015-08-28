package com.lt.dao.po;

import java.math.BigDecimal;

import com.lt.dao.model.AdCampaign;
import com.lt.platform.util.time.DateFormatUtil;

public class AdCampaignPO extends AdCampaign implements Cloneable
{
	private BigDecimal cost;
	private BigDecimal freezeMoney;
	private Integer transactionAuthorizeId;
	private String reportDate;
	private Integer isCharged;
    private String companyName;
    @SuppressWarnings("unused")
    private String startDateTimeStr;
    @SuppressWarnings("unused")
    private String endDateTimeStr;
	
	private BigDecimal chargeAmount;
	
	public BigDecimal getCost()
	{
		return cost;
	}

	public void setCost(BigDecimal cost)
	{
		this.cost = cost;
	}

	public BigDecimal getFreezeMoney()
	{
		return freezeMoney;
	}

	public void setFreezeMoney(BigDecimal freezeMoney)
	{
		this.freezeMoney = freezeMoney;
	}

	public Integer getTransactionAuthorizeId()
	{
		return transactionAuthorizeId;
	}

	public void setTransactionAuthorizeId(Integer transactionAuthorizeId)
	{
		this.transactionAuthorizeId = transactionAuthorizeId;
	}

	public String getReportDate()
	{
		return reportDate;
	}

	public void setReportDate(String reportDate)
	{
		this.reportDate = reportDate;
	}

	public BigDecimal getChargeAmount()
	{
		return chargeAmount;
	}

	public void setChargeAmount(BigDecimal chargeAmount)
	{
		this.chargeAmount = chargeAmount;
	}

	public Integer getIsCharged()
	{
		return isCharged;
	}

	public void setIsCharged(Integer isCharged)
	{
		this.isCharged = isCharged;
	}

	public String getCompanyName()
    {
        return companyName;
    }

    public void setCompanyName(String companyName)
    {
        this.companyName = companyName;
    }
    
    public String getStartDateTimeStr() {
        if (super.getStartDatetime() != null) {
            return DateFormatUtil.convertIntegerToString(super.getStartDatetime()).substring(0, 10);
        }
        return null;
    }
    
    public void setStartDateTimeStr(String startDateTimeStr) {
        this.startDateTimeStr = startDateTimeStr;
        if (startDateTimeStr == null) {
            super.setStartDatetime(null);
        } else {
            super.setStartDatetime(DateFormatUtil.converStrToInteger(startDateTimeStr + " 00:00:00"));
        }
    }
    
    public String getEndDateTimeStr() {
        if (super.getEndDatetime() != null) {
            return DateFormatUtil.convertIntegerToString(super.getEndDatetime()).substring(0, 10);
        }
        return null;
    }
    
    public void setEndDateTimeStr(String endDateTimeStr) {
        this.endDateTimeStr = endDateTimeStr;
        if (endDateTimeStr == null) {
            super.setEndDatetime(null);
        } else {
            super.setEndDatetime(DateFormatUtil.converStrToInteger(endDateTimeStr + " 00:00:00"));
        }
    }

    @Override
	public AdCampaignPO clone()
	{
		AdCampaignPO o = null;
		try
		{
			o = (AdCampaignPO) super.clone();// Object 中的clone()识别出你要复制的是哪一个对象。
		} catch (CloneNotSupportedException e)
		{
			e.printStackTrace();
		}
		return o;
	}

}
