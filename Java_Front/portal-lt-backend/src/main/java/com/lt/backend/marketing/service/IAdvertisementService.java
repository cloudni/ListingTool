package com.lt.backend.marketing.service;

import java.util.List;

import com.lt.dao.po.AdAdvertiseFeedPO;
import com.lt.dao.po.AdAdvertiseVariationPO;
import com.lt.dao.po.AdCampaignPO;
import com.lt.dao.po.AdGroupPO;

public interface IAdvertisementService
{
    public List<AdCampaignPO> getCampaignList(AdCampaignPO po);
    public int saveCampaign(AdCampaignPO po);
    public int updateCampaign(AdCampaignPO po);
    public boolean checkCampaignExist(String name);
    
    public List<AdGroupPO> getGroupList(AdGroupPO po);
    public int saveGroup(AdGroupPO po);
    public int updateGroup(AdGroupPO po);
    public boolean checkGroupExist(AdGroupPO po);

    public List<AdAdvertiseFeedPO> getAdFeedList(AdAdvertiseFeedPO po);
    public int updateAdFeed(AdAdvertiseFeedPO po);

    public List<AdAdvertiseVariationPO> getAdVariationList(AdAdvertiseVariationPO po);
    public int updateAdVariation(AdAdvertiseVariationPO po);
    
    
}
