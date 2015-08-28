package com.lt.thirdpartylibrary.googleadwords.service.impl;

import java.util.List;

import org.slf4j.Logger;
import org.slf4j.LoggerFactory;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

import com.google.api.ads.adwords.axis.factory.AdWordsServices;
import com.google.api.ads.adwords.axis.utils.v201502.SelectorBuilder;
import com.google.api.ads.adwords.axis.v201502.cm.AdGroupOperation;
import com.google.api.ads.adwords.axis.v201502.cm.AdGroupReturnValue;
import com.google.api.ads.adwords.axis.v201502.cm.AdGroupServiceInterface;
import com.google.api.ads.adwords.axis.v201502.cm.AdGroupStatus;
import com.google.api.ads.adwords.axis.v201502.cm.AdvertisingChannelType;
import com.google.api.ads.adwords.axis.v201502.cm.BiddingStrategyConfiguration;
import com.google.api.ads.adwords.axis.v201502.cm.BiddingStrategyType;
import com.google.api.ads.adwords.axis.v201502.cm.Bids;
import com.google.api.ads.adwords.axis.v201502.cm.Budget;
import com.google.api.ads.adwords.axis.v201502.cm.BudgetBudgetDeliveryMethod;
import com.google.api.ads.adwords.axis.v201502.cm.BudgetBudgetPeriod;
import com.google.api.ads.adwords.axis.v201502.cm.BudgetOperation;
import com.google.api.ads.adwords.axis.v201502.cm.BudgetServiceInterface;
import com.google.api.ads.adwords.axis.v201502.cm.Campaign;
import com.google.api.ads.adwords.axis.v201502.cm.CampaignOperation;
import com.google.api.ads.adwords.axis.v201502.cm.CampaignReturnValue;
import com.google.api.ads.adwords.axis.v201502.cm.CampaignServiceInterface;
import com.google.api.ads.adwords.axis.v201502.cm.CampaignStatus;
import com.google.api.ads.adwords.axis.v201502.cm.CpcBid;
import com.google.api.ads.adwords.axis.v201502.cm.ManualCpcBiddingScheme;
import com.google.api.ads.adwords.axis.v201502.cm.Money;
import com.google.api.ads.adwords.axis.v201502.cm.NetworkSetting;
import com.google.api.ads.adwords.axis.v201502.cm.Operator;
import com.google.api.ads.adwords.axis.v201502.cm.Selector;
import com.google.api.ads.adwords.axis.v201502.rm.AdwordsUserListServiceInterface;
import com.google.api.ads.adwords.axis.v201502.rm.ExpressionRuleUserList;
import com.google.api.ads.adwords.axis.v201502.rm.Rule;
import com.google.api.ads.adwords.axis.v201502.rm.RuleItem;
import com.google.api.ads.adwords.axis.v201502.rm.RuleItemGroup;
import com.google.api.ads.adwords.axis.v201502.rm.StringKey;
import com.google.api.ads.adwords.axis.v201502.rm.StringRuleItem;
import com.google.api.ads.adwords.axis.v201502.rm.StringRuleItemStringOperator;
import com.google.api.ads.adwords.axis.v201502.rm.UserList;
import com.google.api.ads.adwords.axis.v201502.rm.UserListMembershipStatus;
import com.google.api.ads.adwords.axis.v201502.rm.UserListOperation;
import com.google.api.ads.adwords.axis.v201502.rm.UserListPage;
import com.google.api.ads.adwords.axis.v201502.rm.UserListReturnValue;
import com.google.api.ads.adwords.lib.client.AdWordsSession;
import com.google.api.client.util.Lists;
import com.google.gson.Gson;
import com.lt.dao.mapper.GoogleAdwordsAudienceMapper;
import com.lt.dao.model.AdAdvertise;
import com.lt.dao.model.AdCampaign;
import com.lt.dao.model.AdGroup;
import com.lt.dao.model.GoogleAdwordsAudience;
import com.lt.platform.util.time.DateFormatUtil;
import com.lt.thirdpartylibrary.googleadwords.service.IBaseOperatorService;
import com.lt.thirdpartylibrary.googleadwords.service.IReportService;
import com.lt.thirdpartylibrary.googleadwords.util.AdwordsUtil;

