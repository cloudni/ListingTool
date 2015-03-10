<?php

/**
 * This is the model class for table "{{ebay_detail}}".
 *
 * The followings are the available columns in table '{{ebay_detail}}':
 * @property integer $id
 * @property string $name
 * @property integer $site_id
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
class eBayDetail extends NIAdminActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{ebay_detail}}';
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
			array('note', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, site_id, ebay_entity_type_id, ebay_attribute_set_id, note, create_time_utc, create_admin_id, update_time_utc, update_admin_id', 'safe', 'on'=>'search'),
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
	 * @return eBayDetail the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function getEntityAttributeValueByCodeWithAllChildren($codes, $separator='->')
	{
		$codes = explode($separator, $codes);
		//get target entity attribute object recursively
		$parentEntityAttributeId = 0;
		foreach($codes as $code)
		{
			$criteria = new CDbCriteria();
			$criteria->join = 'left join lt_ebay_attribute ea on ea.id = t.attribute_id';
			$criteria->condition = 't.attribute_set_id=:attribute_set_id and ea.code=:code and t.parent_id=:parent_id and t.entity_type_id=:entity_type_id';
			$criteria->params = array(
				':attribute_set_id'=>$this->ebay_attribute_set_id,
				':entity_type_id'=>$this->ebay_entity_type_id,
				':parent_id'=>$parentEntityAttributeId,
				':code'=>$code,
			);
			$eBayEntityAttribute = eBayEntityAttribute::model()->find($criteria);
			if(empty($eBayEntityAttribute)) return NULL;
			$parentEntityAttributeId = $eBayEntityAttribute->id;
		}

		return $this->getEntityAttributeValueByEntityAttributeRC($eBayEntityAttribute);
	}

	private function getEntityAttributeValueByEntityAttributeRC($eBayEntityAttribute, $parentEntityAttribute=null, $parentValueId=0)
	{
		switch($eBayEntityAttribute->eBayAttribute->backend_type)
		{
			case eBayAttribute::BACKEND_TYPE_INT:
				$valueType = 'int';
				break;
			case eBayAttribute::BACKEND_TYPE_DECIMAL:
				$valueType = 'decimal';
				break;
			case eBayAttribute::BACKEND_TYPE_VARCHAR:
				$valueType = 'varchar';
				break;
			case eBayAttribute::BACKEND_TYPE_TEXT:
				$valueType = 'text';
				break;
			case eBayAttribute::BACKEND_TYPE_DATETIME:
				$valueType = 'datetime';
				break;
			case eBayAttribute::BACKEND_TYPE_BOOLEAN:
				$valueType = 'boolean';
				break;
			case eBayAttribute::BACKEND_TYPE_CONTAINER:
				$valueType = 'container';
				break;
			default:
				return NULL;
				break;
		}

		//find a;; available entity attribute value
		$query = "SELECT valuetable.*
            FROM lt_ebay_prefetch_{$valueType} valuetable
            where valuetable.ebay_entity_type_id = :ebay_entity_type_id
            and valuetable.ebay_attribute_id = :ebay_attribute_id
            and valuetable.ebay_entity_attribute_id = :ebay_entity_attribute_id
            and valuetable.ebay_entity_id = :ebay_entity_id ";
		if(isset($parentEntityAttribute) || $parentValueId)
			$query .=" and valuetable.parent_value_id = :parent_value_id
                and valuetable.parent_value_entity_attribute_id = :parent_value_entity_attribute_id; ";
		$command = Yii::app()->db->createCommand($query);
		$command->bindValue(":ebay_entity_type_id", $this->ebay_entity_type_id, PDO::PARAM_INT);
		$command->bindValue(":ebay_attribute_id", $eBayEntityAttribute->eBayAttribute->id, PDO::PARAM_INT);
		$command->bindValue(":ebay_entity_attribute_id", $eBayEntityAttribute->id, PDO::PARAM_INT);
		$command->bindValue(":ebay_entity_id", $this->id, PDO::PARAM_INT);
		if(isset($parentEntityAttribute) || $parentValueId)
		{
			$command->bindValue(":parent_value_id", $parentValueId, PDO::PARAM_INT);
			$command->bindValue(":parent_value_entity_attribute_id", $parentEntityAttribute->id, PDO::PARAM_INT);
		}
		$results = $command->queryAll();
		if(empty($results)) return NULL;

		if(Count($results) == 1)
		{
			if($eBayEntityAttribute->eBayAttribute->backend_type != eBayAttribute::BACKEND_TYPE_CONTAINER)
			{
				return $results[0]['value'];
			}
			else
			{
				$entityAttributeValue = array();
				foreach($eBayEntityAttribute->attributeChildren as $childEntity)
				{
					$childEntityValue = $this->getEntityAttributeValueByEntityAttributeRC($childEntity, $eBayEntityAttribute, $results[0]['id']);
					if(isset($childEntityValue)) $entityAttributeValue[$childEntity->eBayAttribute->code] = $childEntityValue;
				}
				return $entityAttributeValue;
			}
		}
		else
		{
			if($eBayEntityAttribute->eBayAttribute->backend_type != eBayAttribute::BACKEND_TYPE_CONTAINER)
			{
				$eBayEntityAttribute = array();
				foreach($results as $row)
				{
					$eBayEntityAttribute[] = $row['value'];
				}
				return $eBayEntityAttribute;
			}
			else
			{
				$entityAttributeValue = array();
				foreach($results as $row)
				{
					$subAttributeValue = array();
					foreach($eBayEntityAttribute->attributeChildren as $childEntity)
					{
						$childEntityValue = $this->getEntityAttributeValueByEntityAttributeRC($childEntity, $eBayEntityAttribute, $row['id']);
						if(isset($childEntityValue)) $subAttributeValue[$childEntity->eBayAttribute->code] = $childEntityValue;
					}
					$entityAttributeValue[] = $subAttributeValue;
				}
				return $entityAttributeValue;
			}
		}
	}
}
