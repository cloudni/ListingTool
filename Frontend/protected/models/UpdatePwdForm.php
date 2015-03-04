<?php


class UpdatePwdForm extends CFormModel
{
    public $password;
    public $password_repeat;
    public $rememberMe;

    /**
     * Declares the validation rules.
     * The rules state that email are required,
     */
    public function rules()
    {
        return array(
            // password are required
            array('password', 'required'),
            array('password','compare'),
            array('password_repeat', 'safe'),
            array('rememberMe', 'boolean'),
        );
    }

    /**
     * Declares attribute labels.
     */
    public function attributeLabels()
    {
        return array(
            'password' => 'New Password',
            'password_repeat' => 'Password Repeat',
            'rememberMe'=> 'Sign In After Update',
        );
    }

    public function changePwd($email,$password){
        try
        {
            $user = User::model()->findByAttributes(array('email' => $email));
            User::model()->updateByPk($user->id,array("password" => User::model()->encrypt($password)));
        }catch(Exception $ex)
        {
            throw new CHttpException(406,"internal error");
        }
    }

    public static function validateCode($code)
    {
        try
        {
            $user = User::model()->find("md5(email)=:code", array(':code'=>$code));
            if(!empty($user))
                return $user->email;
            else
                return false;
        }catch(Exception $ex)
        {
            throw new CHttpException(406,"internal error");
        }
    }

    public function getName($code){
        try
        {
            $user = User::model()->find("md5(email)=:code", array(':code'=>$code));
            if(!empty($user))
                return ($user->username);
            else
                return false;
        }catch(Exception $ex){
            throw new CHttpException(406,"internal error");
        }

    }

}
