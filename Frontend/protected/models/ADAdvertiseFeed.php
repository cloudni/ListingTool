<?php

/**
 * This is the model class for table "{{ad_advertise_feed}}".
 *
 * The followings are the available columns in table '{{ad_advertise_feed}}':
 * @property integer $id
 * @property integer $ad_advertise_id
 * @property integer $ad_group_id
 * @property integer $ad_campaign_id
 * @property integer $company_id
 * @property string $item_id
 * @property integer $item_type
 * @property string $item_keywords
 * @property string $item_headline
 * @property string $item_sub_headline
 * @property string $item_description
 * @property string $item_address
 * @property string $price
 * @property string $image_url
 * @property integer $item_category
 * @property string $sale_price
 * @property string $remarketing_url
 * @property string $destination_url
 * @property string $final_url
 * @property integer $create_time_utc
 * @property integer $create_user_id
 * @property integer $update_time_utc
 * @property integer $update_user_id
 *
 * The followings are the available model relations:
 * @property AdAdvertise $adAdvertise
 * @property Company $company
 * @property AdGroup $adGroup
 * @property AdCampaign $adCampaign
 */
class ADAdvertiseFeed extends NIActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{ad_advertise_feed}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ad_advertise_id, ad_group_id, ad_campaign_id, company_id, item_id, item_headline, image_url, remarketing_url, destination_url, final_url', 'required'),
			array('ad_advertise_id, ad_group_id, ad_campaign_id, company_id, item_type, item_category', 'numerical', 'integerOnly'=>true),
            array('item_id', 'length', 'max'=>50),
			array('item_headline, item_sub_headline', 'length', 'max'=>100),
            array('item_description, item_address', 'length', 'max'=>255),
			array('price, sale_price', 'length', 'max'=>20),
			array('image_url, remarketing_url, destination_url, final_url', 'length', 'max'=>500),
			array('item_keywords', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, ad_advertise_id, ad_group_id, ad_campaign_id, company_id, item_id, item_type, item_keywords, item_headline, item_sub_headline, item_description, item_address, price, image_url, item_category, sale_price, remarketing_url, destination_url, final_url, create_time_utc, create_user_id, update_time_utc, update_user_id', 'safe', 'on'=>'search'),
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
			'adAdvertise' => array(self::BELONGS_TO, 'ADAdvertise', 'ad_advertise_id'),
			'company' => array(self::BELONGS_TO, 'Company', 'company_id'),
			'adGroup' => array(self::BELONGS_TO, 'ADGroup', 'ad_group_id'),
			'adCampaign' => array(self::BELONGS_TO, 'ADCampaign', 'ad_campaign_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'ad_advertise_id' => 'Ad Advertise',
			'ad_group_id' => 'Ad Group',
			'ad_campaign_id' => 'Ad Campaign',
			'company_id' => 'Company',
			'item_id' => 'Item',
			'item_type' => 'Item Type',
			'item_keywords' => 'Item Keywords',
			'item_headline' => 'Item Headline',
			'item_sub_headline' => 'Item Sub Headline',
			'item_description' => 'Item Description',
			'item_address' => 'Item Address',
			'price' => 'Price',
			'image_url' => 'Image Url',
			'item_category' => 'Item Category',
			'sale_price' => 'Sale Price',
			'remarketing_url' => 'Remarketing Url',
			'destination_url' => 'Destination Url',
			'final_url' => 'Final Url',
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
		$criteria->compare('ad_advertise_id',$this->ad_advertise_id);
		$criteria->compare('ad_group_id',$this->ad_group_id);
		$criteria->compare('ad_campaign_id',$this->ad_campaign_id);
		$criteria->compare('company_id',$this->company_id);
        $criteria->compare('item_id',$this->item_id,true);
		$criteria->compare('item_type',$this->item_type);
		$criteria->compare('item_keywords',$this->item_keywords,true);
		$criteria->compare('item_headline',$this->item_headline,true);
		$criteria->compare('item_sub_headline',$this->item_sub_headline,true);
		$criteria->compare('item_description',$this->item_description,true);
		$criteria->compare('item_address',$this->item_address,true);
		$criteria->compare('price',$this->price,true);
		$criteria->compare('image_url',$this->image_url,true);
		$criteria->compare('item_category',$this->item_category);
		$criteria->compare('sale_price',$this->sale_price,true);
		$criteria->compare('remarketing_url',$this->remarketing_url,true);
		$criteria->compare('destination_url',$this->destination_url,true);
		$criteria->compare('final_url',$this->final_url,true);
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
	 * @return ADAdvertiseFeed the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
