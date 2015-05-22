<?php

/**
 * This is the model class for table "{{schedule_job}}".
 *
 * The followings are the available columns in table '{{schedule_job}}':
 * @property integer $id
 * @property integer $platform
 * @property integer $action
 * @property string $params
 * @property integer $is_active
 * @property integer $create_time_utc
 * @property integer $last_execute_status
 * @property string $last_execute_result
 * @property integer $last_execute_time_utc
 * @property integer $last_finish_time_utc
 * @property integer $next_execute_time_utc
 * @property string $crontab
 * @property integer $type
 */
class ScheduleJob extends CActiveRecord
{
    const ACTION_EBAYGETMYEBAYSELLING=1;
    const ACTION_EBAYGETSELLERLIST=9;
    const ACTION_EBAYGETCATEGORIES=2;
    const ACTION_EBAYGETEBAYDETAILS=3;
    const ACTION_EBAYGETCATEGORYFEATURES=4;
    const ACTION_EBAYGETSELLERDASHBOARD=5;
    const ACTION_EBAYGETUSER=6;
    const ACTION_EBAYSHOPPINGAPIGETMULTIPLEITEMS=7;
    const ACTION_WISHGETALLPRODUCTS=8;

    public function getActionOptions()
    {
        return array(
            self::ACTION_EBAYGETMYEBAYSELLING=>"eBay Get My eBay Selling",
            self::ACTION_EBAYGETSELLERLIST=>'eBay Get Seller List',
            self::ACTION_EBAYGETCATEGORIES=>'eBay Get Categories',
            self::ACTION_EBAYGETEBAYDETAILS=>'eBay Get eBay Details',
            self::ACTION_EBAYGETCATEGORYFEATURES=>'eBay Get Category Features',
            self::ACTION_EBAYGETSELLERDASHBOARD=>'eBay Get Seller Dashboard',
            self::ACTION_EBAYGETUSER=>'eBay Get User',
            self::ACTION_EBAYSHOPPINGAPIGETMULTIPLEITEMS=>'eBay Shopping API Get Multiple Items',
            self::ACTION_WISHGETALLPRODUCTS=>"Wish Get All Products",
        );
    }

    public function getActionText()
    {
        $actions = $this->getActionOptions();
        return isset($actions[$this->action]) ? $actions[$this->action] : "unknown action: ({$this->action})";
    }

    const LAST_EXECUTE_STATUS_SUCCESS=1;
    const LAST_EXECUTE_STATUS_ERROR=2;
    const LAST_EXECUTE_STATUS_EXECUTE=3;
    const LAST_EXECUTE_STATUS_NO_OCCURRED=4;

    public function getLastExecuteStatusOptions()
    {
        return array(

            self::LAST_EXECUTE_STATUS_SUCCESS=>'Success',
            self::LAST_EXECUTE_STATUS_ERROR=>'Error',
            self::LAST_EXECUTE_STATUS_EXECUTE=>"Executing",
        );
    }

