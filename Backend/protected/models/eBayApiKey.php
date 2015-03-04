<?php

/**
 * This is the model class for table "{{ebay_api_key}}".
 *
 * The followings are the available columns in table '{{ebay_api_key}}':
 * @property integer $id
 * @property string $name
 * @property string $api_url
 * @property string $compatibility_level
 * @property integer $type
 * @property string $dev_id
 * @property string $app_id
 * @property string $cert_id
 * @property string $runame
 * @property integer $create_time_utc
 * @property integer $create_admin_id
 * @property integer $update_time_utc
 * @property integer $update_admin_id
 */
class eBayApiKey extends NIAdminActiveRecord
{
    const TYPE_SANDBOX=1;
    const TYPE_PROD=2;

    /**
     * Get store is active
     * @return array
     */
    public function getTypeOptions()
    {
        return array(
            self::TYPE_SANDBOX=>"Sandbox",
            self::TYPE_PROD=>'Production',
        );
    }

    /**
     * @return string get active text
     */
    public function getTypeText()
    {
        $types = $this->typeOptions;
        return isset($types[$this->type]) ? $types[$this->type] : "Unknown Type ({$this->type})";
    }

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{ebay_api_key}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('api_url, compatibility_level, name, dev_id, app_id, cert_id', 'required'),
			array('type', 'numerical', 'integerOnly'=>true),
			array('api_url, name, dev_id, app_id, cert_id', 'length', 'max'=>255),
			array('compatibility_level', 'length', 'max'=>50),
            array('runame', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, api_url, compatibility_level, type, name, dev_id, app_id, cert_id, runame, create_time_utc, create_admin_id, update_time_utc, update_admin_id', 'safe', 'on'=>'search'),
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
			'api_url' => 'API URL',
			'compatibility_level' => 'Compatibility Level',
			'type' => 'Type',
			'name' => 'Name',
			'dev_id' => 'DevID',
			'app_id' => 'AppID',
			'cert_id' => 'CertID',
            'runame' => 'RuName',
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
		$criteria->compare('api_url',$this->api_url,true);
		$criteria->compare('compatibility_level',$this->compatibility_level,true);
		$criteria->compare('type',$this->type);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('dev_id',$this->dev_id,true);
		$criteria->compare('app_id',$this->app_id,true);
		$criteria->compare('cert_id',$this->cert_id,true);
        $criteria->compare('runame',$this->runame,true);
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
	 * @return eBayApiKey the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
