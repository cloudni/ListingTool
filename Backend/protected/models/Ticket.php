<?php

/**
 * This is the model class for table "{{ticket}}".
 *
 * The followings are the available columns in table '{{ticket}}':
 * @property integer $id
 * @property string $title
 * @property string $content
 * @property integer $type
 * @property integer $is_repliable
 * @property integer $is_viewable
 * @property integer $parent_id
 * @property integer $create_time_utc
 * @property integer $create_user_id
 * @property integer $update_time_utc
 * @property integer $update_user_id
 * @property integer $is_user
 * @property integer $is_new
 */
class Ticket extends CActiveRecord
{

    private $user = null;

    const TYPE_ISSUE = 0;
    const TYPE_ADVISE = 1;
    const TYPE_BILLING = 2;
    const TYPE_DEMAND = 3;


    const STATUS_YES = 1;
    const STATUS_NO = 0;

    /**
     * @return array type 0=>issue,1=>advise ...
     */
    public function getTypeOptions()
    {
        return array(
            self::TYPE_ISSUE=>'Issue',
            self::TYPE_ADVISE=>'Advise',
            self::TYPE_BILLING=>'Billing',
            self::TYPE_DEMAND=>'Functional Needs'
        );
    }

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{ticket}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
            array('title,content,type','required'),
			array('type, is_repliable, is_viewable, parent_id, create_time_utc, create_user_id, update_time_utc, update_user_id, is_user', 'numerical', 'integerOnly'=>true),
			array('title', 'length', 'max'=>255),
			array('content', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, title, content, type, is_repliable, is_viewable, parent_id, create_time_utc, create_user_id, update_time_utc, update_user_id, is_user', 'safe', 'on'=>'search'),
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
            'user' => array(self::BELONGS_TO, 'User', 'create_user_id'),
            'replies' => array(self::BELONGS_TO, 'Ticket', 'parent_id'),
            'repliesCount' =>  array(self::STAT, 'Ticket', 'parent_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'title' => 'Title',
			'content' => 'Content',
			'type' => 'Type',
			'is_repliable' => 'Is Repliable',
			'is_viewable' => 'Is Viewable',
			'parent_id' => 'Parent',
			'create_time_utc' => 'Created Time Utc',
			'create_user_id' => 'Created User',
			'update_time_utc' => 'Updated Time Utc',
			'update_user_id' => 'Updated User',
			'is_user' => 'Is User',
            'is_new' => 'Is New',
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
		$criteria->compare('title',$this->title,true);
		$criteria->compare('content',$this->content,true);
		$criteria->compare('type',$this->type);
		$criteria->compare('is_repliable',$this->is_repliable);
		$criteria->compare('is_viewable',$this->is_viewable);
		$criteria->compare('parent_id',$this->parent_id);
		$criteria->compare('create_time_utc',$this->create_time_utc);
		$criteria->compare('create_user_id',$this->create_user_id);
		$criteria->compare('update_time_utc',$this->update_time_utc);
		$criteria->compare('update_user_id',$this->update_user_id);
		$criteria->compare('is_user',$this->is_user);
        $criteria->compare('is_new',$this->is_new);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Ticket the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public function getTypeText()
    {
        foreach(self::getTypeOptions() as $v => $k){
            if($v ==$this->type){
                return $k;
            }
        }
        return "unknown type({$this->type})";
    }


    public function getStatus()
    {
        return array(
            self::STATUS_YES=>'Yes',
            self::STATUS_NO=>'No',
        );
    }

    /**
     * @param $status
     * @return null|string Yes Or No
     */
    public function getStatusText($status)
    {
        if(self::STATUS_YES == $status)
        {
            return 'Yes' ;
        }
        else if (self::STATUS_NO == $status)
        {
            return 'No' ;
        }
        return null;
    }

    /**
     * formatTime
     * @param $format
     * @param $time
     * @return bool|string
     */
    public function getFormatTime($format,$time)
    {
        return date($format,$time);
    }

    /**
     * save ticket
     * @param $ticket
     * @return mixed
     */
    public function addTicket($ticket)
    {
        $ticket->parent_id=$this->id;
        $ticket->is_new=1;
        return $ticket->save();
    }


    public function findUserById($id,$is_user)
    {
        $sql = 'select lu.username from lt_user lu where lu.id=:id';
        if($is_user==1)
        {
            $sql = 'select la.username from lt_admin la where la.id=:id';
        }
        $command = Yii::app()->db->createCommand($sql);
        $command->bindValue(":id", $id, PDO::PARAM_INT);
        $data = $command->queryAll();
        if($data==null)return '';
        return $command->queryAll()[0]['username'];
    }
}
