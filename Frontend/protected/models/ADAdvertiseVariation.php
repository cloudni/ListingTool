<?php

/**
 * This is the model class for table "{{ad_advertise_variation}}".
 *
 * The followings are the available columns in table '{{ad_advertise_variation}}':
 * @property integer $id
 * @property integer $ad_group_id
 * @property integer $ad_campaign_id
 * @property integer $ad_advertise_id
 * @property integer $company_id
 * @property integer $type
 * @property integer $code
 * @property integer $status
 * @property string $criteria
 * @property string $display_url
 * @property string $landing_page
 * @property integer $width
 * @property integer $height
 * @property integer $is_delete
 * @property integer $create_time_utc
 * @property integer $create_user_id
 * @property integer $update_time_utc
 * @property integer $update_user_id
 *
 * The followings are the available model relations:
 * @property Company $company
 * @property AdAdvertise $adAdvertise
 * @property AdGroup $adGroup
 * @property AdCampaign $adCampaign
 */
class ADAdvertiseVariation extends NIActiveRecord
{
    public static $FlashResolutionList = array(
        '468x60'=>array('width'=>468, 'height'=>60),
        '728x90'=>array('width'=>728, 'height'=>90),
        '970x90'=>array('width'=>970, 'height'=>90),
        '200x200'=>array('width'=>200, 'height'=>200),
        '120x600'=>array('width'=>120, 'height'=>600),
        '160x600'=>array('width'=>160, 'height'=>600),
        '250x250'=>array('width'=>250, 'height'=>250),
        '300x250'=>array('width'=>300, 'height'=>250),
        '300x600'=>array('width'=>300, 'height'=>600),
        '336x280'=>array('width'=>336, 'height'=>280),
    );
    public static $Html5ResolutionList = array(
        '320x50'=>array('width'=>320, 'height'=>50),
        '320x100'=>array('width'=>320, 'height'=>100),
        '468x60'=>array('width'=>468, 'height'=>60),
        '728x90'=>array('width'=>728, 'height'=>90),
        '970x90'=>array('width'=>970, 'height'=>90),
        '200x200'=>array('width'=>200, 'height'=>200),
        '120x600'=>array('width'=>120, 'height'=>600),
        '160x600'=>array('width'=>160, 'height'=>600),
        '250x250'=>array('width'=>250, 'height'=>250),
        '300x250'=>array('width'=>300, 'height'=>250),
        '300x600'=>array('width'=>300, 'height'=>600),
        '336x280'=>array('width'=>336, 'height'=>280),
    );

    CONST Type_Text = 1;
    CONST Type_Image = 2;
    CONST Type_AdGallery = 3;

    CONST Code_Flash = 1;
    CONST Code_Html5 = 2;

    CONST Criteria_Separator="$$$$$";
    CONST Delete_Yes=1;
    CONST Delete_No=0;

    CONST Status_Enabled=0;
    CONST Status_Paused=1;
    CONST Status_Removed=2;
    CONST Status_Pending=3;

    public static function getTypeOptions()
    {
        return array(
            self::Type_Text=>'Text Ad',
            self::Type_Image=>'Image Ad',
            self::Type_AdGallery=>'Gallery Ad',
        );
    }

    public static function getCodeOptions()
    {
        return array(
            self::Code_Flash=>'Flash',
            self::Code_Html5=>'HTML5',
        );
    }

    public static function getTypeText($type)
    {
        $typeOptions = self::getCodeOptions();
        return isset($typeOptions[$type]) ? $typeOptions[$type] : "unknown Type ({$type})";
    }

    public static function getCodeText($code)
    {
        $codeOptions = self::getCodeOptions();
        return isset($codeOptions[$code]) ? $codeOptions[$code] : "unknown Code ({$code})";
    }

    public static function getStatusOptions()
    {
        return array(
            self::Status_Enabled=>'Enabled',
            self::Status_Paused=>'Paused',
            self::Status_Removed=>'Removed',
        );
    }

