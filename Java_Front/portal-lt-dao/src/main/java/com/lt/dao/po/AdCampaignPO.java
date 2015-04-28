package com.lt.dao.po;

import java.math.BigDecimal;

import com.lt.dao.model.AdCampaign;

public class AdCampaignPO extends AdCampaign implements Cloneable
{
	private BigDecimal totalCost;
	private BigDecimal freezeMoney;
	private Integer transactionAuthorizeId;
	private String reportDate;
	
	private BigDecimal chargAmount;

	public BigDecimal getTotalCost()
	{
		return totalCost;
	}

	public void setTotalCost(BigDecimal totalCost)
	{
		this.totalCost = totalCost;
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

	public BigDecimal getChargAmount()
	{
		return chargAmount;
	}

	public void setChargAmount(BigDecimal chargAmount)
	{
		this.chargAmount = chargAmount;
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
