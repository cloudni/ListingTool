<?php
/**
 * Created by PhpStorm.
 * User: cloud
 * Date: 14-9-16
 * Time: 10:09am
 */

Yii::import('application.components.*');
require_once("ExceptionHandler/HttpStatus.php");

class SignUpForm extends CFormModel
{
    public $username;
    public $password;
    public $password_repeat;
    public $email;
    public $name;
    public $phone;
    public $country;
    public $verifyCode;

    /**
     * Declares the validation rules.
     * The rules state that username and password are required,
     * and password needs to be authenticated.
     */
    public function rules()
    {
        if(Yii::app()->params['signUpDisplayVerificationCode']){
            return array(
                array('verifyCode', 'captcha', 'allowEmpty'=>!CCaptcha::checkRequirements()),
                array('username, password, email, name', 'required'),
                array('password', 'compare'),
            );
        }else{
           return array(
                array('username, password, email, name', 'required'),
                array('password', 'compare'),
           );
       }
    }

    /**
     * Declares attribute labels.
     */
    public function attributeLabels()
    {
        return array(
            'email' => Yii::t('models/SignUpForm','Email Address'),
            'username' =>Yii::t('models/SignUpForm','User Name'),
            'password' =>Yii::t('models/SignUpForm','Password') ,
            'password_repeat'=>Yii::t('models/SignUpForm','Password Repeat'),
            'name' => Yii::t('models/SignUpForm','Company Name'),
            'phone' => Yii::t('models/SignUpForm','Phone Number') ,
            'country' => Yii::t('models/SignUpForm','Country or Area') ,
            'verifyCode'=> Yii::t('models/SignUpForm','Verification Code') ,
        );
    }

    /**
     * check if email or username has been registered
     */
    public function validation()
    {
        try
        {
            $criteria=new CDbCriteria();
            $criteria->select='id';
            $criteria->condition='username=:username or email=:email';
            $criteria->params=array(':username'=>$this->username, ':email'=>$this->email);
            $result = User::model()->findAll($criteria);
            if($result)
                return false;
            else
                return true;
        }catch(Exception $ex){
            throw new CHttpException(406,"internal error");
        }
    }

    /**
     * create new company & user as creator & admin
     */
    public function register()
    {
        $transaction= Yii::app()->db->beginTransaction();
        try
        {var_dump($this);die();
            //create company first
            $company = new Company();
            $company->name = $this->name;
            $company->country = $this->country;
            $company->phone = $this->phone;
            if(!$company->save(false))
            {
                $transaction->rollback();
                Yii::app()->user->setFlash('Error', 'Fail to create Company!');
                return false;
            }

            $department = new Department();
            $department->company_id = $company->id;
            $department->name = 'Main Department';
            $department->parent_id = 0;
            if(!$department->save(false))
            {
                $transaction->rollback();
                Yii::app()->user->setFlash('Error', 'Fail to create department!');
                return false;
            }

            //create user
            $user = new User();
            $user->username = $this->username;
            $user->password = $user->encrypt($this->password);
            $user->password_repeat = $this->password_repeat;
            $user->email = $this->email;
            $user->company_id = $company->id;
            $user->department_id = $department->id;
            $user->create_time_utc = $user->update_time_utc = time();
            if(!$user->save(false))
            {
                $transaction->rollback();
                Yii::app()->user->setFlash('Error', 'Fail to create User!');
                return false;
            }

            $company->owner_id = $company->create_user_id = $company->update_user_id = $user->id;
            if(!$company->update(false))
            {
                $transaction->rollback();
                Yii::app()->user->setFlash('Error', 'Fail to update Company!');
                return false;
            }

            $department->create_user_id = $department->update_user_id = $user->id;
            if(!$department->update())
            {
                $transaction->rollback();
                Yii::app()->user->setFlash('Error', 'Fail to update department!');
                return false;
            }

            $user->create_user_id = $user->update_user_id = $user->id;
            if(!$user->update())
            {
                $transaction->rollback();
                Yii::app()->user->setFlash('Error', 'Fail to update User!');
                return false;
            }

            //create default product folder
            $defaultProductFolder = new ProductFolder();
            $defaultProductFolder->name = 'Main Folder';
            $defaultProductFolder->parent_id = 0;
            $defaultProductFolder->company_id = $company->id;
            if(!$defaultProductFolder->save(false))
            {
                $transaction->rollback();
                Yii::app()->user->setFlash('Error', 'Fail to create default product folder!');
                return false;
            }

            //create default picture folder
            $defaultPictureFolder = new PictureFolder();
            $defaultPictureFolder->name = 'Main Picture Folder';
            $defaultPictureFolder->parent_id = 0;
            $defaultPictureFolder->company_id = $company->id;
            if(!$defaultPictureFolder->save(false))
            {
                $transaction->rollback();
                Yii::app()->user->setFlash('Error', 'Fail to create default picture folder!');
                return false;
            }

            $transaction->commit();
            return true;
        }
        catch(Exception $ex)
        {
            $transaction->rollback();
            throw new CHttpException(HttpStatus::STATUS_503, 'Error: ['.$ex->getCode().'], '.$ex->getMessage());
            return false;
        }
    }
} 