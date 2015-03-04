<?php

/**
 * This is the model class for table "{{store}}".
 *
 * The followings are the available columns in table '{{store}}':
 * @property integer $id
 * @property string $name
 * @property integer $platform
 * @property integer $is_active
 * @property integer $company_id
 * @property integer $last_listing_sync_time_utc
 * @property integer $ebay_api_key_id
 * @property string $ebay_token
 * @property integer $HardExpirationTime
 * @property integer $ebay_site_code
 * @property integer $create_time_utc
 * @property integer $create_user_id
 * @property integer $update_time_utc
 * @property integer $update_user_id
 *
 * The followings are the available model relations:
 * @property eBayListing[] $ebayListings
 * @property Company $company
 */
class Store extends NIActiveRecord
{
    //const for platform
    const PLATFORM_EBAY=1;
    const PLATFORM_AMAZON=2;
    const PLATFORM_ALIEXPRESS=3;
    const PLATFORM_WISH=4;
    const PLATFORM_ECSHOP=5;
    const PLATFORM_MAGENTO=6;

    //const for is active
    const ACTIVE_YES=1;
    const ACTIVE_NO=2;

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{store}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, platform', 'required'),
			array('platform, is_active, company_id, ebay_api_key_id, ebay_site_code, HardExpirationTime', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>256),
            array('ebay_token', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, platform, is_active, company_id, last_listing_sync_time_utc, ebay_api_key_id, ebay_token, ebay_site_code, HardExpirationTime, create_time_utc, create_user_id, update_time_utc, update_user_id', 'safe', 'on'=>'search'),
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
            'eBayListings' => array(self::HAS_MANY, 'eBayListing', 'store_id'),
			'company' => array(self::BELONGS_TO, 'Company', 'company_id'),
            'eBayApiKey' => array(self::BELONGS_TO, 'eBayApiKey', 'ebay_api_key_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => Yii::t('models/Store','ID'),
			'name' => Yii::t('models/Store','Name'),
			'platform' => Yii::t('models/Store','Platform'),
            'is_active' => Yii::t('models/Store','Is Active') ,
			'company_id' => Yii::t('models/Store','Company') ,
            'ebay_api_key_id' => 'eBay API Key',
            'ebay_token' => 'eBay Token',
            'ebay_site_code' => 'eBay Site Code',
            'HardExpirationTime' => 'eBay Token Expiration Time',
            'last_listing_sync_time_utc' => Yii::t('models/Store','Last Listing Sync Time Utc'),
            'create_time_utc' => Yii::t('models/Store','Create Time Utc') ,
            'create_user_id' => Yii::t('models/Store','Create User'),
            'update_time_utc' => Yii::t('models/Store','Update Time Utc') ,
            'update_user_id' => Yii::t('models/Store','Update User') ,
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
		$criteria->compare('platform',$this->platform);
        $criteria->compare('is_active',$this->is_active);
		$criteria->compare('company_id',$this->company_id);
        $criteria->compare('last_listing_sync_time_utc',$this->last_listing_sync_time_utc);
        $criteria->compare('ebay_api_key_id',$this->ebay_api_key_id);
        $criteria->compare('ebay_token',$this->ebay_token,true);
        $criteria->compare('ebay_site_code',$this->ebay_site_code);
        $criteria->compare('HardExpirationTime',$this->HardExpirationTime);
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
	 * @return Store the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    /**
     * Get store platform types
     * @return array
     */
    public function getPlatformOptions()
    {
        return array(
            self::PLATFORM_EBAY=>'eBay.com',
            /*self::PLATFORM_AMAZON=>'Amazon.com',
            self::PLATFORM_ALIEXPRESS=>'AliExpress.com',
            self::PLATFORM_WISH=>'Wish.com',
            self::PLATFORM_ECSHOP=>'Ecshop sites',
            self::PLATFORM_MAGENTO=>'Magento sites',*/
        );
    }

    public function getPlatformOptionsStatic()
    {
        return array(
            self::PLATFORM_EBAY=>'eBay.com',
            /*self::PLATFORM_AMAZON=>'Amazon.com',
            self::PLATFORM_ALIEXPRESS=>'AliExpress.com',
            self::PLATFORM_WISH=>'Wish.com',
            self::PLATFORM_ECSHOP=>'Ecshop sites',
            self::PLATFORM_MAGENTO=>'Magento sites',*/
        );
    }

    public static function getPlatformTextStatic($platform=null)
    {
        $platformOptions = Store::getPlatformOptionsStatic();
        return isset($platformOptions[$platform]) ? $platformOptions[$platform] : "unknown Platform ({$platform})";
    }

    /**
     * @return string get platform text
     */
    public function getPlatformText()
    {
        $platformOptions = $this->platformOptions;
        return isset($platformOptions[$this->platform]) ? $platformOptions[$this->platform] : "unknown Platform ({$this->platform})";
    }

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

    public static function getIsActiveOptionsStatic()
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

    public static function getIsActiveTextStatic($isActve)
    {
        $isActiveOptions = Store::getIsActiveOptionsStatic();
        return isset($isActiveOptions[$isActve]) ? $isActiveOptions[$isActve] : "unknown Active Type ({$isActve})";
    }

    public static function getStoreOptions($platform=NULL)
    {
        $stores = Store::model()->findAll('platform=:platform', array(':platform'=>(int)$platform));
        if(empty($stores)) return array();
        $resultList = array();
        foreach($stores as $store)
        {
            $resultList[$store['id']] = $store['name'];
        }
        return $resultList;
    }
}
