package com.lt.dao.po;

import com.lt.dao.model.AdAdvertiseVariation;

public class AdAdvertiseVariationPO extends AdAdvertiseVariation
{
    private String companyName;
    private String campaignName;
    private String groupName;
    private String adName;
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
    public String getGroupName()
    {
        return groupName;
    }
    public void setGroupName(String groupName)
    {
        this.groupName = groupName;
    }
    public String getAdName()
    {
        return adName;
    }
    public void setAdName(String adName)
    {
        this.adName = adName;
    }

}