    public function getLastExecuteStatusText()
    {
        $Status = $this->lastExecuteStatusOptions;
        return isset($Status[$this->last_execute_status]) ? $Status[$this->last_execute_status] : "unknown status ({$this->last_execute_status})";
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

    //const for is active
    const ACTIVE_YES=1;
    const ACTIVE_NO=2;

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

    const TYPE_REPEAT=1;
    const TYPE_ONCE=2;

    /**
     * Get type options
     * @return array
     */
    public function getTypeOptions()
    {
        return array(
            self::TYPE_REPEAT=>"Repeat Job",
            self::TYPE_ONCE=>'One Time Job',
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
		return '{{schedule_job}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('platform, action, is_active, create_time_utc, last_execute_status, last_execute_time_utc, last_finish_time_utc, next_execute_time_utc, type', 'numerical', 'integerOnly'=>true),
			array('last_execute_result', 'length', 'max'=>500),
			array('crontab', 'max'=>255),
			array('params', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, playform, action, params, is_active, create_time_utc, last_execute_status, last_execute_result, last_execute_time_utc, last_finish_time_utc, next_execute_time_utc, crontab, type', 'safe', 'on'=>'search'),
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
			'is_active' => 'Is Active',
			'create_time_utc' => 'Create Time Utc',
			'last_execute_status' => 'Last Execute Status',
			'last_execute_result' => 'Last Execute Result',
			'last_execute_time_utc' => 'Last Execute Time Utc',
			'last_finish_time_utc' => 'Last Finish Time Utc',
			'next_execute_time_utc' => 'Next Execute Time Utc',
			'crontab' => 'Crontab',
            'type' =>'Type'
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
		$criteria->compare('platform',$this->playform);
		$criteria->compare('action',$this->action);
		$criteria->compare('params',$this->params,true);
		$criteria->compare('is_active',$this->is_active);
		$criteria->compare('create_time_utc',$this->create_time_utc);
		$criteria->compare('last_execute_status',$this->last_execute_status);
		$criteria->compare('last_execute_result',$this->last_execute_result,true);
		$criteria->compare('last_execute_time_utc',$this->last_execute_time_utc);
		$criteria->compare('last_finish_time_utc',$this->last_finish_time_utc);
		$criteria->compare('next_execute_time_utc',$this->next_execute_time_utc);
		$criteria->compare('crontab',$this->crontab,true);
        $criteria->compare('type',$this->crontab,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ScheduleJob the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public function getNextExecuteTime()
    {
        $crontab = explode(' ', $this->crontab);
        $minute = $crontab[0];
        $hour = $crontab[1];
        $day = $crontab[2];
        $month = $crontab[3];
        $week = $crontab[4];

        $nextYear = date("Y");

        $nextMinute = $this->processNextTimeSegment($minute, 0, 59, 60, (int)date("i"))==(int)date("i") ? $this->processNextTimeSegment($minute, 0, 59, 60, (int)date("i")+1) : $this->processNextTimeSegment($minute, 0, 59, 60, (int)date("i"));
        $nextHour = $nextMinute < (int)date("i") && $this->processNextTimeSegment($hour, 0, 23, 24, (int)date("G")) == (int)date("G") ? $this->processNextTimeSegment($hour, 0, 23, 24, (int)date("G")+1) : $this->processNextTimeSegment($hour, 0, 23, 24, (int)date("G"));
        $nextDay = $nextHour < (int)date("G") && $this->processNextTimeSegment($day, 1, date('t'), date('t'), (int)date("j")) == (int)date("j") ? $this->processNextTimeSegment($day, 1, date('t'), date('t'), (int)date("j")+1) : $this->processNextTimeSegment($day, 1, date('t'), date('t'), (int)date("j"));
        $nextMonth = $nextDay < (int)date("j") && $this->processNextTimeSegment($month, 1, 12, 12, (int)date("n")) == (int)date("n") ? $this->processNextTimeSegment($month, 1, 12, 12, (int)date("n")+1) : $this->processNextTimeSegment($month, 1, 12, 12, (int)date("n"));

        if($nextMonth < (int)date("n")) $nextYear++;

        $nextTime = strtotime($nextYear.'/'.$nextMonth.'/'.$nextDay.' '.$nextHour.':'.$nextMinute);
        return $nextTime;
    }

    private function processNextTimeSegment($timeSegment, $segmentStart, $segmentEnd, $segmentLength, $currentTime)
    {
        if($currentTime>$segmentEnd) $currentTime = $currentTime % $segmentLength;
        //echo "timeSegment:$timeSegment, segmentLength:$segmentLength, currentTimeSegment:$currentTime\n";
        unset($nextTime);
        $slices = explode(',', $timeSegment);
        foreach($slices as $slice)
        {
            unset($tempNext, $tempList, $section, $per, $sectionStart, $sectionEnd);
            if($slice === '*') $slice = '*/1';
            if(stripos($slice, '/', 0)!==false) // x-y/z, */1, mode
            {
                //echo "slice: $slice\n";
                $tempList = explode('/', $slice);
                $section = $tempList[0];
                $per = !(int)$tempList[1] ? 1 : (int)$tempList[1];

                if(stripos($section, '-', 0)!==false) // x-y/z model
                {
                    $tempList = explode('-', $section);
                    $sectionStart = (int)$tempList[0];
                    $sectionEnd = (int)$tempList[1];
                }
                elseif($section === '*') // */y mode
                {
                    $sectionStart = $segmentStart;
                    $sectionEnd = $segmentEnd;
                }
                else // x/y mode
                {
                    $sectionStart = (int)$section;
                    $sectionEnd = $segmentEnd;
                }

                //check boundary
                if($sectionStart<$segmentStart) $sectionStart = $segmentLength - abs($sectionStart)%$segmentLength;
                if($sectionEnd>=$segmentLength || $sectionEnd<$segmentStart) $sectionEnd = $segmentEnd;
                if($per<=0) $per = 1;
                if($per>$segmentLength) $per = $segmentLength;

                if($sectionStart<=$currentTime && $currentTime<=$sectionEnd)
                {
                    $tempNext = $sectionStart + ceil(($currentTime - $sectionStart) / $per) * $per;
                    if($tempNext>=$sectionEnd) $tempNext = $sectionEnd;
                }
                else
                {
                    $tempNext = $sectionStart;
                }
            }
            else // x,y,z mode
            {
                $tempNext = (int)$slice;//echo "slice: $slice\n";
                //check boundary
                if($tempNext>=$segmentLength) $tempNext = $tempNext - floor($tempNext / $segmentLength) * $segmentLength;
                if($tempNext<$segmentStart) $tempNext = $segmentLength - abs($tempNext)%$segmentLength;
                //echo "tempNext: $tempNext\n";
            }

            //compare with other slice
            if(!isset($nextTime))
            {
                $nextTime = $tempNext;
                continue;
            }
            if($currentTime<=$tempNext)
            {
                if($currentTime<=$nextTime)
                {
                    if($nextTime<=$tempNext)
                    {
                        continue;
                    }
                    else
                    {
                        $nextTime = $tempNext;
                        continue;
                    }
                }
                else
                {
                    $nextTime = $tempNext;
                    continue;
                }
            }
            else
            {
                if($currentTime<=$nextTime)
                {
                    continue;
                }
                else
                {
                    if($nextTime<=$tempNext)
                    {
                        continue;
                    }
                    else
                    {
                        $nextTime = $tempNext;
                        continue;
                    }
                }
            }
        }

        return $nextTime;
    }
}
