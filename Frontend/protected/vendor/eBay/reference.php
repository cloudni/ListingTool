<?php
/**
 * Created by PhpStorm.
 * User: cloud
 * Date: 14-10-30
 * Time: 9:38pm
 */

class eBaySiteIdCodeType
{
    const US="0";
    const eBayMotors="100";
    const Italy="101";
    const Belgium_Dutch="123";
    const Netherlands="146";
    const Australia="15";
    const Austria="16";
    const Spain="186";
    const Switzerland="193";
    const Taiwan="196";
    const Canada="2";
    const HongKong="201";
    const India="203";
    const Ireland="205";
    const Malaysia="207";
    const Canada_French="210";
    const Philippines="211";
    const Poland="212";
    const Singapore="216";
    const Sweden="218";
    const China="223";
    const Belgium_French="23";
    const UK="3";
    const France="71";
    const Germany="77";

    public static function getSiteIdCodeTypeOptions()
    {
        return array(
            self::US=>"US",
            self::eBayMotors=>"eBayMotors",
            self::Italy=>"Italy",
            self::Belgium_Dutch=>"Belgium Dutch",
            self::Netherlands=>"Netherlands",
            self::Australia=>"Australia",
            self::Austria=>"Austria",
            self::Spain=>"Spain",
            self::Switzerland=>"Switzerland",
            //self::Taiwan=>"196",
            self::Canada=>"Canada",
            self::HongKong=>"HongKong",
            self::India=>"India",
            self::Ireland=>"Ireland",
            self::Malaysia=>"Malaysia",
            self::Canada_French=>"Canada French",
            self::Philippines=>"Philippines",
            self::Poland=>"Poland",
            self::Singapore=>"Singapore",
            //self::Sweden=>"218",
            //self::China=>"223",
            self::Belgium_French=>"Belgium French",
            self::UK=>"UK",
            self::France=>"France",
            self::Germany=>"Germany",
        );
    }

    public static function getSiteIdCodeTypeText($code)
    {
        $siteIdCodeTypeOptions = eBaySiteIdCodeType::getSiteIdCodeTypeOptions();
        return isset($siteIdCodeTypeOptions[$code]) ? $siteIdCodeTypeOptions[$code] : "unknown eBay Site Code ({$code})";
    }
}

class eBaySiteName
{
    const CustomCode='CustomCode';
    const US="US";
    const eBayMotors="eBayMotors";
    const Italy="Italy";
    const Belgium_Dutch="Belgium_Dutch";
    const Netherlands="Netherlands";
    const Australia="Australia";
    const Austria="Austria";
    const Spain="Spain";
    const Switzerland="Switzerland";
    //const Taiwan="196";
    const Canada="Canada";
    const HongKong="HongKong";
    const India="India";
    const Ireland="Ireland";
    const Malaysia="Malaysia";
    const Canada_French="Canada_French";
    const Philippines="Philippines";
    const Poland="Poland";
    const Singapore="Singapore";
    //const Sweden="218";
    //const China="223";
    const Belgium_French="Belgium_French";
    const UK="UK";
    const France="France";
    const Germany="Germany";

    public static function geteBaySiteNameOptions()
    {
        return array(
            //self::CustomCode=>'CustomCode',
            self::US=>"0",
            self::eBayMotors=>"100",
            self::Italy=>"101",
            self::Belgium_Dutch=>"123",
            self::Netherlands=>"146",
            self::Australia=>"15",
            self::Austria=>"16",
            self::Spain=>"186",
            self::Switzerland=>"193",
            //self::Taiwan=>"196",
            self::Canada=>"2",
            self::HongKong=>"201",
            self::India=>"203",
            self::Ireland=>"205",
            self::Malaysia=>"207",
            self::Canada_French=>"210",
            self::Philippines=>"211",
            self::Poland=>"212",
            self::Singapore=>"216",
            //self::Sweden=>"218",
            //self::China=>"223",
            self::Belgium_French=>"23",
            self::UK=>"3",
            self::France=>"71",
            self::Germany=>"77",
        );
    }

    public static function geteBaySiteNameCode($name)
    {
        $eBaySiteNameOptions = eBaySiteName::geteBaySiteNameOptions();
        return isset($eBaySiteNameOptions[$name]) ? $eBaySiteNameOptions[$name] : "unknown Site Name ({$name})";
    }
}

