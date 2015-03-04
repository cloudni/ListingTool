<?php


class ForgotPasswordForm extends CFormModel
{
    public $email;
    /**
     * Declares the validation rules.
     * The rules state that email are required,
     */
    public function rules()
    {
        return array(
            // email are required
            array('email', 'required'),
        );
    }

    /**
     * Declares attribute labels.
     */
    public function attributeLabels()
    {
        return array(
            'email' => Yii::t('models/ForgotPasswordForm','Email Address'),
        );
    }

    /**
     * check if email has been registered
     */
    public function validation()
    {
        try
        {
            $criteria=new CDbCriteria();
            $criteria->select='id';
            $criteria->condition='email=:email';
            $criteria->params=array(':email'=>$this->email);
            $result = User::model()->findAll($criteria);
            if($result)
                return true;
            else
                return false;
        }catch (Exception $ex){
            if(Yii::app()->language == 'zh_cn')
            {
                throw new CHttpException(406,"内部错误！");
            }
            else
            {
                throw new CHttpException(406,"internal error");
            }
        }
    }

}
