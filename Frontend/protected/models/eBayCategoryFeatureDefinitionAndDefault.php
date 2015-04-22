<?php

/**
 * This is the model class for table "{{ebay_category_feature_definition_and_default}}".
 *
 * The followings are the available columns in table '{{ebay_category_feature_definition_and_default}}':
 * @property integer $id
 * @property string $name
 * @property integer $site_id
 * @property string $CategoryVersion
 * @property integer $ebay_entity_type_id
 * @property integer $ebay_attribute_set_id
 * @property string $note
 * @property integer $create_time_utc
 * @property integer $create_admin_id
 * @property integer $update_time_utc
 * @property integer $update_admin_id
 *
 * The followings are the available model relations:
 * @property EbayEntityType $ebayEntityType
 * @property EbayAttributeSet $ebayAttributeSet
 */
class eBayCategoryFeatureDefinitionAndDefault extends NIAdminActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{ebay_category_feature_definition_and_default}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('site_id, ebay_entity_type_id, ebay_attribute_set_id', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>45),
			array('CategoryVersion, note', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, site_id, CategoryVersion, ebay_entity_type_id, ebay_attribute_set_id, note, create_time_utc, create_admin_id, update_time_utc, update_admin_id', 'safe', 'on'=>'search'),
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
			'eBayEntityType' => array(self::BELONGS_TO, 'eBayEntityType', 'ebay_entity_type_id'),
			'eBayAttributeSet' => array(self::BELONGS_TO, 'eBayAttributeSet', 'ebay_attribute_set_id'),
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
			'site_id' => 'Site',
			'CategoryVersion' => 'Category Version',
			'ebay_entity_type_id' => 'Ebay Entity Type',
			'ebay_attribute_set_id' => 'Ebay Attribute Set',
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
		$criteria->compare('site_id',$this->site_id);
		$criteria->compare('CategoryVersion',$this->CategoryVersion,true);
		$criteria->compare('ebay_entity_type_id',$this->ebay_entity_type_id);
		$criteria->compare('ebay_attribute_set_id',$this->ebay_attribute_set_id);
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
	 * @return eBayCategoryFeatureDefinitionAndDefault the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
