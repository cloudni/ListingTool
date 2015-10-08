<?php

/**
 * Created by PhpStorm.
 * User: cloud
 * Date: 2015/10/8
 * Time: 11:06
 */
Yii::import('application.vendor.Google.*');
require_once 'Api/Ads/AdWords/Lib/AdWordsUser.php';
require_once 'Api/Ads/AdWords/v201506/CampaignService.php';

define('ADWORDS_VERSION', 'v201502');

class googleCommand extends CConsoleCommand
{
    public function run($args)
    {
        $this->syncAdWordsADGroup();
    }

    protected function syncAdWordsCampaign()
    {
        $user = new AdWordsUser();

        $campaignService = $user->GetService('CampaignService', ADWORDS_VERSION);
        $selector = new Selector();
        $selector->fields = array('Id',
            'Name',
            'Status',
            'ServingStatus',
            'StartDate',
            'EndDate',
            'AdServingOptimizationStatus',
            'Settings',
            'AdvertisingChannelType',
            'AdvertisingChannelSubType',
            'Labels',
            'TrackingUrlTemplate',
            'UrlCustomParameters'
        );
        // Labels filtering is performed by ID. You can use containsAny to select
        // campaigns with any of the label IDs, containsAll to select campaigns with
        // all of the label IDs, or containsNone to select campaigns with none of the
        // label IDs.

        $selector->ordering[] = new OrderBy('Name', 'ASCENDING');
        $selector->predicates[] = new Predicate('Status', 'IN', array('ENABLED'));

        // Create paging controls.
        $selector->paging = new Paging(0, AdWordsConstants::RECOMMENDED_PAGE_SIZE);
        do {
            // Make the get request.
            $page = $campaignService->get($selector);

            // Display results.
            if (isset($page->entries)) {
                foreach ($page->entries as $campaign)
                {
                    printf("Campaign with name '%s' and ID '%d' was found.\n", $campaign->name, $campaign->id);
                    $tempList = explode('###', str_ireplace('$$$', '', $campaign->name));
                    $ltCampaignId = null;
                    if(count($tempList) < 4)
                    {
                        echo printf("campaign name pattern is error, name: %s, ID: %d\n", $campaign->name, $campaign->id);
                    }
                    else
                    {
                        $ltCampaign = ADCampaign::model()->find("company_id=:company_id and id=:id", array(":company_id" => $tempList[1], ":id" => $tempList[3]));
                        if(!empty($ltCampaign))
                        {
                            $ltCampaignId = $ltCampaign->id;
                            echo "it campaign found, id: $ltCampaignId\n";
                        }
                    }
                    $gaCampaign = GoogleAdWordsCampaign::model()->findByPk($campaign->id);
                    if(empty($gaCampaign)) {
                        $gaCampaign = new GoogleAdWordsCampaign();
                        $gaCampaign->create_time_utc = time();
                    }
                    $gaCampaign->id = (int)$campaign->id;
                    $gaCampaign->lt_ad_campaign_id = (int)$ltCampaignId;
                    $gaCampaign->name = (string)$campaign->name;
                    $gaCampaign->status = (string)$campaign->status;
                    $gaCampaign->serving_status = (string)$campaign->servingStatus;
                    $gaCampaign->start_date = (string)$campaign->startDate;
                    $gaCampaign->end_date = $campaign->endDate;
                    $gaCampaign->budget = isset($campaign->budget) ? (int)$campaign->budget : null;
                    $gaCampaign->conversion_optimizer_eligibility = null;
                    $gaCampaign->adServing_optimization_status = isset($campaign->adServingOptimizationStatus) ? (string)$campaign->adServingOptimizationStatus : null;
                    $gaCampaign->frequency_cap = null;
                    $gaCampaign->settings = isset($campaign->settings) ? json_encode($campaign->settings) : null;
                    $gaCampaign->advertising_channel_type = isset($campaign->advertisingChannelType) ? (string)$campaign->advertisingChannelType : null;
                    $gaCampaign->advertising_channel_sub_type = null;
                    $gaCampaign->network_setting = null;
                    $gaCampaign->labels = null;
                    $gaCampaign->bidding_strategy_configuration = null;
                    $gaCampaign->forward_compatibility_map = null;
                    $gaCampaign->tracking_url_template = null;
                    $gaCampaign->url_custom_parameters = null;
                    $gaCampaign->update_time_utc = time();
                    if($gaCampaign->save())
                        printf("Campaign with name '%s' and ID '%d' saved successful.\n", $campaign->name, $campaign->id);
                    else
                        printf("Campaign with name '%s' and ID '%d' saved fail.\n", $campaign->name, $campaign->id);
                    echo "\n\n";
                }
            } else {
                print "No campaigns were found.\n";
            }

            // Advance the paging index.
            $selector->paging->startIndex += AdWordsConstants::RECOMMENDED_PAGE_SIZE;
        } while ($page->totalNumEntries > $selector->paging->startIndex);
    }

