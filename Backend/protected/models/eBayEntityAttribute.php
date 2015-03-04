<?php

/**
 * This is the model class for table "{{ebay_entity_attribute}}".
 *
 * The followings are the available columns in table '{{ebay_entity_attribute}}':
 * @property integer $id
 * @property integer $entity_type_id
 * @property integer $attribute_set_id
 * @property integer $attribute_group_id
 * @property integer $attribute_id
 * @property integer $parent_id
 * @property integer $sort_order
 * @property integer $is_required
 * @property integer $is_unique
 * @property integer $create_time_utc
 * @property integer $create_admin_id
 * @property integer $update_time_utc
 * @property integer $update_admin_id
 *
 * The followings are the available model relations:
 * @property eBayEntityType $entityType
 * @property eBayAttributeSet $attributeSet
 * @property eBayAttributeGroup $attributeGroup
 * @property eBayAttribute $attribute
 */
class eBayEntityAttribute extends NIAdminActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{ebay_entity_attribute}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('entity_type_id, attribute_set_id, attribute_group_id, attribute_id', 'required'),
			array('entity_type_id, attribute_set_id, attribute_group_id, attribute_id, parent_id, sort_order, is_required, is_unique', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, entity_type_id, attribute_set_id, attribute_group_id, attribute_id, parent_id, sort_order, is_required, is_unique, create_time_utc, create_admin_id, update_time_utc, update_admin_id', 'safe', 'on'=>'search'),
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
			'eBayEntityType' => array(self::BELONGS_TO, 'eBayEntityType', 'entity_type_id'),
			'eBayAttributeSet' => array(self::BELONGS_TO, 'eBayAttributeSet', 'attribute_set_id'),
			'eBayAttributeGroup' => array(self::BELONGS_TO, 'eBayAttributeGroup', 'attribute_group_id'),
			'eBayAttribute' => array(self::BELONGS_TO, 'eBayAttribute', 'attribute_id'),
            'attributeParent' => array(self::BELONGS_TO, 'eBayEntityAttribute', 'parent_id'),
            'attributeChildren' => array(self::HAS_MANY, 'eBayEntityAttribute', 'parent_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'entity_type_id' => 'eBay Entity Type',
			'attribute_set_id' => 'eBay Attribute Set',
			'attribute_group_id' => 'eBay Attribute Group',
			'attribute_id' => 'eBay Attribute',
			'parent_id' => 'Parent',
			'sort_order' => 'Sort Order',
			'is_required' => 'Is Required',
			'is_unique' => 'Is Unique',
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
		$criteria->compare('entity_type_id',$this->entity_type_id);
		$criteria->compare('attribute_set_id',$this->attribute_set_id);
		$criteria->compare('attribute_group_id',$this->attribute_group_id);
		$criteria->compare('attribute_id',$this->attribute_id);
		$criteria->compare('parent_id',$this->parent_id);
		$criteria->compare('sort_order',$this->sort_order);
		$criteria->compare('is_required',$this->is_required);
		$criteria->compare('is_unique',$this->is_unique);
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
	 * @return eBayEntityAttribute the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
