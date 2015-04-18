<?php

/**
 * This is the model class for table "{{ad_campaign}}".
 *
 * The followings are the available columns in table '{{ad_campaign}}':
 * @property integer $id
 * @property string $name
 * @property integer $company_id
 * @property integer $status
 * @property integer $is_delete
 * @property string $criteria
 * @property string $budget
 * @property integer $start_datetime
 * @property integer $end_datetime
 * @property string $note
 * @property integer $create_time_utc
 * @property integer $create_user_id
 * @property integer $update_time_utc
 * @property integer $update_user_id
 *
 * The followings are the available model relations:
 * @property Company $company
 * @property AdCampaignSchedule[] $adCampaignSchedules
 * @property AdGroup[] $adGroups
 */
class ADCampaign extends NIActiveRecord
{
    CONST Delete_Yes=1;
    CONST Delete_No=0;

    CONST Status_Eligible=0;
    CONST Status_Paused=1;
    CONST Status_Removed=2;
    CONST Status_Pending=3;
    CONST Stauts_Ended=4;
    CONST Status_Suspended=5;
    CONST Status_LimitedByBudget=6;

    public static function getStatusOptions()
    {
        return array(
            self::Status_Eligible=>'Eligible',
            self::Status_Paused=>'Paused',
            self::Status_Removed=>'Removed',
            self::Status_Pending=>'Pending',
            self::Stauts_Ended=>'Ended',
            self::Status_Suspended=>'Suspended',
            self::Status_LimitedByBudget=>'Limited By Budget',
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
		return '{{ad_campaign}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, company_id', 'required'),
			array('company_id, status, is_delete, start_datetime, end_datetime', 'numerical', 'integerOnly'=>true),
			array('name, note', 'length', 'max'=>255),
			array('budget', 'length', 'max'=>20),
			array('criteria', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, company_id, status, is_delete, criteria, budget, start_datetime, end_datetime, note, create_time_utc, create_user_id, update_time_utc, update_user_id', 'safe', 'on'=>'search'),
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
			'adGroups' => array(self::HAS_MANY, 'ADGroup', 'campaign_id'),
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
			'status' => 'Status',
			'is_delete' => 'Is Delete',
			'criteria' => 'Criteria',
			'budget' => 'Budget',
			'start_datetime' => 'Start Datetime',
			'end_datetime' => 'End Datetime',
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
		$criteria->compare('status',$this->status);
		$criteria->compare('is_delete',$this->is_delete);
		$criteria->compare('criteria',$this->criteria,true);
		$criteria->compare('budget',$this->budget,true);
		$criteria->compare('start_datetime',$this->start_datetime);
		$criteria->compare('end_datetime',$this->end_datetime);
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
	 * @return ADCampaign the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
