<?php

/**
 * This is the model class for table "{{ebay_attribute}}".
 * This model is readonly in frontend site
 *
 * The followings are the available columns in table '{{ebay_attribute}}':
 * @property integer $id
 * @property string $name
 * @property string $code
 * @property integer $backend_type
 * @property integer $size
 * @property string $frontend_input
 * @property string $frontend_label
 * @property string $note
 * @property integer $create_time_utc
 * @property integer $create_admin_id
 * @property integer $update_time_utc
 * @property integer $update_admin_id
 *
 * The followings are the available model relations:
 */
class eBayAttribute extends NIAdminActiveRecord
{
    /*
     * CONST FOR backend type of attribute
     */
    const BACKEND_TYPE_INT=1;
    const BACKEND_TYPE_DECIMAL=2;
    const BACKEND_TYPE_VARCHAR=3;
    const BACKEND_TYPE_TEXT=4;
    const BACKEND_TYPE_DATETIME=5;
    const BACKEND_TYPE_BOOLEAN=6;
    const BACKEND_TYPE_CONTAINER=7;

    public function getBackendTypes()
    {
        return array(
            self::BACKEND_TYPE_INT=>'Integer',
            self::BACKEND_TYPE_DECIMAL=>'Decimal',
            self::BACKEND_TYPE_VARCHAR=>'Short Text(500 Max)',
            self::BACKEND_TYPE_TEXT=>'Long Text',
            self::BACKEND_TYPE_DATETIME=>'DateTime',
            self::BACKEND_TYPE_BOOLEAN=>'Yes or No',
            self::BACKEND_TYPE_CONTAINER=>'Container for other attribute',
        );
    }

    /**
     * @return string get backend type text
     */
    public function getBackendTypeText()
    {
        $backendTypes = $this->backendTypes;
        return isset($backendTypes[$this->backend_type]) ? $backendTypes[$this->backend_type] : "unknown backend type ({$this->backend_type})";
    }

    /*
     * const for frontend input type
     */
    const FRONTEND_TEXT=1;
    const FRONTEND_TEXTAREA=2;
    const FRONTEND_CALENDAR=3;
    const FRONTEND_DROPDOWNLIST=4;
    const FRONTEND_CHECKBOX=5;

    public function getFrontendInputs()
    {
        return array(
            self::FRONTEND_TEXT=>'Single Line Text Field',
            self::FRONTEND_TEXTAREA=>'Multiple Line Text Input',
            self::FRONTEND_CALENDAR=>'Calendar',
            self::FRONTEND_DROPDOWNLIST=>'Drop Down List',
            self::FRONTEND_CHECKBOX=>'Check Box',
        );
    }

    /**
     * @return string get front end text
     */
    public function getFrontendInputText()
    {
        $frontendInputs = $this->frontendInputs;
        return isset($frontendInputs[$this->frontend_input]) ? $frontendInputs[$this->frontend_input] : "unknown front input: ({$this->frontend_input})";
    }

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{ebay_attribute}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, code, backend_type', 'required'),
			array('backend_type, size', 'numerical', 'integerOnly'=>true),
			array('name, code, frontend_input, frontend_label, note', 'length', 'max'=>255),
            array('code','unique'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, code, backend_type, size, frontend_input, frontend_label, note, create_time_utc, create_admin_id, update_time_utc, update_admin_id', 'safe', 'on'=>'search'),
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
			'code' => 'Code',
			'backend_type' => 'Backend Type',
            'size' => 'Size',
			'frontend_input' => 'Frontend Input',
			'frontend_label' => 'Frontend Label',
			'note' => 'Note',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('code',$this->code,true);
		$criteria->compare('backend_type',$this->backend_type);
        $criteria->compare('size',$this->size);
		$criteria->compare('frontend_input',$this->frontend_input,true);
		$criteria->compare('frontend_label',$this->frontend_label,true);
		$criteria->compare('note',$this->note,true);
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
	 * @return eBayAttribute the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