@Service
public class BaseOperatorServiceImpl implements IBaseOperatorService
{

    private Logger log = LoggerFactory.getLogger(BaseOperatorServiceImpl.class);
    
    private final int MAX_RULE_LENGTH = 120;

    @Autowired
    private IReportService reportService;

    @Autowired
    private GoogleAdwordsAudienceMapper googleAdwordsAudienceMapper;
    
    public boolean AddAdGroups(AdGroup adGroup) throws Exception
    {
        AdWordsServices adWordsServices = new AdWordsServices();
        AdWordsSession session = AdwordsUtil.getSession();
        
        AdGroupServiceInterface adGroupService = adWordsServices.get(session, AdGroupServiceInterface.class);
        
        // Add as many additional ad groups as you need.
        com.google.api.ads.adwords.axis.v201502.cm.AdGroup group = new com.google.api.ads.adwords.axis.v201502.cm.AdGroup();
        group.setName(adGroup.getName());
        group.setStatus(AdGroupStatus.ENABLED);
        group.setCampaignId(adGroup.getCampaignId().longValue());

        BiddingStrategyConfiguration biddingStrategyConfiguration = new BiddingStrategyConfiguration();
        CpcBid bid = new CpcBid();
        Double defaultBid = adGroup.getDefaultBid().doubleValue() * 1000000L;
        bid.setBid(new Money(null, defaultBid.longValue()));
        biddingStrategyConfiguration.setBids(new Bids[] {bid});
        group.setBiddingStrategyConfiguration(biddingStrategyConfiguration);

        // Create operations.
        AdGroupOperation operation = new AdGroupOperation();
        operation.setOperand(group);
        operation.setOperator(Operator.ADD);


        AdGroupOperation[] operations = new AdGroupOperation[] {operation};

        // Add ad groups.
        AdGroupReturnValue result = adGroupService.mutate(operations);

        // Display new ad groups.
        for (com.google.api.ads.adwords.axis.v201502.cm.AdGroup adGroupResult : result.getValue()) {
            log.info("Ad group with name \"" + adGroupResult.getName() + "\" and id \""
              + adGroupResult.getId() + "\" was added.");
            reportService.getAdGroup(null, adGroupResult.getId(), adGroup.getId());
        }
        return true;
    }

