<?php

/**
 * This is the model class for table "lt_user".
 *
 * The followings are the available columns in table 'lt_user':
 * @property integer $id
 * @property string $email
 * @property string $username
 * @property string $password
 * @property integer $company_id
 * @property integer $last_login_time_utc
 * @property string $last_login_ip
 * @property integer $create_time_utc
 * @property integer $create_user_id
 * @property integer $update_time_utc
 * @property integer $update_user_id
 * @property integer $department_id
 */
class User extends NIActiveRecord
{
    public $password_repeat;

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{user}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('email, username, password', 'required'),
            array('email, username', 'unique'),
			array('email, username, password', 'length', 'max'=>256),
            array('department_id', 'numerical'),
            array('password', 'compare'),
            //array('department_id', 'integerOnly'=>true),
            array('password_repeat', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, email, username, password,department_id, company_id, last_login_time_utc, last_login_ip, create_time_utc, create_user_id, update_time_utc, update_user_id', 'safe', 'on'=>'search'),
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
            'company' => array(self::BELONGS_TO, 'Company', 'company_id'),
            'department' => array(self::BELONGS_TO, 'Department', 'department_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => Yii::t('models/User','ID'),
			'email' => Yii::t('models/User','Email'),
			'username' => Yii::t('models/User','Username'),
			'password' => Yii::t('models/User','Password'),
			'company_id' => Yii::t('models/User','Company'),
			'last_login_time_utc' => Yii::t('models/User','Last Login Time Utc'),
			'last_login_ip' => Yii::t('models/User','Last Login Ip') ,
			'create_time_utc' => Yii::t('models/User','Create Time Utc') ,
			'create_user_id' => Yii::t('models/User','Create User'),
			'update_time_utc' => Yii::t('models/User','Update Time Utc') ,
			'update_user_id' => Yii::t('models/User','Update User') ,
            'department_id' => Yii::t('models/User','Department') ,
            'password_repeat'=>Yii::t('models/User','Password Repeat'),
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
		$criteria->compare('email',$this->email,true);
		$criteria->compare('username',$this->username,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('company_id',$this->company_id);
		$criteria->compare('last_login_time_utc',$this->last_login_time_utc);
		$criteria->compare('last_login_ip',$this->last_login_ip,true);
		$criteria->compare('create_time_utc',$this->create_time_utc);
		$criteria->compare('create_user_id',$this->create_user_id);
		$criteria->compare('update_time_utc',$this->update_time_utc);
		$criteria->compare('update_user_id',$this->update_user_id);
        $criteria->compare('department_id',$this->department_id);
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return User the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    /**
     * perform one-way encryption on the password before we store it in the database
     */
    protected function afterValidate() {
        parent::afterValidate();
        $this->password = $this->encrypt($this->password);
    }

    /**
     * encryption on password
     * @param $value
     * @return string
     */
    public function encrypt($value) {
        return md5($value);
    }
    public function findUserByCompanyId(){
        $users = User::model()->findAll("company_id=:company_id" ,array(':company_id' => Yii::app()->session['user']->company_id));
        $result = array();
        if(!empty($users))
            foreach($users as $user)
            {
                $result[$user->id] = array(
                    'id' => $user->id,
                    'name' => $user->username,
                );
            }

        return $result;
    }
    public function findUserByDepartment($departmentId){
        $users = User::model()->findAll($departmentId,"company_id=:company_id" ,array(':company_id' => Yii::app()->session['user']->company_id));
        $result = array();
        if(!empty($users))
            foreach($users as $user)
            {
                $result[$user->id] = array(
                    'id' => $user->id,
                    'name' => $user->username,
                );
            }
        return $result;
    }
}