/*
 * This code identifies the acknowledgement code types that eBay could use to communicate the status of processing a (request) message to an application.
 */
class eBayAckCodeType
{
    const CustomCode='CustomCode';//Reserved for internal or future use.
    const Failure='Failure';//Request processing failed
    const PartialFailure='PartialFailure';//Request processing completed with some failures. See the Errors data to determine which portions of the request failed.
    const Success='Success';//Request processing succeeded
    const Warning='Warning';//Request processing completed with warning information being included in the response message
}

/*
 * Specifies a predefined subset of fields to return. The predefined set of fields can vary for different calls. Only applicable to certain calls
 */
class eBayGranularityLevelCodeType
{
    const Coarse='Coarse'; //For each record in the response, retrieves less data than Medium.
    const CustomCode='CustomCode';
    const Fine='Fine'; //For each record in the response, retrieves more data than Medium.
    const Medium='Medium'; //For each record in the response, retrieves more data than Coarse and less data than Fine.
}

/*
 * Specifies standard subsets of data to return for each result within the set of results in the response payload. If no detail level is specified, a base set of data is returned. The base set of data varies per call.
 */
class eBayDetailLevelCodeType
{
    const ItemReturnAttributes='ItemReturnAttributes'; //For GetItem, returns Item Specifics and Pre-filled Item Information, if any. For GetSearchResults, only returns Item Specifics (if any) that are applicable to search results, and only under certain conditions.
    const ItemReturnCategories='ItemReturnCategories'; //For the GetSearchResults call, returns the primary category and, if applicable, the secondary category
    const ItemReturnDescription='ItemReturnDescription'; //Returns Description, plus the ListingDesigner node and some additional information if applicable
    const ReturnAll='ReturnAll'; //Returns all available data. With GetSellerList and other calls that retrieve large data sets, please avoid using ReturnAll when possible. For example, if you use GetSellerList, use a GranularityLevel or use the GetSellerEvents call instead. If you use ReturnAll with GetSellerList, use a small EntriesPerPage value and a short EndTimeFrom/EndTimeTo range for better performance.
    const ReturnHeaders='ReturnHeaders'; //Returns message headers.
    const ReturnMessages='ReturnMessages'; //Returns full message information.
    const ReturnSummary='ReturnSummary'; //Returns the summary data
}

class eBayErrorLanguageType
{
    const en_AU='en_AU'; //Australia
    const de_AT='de_AT'; //Austria
    const nl_BE='nl_BE'; //Belgium (Dutch)
    const fr_BE='fr_BE'; //Belgium (French)
    const en_CA='en_CA'; //Canada
    const fr_CA='fr_CA'; //Canada (French)
    const zh_CN='zh_CN'; //China
    const fr_FR='fr_FR'; //France
    const de_DE='de_DE'; //Germany
    const zh_HK='zh_HK'; //Hong Kong
    const en_IN='en_IN'; //India
    const en_IE='en_IE'; //Ireland
    const it_IT='it_IT'; //Italy
    const nl_NL='nl_NL'; //Netherlands
    const en_SG='en_SG'; //Singapore
    const es_ES='es_ES'; //Spain
    const de_CH='de_CH'; //Switzerland
    const en_GB='en_GB'; //United Kingdom
    const en_US='en_US'; //United States
}

class eBayWarningLevelCodeType
{
    const High='High'; //Return warnings when the application passes unrecognized or deprecated elements in a request.
    const Low='Low'; //Do not return warnings when the application passes unrecognized or deprecated elements in a request. This is the default value if WarningLevel is not specified.
}

class eBayPaginationType
{
    public $EntriesPerPage=20;
    public $PageNumber=0;
}

/*
 * Type that uses ErrorClassificationCodeType
 */
class eBayErrorClassificationCodeType
{
    const CustomCode='CustomCode';//Reserved for internal or future use.
    const RequestError='RequestError';//An error has occurred either as a result of a problem in the sending application or because the application's end-user has attempted to submit invalid data (or missing data).
    const SystemError='SystemError';//Indicates that an error has occurred on the eBay system side, such as a database or server down. An application can retry the request as-is a reasonable number of times (eBay recommends twice).
}