    public boolean addCampaigns(AdCampaign ltCampaign) throws Exception
    {
        
        AdWordsServices adWordsServices = new AdWordsServices();
        AdWordsSession session = AdwordsUtil.getSession();
        
        BudgetServiceInterface budgetService = adWordsServices.get(session, BudgetServiceInterface.class);
        
        // Create a budget, which can be shared by multiple campaigns.
        Budget sharedBudget = new Budget();
        sharedBudget.setName(ltCampaign.getName() + DateFormatUtil.getSysdate());
        Money budgetAmount = new Money();
        budgetAmount.setMicroAmount(ltCampaign.getBudget().longValue() * 1000000L);
        sharedBudget.setAmount(budgetAmount);
        sharedBudget.setDeliveryMethod(BudgetBudgetDeliveryMethod.STANDARD);
        sharedBudget.setPeriod(BudgetBudgetPeriod.DAILY);

        BudgetOperation budgetOperation = new BudgetOperation();
        budgetOperation.setOperand(sharedBudget);
        budgetOperation.setOperator(Operator.ADD);

        // Add the budget
        Long budgetId = budgetService.mutate(new BudgetOperation[] {budgetOperation}).getValue(0).getBudgetId();

        // Get the CampaignService.
        CampaignServiceInterface campaignService =
            adWordsServices.get(session, CampaignServiceInterface.class);

        // Create campaign.
        Campaign campaign = new Campaign();
        campaign.setName(ltCampaign.getName() + DateFormatUtil.getSysdate());
        campaign.setStatus(CampaignStatus.PAUSED);
        BiddingStrategyConfiguration biddingStrategyConfiguration = new BiddingStrategyConfiguration();
        biddingStrategyConfiguration.setBiddingStrategyType(BiddingStrategyType.MANUAL_CPC);

        // You can optionally provide a bidding scheme in place of the type.
        ManualCpcBiddingScheme cpcBiddingScheme = new ManualCpcBiddingScheme();
        cpcBiddingScheme.setEnhancedCpcEnabled(false);
        biddingStrategyConfiguration.setBiddingScheme(cpcBiddingScheme);

        campaign.setBiddingStrategyConfiguration(biddingStrategyConfiguration);

        // You can optionally provide these field(s).
        if (ltCampaign.getStartDatetime() != null) {
          campaign.setStartDate(DateFormatUtil.convertIntegerToString(ltCampaign.getStartDatetime(), "yyyyMMdd"));
          campaign.setEndDate(DateFormatUtil.convertIntegerToString(ltCampaign.getEndDatetime(), "yyyyMMdd"));
//          campaign.setEndDate(new DateTime().plusDays(30).toString("yyyyMMdd"));
        }
//        campaign.setAdServingOptimizationStatus(AdServingOptimizationStatus.ROTATE);
//        campaign.setFrequencyCap(new FrequencyCap(5L, TimeUnit.DAY, Level.ADGROUP));

        // Only the budgetId should be sent, all other fields will be ignored by CampaignService.
        Budget budget = new Budget();
        budget.setBudgetId(budgetId);
        campaign.setBudget(budget);

        campaign.setAdvertisingChannelType(AdvertisingChannelType.DISPLAY);
//        campaign.setAdvertisingChannelSubType(AdvertisingChannelSubType.DISPLAY_EXPRESS);
        
        // Set the campaign network options to Search and Search Network.
        NetworkSetting networkSetting = new NetworkSetting();
        networkSetting.setTargetGoogleSearch(true);
        networkSetting.setTargetSearchNetwork(true);
        networkSetting.setTargetContentNetwork(false);
        networkSetting.setTargetPartnerSearchNetwork(false);
        //campaign.setNetworkSetting(networkSetting);

        // Set options that are not required.
//        GeoTargetTypeSetting geoTarget = new GeoTargetTypeSetting();
//        geoTarget.setPositiveGeoTargetType(GeoTargetTypeSettingPositiveGeoTargetType.DONT_CARE);
//        campaign.setSettings(new Setting[] {geoTarget});
        // Create operations.
        CampaignOperation operation = new CampaignOperation();
        operation.setOperand(campaign);
        operation.setOperator(Operator.ADD);
        CampaignOperation[] operations = new CampaignOperation[] {operation};
        // Add campaigns.
        CampaignReturnValue result = campaignService.mutate(operations);

        // Display campaigns.
        for (Campaign campaignResult : result.getValue()) {
            log.info("Campaign with name \"" + campaignResult.getName() + "\" and id \""
              + campaignResult.getId() + "\" was added.");

            reportService.getCampaign(null, campaignResult.getId(), ltCampaign.getId().longValue());
            reportService.getBudget(null, budgetId);
        }
        return true;
        
    }

