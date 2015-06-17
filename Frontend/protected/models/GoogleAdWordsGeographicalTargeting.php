<?php

/**
 * This is the model class for table "{{google_adwords_para_geographical_targeting}}".
 *
 * The followings are the available columns in table '{{google_adwords_para_geographical_targeting}}':
 * @property string $criteria_id
 * @property string $name
 * @property string $canonical_name
 * @property string $parent_id
 * @property string $country_code
 * @property string $target_type
 * @property string $status
 */
class GoogleAdWordsGeographicalTargeting extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{google_adwords_para_geographical_targeting}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('criteria_id', 'required'),
			array('criteria_id, parent_id', 'length', 'max'=>16),
			array('name, canonical_name', 'length', 'max'=>255),
			array('country_code', 'length', 'max'=>2),
			array('target_type', 'length', 'max'=>36),
			array('status', 'length', 'max'=>20),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('criteria_id, name, canonical_name, parent_id, country_code, target_type, status', 'safe', 'on'=>'search'),
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
            'targetParent' => array(self::BELONGS_TO, 'GoogleAdWordsGeographicalTargeting', 'parent_id'),
            'targetChildren' => array(self::HAS_MANY, 'GoogleAdWordsGeographicalTargeting', 'parent_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'criteria_id' => 'Criteria',
			'name' => 'Name',
			'canonical_name' => 'Canonical Name',
			'parent_id' => 'Parent',
			'country_code' => 'Country Code',
			'target_type' => 'Target Type',
			'status' => 'Status',
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

		$criteria->compare('criteria_id',$this->criteria_id,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('canonical_name',$this->canonical_name,true);
		$criteria->compare('parent_id',$this->parent_id,true);
		$criteria->compare('country_code',$this->country_code,true);
		$criteria->compare('target_type',$this->target_type,true);
		$criteria->compare('status',$this->status,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return GoogleAdwordsGeographicalTargeting the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public static function getByCriteriaId($id)
    {
        $geoTargeting = Yii::app()->cache->get(sprintf("GoogleAdWordsGeographicalTargeting_criteria_id_%s", $id));
        if($geoTargeting == false)
        {
            $geoTargeting = GoogleAdWordsGeographicalTargeting::model()->findByPk($id);
            Yii::app()->cache->set(sprintf("GoogleAdWordsGeographicalTargeting_criteria_id_%s", $id), $geoTargeting, 60 * 60 * 24 * 7);
        }
        return GoogleAdWordsGeographicalTargeting::model()->findByPk($id);
    }
}
