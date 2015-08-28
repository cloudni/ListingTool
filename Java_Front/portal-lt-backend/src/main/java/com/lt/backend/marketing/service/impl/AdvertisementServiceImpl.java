package com.lt.backend.marketing.service.impl;

import java.util.List;
import java.util.Map;
import java.util.Map.Entry;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

import com.google.gson.Gson;
import com.google.gson.reflect.TypeToken;
import com.lt.backend.marketing.service.IAdvertisementService;
import com.lt.dao.mapper.AdAdvertiseFeedMapper;
import com.lt.dao.mapper.AdAdvertiseVariationMapper;
import com.lt.dao.mapper.AdCampaignMapper;
import com.lt.dao.mapper.AdChangeLogMapper;
import com.lt.dao.mapper.AdGroupMapper;
import com.lt.dao.model.AdAdvertiseFeed;
import com.lt.dao.model.AdChangeLog;
import com.lt.dao.po.AdAdvertiseFeedPO;
import com.lt.dao.po.AdAdvertiseVariationPO;
import com.lt.dao.po.AdCampaignPO;
import com.lt.dao.po.AdGroupPO;

@Service
public class AdvertisementServiceImpl implements IAdvertisementService
{
    @Autowired
    private  AdChangeLogMapper adChangeLogMapper;
    @Autowired
    private AdCampaignMapper adCampaignMapper;
    @Autowired
    private AdGroupMapper adGroupMapper;
    @Autowired
    private AdAdvertiseFeedMapper adAdvertiseFeedMapper;
    @Autowired
    private AdAdvertiseVariationMapper adAdvertiseVariationMapper;

    @Override
    public List<AdCampaignPO> getCampaignList(AdCampaignPO po)
    {
        return adCampaignMapper.getCampaignList(po);
    }

    @Override
    public int saveCampaign(AdCampaignPO po)
    {
        int ret = adCampaignMapper.insert(po);
        AdChangeLog adl = new AdChangeLog();
        adl.setAction(0);
        adl.setStatus(0);
        adl.setCompanyId(po.getCompanyId());
        adl.setObjectId(adCampaignMapper.getLastInsertId());
        adl.setObjectType("ADCampaign");
        adl.setTitle("Add New AD Campaign for Company:" + po.getCompanyName());
        Gson gson = new Gson();
        Map<String, String> retMap = gson.fromJson(po.getCriteria(),  new TypeToken<Map<String, String>>() {}.getType());
        String criteria = "";
        for (Entry<String, String> entry : retMap.entrySet()) {
            criteria += entry.getKey() + ":" + entry.getValue() + "<br/>";
        }
        adl.setContent("ADD NEW AD Campaign for Company id: " + po.getCompanyId() + ", name: " + po.getCompanyName() + "<br />"
                + "Campaign Name: " + po.getName() + "<br />"
                + "Campaign Budget: $" + po.getBudget() + "<br />"
                + "Campaign Start Date: $" + po.getStartDateTimeStr() + "<br />"
                + criteria);
        adl.setPriority(0);
        adl.setCreateTimeUtc(po.getCreateTimeUtc());
        adl.setCreateUserId(po.getCreateUserId());
        adl.setUpdateTimeUtc(po.getUpdateTimeUtc());
        adl.setUpdateUserId(po.getUpdateUserId());
        adChangeLogMapper.insert(adl);
        return ret;
    }

    @Override
    public int updateCampaign(AdCampaignPO po)
    {
        int ret = adCampaignMapper.updateByPrimaryKeySelective(po);
        AdChangeLog adl = new AdChangeLog();
        adl.setAction(1);
        adl.setStatus(0);
        adl.setCompanyId(po.getCompanyId());
        adl.setObjectId(po.getId());
        adl.setObjectType("ADCampaign");
        adl.setTitle("Edit AD Campaign for Company:" + po.getCompanyName());
        Gson gson = new Gson();
        Map<String, String> retMap = gson.fromJson(po.getCriteria(),  new TypeToken<Map<String, String>>() {}.getType());
        String criteria = "";
        for (Entry<String, String> entry : retMap.entrySet()) {
            criteria += entry.getKey() + ":" + entry.getValue() + "<br/>";
        }
        adl.setContent("Edit AD Campaign for Company id: " + po.getCompanyId() + ", name: " + po.getCompanyName() + "<br />"
                + "Campaign Name: " + po.getName() + "<br />"
                + "Campaign Budget: $" + po.getBudget() + "<br />"
                + "Campaign Start Date: $" + po.getStartDateTimeStr()
                + "<br />"+ criteria);
        adl.setPriority(0);
        adl.setUpdateTimeUtc(po.getUpdateTimeUtc());
        adl.setUpdateUserId(po.getUpdateUserId());
        adChangeLogMapper.insert(adl);
        return ret;
    }

    public boolean checkCampaignExist(String name) {
        int cnt = adCampaignMapper.checkExist(name);
        if (cnt > 0) {
            return true;
        }
        return false;
    }

    @Override
    public List<AdGroupPO> getGroupList(AdGroupPO po)
    {
        return adGroupMapper.getGroupList(po);
    }

