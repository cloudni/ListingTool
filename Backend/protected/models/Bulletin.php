<?php

/**
 * This is the model class for table "{{bulletin}}".
 *
 * The followings are the available columns in table '{{bulletin}}':
 * @property integer $id
 * @property string $title
 * @property string $content
 * @property integer $is_new
 * @property integer $is_top
 * @property integer $is_viewable
 * @property integer $create_time_utc
 * @property integer $create_admin_id
 * @property integer $update_time_utc
 * @property integer $update_admin_id
 * @property integer $owner
 */
class Bulletin extends NIAdminActiveRecord
{
    const STATUS_TRUE = 1;
    const STATUS_FALSE = 0;

    const STATUS_ALL = 0;
    const STATUS_ADMIN = 1;
    const STATUS_USER = 2;


	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{bulletin}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('is_new, is_top, is_viewable, create_time_utc, create_admin_id, update_time_utc, update_admin_id', 'numerical', 'integerOnly'=>true),
			array('title', 'length', 'max'=>255),
			array('content', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, title, content, is_new, is_top, is_viewable, create_time_utc, create_admin_id, update_time_utc, update_admin_id', 'safe', 'on'=>'search'),
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
            'Admin' => array(self::BELONGS_TO, 'Admin', 'create_admin_id'),
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
			'is_new' => 'Is New',
			'is_top' => 'Is Top',
			'is_viewable' => 'Is Viewable',
			'create_time_utc' => 'Create Time Utc',
			'create_admin_id' => 'Create Admin',
			'update_time_utc' => 'Update Time Utc',
			'update_admin_id' => 'Update Admin',
            'owner' => 'Viewer',
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
		$criteria->compare('is_new',$this->is_new);
		$criteria->compare('is_top',$this->is_top);
		$criteria->compare('is_viewable',$this->is_viewable);
		$criteria->compare('create_time_utc',$this->create_time_utc);
		$criteria->compare('create_admin_id',$this->create_admin_id);
		$criteria->compare('update_time_utc',$this->update_time_utc);
		$criteria->compare('update_admin_id',$this->update_admin_id);
        $criteria->compare('owner',$this->owner);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Bulletin the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}


    public function getStatus()
    {
        return array(
            self::STATUS_TRUE=>'True',
            self::STATUS_FALSE=>'False',
        );
    }

    public function getStatusText($status)
    {
        if(self::STATUS_TRUE == $status)
        {
            return 'True' ;
        }
        else if (self::STATUS_FALSE == $status)
        {
            return 'False' ;
        }
        return null;
    }

    public function getFormatTime($format,$time)
    {
        return date($format,$time);
    }

    public function getRecentlyBulletin()
    {
        $limit = Yii::app()->params['bulletin']['limitCount'];
        $sql = 'select * from lt_bulletin where is_viewable=1 and is_top = 1 and (owner = 0 or owner = 1) order by is_top desc,id desc limit :limit;';
        $command = Yii::app()->db->createCommand($sql);
        $command->bindValue(":limit", $limit, PDO::PARAM_INT);
        $data = $command->queryAll();
        //var_dump($data);
        return $data;
    }

    public function getOwnerStatus()
    {
        return array(
            self::STATUS_ALL=>'Users and administrators',
            self::STATUS_ADMIN=>'Administrator',
            self::STATUS_USER=>'Users',
        );
    }

    public function getOwnerStatusText($status)
    {
        if(self::STATUS_ALL == $status)
        {
            return 'Users and administrators' ;
        }
        else if (self::STATUS_ADMIN == $status)
        {
            return 'Administrator' ;
        }else if(self::STATUS_USER == $status)
        {
            return 'Users' ;
        }
        return null;
    }
}
