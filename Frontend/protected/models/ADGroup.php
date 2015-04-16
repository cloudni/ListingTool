<?php

/**
 * This is the model class for table "{{ad_group}}".
 *
 * The followings are the available columns in table '{{ad_group}}':
 * @property integer $id
 * @property string $name
 * @property integer $company_id
 * @property integer $campaign_id
 * @property integer $status
 * @property integer $is_delete
 * @property string $default_bid
 * @property string $criteria
 * @property string $note
 * @property integer $create_time_utc
 * @property integer $create_user_id
 * @property integer $update_time_utc
 * @property integer $update_user_id
 *
 * The followings are the available model relations:
 * @property Company $company
 * @property AdCampaign $campaign
 */
class ADGroup extends NIActiveRecord
{
    CONST Criteria_Separator="$$$$$";
    CONST Delete_Yes=1;
    CONST Delete_No=0;

    CONST Status_Enabled=0;
    CONST Status_Paused=1;
    CONST Status_Removed=2;

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

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{ad_group}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, company_id, default_bid', 'required'),
			array('company_id, campaign_id, status, is_delete', 'numerical', 'integerOnly'=>true),
			array('name, note', 'length', 'max'=>255),
			array('default_bid', 'length', 'max'=>20),
			array('criteria', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, company_id, campaign_id, status, is_delete, default_bid, criteria, note, create_time_utc, create_user_id, update_time_utc, update_user_id', 'safe', 'on'=>'search'),
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
			'campaign' => array(self::BELONGS_TO, 'ADCampaign', 'campaign_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Name',
			'company_id' => 'Company',
			'campaign_id' => 'Campaign',
			'status' => 'Status',
			'is_delete' => 'Is Delete',
			'default_bid' => 'Default Bid',
			'criteria' => 'Criteria',
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('company_id',$this->company_id);
		$criteria->compare('campaign_id',$this->campaign_id);
		$criteria->compare('status',$this->status);
		$criteria->compare('is_delete',$this->is_delete);
		$criteria->compare('default_bid',$this->default_bid,true);
		$criteria->compare('criteria',$this->criteria,true);
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
	 * @return ADGroup the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
