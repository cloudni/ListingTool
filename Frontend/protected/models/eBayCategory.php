<?php

/**
 * This is the model class for table "{{ebay_category}}".
 *
 * The followings are the available columns in table '{{ebay_category}}':
 * @property integer $id
 * @property integer $AutoPayEnabled
 * @property integer $B2BVATEnabled
 * @property integer $BestOfferEnabled
 * @property string $CategoryID
 * @property integer $CategorySiteID
 * @property integer $CategoryLevel
 * @property string $CategoryName
 * @property string $CategoryParentID
 * @property integer $Expired
 * @property integer $LeafCategory
 * @property integer $LSD
 * @property integer $ORPA
 * @property integer $ORRA
 * @property integer $Virtual
 * @property integer $ebay_entity_type_id
 * @property integer $ebay_attribute_set_id
 * @property string $note
 * @property integer $create_time_utc
 * @property integer $create_user_id
 * @property integer $update_time_utc
 * @property integer $update_user_id
 *
 * The followings are the available model relations:
 * @property EbayEntityType $ebayEntityType
 * @property EbayAttributeSet $ebayAttributeSet
 */
class eBayCategory extends NIActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{ebay_category}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('AutoPayEnabled, B2BVATEnabled, BestOfferEnabled, CategorySiteID, CategoryLevel, Expired, LeafCategory, LSD, ORPA, ORRA, Virtual, ebay_entity_type_id, ebay_attribute_set_id', 'numerical', 'integerOnly'=>true),
			array('CategoryID, CategoryParentID', 'length', 'max'=>10),
			array('CategoryName', 'length', 'max'=>30),
			array('note', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, AutoPayEnabled, B2BVATEnabled, BestOfferEnabled, CategoryID, CategorySiteID, CategoryLevel, CategoryName, CategoryParentID, Expired, LeafCategory, LSD, ORPA, ORRA, Virtual, ebay_entity_type_id, ebay_attribute_set_id, note, create_time_utc, create_user_id, update_time_utc, update_user_id', 'safe', 'on'=>'search'),
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
			'eBayEntityType' => array(self::BELONGS_TO, 'EbayEntityType', 'ebay_entity_type_id'),
			'eBayAttributeSet' => array(self::BELONGS_TO, 'EbayAttributeSet', 'ebay_attribute_set_id'),
            'categoryParent' => array(self::BELONGS_TO, 'eBayCategory', 'CategoryParentID'),
            'categoryChildren' => array(self::HAS_MANY, 'eBayCategory', 'CategoryParentID'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'AutoPayEnabled' => 'Auto Pay Enabled',
			'B2BVATEnabled' => 'B2 Bvatenabled',
			'BestOfferEnabled' => 'Best Offer Enabled',
			'CategoryID' => 'Category',
			'CategorySiteID' => 'Category Site',
			'CategoryLevel' => 'Category Level',
			'CategoryName' => 'Category Name',
			'CategoryParentID' => 'Category Parent',
			'Expired' => 'Expired',
			'LeafCategory' => 'Leaf Category',
			'LSD' => 'Lsd',
			'ORPA' => 'Orpa',
			'ORRA' => 'Orra',
			'Virtual' => 'Virtual',
			'ebay_entity_type_id' => 'eBay Entity Type',
			'ebay_attribute_set_id' => 'eBay Attribute Set',
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
		$criteria->compare('AutoPayEnabled',$this->AutoPayEnabled);
		$criteria->compare('B2BVATEnabled',$this->B2BVATEnabled);
		$criteria->compare('BestOfferEnabled',$this->BestOfferEnabled);
		$criteria->compare('CategoryID',$this->CategoryID,true);
		$criteria->compare('CategorySiteID',$this->CategorySiteID);
		$criteria->compare('CategoryLevel',$this->CategoryLevel);
		$criteria->compare('CategoryName',$this->CategoryName,true);
		$criteria->compare('CategoryParentID',$this->CategoryParentID,true);
		$criteria->compare('Expired',$this->Expired);
		$criteria->compare('LeafCategory',$this->LeafCategory);
		$criteria->compare('LSD',$this->LSD);
		$criteria->compare('ORPA',$this->ORPA);
		$criteria->compare('ORRA',$this->ORRA);
		$criteria->compare('Virtual',$this->Virtual);
		$criteria->compare('ebay_entity_type_id',$this->ebay_entity_type_id);
		$criteria->compare('ebay_attribute_set_id',$this->ebay_attribute_set_id);
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
	 * @return eBayCategory the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public static function getParentCategory($level=2)
    {

    }
}
