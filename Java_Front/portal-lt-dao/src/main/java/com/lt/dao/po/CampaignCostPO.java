package com.lt.dao.po;

import java.math.BigDecimal;
import java.util.Date;

public class CampaignCostPO
{
	private Date date;
	private Integer isCharged;
	private Integer companyId;
	private BigDecimal markupAmount;
	private Integer markupType;
	
	private Integer ltAdCampaignId;
	
	public Date getDate()
	{
		return date;
	}
	public void setDate(Date date)
	{
		this.date = date;
	}
	public Integer getIsCharged()
	{
		return isCharged;
	}
	public void setIsCharged(Integer isCharged)
	{
		this.isCharged = isCharged;
	}
	public Integer getCompanyId()
	{
		return companyId;
	}
	public void setCompanyId(Integer companyId)
	{
		this.companyId = companyId;
	}
	public BigDecimal getMarkupAmount()
	{
		return markupAmount;
	}
	public void setMarkupAmount(BigDecimal markupAmount)
	{
		this.markupAmount = markupAmount;
	}
	public Integer getMarkupType()
	{
		return markupType;
	}
	public void setMarkupType(Integer markupType)
	{
		this.markupType = markupType;
	}
	public Integer getLtAdCampaignId()
	{
		return ltAdCampaignId;
	}
	public void setLtAdCampaignId(Integer ltAdCampaignId)
	{
		this.ltAdCampaignId = ltAdCampaignId;
	}
}
