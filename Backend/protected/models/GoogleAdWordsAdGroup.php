<?php

/**
 * This is the model class for table "{{google_adwords_ad_group}}".
 *
 * The followings are the available columns in table '{{google_adwords_ad_group}}':
 * @property string $id
 * @property integer $lt_ad_group_id
 * @property string $campaign_id
 * @property string $campaign_name
 * @property string $name
 * @property string $status
 * @property string $settings
 * @property string $experiment_data
 * @property string $labels
 * @property string $forward_compatibility_map
 * @property string $bidding_strategy_configuration
 * @property string $content_bid_criterionType_group
 * @property string $tracking_url_template
 * @property string $url_custom_parameters
 * @property integer $create_time_utc
 * @property integer $create_admin_id
 * @property integer $update_time_utc
 * @property integer $update_admin_id
 */
class GoogleAdWordsAdGroup extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{google_adwords_ad_group}}';
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
			array('lt_ad_group_id, create_time_utc, create_admin_id, update_time_utc, update_admin_id', 'numerical', 'integerOnly'=>true),
			array('id, campaign_id', 'length', 'max'=>20),
			array('campaign_name, name, tracking_url_template', 'length', 'max'=>255),
			array('status', 'length', 'max'=>36),
			array('settings, experiment_data, labels, forward_compatibility_map, bidding_strategy_configuration, content_bid_criterionType_group, url_custom_parameters', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, lt_ad_group_id, campaign_id, campaign_name, name, status, settings, experiment_data, labels, forward_compatibility_map, bidding_strategy_configuration, content_bid_criterionType_group, tracking_url_template, url_custom_parameters, create_time_utc, create_admin_id, update_time_utc, update_admin_id', 'safe', 'on'=>'search'),
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
			'aDGroup' => array(self::BELONGS_TO, 'ADGroup', 'lt_ad_group_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'lt_ad_group_id' => 'Lt Ad Group',
			'campaign_id' => 'Campaign',
			'campaign_name' => 'Campaign Name',
			'name' => 'Name',
			'status' => 'Status',
			'settings' => 'Settings',
			'experiment_data' => 'Experiment Data',
			'labels' => 'Labels',
			'forward_compatibility_map' => 'Forward Compatibility Map',
			'bidding_strategy_configuration' => 'Bidding Strategy Configuration',
			'content_bid_criterionType_group' => 'Content Bid Criterion Type Group',
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
		$criteria->compare('lt_ad_group_id',$this->lt_ad_group_id);
		$criteria->compare('campaign_id',$this->campaign_id,true);
		$criteria->compare('campaign_name',$this->campaign_name,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('settings',$this->settings,true);
		$criteria->compare('experiment_data',$this->experiment_data,true);
		$criteria->compare('labels',$this->labels,true);
		$criteria->compare('forward_compatibility_map',$this->forward_compatibility_map,true);
		$criteria->compare('bidding_strategy_configuration',$this->bidding_strategy_configuration,true);
		$criteria->compare('content_bid_criterionType_group',$this->content_bid_criterionType_group,true);
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
	 * @return GoogleAdWordsAdGroup the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