    public void downloadAudienceList() throws Exception
    {

        AdWordsServices adWordsServices = new AdWordsServices();
        AdWordsSession session = AdwordsUtil.getSession();
        AdwordsUserListServiceInterface userListService = adWordsServices.get(
                session, AdwordsUserListServiceInterface.class);

        int offset = 0;
        int PAGE_SIZE = 1000;
        boolean morePages = true;

        SelectorBuilder builder = new SelectorBuilder();
        Selector selector = builder.fields(
                "Id",
                "IsReadOnly",
                "Name",
                "Description",
                "Status",
                "IntegrationCode",
                "AccessReason",
                "AccountUserListStatus",
                "MembershipLifeSpan",
                "Size",
                "SizeRange",
                "SizeForSearch",
                "SizeRangeForSearch",
                "ListType",
                "ExpressionListRule").orderAscBy("Name")
        // .equals("CampaignId", campaignId.toString())
                .build();
        Gson gson = new Gson();
        while (morePages)
        {
            // Get all ad groups.
            UserListPage page = userListService.get(selector);

            if (page.getEntries() != null)
            {

                for (UserList ul : page.getEntries())
                {
                    System.out.println("UserList name \"" + ul.getName()
                            + "\" and id \"" + ul.getId() + "\" was found.");
                    if (ul instanceof ExpressionRuleUserList)
                    {

                        ExpressionRuleUserList erl = (ExpressionRuleUserList) ul;
                        GoogleAdwordsAudience entity = new GoogleAdwordsAudience();
                        entity.setId(erl.getId());
                        entity.setIsReadOnly(erl.getIsReadOnly());
                        entity.setName(erl.getName());
                        entity.setDescription(erl.getDescription());
                        entity.setStatus(erl.getStatus().getValue());
                        entity.setIntegrationCode(erl.getIntegrationCode());
                        entity.setAccessReason(erl.getAccessReason().getValue());
                        entity.setAccountUserListStatus(erl.getAccountUserListStatus().getValue());
                        entity.setMembershipLifeSpan(erl.getMembershipLifeSpan());
                        entity.setSize(erl.getSize());
                        entity.setSizeRange(erl.getSizeRange().getValue());
                        entity.setSizeForSearch(erl.getSizeForSearch());
                        entity.setSizeRangeForSearch(erl.getSizeRangeForSearch().getValue());
                        entity.setListType(erl.getListType().getValue());
                        entity.setUserListType(erl.getUserListType());
                        entity.setRule(gson.toJson(erl.getRule()));
                        GoogleAdwordsAudience obj = googleAdwordsAudienceMapper.selectByPrimaryKey(erl.getId());
                        if (obj == null) {
                            Integer now = DateFormatUtil.getCurrentIntegerTime();
                            entity.setCreateTimeUtc(now);
                            entity.setCreateTimeUtc(1);
                            entity.setUpdateTimeUtc(now);
                            entity.setUpdateUserId(1);
                            googleAdwordsAudienceMapper.insert(entity);
                        } else {
                            entity.setCreateTimeUtc(obj.getCreateTimeUtc());
                            entity.setCreateTimeUtc(obj.getCreateUserId());
                            entity.setUpdateTimeUtc(DateFormatUtil.getCurrentIntegerTime());
                            entity.setUpdateUserId(1);
                            googleAdwordsAudienceMapper.updateByPrimaryKey(entity);
                        }
                    }
                }
            } else
            {
                System.out.println("No ad groups were found.");
            }

            offset += PAGE_SIZE;
            selector = builder.increaseOffsetBy(PAGE_SIZE).build();
            morePages = offset < page.getTotalNumEntries();
        }
    }

    public void createAudienceList() throws Exception {
        
    }
    
