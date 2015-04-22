<?php

/**
 * This is the model class for table "{{ebay_listing}}".
 *
 * The followings are the available columns in table '{{ebay_listing}}':
 * @property integer $id
 * @property integer $store_id
 * @property integer $company_id
 * @property string $ebay_listing_id
 * @property integer $site_id
 * @property integer $ebay_entity_type_id
 * @property integer $ebay_attribute_set_id
 * @property integer $is_active
 * @property string $note
 * @property integer $create_time_utc
 * @property integer $create_user_id
 * @property integer $update_time_utc
 * @property integer $update_user_id
 *
 * The followings are the available model relations:
 * @property Company $company
 * @property Store $store
 * @property EbayEntityType $ebayEntityType
 * @property EbayAttributeSet $ebayAttributeSet
 */
class eBayListing extends NIActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{ebay_listing}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('store_id, company_id, ebay_listing_id, ebay_entity_type_id, ebay_attribute_set_id', 'required'),
			array('store_id, company_id, site_id, ebay_entity_type_id, ebay_attribute_set_id, is_active', 'numerical', 'integerOnly'=>true),
            array('ebay_listing_id', 'length', 'max'=>50),
            array('ebay_listing_id','unique'),
			array('note', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, store_id, company_id, ebay_listing_id, site_id, ebay_entity_type_id, ebay_attribute_set_id, is_active, note, create_time_utc, create_user_id, update_time_utc, update_user_id', 'safe', 'on'=>'search'),
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
			'Company' => array(self::BELONGS_TO, 'Company', 'company_id'),
			'Store' => array(self::BELONGS_TO, 'Store', 'store_id'),
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
			'store_id' => 'Store',
			'company_id' => 'Company',
			'ebay_listing_id' => 'eBay Listing Id',
			'site_id' => 'eBay Site',
			'ebay_entity_type_id' => 'eBay Entity Type',
			'ebay_attribute_set_id' => 'eBay Attribute Set',
			'is_active' => 'Is Active',
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
		$criteria->compare('store_id',$this->store_id);
		$criteria->compare('company_id',$this->company_id);
        $criteria->compare('ebay_listing_id',$this->ebay_listing_id,true);
		$criteria->compare('site_id',$this->site_id);
		$criteria->compare('ebay_entity_type_id',$this->ebay_entity_type_id);
		$criteria->compare('ebay_attribute_set_id',$this->ebay_attribute_set_id);
		$criteria->compare('is_active',$this->is_active);
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
	 * @return eBayListing the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    /*
     * get entity attribute value by attribute code,
     * @param string $code, the attribute need to retrieve, if sub attribute, using combined code till top attribute. For example, "PictureDetails->PictureURL" or "PictureDetails"
     * return entity attribute value, if not find entity attribute or attribute value, return NULL.
     */
    public function getEntityAttributeValue($codes, $separator='->')
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
            FROM lt_ebay_entity_{$valueType} valuetable
            where valuetable.ebay_entity_type_id = :ebay_entity_type_id
            and valuetable.ebay_attribute_id = :ebay_attribute_id
            and valuetable.ebay_entity_attribute_id = :ebay_entity_attribute_id
            and valuetable.ebay_entity_id = :ebay_entity_id; ";
        $command = Yii::app()->db->createCommand($query);
        $command->bindValue(":ebay_entity_type_id", $this->ebay_entity_type_id, PDO::PARAM_INT);
        $command->bindValue(":ebay_attribute_id", $eBayEntityAttribute->eBayAttribute->id, PDO::PARAM_INT);
        $command->bindValue(":ebay_entity_attribute_id", $eBayEntityAttribute->id, PDO::PARAM_INT);
        $command->bindValue(":ebay_entity_id", $this->id, PDO::PARAM_INT);
        $results = $command->queryAll();
        if(empty($results)) return NULL;
        if(Count($results) == 1) return $results[0]['value'];
        $values = array();
        foreach($results as $row)
            $values[] = $row['value'];
        return $values;
    }

    public function getEntityAttributeLabel($codes, $separator='->')
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

        return $eBayEntityAttribute->eBayAttribute->frontend_label;
    }

    /*
     * get eBay listing all entity attribute value in list form
     */
    private function getAllEntityAttributeValues()
    {
        $attributeValues = array();
        /*get all entity attribute values*/
        $sql = "SELECT ea.code, t.*
                FROM {{ebay_entity_int}} t
                left join {{ebay_attribute}} as ea on ea.id = t.ebay_attribute_id
                where ebay_entity_id=:ebay_entity_id";
        $command = Yii::app()->db->createCommand($sql);
        $command->bindValue(":ebay_entity_id", $this->id, PDO::PARAM_INT);
        $resultList = $command->queryAll();
        $integerValues = array();
        foreach($resultList as $row)
        {
            if(!isset($integerValues[$row['code'].'_'.$row['ebay_entity_attribute_id']]))
            {
                $integerValues[$row['code'].'_'.$row['ebay_entity_attribute_id']]['value'] = $row['value'];
                continue;
            }
            if(gettype($integerValues[$row['code'].'_'.$row['ebay_entity_attribute_id']]['value']) != 'array')
                $integerValues[$row['code'].'_'.$row['ebay_entity_attribute_id']]['value'] = array($integerValues[$row['code'].'_'.$row['ebay_entity_attribute_id']]['value']);
            $integerValues[$row['code'].'_'.$row['ebay_entity_attribute_id']]['value'][] = $row['value'];
        }
        $attributeValues = array_merge($attributeValues, $integerValues);

        $sql = "SELECT ea.code, t.*
                FROM {{ebay_entity_varchar}} t
                left join {{ebay_attribute}} as ea on ea.id = t.ebay_attribute_id
                where ebay_entity_id=:ebay_entity_id";
        $command = Yii::app()->db->createCommand($sql);
        $command->bindValue(":ebay_entity_id", $this->id, PDO::PARAM_INT);
        $resultList = $command->queryAll();
        $varcharValue = array();
        foreach($resultList as $row)
        {
            if(!isset($varcharValue[$row['code'].'_'.$row['ebay_entity_attribute_id']]['value']))
            {
                $varcharValue[$row['code'].'_'.$row['ebay_entity_attribute_id']]['value'] = $row['value'];
                continue;
            }
            if(gettype($varcharValue[$row['code'].'_'.$row['ebay_entity_attribute_id']]['value']) != 'array')
                $varcharValue[$row['code'].'_'.$row['ebay_entity_attribute_id']]['value'] = array($varcharValue[$row['code'].'_'.$row['ebay_entity_attribute_id']]['value']);
            $varcharValue[$row['code'].'_'.$row['ebay_entity_attribute_id']]['value'][] = $row['value'];
        }
        $attributeValues = array_merge($attributeValues, $varcharValue);

        $sql = "SELECT ea.code, t.*
                FROM {{ebay_entity_boolean}} t
                left join {{ebay_attribute}} as ea on ea.id = t.ebay_attribute_id
                where ebay_entity_id=:ebay_entity_id";
        $command = Yii::app()->db->createCommand($sql);
        $command->bindValue(":ebay_entity_id", $this->id, PDO::PARAM_INT);
        $resultList = $command->queryAll();
        $booleanValue = array();
        foreach($resultList as $row)
        {
            if(!isset($booleanValue[$row['code'].'_'.$row['ebay_entity_attribute_id']]['value']))
            {
                $booleanValue[$row['code'].'_'.$row['ebay_entity_attribute_id']]['value'] = (bool)$row['value'];
                continue;
            }
            if(gettype($booleanValue[$row['code'].'_'.$row['ebay_entity_attribute_id']]['value']) != 'array')
                $booleanValue[$row['code'].'_'.$row['ebay_entity_attribute_id']]['value'] = array($booleanValue[$row['code'].'_'.$row['ebay_entity_attribute_id']]['value']);
            $booleanValue[$row['code'].'_'.$row['ebay_entity_attribute_id']]['value'][] = (bool)$row['value'];
        }
        $attributeValues = array_merge($attributeValues, $booleanValue);

        $sql = "SELECT ea.code, t.*
                FROM {{ebay_entity_container}} t
                left join {{ebay_attribute}} as ea on ea.id = t.ebay_attribute_id
                where ebay_entity_id=:ebay_entity_id";
        $command = Yii::app()->db->createCommand($sql);
        $command->bindValue(":ebay_entity_id", $this->id, PDO::PARAM_INT);
        $resultList = $command->queryAll();
        $containerValue = array();
        foreach($resultList as $row)
        {
            if(!isset($containerValue[$row['code'].'_'.$row['ebay_entity_attribute_id']]['value']))
            {
                $containerValue[$row['code'].'_'.$row['ebay_entity_attribute_id']]['value'] = $row['value'];
                continue;
            }
            if(gettype($containerValue[$row['code'].'_'.$row['ebay_entity_attribute_id']]['value']) != 'array')
                $containerValue[$row['code'].'_'.$row['ebay_entity_attribute_id']]['value'] = array($containerValue[$row['code'].'_'.$row['ebay_entity_attribute_id']]['value']);
            $containerValue[$row['code'].'_'.$row['ebay_entity_attribute_id']]['value'][] = $row['value'];
        }
        $attributeValues = array_merge($attributeValues, $containerValue);

        $sql = "SELECT ea.code, t.*
                FROM {{ebay_entity_datetime}} t
                left join {{ebay_attribute}} as ea on ea.id = t.ebay_attribute_id
                where ebay_entity_id=:ebay_entity_id";
        $command = Yii::app()->db->createCommand($sql);
        $command->bindValue(":ebay_entity_id", $this->id, PDO::PARAM_INT);
        $resultList = $command->queryAll();
        $datetimeValue = array();
        foreach($resultList as $row)
        {
            if(!isset($datetimeValue[$row['code'].'_'.$row['ebay_entity_attribute_id']]['value']))
            {
                $datetimeValue[$row['code'].'_'.$row['ebay_entity_attribute_id']]['value'] = $row['value'];
                continue;
            }
            if(gettype($datetimeValue[$row['code'].'_'.$row['ebay_entity_attribute_id']]['value']) != 'array')
                $datetimeValue[$row['code'].'_'.$row['ebay_entity_attribute_id']]['value'] = array($datetimeValue[$row['code'].'_'.$row['ebay_entity_attribute_id']]['value']);
            $datetimeValue[$row['code'].'_'.$row['ebay_entity_attribute_id']]['value'][] = $row['value'];
        }
        $attributeValues = array_merge($attributeValues, $datetimeValue);

        $sql = "SELECT ea.code, t.*
                FROM {{ebay_entity_decimal}} t
                left join {{ebay_attribute}} as ea on ea.id = t.ebay_attribute_id
                where ebay_entity_id=:ebay_entity_id";
        $command = Yii::app()->db->createCommand($sql);
        $command->bindValue(":ebay_entity_id", $this->id, PDO::PARAM_INT);
        $resultList = $command->queryAll();
        $decimalValue = array();
        foreach($resultList as $row)
        {
            if(!isset($decimalValue[$row['code'].'_'.$row['ebay_entity_attribute_id']]['value']))
            {
                $decimalValue[$row['code'].'_'.$row['ebay_entity_attribute_id']]['value'] = $row['value'];
                continue;
            }
            if(gettype($decimalValue[$row['code'].'_'.$row['ebay_entity_attribute_id']]['value']) != 'array')
                $decimalValue[$row['code'].'_'.$row['ebay_entity_attribute_id']]['value'] = array($decimalValue[$row['code'].'_'.$row['ebay_entity_attribute_id']]['value']);
            $decimalValue[$row['code'].'_'.$row['ebay_entity_attribute_id']]['value'][] = $row['value'];
        }
        $attributeValues = array_merge($attributeValues, $decimalValue);

        $sql = "SELECT ea.code, t.*
                FROM {{ebay_entity_text}} t
                left join {{ebay_attribute}} as ea on ea.id = t.ebay_attribute_id
                where ebay_entity_id=:ebay_entity_id";
        $command = Yii::app()->db->createCommand($sql);
        $command->bindValue(":ebay_entity_id", $this->id, PDO::PARAM_INT);
        $resultList = $command->queryAll();
        $textValue = array();
        foreach($resultList as $row)
        {
            if(!isset($textValue[$row['code'].'_'.$row['ebay_entity_attribute_id']]['value']))
            {
                $textValue[$row['code'].'_'.$row['ebay_entity_attribute_id']]['value'] = $row['value'];
                continue;
            }
            if(gettype($textValue[$row['code'].'_'.$row['ebay_entity_attribute_id']]['value']) != 'array')
                $textValue[$row['code'].'_'.$row['ebay_entity_attribute_id']]['value'] = array($textValue[$row['code'].'_'.$row['ebay_entity_attribute_id']]['value']);
            $textValue[$row['code'].'_'.$row['ebay_entity_attribute_id']]['value'][] = $row['value'];
        }
        $attributeValues = array_merge($attributeValues, $textValue);
        /*get all entity attribute values*/

        return $attributeValues;
    }

    /*
     * get eBay listing attribute value in cascade form
     */
    public function getEntityAttributeValues()
    {
        $topEntityAttributes = eBayEntityAttribute::model()->findAllByAttributes(array('attribute_set_id'=>$this->ebay_attribute_set_id, 'parent_id'=>0));
        if(empty($topEntityAttributes)) return array();
        $attributeValues = $this->getAllEntityAttributeValues();

        $valueTree = array();
        foreach($topEntityAttributes as $top)
        {
            $valueTree[$top->eBayAttribute->code] = $this->getEntityAttributeValueChildrenRC($top, $attributeValues);
        }
        return array_filter($valueTree);
    }

    /*
     * get entity attribute value recursively
     */
    private function getEntityAttributeValueChildrenRC($entityAttribute, &$attributeValues)
    {
        if(!isset($attributeValues[$entityAttribute->eBayAttribute->code.'_'.$entityAttribute->id])) return array();

        $result = $attributeValues[$entityAttribute->eBayAttribute->code.'_'.$entityAttribute->id];
        if(!empty($entityAttribute->attributeChildren))
        {
            foreach($entityAttribute->attributeChildren as $child)
            {
                $temp = $this->getEntityAttributeValueChildrenRC($child, $attributeValues);
                if(!empty($temp)) $result['children'][$child->eBayAttribute->code] = $temp;
            }
        }
        return $result;
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
            FROM lt_ebay_entity_{$valueType} valuetable
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
