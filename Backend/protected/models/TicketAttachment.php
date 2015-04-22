<?php

/**
 * This is the model class for table "{{ticket_attachment}}".
 *
 * The followings are the available columns in table '{{ticket_attachment}}':
 * @property integer $id
 * @property integer $ticket_id
 * @property string $name
 * @property integer $company_id
 * @property string $path
 * @property string $view_url
 * @property string $type
 * @property integer $is_delete
 * @property integer $size
 * @property integer $create_time_utc
 * @property integer $create_user_id
 * @property integer $update_time_utc
 * @property integer $update_user_id
 *
 * The followings are the available model relations:
 * @property Ticket $ticket
 * @property Company $company
 */
class TicketAttachment extends NIActiveRecord
{
    const IS_DELETE_YES=1;
    CONST IS_DELETE_NO=2;

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{ticket_attachment}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ticket_id, company_id, is_delete, size', 'numerical', 'integerOnly'=>true),
			array('name, type', 'length', 'max'=>45),
			array('path', 'length', 'max'=>255),
			array('view_url', 'length', 'max'=>500),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, ticket_id, name, company_id, path, view_url, type, is_delete, size, create_time_utc, create_user_id, update_time_utc, update_user_id', 'safe', 'on'=>'search'),
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
			'ticket' => array(self::BELONGS_TO, 'Ticket', 'ticket_id'),
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
			'ticket_id' => 'Ticket',
			'name' => 'Name',
			'company_id' => 'Company',
			'path' => 'Path',
			'view_url' => 'View Url',
			'type' => 'Type',
			'is_delete' => 'Is Delete',
			'size' => 'Size',
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
		$criteria->compare('ticket_id',$this->ticket_id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('company_id',$this->company_id);
		$criteria->compare('path',$this->path,true);
		$criteria->compare('view_url',$this->view_url,true);
		$criteria->compare('type',$this->type,true);
		$criteria->compare('is_delete',$this->is_delete);
		$criteria->compare('size',$this->size);
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
	 * @return TicketAttachment the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