    public boolean addAudienceList(String audienceListName, String id) throws Exception
    {

        String[] ids = id.split(",");
        if (ids.length > MAX_RULE_LENGTH / 2) {
            throw new Exception("Rule超出最大数限制:" + MAX_RULE_LENGTH / 2);
        }
        AdWordsServices adWordsServices = new AdWordsServices();
        AdWordsSession session = AdwordsUtil.getSession();
        AdwordsUserListServiceInterface userListService = adWordsServices.get(session, AdwordsUserListServiceInterface.class);
        
        RuleItemGroup[] rig = new RuleItemGroup[ids.length * 2];
        for (int j = 0; j < ids.length; j++)
        {
            StringKey urlKey = new StringKey("URL");
            StringRuleItem urlRuleItem = new StringRuleItem();
            urlRuleItem.setKey(urlKey);
            urlRuleItem.setOp(StringRuleItemStringOperator.CONTAINS);
            urlRuleItem.setValue(ids[j]);
            RuleItem checkoutRuleItem = new RuleItem();
            checkoutRuleItem.setStringRuleItem(urlRuleItem);
            
            RuleItemGroup checkoutMultipleItemGroup = new RuleItemGroup();
            checkoutMultipleItemGroup.setItems(new RuleItem[]{checkoutRuleItem});
            rig[j * 2] = checkoutMultipleItemGroup;
            
            StringKey referrerUrlKey = new StringKey("Referrer URL");
            StringRuleItem referrerUrlStringRuleItem = new StringRuleItem();
            referrerUrlStringRuleItem.setKey(referrerUrlKey);
            referrerUrlStringRuleItem.setOp(StringRuleItemStringOperator.CONTAINS);
            referrerUrlStringRuleItem.setValue(ids[j]);
            RuleItem referrerUrlRuleItem = new RuleItem();
            referrerUrlRuleItem.setStringRuleItem(referrerUrlStringRuleItem);

            RuleItemGroup referrerItemGroup = new RuleItemGroup();
            checkoutMultipleItemGroup.setItems(new RuleItem[]{referrerUrlRuleItem});
            rig[j * 2 + 1] = referrerItemGroup;
        }

        // Combine the rule item groups into a Rule so AdWords will OR the groups together.
        Rule rule = new Rule();
        rule.setGroups(rig);

        // Create the user list with no restrictions on site visit date.
        ExpressionRuleUserList expressionUserList = new ExpressionRuleUserList();
        expressionUserList.setName(audienceListName);
        expressionUserList.setRule(rule);
        
        // Create operations to add the user lists.
        List<UserListOperation> operations = Lists.newArrayList();
        for (UserList userList : new UserList[] {expressionUserList}) {
          UserListOperation operation = new UserListOperation();
          operation.setOperand(userList);
          operation.setOperator(Operator.ADD);
          operations.add(operation);
        }

        // Submit the operations.
        UserListReturnValue result =
            userListService.mutate(operations.toArray(new UserListOperation[operations.size()]));

        // Display the results.
        for (UserList userListResult : result.getValue()) {
          log.info("User list added with ID %d, name '%s', status '%s', list type '%s',"
              + " accountUserListStatus '%s', description '%s'.%n",
              userListResult.getId(),
              userListResult.getName(),
              userListResult.getStatus().getValue(),
              userListResult.getListType() == null ? null : userListResult.getListType().getValue(),
              userListResult.getAccountUserListStatus().getValue(),
              userListResult.getDescription());
        }
        
        return true;
    }
    
    public boolean updateAudienceList(Long audienceListId, String audienceListName, String id) throws Exception
    {

        String[] ids = id.split(",");
        if (ids.length > MAX_RULE_LENGTH / 2) {
            throw new Exception("Rule超出最大数限制:" + MAX_RULE_LENGTH / 2);
        }
        AdWordsServices adWordsServices = new AdWordsServices();
        AdWordsSession session = AdwordsUtil.getSession();
        AdwordsUserListServiceInterface userListService = adWordsServices.get(session, AdwordsUserListServiceInterface.class);

        RuleItemGroup[] rig = new RuleItemGroup[ids.length * 2];
        for (int j = 0; j < ids.length; j++)
        {
            StringKey urlKey = new StringKey("URL");
            StringRuleItem urlRuleItem = new StringRuleItem();
            urlRuleItem.setKey(urlKey);
            urlRuleItem.setOp(StringRuleItemStringOperator.CONTAINS);
            urlRuleItem.setValue(ids[j]);
            RuleItem checkoutRuleItem = new RuleItem();
            checkoutRuleItem.setStringRuleItem(urlRuleItem);
            
            RuleItemGroup checkoutMultipleItemGroup = new RuleItemGroup();
            checkoutMultipleItemGroup.setItems(new RuleItem[]{checkoutRuleItem});
            rig[j * 2] = checkoutMultipleItemGroup;
            
            StringKey referrerUrlKey = new StringKey("Referrer URL");
            StringRuleItem referrerUrlStringRuleItem = new StringRuleItem();
            referrerUrlStringRuleItem.setKey(referrerUrlKey);
            referrerUrlStringRuleItem.setOp(StringRuleItemStringOperator.CONTAINS);
            referrerUrlStringRuleItem.setValue(ids[j]);
            RuleItem referrerUrlRuleItem = new RuleItem();
            referrerUrlRuleItem.setStringRuleItem(referrerUrlStringRuleItem);

            RuleItemGroup referrerItemGroup = new RuleItemGroup();
            checkoutMultipleItemGroup.setItems(new RuleItem[]{referrerUrlRuleItem});
            rig[j * 2 + 1] = referrerItemGroup;
        }

        // Combine the rule item groups into a Rule so AdWords will OR the groups together.
        Rule rule = new Rule();
        rule.setGroups(rig);

        // Create the user list with no restrictions on site visit date.
        ExpressionRuleUserList expressionUserList = new ExpressionRuleUserList();
        expressionUserList.setId(audienceListId);
        expressionUserList.setName(audienceListName);
        expressionUserList.setRule(rule);
        expressionUserList.setStatus(UserListMembershipStatus.OPEN);
        
        // Create operations to add the user lists.
        List<UserListOperation> operations = Lists.newArrayList();
        for (UserList userList : new UserList[] {expressionUserList}) {
          UserListOperation operation = new UserListOperation();
          operation.setOperand(userList);
          operation.setOperator(Operator.SET);
          operations.add(operation);
        }

        // Submit the operations.
        UserListReturnValue result = userListService.mutate(operations.toArray(new UserListOperation[operations.size()]));

        // Display the results.
        for (UserList userListResult : result.getValue()) {
          log.info("User list added with ID %d, name '%s', status '%s', list type '%s',"
              + " accountUserListStatus '%s', description '%s'.%n",
              userListResult.getId(),
              userListResult.getName(),
              userListResult.getStatus().getValue(),
              userListResult.getListType() == null ? null : userListResult.getListType().getValue(),
              userListResult.getAccountUserListStatus().getValue(),
              userListResult.getDescription());
        }
        return true;
    }
    
