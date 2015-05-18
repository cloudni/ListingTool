<?php

/**
 * This is the model class for table "{{ad_change_log}}".
 *
 * The followings are the available columns in table '{{ad_change_log}}':
 * @property integer $id
 * @property integer $company_id
 * @property string $object_type
 * @property integer $object_id
 * @property integer $action
 * @property string $title
 * @property string $content
 * @property integer $status
 * @property integer $priority
 * @property integer $create_time_utc
 * @property integer $create_user_id
 * @property integer $update_time_utc
 * @property integer $update_user_id
 *
 * The followings are the available model relations:
 * @property Company $company
 */
class ADChangeLog extends CActiveRecord
{
    CONST Action_AddNew=0;
    CONST Action_Update=1;
    CONST Action_Delete=2;

    CONST Status_Pending=0;
    CONST Status_Processed=1;
    CONST Status_Process_Failed=2;

    CONST Priority_Normal=0;
    CONST Priority_High=1;
    CONST Priority_Higher=2;
    CONST Priority_Highest=3;
    CONST Priority_Urgent=4;

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{ad_change_log}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('company_id, object_type, object_id, title, content', 'required'),
			array('company_id, object_id, action, status, priority, create_time_utc, create_user_id, update_time_utc, update_user_id', 'numerical', 'integerOnly'=>true),
			array('object_type', 'length', 'max'=>255),
			array('title', 'length', 'max'=>256),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, company_id, object_type, object_id, action, title, content, status, priority, create_time_utc, create_user_id, update_time_utc, update_user_id', 'safe', 'on'=>'search'),
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
			'object_type' => 'Object Type',
			'object_id' => 'Object',
			'action' => 'Action',
			'title' => 'Title',
			'content' => 'Content',
			'status' => 'Status',
			'priority' => 'Priority',
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
		$criteria->compare('company_id',$this->company_id);
		$criteria->compare('object_type',$this->object_type,true);
		$criteria->compare('object_id',$this->object_id);
		$criteria->compare('action',$this->action);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('content',$this->content,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('priority',$this->priority);
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
	 * @return ADChangeLog the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
