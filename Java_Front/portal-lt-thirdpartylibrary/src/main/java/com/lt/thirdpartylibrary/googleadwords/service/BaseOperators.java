/**
 * 
 */
package com.lt.thirdpartylibrary.googleadwords.service;

import com.google.api.ads.adwords.axis.factory.AdWordsServices;
import com.google.api.ads.adwords.axis.v201409.cm.AdGroupCriterionReturnValue;
import com.google.api.ads.adwords.axis.v201409.cm.AdGroupReturnValue;
import com.google.api.ads.adwords.axis.v201409.cm.CampaignReturnValue;
import com.google.api.ads.adwords.lib.client.AdWordsSession;

/**
 * @author Tik
 *
 */
public interface BaseOperators
{
    /**
     * adds ad groups to a campaign
     * @return
     */
    public AdGroupReturnValue AddAdGroups(long campaignId);
    public CampaignReturnValue addCampaigns(AdWordsServices adWordsServices, AdWordsSession session);
    public AdGroupCriterionReturnValue addKeywords(AdWordsServices adWordsServices, AdWordsSession session, long adGroupId);
    public void addTextAds(AdWordsServices adWordsServices, AdWordsSession session, long adGroupId);
    public void getAdGroups(AdWordsServices adWordsServices, AdWordsSession session, Long campaignId);
    public void getCampaigns(AdWordsServices adWordsServices, AdWordsSession session);
    public void getCampaignsWithAwql(AdWordsServices adWordsServices, AdWordsSession session);
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