    public boolean deleteAudienceList(Long audienceListId) throws Exception {

        AdWordsServices adWordsServices = new AdWordsServices();
        AdWordsSession session = AdwordsUtil.getSession();
        AdwordsUserListServiceInterface userListService = adWordsServices.get(session, AdwordsUserListServiceInterface.class);
        
        ExpressionRuleUserList expressionUserList = new ExpressionRuleUserList();
        expressionUserList.setId(audienceListId);
        expressionUserList.setStatus(UserListMembershipStatus.CLOSED);
        
        // Create operations to add the user lists.
        List<UserListOperation> operations = Lists.newArrayList();
        for (UserList userList : new UserList[] {expressionUserList}) {
          UserListOperation operation = new UserListOperation();
          operation.setOperand(userList);
          operation.setOperator(Operator.SET);
          operations.add(operation);
        }
        UserListReturnValue result = userListService.mutate(operations.toArray(new UserListOperation[operations.size()]));

            // Display the results.
            for (UserList userListResult : result.getValue()) {
              System.out.printf("User list added with ID %d, name '%s', status '%s', list type '%s',"
                  + " accountUserListStatus '%s', description '%s'.%n",
                  userListResult.getId(),
                  userListResult.getName(),
                  userListResult.getStatus().getValue(),
                  userListResult.getListType() == null ? null : userListResult.getListType().getValue(),
                  userListResult.getAccountUserListStatus().getValue(),
                  userListResult.getDescription());
            }
        return true;
    }
   
    public boolean addAd(AdAdvertise ad)
    {

        return false;

    }

    public boolean addKeywords(long adGroupId)
    {
        return false;
    }

    public void getAdGroups(Long campaignId)
    {
        // TODO Auto-generated method stub

    }

    public void getCampaigns(String companyId)
    {
        // TODO Auto-generated method stub

    }

    public void getCampaignsWithAwql()
    {
        // TODO Auto-generated method stub

    }

    public void getKeywords(Long adGroupId)
    {
        // TODO Auto-generated method stub

    }

    public void getTextAds(Long adGroupId)
    {
        // TODO Auto-generated method stub

    }

    public void pauseAd()
    {
        // TODO Auto-generated method stub

    }

    public void removeAd()
    {
        // TODO Auto-generated method stub

    }

    public void removeAdGroup()
    {
        // TODO Auto-generated method stub

    }

    public void removeCampaign()
    {
        // TODO Auto-generated method stub

    }

    public void removeKeyword()
    {
        // TODO Auto-generated method stub

    }

    public void updateAdGroup()
    {
        // TODO Auto-generated method stub

    }

    public void updateCampaign()
    {
        // TODO Auto-generated method stub

    }

    public void updateKeyword()
    {
        // TODO Auto-generated method stub

    }

}