/*
 * SeverityCodeType - Type declaration to be used by other schema. This code identifies the severity of an API error. A code indicates whether there is an API-level error or warning that needs to be communicated to the client.
 */
class eBaySeverityCodeType
{
    const CustomCode='CustomCode';//Reserved for internal or future use.
    const Error='Error';//The request that triggered the error was not processed successfully. When a serious application-level error occurs, the error is returned instead of the business data.
    const Warning='Warning';//The request was processed successfully, but something occurred that may affect your application or the user.
}

/*
 * Specifies an active or ended listing's status in eBay's processing workflow.
 */
class eBayListingStatusCodeType
{
    const Active='Active';//The listing is still active or the listing has ended with a sale but eBay has not completed processing the sale details (e.g., total price and high bidder).
    const Completed='Completed';//The listing has closed and eBay has completed processing the sale. All sale information returned from eBay (e.g., total price and high bidder) should be considered accurate and complete.
    const Custom='Custom';//Reserved for internal or future use.
    const CustomCode='CustomCode';//Reserved for internal or future use.
    const Ended='Ended';//The listing has ended. If the listing ended with a sale, eBay has completed processing of the sale. All sale information returned from eBay (e.g., total price and high bidder) should be considered accurate and complete.

    public static function getStatusOptions()
    {
        return array(
            self::Active=>self::Active,
            self::Completed=>self::Completed,
            self::Custom=>self::Custom,
            self::CustomCode=>self::CustomCode,
            self::Ended=>self::Ended,
        );
    }

    public static function getStatusText($status)
    {
        $statusOptions = eBayListingStatusCodeType::getStatusOptions();
        return isset($statusOptions[$status]) ? $statusOptions[$status] : "Unknown Status: ({$status})";
    }
}

/*
 * Specifies the selling format used for a listing.
 */
class eBayListingTypeCodeType
{
    const AdType='AdType';//Advertisement to solicit inquiries on listings such as real estate. Permits no bidding on that item, service, or property.
    const Auction='Auction';//An optional input parameter used with GetMyeBaySelling. When used in the request, returns items of competitive-bid auctions.
    const Chinese='Chinese';//Single-quantity online auction format. A Chinese auction has a Quantity of 1. Buyers engage in competitive bidding, although Buy It Now may be offered as long as no bids have been placed. Online auctions are listed on eBay.com, and they are also listed in the seller's eBay Store if the seller is a Store owner.
    const CustomCode='CustomCode';//Reserved for internal or future use.
    const FixedPriceItem='FixedPriceItem';//A basic fixed-price item format. Bids do not occur. The quantity of items is one or more.
    const Half='Half';//Half.com listing (item is listed on Half.com, not on eBay). You must be a registered Half.com seller to use this format.
    const LeadGeneration='LeadGeneration';//Lead Generation format (advertisement-style listing to solicit inquiries or offers, no bidding or fixed price, listed on eBay).
    const PersonalOffer='PersonalOffer';//Second chance offer made to a non-winning bidder on an ended listing. A seller can make an offer to a non-winning bidder when either the winning bidder has failed to pay for an item or the seller has a duplicate of the item.
    const Shopping='Shopping';//Reserved for internal or future use. You can ignore Shopping.com items in your results.
    const Unknown='Unknown';//Unknown or undefined auction type. Applicable to user preferences and other informational use cases.

    public static function getListingTypeOptions()
    {
        return array(
            eBayListingTypeCodeType::AdType=>eBayListingTypeCodeType::AdType,
            eBayListingTypeCodeType::Auction=>eBayListingTypeCodeType::Auction,
            eBayListingTypeCodeType::Chinese=>eBayListingTypeCodeType::Chinese,
            eBayListingTypeCodeType::CustomCode=>eBayListingTypeCodeType::CustomCode,
            eBayListingTypeCodeType::FixedPriceItem=>eBayListingTypeCodeType::FixedPriceItem,
            eBayListingTypeCodeType::Half=>eBayListingTypeCodeType::Half,
            eBayListingTypeCodeType::LeadGeneration=>eBayListingTypeCodeType::LeadGeneration,
            eBayListingTypeCodeType::PersonalOffer=>eBayListingTypeCodeType::PersonalOffer,
            eBayListingTypeCodeType::Shopping=>eBayListingTypeCodeType::Shopping,
            eBayListingTypeCodeType::Unknown=>eBayListingTypeCodeType::Unknown,
        );
    }

