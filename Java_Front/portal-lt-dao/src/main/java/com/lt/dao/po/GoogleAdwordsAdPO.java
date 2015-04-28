package com.lt.dao.po;

import com.lt.dao.model.GoogleAdwordsAd;

public class GoogleAdwordsAdPO extends GoogleAdwordsAd
{
	private Integer campaignId;

	public Integer getCampaignId()
	{
		return campaignId;
	}

	public void setCampaignId(Integer campaignId)
	{
		this.campaignId = campaignId;
	}
}
