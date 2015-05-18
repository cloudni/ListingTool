<?php

/**
 * This is the model class for table "{{wish_listing}}".
 *
 * The followings are the available columns in table '{{wish_listing}}':
 * @property integer $id
 * @property integer $company_id
 * @property integer $store_id
 * @property string $wish_id
 * @property string $main_image
 * @property string $description
 * @property string $name
 * @property string $review_status
 * @property string $upc
 * @property string $extra_images
 * @property string $landing_page_url
 * @property integer $number_saves
 * @property integer $number_sold
 * @property string $parent_sku
 * @property string $note
 * @property integer $create_time_utc
 * @property integer $create_user_id
 * @property integer $update_time_utc
 * @property integer $update_user_id
 *
 * The followings are the available model relations:
 * @property Company $company
 * @property Store $store
 */
class WishListing extends NIActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{wish_listing}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('company_id, store_id, wish_id', 'required'),
			array('company_id, store_id, number_saves, number_sold, create_time_utc, create_user_id, update_time_utc, update_user_id', 'numerical', 'integerOnly'=>true),
			array('wish_id, name, review_status, upc, extra_images, landing_page_url, parent_sku, note', 'length', 'max'=>255),
			array('main_image', 'length', 'max'=>500),
			array('description', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, company_id, store_id, wish_id, main_image, description, name, review_status, upc, extra_images, landing_page_url, number_saves, number_sold, parent_sku, note, create_time_utc, create_user_id, update_time_utc, update_user_id', 'safe', 'on'=>'search'),
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
			'store' => array(self::BELONGS_TO, 'Store', 'store_id'),
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
			'store_id' => 'Store',
			'wish_id' => 'Wish',
			'main_image' => 'Main Image',
			'description' => 'Description',
			'name' => 'Name',
			'review_status' => 'Review Status',
			'upc' => 'Upc',
			'extra_images' => 'Extra Images',
			'landing_page_url' => 'Landing Page Url',
			'number_saves' => 'Number Saves',
			'number_sold' => 'Number Sold',
			'parent_sku' => 'Parent Sku',
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
		$criteria->compare('company_id',$this->company_id);
		$criteria->compare('store_id',$this->store_id);
		$criteria->compare('wish_id',$this->wish_id,true);
		$criteria->compare('main_image',$this->main_image,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('review_status',$this->review_status,true);
		$criteria->compare('upc',$this->upc,true);
		$criteria->compare('extra_images',$this->extra_images,true);
		$criteria->compare('landing_page_url',$this->landing_page_url,true);
		$criteria->compare('number_saves',$this->number_saves);
		$criteria->compare('number_sold',$this->number_sold);
		$criteria->compare('parent_sku',$this->parent_sku,true);
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
	 * @return WishListing the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
