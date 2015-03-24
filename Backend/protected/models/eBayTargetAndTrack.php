<?php

/**
 * This is the model class for table "{{ebay_target_and_track}}".
 *
 * The followings are the available columns in table '{{ebay_target_and_track}}':
 * @property integer $id
 * @property string $name
 * @property integer $company_id
 * @property string $target_ebay_item_id
 * @property string $tracking_ebay_listing_id
 * @property string $update_param
 * @property integer $is_active
 * @property string $note
 * @property integer $create_time_utc
 * @property integer $create_user_id
 * @property integer $update_time_utc
 * @property integer $update_user_id
 *
 * The followings are the available model relations:
 * @property Company $company
 */
class eBayTargetAndTrack extends NIActiveRecord
{
    /*
     * const for active of attribute set
     */
    const ACTIVE_YES=1;
    const ACTIVE_NO=0;

    /**
     * Get store is active
     * @return array
     */
    public function getIsActiveOptions()
    {
        return array(
            self::ACTIVE_YES=>"Yes",
            self::ACTIVE_NO=>'No',
        );
    }

    /**
     * @return string get active text
     */
    public function getIsActiveText()
    {
        $isActiveOptions = $this->isActiveOptions;
        return isset($isActiveOptions[$this->is_active]) ? $isActiveOptions[$this->is_active] : "unknown Active Type ({$this->is_active})";
    }

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{ebay_target_and_track}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, company_id, target_ebay_item_id, tracking_ebay_listing_id, update_param', 'required'),
			array('company_id', 'numerical', 'integerOnly'=>true),
			array('target_ebay_item_id, tracking_ebay_listing_id', 'length', 'max'=>500),
			array('update_param', 'length', 'max'=>1000),
			array('note, name', 'length', 'max'=>256),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, company_id, target_ebay_item_id, tracking_ebay_listing_id, update_param, note', 'safe', 'on'=>'search'),
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
			'Company' => array(self::BELONGS_TO, 'Company', 'company_id'),
            'CreateUser' => array(self::BELONGS_TO, 'User', 'create_user_id'),
            'UpdateUser' => array(self::BELONGS_TO, 'User', 'update_user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'company_id' => 'Company',
			'target_ebay_item_id' => 'Target Ebay Item',
			'tracking_ebay_listing_id' => 'Tracking Ebay Listing',
			'update_param' => 'Update Param',
			'note' => 'Note',
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
        $criteria->compare('name',$this->name);
		$criteria->compare('company_id',$this->company_id);
		$criteria->compare('target_ebay_item_id',$this->target_ebay_item_id,true);
		$criteria->compare('tracking_ebay_listing_id',$this->tracking_ebay_listing_id,true);
		$criteria->compare('update_param',$this->update_param,true);
		$criteria->compare('note',$this->note,true);
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
	 * @return eBayTargetAndTrack the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
