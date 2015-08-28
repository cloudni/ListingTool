package com.lt.backend.system.service;

import com.lt.dao.model.AdCampaign;

public interface ITransactionAuthorizeService
{
	public void updateCampaignCost(String reportDate) throws Exception;
	
	public void freezeCampaignBudget(AdCampaign adCampaign);
}