    protected function syncAdWordsADGroup()
    {
        $user = new AdWordsUser();

        $adGroupService = $user->GetService('AdGroupService', ADWORDS_VERSION);
        $selector = new Selector();
        $selector->fields = array('Id',
            'Name',
            'CampaignId',
            'CampaignName',
            'Status',
            'Settings',
            'Labels',
            'ContentBidCriterionTypeGroup',
            'TrackingUrlTemplate',
            'UrlCustomParameters'
        );
        $selector->ordering[] = new OrderBy('Name', 'ASCENDING');
        $selector->predicates[] = new Predicate('Status', 'IN', array('ENABLED'));

        // Create paging controls.
        $selector->paging = new Paging(0, AdWordsConstants::RECOMMENDED_PAGE_SIZE);
        do {
            // Make the get request.
            $page = $adGroupService->get($selector);

            // Display results.
            if (isset($page->entries)) {
                foreach ($page->entries as $adGroup)
                {
                    printf("ADGroup with name '%s' and ID '%s' was found, campaign id: %s.\n", $adGroup->name, $adGroup->id, $adGroup->campaignId);
                    $tempList = explode('###', str_ireplace('$$$', '', $adGroup->name));
                    $ltADGroupId = null;
                    if(count($tempList) < 6)
                    {
                        echo printf("ADGroup name pattern is error, name: %s, ID: %d\n", $adGroup->name, $adGroup->id);
                    }
                    else
                    {
                        $sql = "select * from {{ad_group}} where company_id=:company_id and id=:id";
                        $command = Yii::app()->db->createCommand($sql);
                        $command->bindValue(":company_id", $tempList[1], PDO::PARAM_INT);
                        $command->bindValue(":id", $tempList[5], PDO::PARAM_INT);
                        $result = $command->queryRow();
                        if(!empty($result))
                        {
                            $ltADGroupId = $result['id'];
                            echo "it AD Group found, id: $ltADGroupId\n";
                        }
                    }

                    $gaGroup = GoogleAdWordsAdGroup::model()->findByPk($adGroup->id);
                    if(empty($gaGroup)) {
                        $gaGroup = new GoogleAdWordsAdGroup();
                        $gaGroup->create_time_utc = time();
                    }
                    $gaGroup->id = $adGroup->id;
                    $gaGroup->lt_ad_group_id = $ltADGroupId;
                    $gaGroup->campaign_id = $adGroup->campaignId;
                    $gaGroup->campaign_name = (string)$adGroup->campaignName;
                    $gaGroup->name = (string)$adGroup->name;
                    $gaGroup->status = (string)$adGroup->status;
                    $gaGroup->settings = isset($adGroup->settings) ? json_encode($adGroup->settings) : null;
                    $gaGroup->experiment_data = null;
                    $gaGroup->labels = isset($adGroup->labels) ? (string)$adGroup->labels : null;
                    $gaGroup->forward_compatibility_map = null;
                    $gaGroup->bidding_strategy_configuration = null;
                    $gaGroup->content_bid_criterionType_group = null;
                    $gaGroup->tracking_url_template = null;
                    $gaGroup->url_custom_parameters = null;
                    $gaGroup->update_time_utc = time();
                    if($gaGroup->save())
                        printf("ADGroup with name '%s' and ID '%s' saved successful.\n", $adGroup->name, $adGroup->id);
                    else
                        printf("ADGroup with name '%s' and ID '%s' saved fail.\n", $adGroup->name, $adGroup->id);
                    echo "\n\n";
                }
            } else {
                print "No ADGroups were found.\n";
            }

            // Advance the paging index.
            $selector->paging->startIndex += AdWordsConstants::RECOMMENDED_PAGE_SIZE;
        } while ($page->totalNumEntries > $selector->paging->startIndex);
    }
}