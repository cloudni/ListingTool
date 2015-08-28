package com.lt.dao.po;

import com.lt.dao.model.AdGroup;

public class AdGroupPO extends AdGroup implements Cloneable
{
    private String companyName;
    private String campaignName;
    public String getCompanyName()
    {
        return companyName;
    }
    public void setCompanyName(String companyName)
    {
        this.companyName = companyName;
    }
    public String getCampaignName()
    {
        return campaignName;
    }
    public void setCampaignName(String campaignName)
    {
        this.campaignName = campaignName;
    }

}
