package com.lt.backend.googleadwords.service;

import java.util.List;

import com.lt.dao.model.GoogleAdwordsAd;
import com.lt.dao.model.GoogleAdwordsAdGroupWithBLOBs;
import com.lt.dao.model.GoogleAdwordsBudget;
import com.lt.dao.model.GoogleAdwordsCampaignWithBLOBs;
import com.lt.dao.model.GoogleAdwordsReportAdGroupWithBLOBs;
import com.lt.dao.model.GoogleAdwordsReportAdWithBLOBs;
import com.lt.dao.model.GoogleAdwordsReportAutomaticPlacements;
import com.lt.dao.model.GoogleAdwordsReportCampaignWithBLOBs;
import com.lt.dao.model.GoogleAdwordsReportDestinationUrl;
import com.lt.dao.model.GoogleAdwordsReportGeo;
import com.lt.dao.model.GoogleAdwordsReportKeywordsWithBLOBs;
import com.lt.dao.model.GoogleAdwordsReportUrl;
import com.lt.dao.model.GoogleAnalyticsReportAudienceOverview;
import com.lt.dao.model.GoogleAnalyticsReportPagePath;

public interface IAdwordsService
{
    public boolean downloadAdwordsReportAd(List<GoogleAdwordsReportAdWithBLOBs> list);
    public boolean downloadAdwordsReportAdGroup(List<GoogleAdwordsReportAdGroupWithBLOBs> list);
    public boolean downloadAdwordsReportCampaign(List<GoogleAdwordsReportCampaignWithBLOBs> list);
    public boolean downloadAdwordsReportAutomaticPlacements(List<GoogleAdwordsReportAutomaticPlacements> list);
    public boolean downloadAdwordsReportDestinationUrl(List<GoogleAdwordsReportDestinationUrl> list);
    public boolean downloadAdwordsReportGeo(List<GoogleAdwordsReportGeo> list);
    public boolean downloadAdwordsReportKeywords(List<GoogleAdwordsReportKeywordsWithBLOBs> list);
    public boolean downloadAdwordsReportUrl(List<GoogleAdwordsReportUrl> list);
    
    public boolean downloadAdwordsCampaign(List<GoogleAdwordsCampaignWithBLOBs> list);
    public boolean downloadAdwordsAdGroup(List<GoogleAdwordsAdGroupWithBLOBs> list);
    public boolean downloadAdwordsAd(List<GoogleAdwordsAd> list);
    public boolean downloadAdwordsBudget(List<GoogleAdwordsBudget> list);
    
    public boolean downloadAnalyticsReportAudienceOverview(List<GoogleAnalyticsReportAudienceOverview> list);
    public boolean downloadAnalyticsReportPagePath(List<GoogleAnalyticsReportPagePath> list);
    
    public String selectGaTrackingIdByEbayListingId(String ebayListingId);
}
