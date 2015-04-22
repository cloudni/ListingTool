<?php

/**
 * This is the model class for table "lt_admin".
 *
 * The followings are the available columns in table 'lt_admin':
 * @property integer $id
 * @property string $email
 * @property string $username
 * @property string $password
 * @property integer $last_login_time_utc
 * @property string $last_login_ip
 * @property integer $create_time_utc
 * @property integer $create_user_id
 * @property integer $update_time_utc
 * @property integer $update_user_id
 */
class Admin extends NIAdminActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
    public $password_repeat;
	public function tableName()
	{
		return 'lt_admin';
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
			array('email, username, password', 'length', 'max'=>256),
			array('last_login_ip', 'length', 'max'=>128),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, email, username, password, last_login_time_utc, last_login_ip, create_time_utc, create_admin_id, update_time_utc, update_admin_id', 'safe', 'on'=>'search'),
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
			'email' => 'Email',
			'username' => 'Username',
			'password' => 'Password',
			'last_login_time_utc' => 'Last Login Time Utc',
			'last_login_ip' => 'Last Login Ip',
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
		$criteria->compare('email',$this->email,true);
		$criteria->compare('username',$this->username,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('last_login_time_utc',$this->last_login_time_utc);
		$criteria->compare('last_login_ip',$this->last_login_ip,true);
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
	 * @return Admin the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
    public function encrypt($value) {
        return md5($value);
    }
    public function validation()
    {
        $criteria=new CDbCriteria();
        $criteria->select='id';
        $criteria->condition='username=:username or email=:email';
        $criteria->params=array(':username'=>$this->username, ':email'=>$this->email);
        $result = Admin::model()->findAll($criteria);
        if($result)
            return false;
        else
            return true;
    }

    /**
     * create new company & user as creator & admin
     */
    public function register()
    {
        $transaction= Yii::app()->db->beginTransaction();
        try
        {
            //create admin
            $admin = new Admin();
            $admin->username = $this->username;
            $admin->password = $admin->encrypt($this->password);
            $admin->password_repeat = $this->password_repeat;
            $admin->email = $this->email;
            $admin->create_time_utc = $admin->update_time_utc = time();
            if(!$admin->save(false))
            {
                $transaction->rollback();
                return false;
            }
            $admin->create_admin_id = $admin->update_admin_id = $admin->id;
            if(!$admin->update())
            {
                $transaction->rollback();
                return false;
            }
            //create default product folder
            $transaction->commit();
            return true;
        }
        catch(Exception $ex)
        {
            $transaction->rollback();
            return false;
        }
    }
}
