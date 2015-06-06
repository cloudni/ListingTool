<?php
/**
 * Created by PhpStorm.
 * User: cloud
 * Date: 2015/6/6
 * Time: 0:21
 */

Yii::import('application.vendor.eBay.*');
require_once 'eBayTradingAPI.php';
require_once 'reference.php';

class trackCommand extends CConsoleCommand
{
    public function run($args)
    {
        $eBayEntityType = eBayEntityType::model()->find('entity_model=:entity_model', array(':entity_model'=>'eBayListing'));
        $eBayAttributeSet = eBayAttributeSet::model()->find(
            'entity_type_id=:entity_type_id',
            array(
                ':entity_type_id'=>$eBayEntityType->id,
            )
        );

        $listingStatusAttribute = $eBayAttributeSet->getEntityAttribute("SellingStatus->ListingStatus");

        $select = "SELECT t.*
                            FROM `lt_ebay_listing` `t`
                            left join lt_ebay_entity_varchar as sstatus on sstatus.ebay_entity_id = t.id and sstatus.ebay_entity_attribute_id = {$listingStatusAttribute->id}
                            where t.company_id=3 and (t.store_id = 25 or t.store_id = 26) and t.ebay_listing_id in (
'181678285557',
'171700856717',
'171524247423',
'171524247599',
'181573778484',
'171524333893',
'171524333943',
'171524333948',
'171524334074',
'171524357770',
'171524357772',
'171524357848',
'181573841792',
'171772390024',
'181730759986',
'181760106186',
'171807832866',
'171807832904',
'181760106447',
'181704251929',
'181704252026',
'171738411946',
'181704561561',
'181704561573',
'171624016179',
'181628608955',
'171624016239',
'171624016240',
'171738905398',
'171738906817',
'181574467166',
'181574468458',
'181731348237',
'181731348560',
'171662203421',
'181653809969',
'171662218555',
'181653811062',
'181760687445',
'171808675695',
'181760687751',
'181653964337',
'171662387325',
'181653964350',
'171662387344',
'181653964411',
'171662387395',
'181653964425',
'181653964457',
'171662405738',
'181653987311',
'181653987313',
'171662405750',
'171662405751',
'171662405756',
'181653987321',
'181653987333',
'181653987335',
'181653987345',
'171624338550',
'181628838774',
'181628838790',
'181628838804',
'171624338637',
'171624442803',
'171624443024',
'181628910585',
'171484540074',
'171526415738',
'171445289527',
'181546246863',
'181546247090',
'171484733937',
'171484735676',
'181575406114',
'171526642782',
'171526642884',
'181629749631',
'181629749743',
'181762549607',
'171741078300',
'181706433668',
'171741078331',
'181762626236',
'171567056770',
'181762657603',
'171811315910',
'171705208182',
'171705208295',
'171705208323',
'171705208475',
'171527749689',
'171741702386',
'181706913540',
'171741704691',
'181681290804',
'171705779545',
'171705779720',
'181548077101',
'181548077596',
'171487002499',
'181548078712',
'361311114687',
'221790334695',
'361311114718',
'361311114784',
'361311114789',
'361311114805',
'361311214908',
'361311214961',
'221790466523',
'361311214997',
'361311215023',
'361311215042',
'181591522519',
'181591522582',
'171620424623',
'181677578894',
'171813138464',
'171813138485',
'181764072444',
'181764168284',
'171812845032',
'181763817505',
'171812845050',
'171812845052',
'181764168154',
'221791519905',
'361311966600',
'361311966654',
'361311966674',
'361311966676',
'361311966700',
'171814027398',
'181764767048',
'171814027451',
'171814027457',
'181765021563',
'181765021619',
'181765068260',
'171814456645',
'181765068599',
'221792343647',
'221792343648',
'221792343649',
'221792343650',
'221792343651',
'361312708373',
'171815595458',
'181765934656',
'181765934669',
'171815718536',
'221793285623',
'221793285926',
'361313402783',
'221793286001',
'221793286082',
'361313402940')

                            and sstatus.value = '".eBayListingStatusCodeType::Active."' ; ";
        $command = Yii::app()->db->createCommand($select);
        $listings = $command->queryAll();

        $ij = InstantJob::model()->findByPk(13);

        foreach($listings as $listing)
        {
            if(!isset($listing["site_id"])) continue;
            $replace = $ij->params;
            $replace = str_replace("ebay_listing_id", $listing["ebay_listing_id"], $replace);
            $replace = str_replace("ebay_user_id", 3, $replace);
            $replace = str_replace("ebay_store_id", $listing["store_id"], $replace);
            $replace = str_replace("ebay_site_id", $listing["site_id"], $replace);
            $inputs = json_decode($replace);

            if(!isset($inputs->applied_listings))
            {
                echo "find error in parameters, exit\n";
                return false;
            }
            if(!isset($inputs->company_id))
            {
                echo "find error in parameters, exit\n";
                return false;
            }
            $params['applied_listings'] = $inputs->applied_listings;
            $params['company_id'] = $inputs->company_id;
            $params['update_rules'] = array();
            if(isset($inputs->update_rules->quantity))
                $params['update_rules']['quantity'] = $inputs->update_rules->quantity;
            if(isset($inputs->update_rules->price))
            {
                $params['update_rules']['price'] = array(
                    'action'=>$inputs->update_rules->price->action,
                    'value'=>$inputs->update_rules->price->value,
                    'type'=>$inputs->update_rules->price->type,
                );
            }
            if(isset($inputs->update_rules->description))
            {
                $params['update_rules']['description'] = array(
                    'action'=>$inputs->update_rules->description->action,
                    'tag'=>$inputs->update_rules->description->tag,
                    'value'=>$inputs->update_rules->description->value,
                    'position'=>$inputs->update_rules->description->position,
                );
            }
            if(isset($inputs->update_rules->excludeShipLocation))
            {
                $params['update_rules']['excludeShipLocation'] = $inputs->update_rules->excludeShipLocation;
            }

            $result = eBayTradingAPI::ReviseListing($params, false);

            $resultStr = "";
            //$resultStr .= "Bulk update items ended!\n";
            //$resultStr .=  "Total processed: {$result['Total']}, Successed: ".count($result['Success']).", Warning: ".count($result['Warning']).", Failed: ".count($result['Failure']).", Unknow status: ".count($result['UnknownStatus'])."\n";
            if(!empty($result['Success']))
            {
                $resultStr .=  "Successed: ";
                foreach($result['Success'] as $row)
                {
                    $resultStr .=  $row['listingId'].", ";
                }
                $resultStr .=  "\n";
            }
            if(!empty($result['Warning']))
            {
                $resultStr .=  "Warning: ";
                foreach($result['Warning'] as $row)
                {
                    $resultStr .=  $row['listingId']."\n";
                    foreach($row['Msg'] as $msg)
                    {
                        $resultStr .=  $msg."\n";
                    }
                }
                echo "\n";
            }
            if(!empty($result['Failure']))
            {
                $resultStr .=  "Failure: ";
                foreach($result['Failure'] as $row)
                {
                    $resultStr .=  $row['listingId'].", status: ".$row['Status']."\n";
                    foreach($row['Msg'] as $msg)
                    {
                        $resultStr .=  $msg."\n";
                    }
                }
                $resultStr .=  "\n";
            }
            if(!empty($result['UnknownStatus']))
            {
                $resultStr .=  "Unknown Status: ";
                foreach($result['UnknownStatus'] as $row)
                {
                    $resultStr .=  $row['listingId'].", ";
                }
                $resultStr .=  "\n";
            }

            echo $resultStr;
        }
    }
}