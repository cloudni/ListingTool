<?php 

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class SignInForm extends CFormModel
{
	public $username;
	public $password;
	public $rememberMe;
	private $_identity;
    public $verifyCode;
	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
        if(Yii::app()->params['displayVerifyCode'])
        {
            return array(
                array('username, password', 'required'),
                // rememberMe needs to be a boolean
                array('rememberMe', 'boolean'),
                // password needs to be authenticated
                array('password', 'authenticate'),
                // verifyCode needs to be entered correctly
                array('verifyCode', 'captcha', 'allowEmpty'=>!CCaptcha::checkRequirements()),
            );
        }
        else
        {
            return array(
                // username and password are required
                array('username, password', 'required'),
                // rememberMe needs to be a boolean
                array('rememberMe', 'boolean'),
                // password needs to be authenticated
                array('password', 'authenticate'),
                // verifyCode needs to be entered correctly
            );
        }

	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'rememberMe'=>'Remember me next time',
            'verifyCode'=>'Verification Code',
		);
	}

	/**
	 * Authenticates the password.
	 * This is the 'authenticate' validator as declared in rules().
	 */
	public function authenticate($attribute,$params)
	{
		if(!$this->hasErrors())
		{
			$this->_identity=new UserIdentity($this->username,$this->password);
			if(!$this->_identity->authenticate())
				$this->addError('password','Incorrect username or password.');
		}
	}

	/**
	 * Logs in the user using the given username and password in the model.
	 * @return boolean whether login is successful
	 */
	public function signIn()
	{
        if($this->_identity===null)
        {
            $this->_identity=new UserIdentity($this->username,$this->password);
            $this->_identity->authenticate();
        }

        if($this->_identity->errorCode===UserIdentity::ERROR_NONE)

        {
            $duration=$this->rememberMe ? 3600*24*7 : 0; // 7 days
            Yii::app()->user->login($this->_identity,$duration);
            $transaction= Yii::app()->db->beginTransaction();
            try
            {
                Admin::model()->updateByPk($this->_identity->id, array('last_login_time_utc'=>time(), 'last_login_ip'=>Yii::app()->request->userHostAddress));
                $transaction->commit();
            }
            catch(Exception $ex)
            {
                $transaction->rollback();
            }
            $user = Admin::model()->findByPk(Yii::app()->user->id);
            Yii::app()->session['user']=$user;
            return true;
        }
        else
        {
            return false;
        }
	}



}
