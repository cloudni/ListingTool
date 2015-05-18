<?php

/**
 * This is the model class for table "{{instant_job}}".
 *
 * The followings are the available columns in table '{{instant_job}}':
 * @property integer $id
 * @property integer $platform
 * @property string $action
 * @property string $params
 * @property string $status
 * @property string $result
 * @property integer $create_time_utc
 * @property integer $execute_time_utc
 * @property integer $finish_time_utc
 */
class InstantJob extends CActiveRecord
{
    const STATUS_WAIT=1;
    CONST STATUS_EXECUTE=2;
    CONST STATUS_END=3;
    CONST STATUS_ERROR=4;

    public function getStatusOptions()
    {
        return array(
            self::STATUS_WAIT=>'Waiting',
            self::STATUS_EXECUTE=>'Processing',
            self::STATUS_ERROR=>'Error',
            self::STATUS_END=>'Finished',
        );
    }

    public function getStatusText()
    {
        $Status = $this->statusOptions;
        return isset($Status[$this->status]) ? $Status[$this->status] : "unknown status ({$this->status})";
    }

    const ACTION_BULKUPDATEITEMS=1;
    CONST ACTION_EBAYGETSELLERLIST=2;
    CONST ACTION_WISHGETALLPRODUCTS=3;

    public function getActionOptions()
    {
        return array(
            self::ACTION_BULKUPDATEITEMS=>'Bulk update eBay listings',
            self::ACTION_EBAYGETSELLERLIST=>'Sync eBay listings',
        );
    }

    public function getActionText()
    {
        $Action = $this->actionOptions;
        return isset($Action[$this->action]) ? $Action[$this->action] : "unknown action ({$this->action})";
    }

    public function getPlatformOptions()
    {
        return array(
            Store::PLATFORM_EBAY=>'eBay.com',
            Store::PLATFORM_AMAZON=>'Amazon.com',
            Store::PLATFORM_ALIEXPRESS=>'AliExpress.com',
            Store::PLATFORM_WISH=>'Wish.com',
            Store::PLATFORM_ECSHOP=>'Ecshop sites',
            Store::PLATFORM_MAGENTO=>'Magento sites',
        );
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
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{instant_job}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('platform, create_time_utc, execute_time_utc, finish_time_utc', 'numerical', 'integerOnly'=>true),
			array('action', 'length', 'max'=>255),
			array('status', 'length', 'max'=>45),
			array('result', 'length', 'max'=>500),
			array('params', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, platform, action, params, status, result, create_time_utc, execute_time_utc, finish_time_utc', 'safe', 'on'=>'search'),
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
			'platform' => 'Platform',
			'action' => 'Action',
			'params' => 'Params',
			'status' => 'Status',
			'result' => 'Result',
			'create_time_utc' => 'Create Time Utc',
			'execute_time_utc' => 'Execute Time Utc',
			'finish_time_utc' => 'Finish Time Utc',
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
		$criteria->compare('platform',$this->platform);
		$criteria->compare('action',$this->action,true);
		$criteria->compare('params',$this->params,true);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('result',$this->result,true);
		$criteria->compare('create_time_utc',$this->create_time_utc);
		$criteria->compare('execute_time_utc',$this->execute_time_utc);
		$criteria->compare('finish_time_utc',$this->finish_time_utc);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return InstantJob the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