    public static function getListingTypeLabels()
    {
        return array(
            eBayListingTypeCodeType::AdType=>'Advertisement to solicit inquiries on listings',
            eBayListingTypeCodeType::Auction=>'Auction',
            eBayListingTypeCodeType::Chinese=>'Single-quantity online auction format',
            eBayListingTypeCodeType::FixedPriceItem=>'Buy It Now',
            eBayListingTypeCodeType::Half=>'Half.com listing',
            eBayListingTypeCodeType::LeadGeneration=>'Lead Generation format',
            eBayListingTypeCodeType::PersonalOffer=>'Second chance offer',
        );
    }
}

class eBayPeriodCodeType
{
    const CustomCode='CustomCode';//This value is reserved for future or internal use.
    //const Days_1='Days_1';//This value is no longer used.
    const Days_180='Days_180';//This value indicates that the evaluation period is set back 180 days from the present date.
    const Days_30='Days_30';//This value indicates that the evaluation period is set back 30 days from the present date.
    const Days_360='Days_360';//This value indicates that the evaluation period is set back 360 days from the present date.
    const Days_540='Days_540';//This value indicates that the evaluation period is set back 540 days from the present date.
}

class eBayDescriptionReviseMode
{
    const Append='Append';
    const CustomCode='CustomCode';
    const Prepend='Prepend';
    const Replace='Replace';
}

class eBayFeedbackRatingStarCodeType
{
    const Blue='Blue';
    const CustomCode='CustomCode';
    const Green='Green';
    const GreenShooting='GreenShooting';
    const None='None';
    const Purple='Purple';
    const PurpleShooting='PurpleShooting';
    const Red='Red';
    const RedShooting='RedShooting';
    const SilverShooting='SilverShooting';
    const Turquoise='Turquoise';
    const TurquoiseShooting='TurquoiseShooting';
    const Yellow='Yellow';
    const YellowShooting='YellowShooting';

    public static function getFeedbackRatingStarImg25X25Options()
    {
        return array(
            self::Blue=>'/images/ebay/iconBlueStar_25x25.gif',
            self::CustomCode=>'',
            self::Green=>'/images/ebay/iconGreenStar_25x25.gif',
            self::GreenShooting=>'/images/ebay/iconShootGrn_25x25.gif',
            self::None=>'',
            self::Purple=>'/images/ebay/iconPurpleStar_25x25.gif',
            self::PurpleShooting=>'/images/ebay/stars-13.gif',
            self::Red=>'/images/ebay/iconRedStar_25x25.gif',
            self::RedShooting=>'/images/ebay/stars-14.gif',
            self::SilverShooting=>'/images/ebay/iconShootSlvr_25x25.gif',
            self::Turquoise=>'/images/ebay/iconTealStar_25x25.gif',
            self::TurquoiseShooting=>'/images/ebay/stars-12.gif',
            self::Yellow=>'/images/ebay/iconYellowStar_25x25.gif',
            self::YellowShooting=>'/images/ebay/stars-11.gif',
        );
    }

    public static function getFeedbackRatingStarImg25X25($star)
    {
        $imgOptions = eBayFeedbackRatingStarCodeType::getFeedbackRatingStarImg25X25Options();
        return isset($imgOptions[$star]) ? $imgOptions[$star] : "";
    }
}

class eBayTopRatedProgramCodeType
{
    const CustomCode='CustomCode';
    const DE='DE';
    const GlobalCode='Global';
    const UK='UK';
    const US='US';
}

class eBaySellerDashboardAlertSeverityCodeType
{
    const CustomCode='CustomCode';
    const Informational='Informational';
    const StrongWarning='StrongWarning';
    const Warning='Warning';
}

class eBayIncludeSelectorCodeType
{
    const Details='Details';
    const Description='Description';
    const TextDescription='TextDescription';
    const ItemSpecifics='ItemSpecifics';
    const Variations='Variations';
}