    public static function getStatusText($status)
    {
        $statusOptions = self::getStatusOptions();
        return isset($statusOptions[$status]) ? $statusOptions[$status] : "unknown status Code ({$status})";
    }

    public static function getStatusImg($status)
    {
        switch($status)
        {
            case self::Status_Enabled:
                return "/themes/facebook/images/enabled.png";
                break;
            case self::Status_Paused:
                return "/themes/facebook/images/pause.gif";
                break;
            case self::Status_Removed:
                return "/themes/facebook/images/disabled.png";
                break;
            default:
                return "/themes/facebook/images/disabled.png";
                break;
        }
    }

    CONST GroupBy_Day=1;
    CONST GroupBy_Week=2;
    CONST GroupBy_Month=3;
    CONST GroupBy_Year=4;

    public static function getGroupByOptions()
    {
        return array(
            self::GroupBy_Day=>ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'daily'),
            self::GroupBy_Week=>ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'weekly'),
            self::GroupBy_Month=>ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'monthly'),
        );
    }

    public static function getGroupByText($groupBy)
    {
        $groupByOptions = self::getGroupByOptions();
        return isset($groupByOptions[$groupBy]) ? $groupByOptions[$groupBy] : "unknown Group By Code ({$groupBy})";
    }

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{ad_advertise_variation}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ad_group_id, ad_campaign_id, ad_advertise_id, company_id, criteria, display_url, is_delete', 'required'),
			array('ad_group_id, ad_campaign_id, ad_advertise_id, company_id, type, code, status, width, height, is_delete', 'numerical', 'integerOnly'=>true),
			array('display_url, landing_page', 'length', 'max'=>500),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, ad_group_id, ad_campaign_id, ad_advertise_id, company_id, type, code, status, criteria, display_url, landing_page, width, height, is_delete, create_time_utc, create_user_id, update_time_utc, update_user_id', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'company' => array(self::BELONGS_TO, 'Company', 'company_id'),
			'adAdvertise' => array(self::BELONGS_TO, 'ADAdvertise', 'ad_advertise_id'),
			'adGroup' => array(self::BELONGS_TO, 'ADGroup', 'ad_group_id'),
			'adCampaign' => array(self::BELONGS_TO, 'ADCampaign', 'ad_campaign_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'ad_group_id' => 'Ad Group',
			'ad_campaign_id' => 'Ad Campaign',
			'ad_advertise_id' => 'Ad Advertise',
			'company_id' => 'Company',
			'type' => 'Type',
			'code' => 'Code',
			'status' => 'Status',
			'criteria' => 'Criteria',
			'display_url' => 'Display Url',
			'landing_page' => 'Landing Page',
			'width' => 'Width',
			'height' => 'Height',
			'is_delete' => 'Is Delete',
			'create_time_utc' => 'Create Time Utc',
			'create_user_id' => 'Create User',
			'update_time_utc' => 'Update Time Utc',
			'update_user_id' => 'Update User',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('ad_group_id',$this->ad_group_id);
		$criteria->compare('ad_campaign_id',$this->ad_campaign_id);
		$criteria->compare('ad_advertise_id',$this->ad_advertise_id);
		$criteria->compare('company_id',$this->company_id);
		$criteria->compare('type',$this->type);
		$criteria->compare('code',$this->code);
		$criteria->compare('status',$this->status);
		$criteria->compare('criteria',$this->criteria,true);
		$criteria->compare('display_url',$this->display_url,true);
		$criteria->compare('landing_page',$this->landing_page,true);
		$criteria->compare('width',$this->width);
		$criteria->compare('height',$this->height);
		$criteria->compare('is_delete',$this->is_delete);
		$criteria->compare('create_time_utc',$this->create_time_utc);
		$criteria->compare('create_user_id',$this->create_user_id);
		$criteria->compare('update_time_utc',$this->update_time_utc);
		$criteria->compare('update_user_id',$this->update_user_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ADAdvertiseVariation the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