    @Override
    public int saveGroup(AdGroupPO po)
    {
        int ret = adGroupMapper.insert(po);
        AdChangeLog adl = new AdChangeLog();
        adl.setAction(0);
        adl.setStatus(0);
        adl.setCompanyId(po.getCompanyId());
        adl.setObjectId(adCampaignMapper.getLastInsertId());
        adl.setObjectType("ADGroup");
        adl.setTitle("Add New AD Group for Company:" + po.getCompanyName());

        Gson gson = new Gson();
        Map<String, String> retMap = gson.fromJson(po.getCriteria(),  new TypeToken<Map<String, String>>() {}.getType());
        String criteria = "";
        for (Entry<String, String> entry : retMap.entrySet()) {
            criteria += entry.getKey() + ":" + entry.getValue() + "<br/>";
        }
        adl.setContent("Add New AD Group for Company id: " + po.getCompanyId() + ", name: " + po.getCompanyName() + "<br />"
                + "Group Name: " + po.getName() + "<br />"
                + "Group Max default CPC: $" + po.getDefaultBid() + "<br />"
                + criteria);
        adl.setPriority(0);
        adl.setCreateTimeUtc(po.getCreateTimeUtc());
        adl.setCreateUserId(po.getCreateUserId());
        adl.setUpdateTimeUtc(po.getUpdateTimeUtc());
        adl.setUpdateUserId(po.getUpdateUserId());
        adChangeLogMapper.insert(adl);
        return ret;
    }

    @Override
    public int updateGroup(AdGroupPO po)
    {
        int ret = adGroupMapper.updateByPrimaryKeySelective(po);
        AdChangeLog adl = new AdChangeLog();
        adl.setAction(1);
        adl.setStatus(0);
        adl.setCompanyId(po.getCompanyId());
        adl.setObjectId(po.getId());
        adl.setObjectType("ADGroup");
        adl.setTitle("Edit AD Group for Company:" + po.getName());

        Gson gson = new Gson();
        Map<String, String> retMap = gson.fromJson(po.getCriteria(),  new TypeToken<Map<String, String>>() {}.getType());
        String criteria = "";
        for (Entry<String, String> entry : retMap.entrySet()) {
            criteria += entry.getKey() + ":" + entry.getValue() + "<br/>";
        }
        adl.setContent("Edit AD Group for Company id: " + po.getCompanyId() + ", name: " + po.getCompanyName() + "<br />"
                + "Group Name: " + po.getName() + "<br />"
                + "Group Max default CPC: $" + po.getDefaultBid() + "<br />"
                + criteria);
        adl.setPriority(0);
        adl.setUpdateTimeUtc(po.getUpdateTimeUtc());
        adl.setUpdateUserId(po.getUpdateUserId());
        adChangeLogMapper.insert(adl);
        return ret;
    }

    @Override
    public boolean checkGroupExist(AdGroupPO po)
    {
        int cnt = adGroupMapper.checkExist(po);
        if (cnt > 0) {
            return true;
        }
        return false;
    }

    @Override
    public List<AdAdvertiseFeedPO> getAdFeedList(AdAdvertiseFeedPO po)
    {
        return adAdvertiseFeedMapper.getAdFeedList(po);
    }

    @Override
    public int updateAdFeed(AdAdvertiseFeedPO po)
    {
        int ret = adAdvertiseFeedMapper.updateByPrimaryKey(po);

        AdChangeLog adl = new AdChangeLog();
        adl.setAction(0);
        adl.setStatus(0);
        adl.setCompanyId(po.getCompanyId());
        adl.setObjectId(po.getId());
        adl.setObjectType("ADAdvertiseFeed");
        adl.setTitle("Edit AD Advertise Feed");
        AdAdvertiseFeed feed = (AdAdvertiseFeed)po;
        Gson gson = new Gson();
        Map<String, String> retMap = gson.fromJson(gson.toJson(feed),  new TypeToken<Map<String, String>>() {}.getType());
        String criteria = "";
        for (Entry<String, String> entry : retMap.entrySet()) {
            criteria += entry.getKey() + ":" + entry.getValue() + "<br/>";
        }
        adl.setContent("Edit AD Advertise Variation <br />"  + criteria);
        adl.setPriority(0);
        adl.setCreateTimeUtc(po.getCreateTimeUtc());
        adl.setCreateUserId(po.getCreateUserId());
        adl.setUpdateTimeUtc(po.getUpdateTimeUtc());
        adl.setUpdateUserId(po.getUpdateUserId());
        adChangeLogMapper.insert(adl);
        return ret;
    }

    @Override
    public List<AdAdvertiseVariationPO> getAdVariationList(AdAdvertiseVariationPO po)
    {
        return adAdvertiseVariationMapper.getAdVariationList(po);
    }

    @Override
    public int updateAdVariation(AdAdvertiseVariationPO po)
    {
        int ret = adAdvertiseVariationMapper.updateAdVariationByAdId(po);

        AdChangeLog adl = new AdChangeLog();
        adl.setAction(0);
        adl.setStatus(0);
        adl.setCompanyId(po.getCompanyId());
        adl.setObjectId(po.getAdAdvertiseId());
        adl.setObjectType("ADAdvertiseVariation");
        adl.setTitle("Edit AD Advertise Variation");
        Gson gson = new Gson();
        Map<String, Object> retMap = gson.fromJson(po.getCriteria(),  new TypeToken<Map<String, Object>>() {}.getType());
        String criteria = "";
        for (Entry<String, Object> entry : retMap.entrySet()) {
            criteria += entry.getKey() + ":" + entry.getValue() + "<br/>";
        }
        adl.setContent("Edit AD Advertise Variation <br />"  + criteria);
        adl.setPriority(0);
        adl.setCreateTimeUtc(po.getCreateTimeUtc());
        adl.setCreateUserId(po.getCreateUserId());
        adl.setUpdateTimeUtc(po.getUpdateTimeUtc());
        adl.setUpdateUserId(po.getUpdateUserId());
        adChangeLogMapper.insert(adl);
        return ret;
    }
}
