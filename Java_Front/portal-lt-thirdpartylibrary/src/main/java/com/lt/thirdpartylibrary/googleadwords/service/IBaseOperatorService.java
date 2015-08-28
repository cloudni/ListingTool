/**
 * 
 */
package com.lt.thirdpartylibrary.googleadwords.service;

import com.lt.dao.model.AdAdvertise;
import com.lt.dao.model.AdCampaign;
import com.lt.dao.model.AdGroup;

/**
 * @author Tik
 *
 */
public interface IBaseOperatorService
{
    /**
     * adds ad groups to a campaign
     * @return
     */
    public boolean AddAdGroups(AdGroup group) throws Exception;
    public boolean addCampaigns(AdCampaign campaign) throws Exception;
    public boolean addKeywords(long adGroupId);
    public boolean addAd(AdAdvertise ad);
    public void downloadAudienceList() throws Exception;
    public void createAudienceList() throws Exception;
    public boolean addAudienceList(String audienceListName, String id) throws Exception;
    public boolean updateAudienceList(Long audienceListId, String audienceListName, String id) throws Exception;
    public boolean deleteAudienceList(Long audienceListId) throws Exception;
    public void getAdGroups(Long campaignId);
    public void getCampaigns(String companyId);
    public void getCampaignsWithAwql();
    public void getKeywords(Long adGroupId);
    public void getTextAds(Long adGroupId);
    public void pauseAd();
    public void removeAd();
    public void removeAdGroup();
    public void removeCampaign();
    public void removeKeyword();
    public void updateAdGroup();
    public void updateCampaign();
    public void updateKeyword();
}
