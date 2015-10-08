<?php

/**
 * This is the model class for table "{{google_adwords_campaign}}".
 *
 * The followings are the available columns in table '{{google_adwords_campaign}}':
 * @property string $id
 * @property string $lt_ad_campaign_id
 * @property string $name
 * @property string $status
 * @property string $serving_status
 * @property string $start_date
 * @property string $end_date
 * @property string $budget
 * @property string $conversion_optimizer_eligibility
 * @property string $adServing_optimization_status
 * @property string $frequency_cap
 * @property string $settings
 * @property string $advertising_channel_type
 * @property string $advertising_channel_sub_type
 * @property string $network_setting
 * @property string $labels
 * @property string $bidding_strategy_configuration
 * @property string $forward_compatibility_map
 * @property string $tracking_url_template
 * @property string $url_custom_parameters
 * @property integer $create_time_utc
 * @property integer $create_admin_id
 * @property integer $update_time_utc
 * @property integer $update_admin_id
 */
class GoogleAdWordsCampaign extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{google_adwords_campaign}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id', 'required'),
			array('create_time_utc, create_admin_id, update_time_utc, update_admin_id', 'numerical', 'integerOnly'=>true),
			array('id, lt_ad_campaign_id, budget, adServing_optimization_status, advertising_channel_sub_type', 'length', 'max'=>20),
			array('name', 'length', 'max'=>255),
			array('status, serving_status', 'length', 'max'=>36),
			array('start_date, end_date', 'length', 'max'=>8),
			array('advertising_channel_type', 'length', 'max'=>10),
			array('conversion_optimizer_eligibility, frequency_cap, settings, network_setting, labels, bidding_strategy_configuration, forward_compatibility_map, tracking_url_template, url_custom_parameters', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, lt_ad_campaign_id, name, status, serving_status, start_date, end_date, budget, conversion_optimizer_eligibility, adServing_optimization_status, frequency_cap, settings, advertising_channel_type, advertising_channel_sub_type, network_setting, labels, bidding_strategy_configuration, forward_compatibility_map, tracking_url_template, url_custom_parameters, create_time_utc, create_admin_id, update_time_utc, update_admin_id', 'safe', 'on'=>'search'),
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
			'aDCampaign' => array(self::BELONGS_TO, 'ADCampaign', 'lt_ad_campaign_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'lt_ad_campaign_id' => 'Lt Ad Campaign',
			'name' => 'Name',
			'status' => 'Status',
			'serving_status' => 'Serving Status',
			'start_date' => 'Start Date',
			'end_date' => 'End Date',
			'budget' => 'Budget',
			'conversion_optimizer_eligibility' => 'Conversion Optimizer Eligibility',
			'adServing_optimization_status' => 'Ad Serving Optimization Status',
			'frequency_cap' => 'Frequency Cap',
			'settings' => 'Settings',
			'advertising_channel_type' => 'Advertising Channel Type',
			'advertising_channel_sub_type' => 'Advertising Channel Sub Type',
			'network_setting' => 'Network Setting',
			'labels' => 'Labels',
			'bidding_strategy_configuration' => 'Bidding Strategy Configuration',
			'forward_compatibility_map' => 'Forward Compatibility Map',
			'tracking_url_template' => 'Tracking Url Template',
			'url_custom_parameters' => 'Url Custom Parameters',
			'create_time_utc' => 'Create Time Utc',
			'create_admin_id' => 'Create Admin',
			'update_time_utc' => 'Update Time Utc',
			'update_admin_id' => 'Update Admin',
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('lt_ad_campaign_id',$this->lt_ad_campaign_id,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('serving_status',$this->serving_status,true);
		$criteria->compare('start_date',$this->start_date,true);
		$criteria->compare('end_date',$this->end_date,true);
		$criteria->compare('budget',$this->budget,true);
		$criteria->compare('conversion_optimizer_eligibility',$this->conversion_optimizer_eligibility,true);
		$criteria->compare('adServing_optimization_status',$this->adServing_optimization_status,true);
		$criteria->compare('frequency_cap',$this->frequency_cap,true);
		$criteria->compare('settings',$this->settings,true);
		$criteria->compare('advertising_channel_type',$this->advertising_channel_type,true);
		$criteria->compare('advertising_channel_sub_type',$this->advertising_channel_sub_type,true);
		$criteria->compare('network_setting',$this->network_setting,true);
		$criteria->compare('labels',$this->labels,true);
		$criteria->compare('bidding_strategy_configuration',$this->bidding_strategy_configuration,true);
		$criteria->compare('forward_compatibility_map',$this->forward_compatibility_map,true);
		$criteria->compare('tracking_url_template',$this->tracking_url_template,true);
		$criteria->compare('url_custom_parameters',$this->url_custom_parameters,true);
		$criteria->compare('create_time_utc',$this->create_time_utc);
		$criteria->compare('create_admin_id',$this->create_admin_id);
		$criteria->compare('update_time_utc',$this->update_time_utc);
		$criteria->compare('update_admin_id',$this->update_admin_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return GoogleAdWordsCampaign the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
