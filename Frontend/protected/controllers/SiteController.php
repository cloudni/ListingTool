<?php

class SiteController extends Controller
{
    /**
     * Declares class-based actions.
     */
    public function actions()
    {
        return array(
            // captcha action renders the CAPTCHA image displayed on the contact page
            'captcha'=>array(
                'class'=>'CCaptchaAction',
                'backColor'=>0xFFFFFF,
            ),
            // page action renders "static" pages stored under 'protected/views/site/pages'
            // They can be accessed via: index.php?r=site/page&view=FileName
            'page'=>array(
                'class'=>'CViewAction',
            ),
            'email'=>array(
                'class'=>'CViewAction',
            ),
        );
    }

    /**
     * This is the default 'index' action that is invoked
     * when an action is not explicitly requested by users.
     */
    public function actionIndex()
    {
        if(Yii::app()->user->isGuest) $this->layout='//layouts/nonav';
        // renders the view file 'protected/views/site/index.php'
        // using the default layout 'protected/views/layouts/main.php'
        //Helper::unsetCookie();
        $bulletins= Bulletin::model()->getRecentlyBulletin();
        if(Yii::app()->user->isGuest)
            $this->render('guest_index');
        else
            $this->render('index',array('bulletins'=>$bulletins));
    }

    /**
     * This is the action to handle external exceptions.
     */
    public function actionError()
    {
        if($error=Yii::app()->errorHandler->error)
        {
            if(Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->render('error', $error);
        }
    }

    /**
     * Displays the contact page
     */
    public function actionContact()
    {
        $model=new ContactForm;
        if(isset($_POST['ContactForm']))
        {
            $model->attributes=$_POST['ContactForm'];
            if($model->validate())
            {
                $name='=?UTF-8?B?'.base64_encode($model->name).'?=';
                $subject='=?UTF-8?B?'.base64_encode($model->subject).'?=';
                $headers="From: $name <{$model->email}>\r\n".
                    "Reply-To: {$model->email}\r\n".
                    "MIME-Version: 1.0\r\n".
                    "Content-Type: text/plain; charset=UTF-8";

                mail(Yii::app()->params['adminEmail'],$subject,$model->body,$headers);
                Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
                $this->refresh();
            }
        }
        $this->render('contact',array('model'=>$model));
    }

    /**
     * Logs out the current user and redirect to homepage.
     */
    public function actionLogout()
    {
        Yii::app()->user->logout();
        Yii::app()->session->clear();
        Yii::app()->session->destroy();
        $this->redirect(Yii::app()->homeUrl);
    }

    /**
     * Displays the SignUp page
     */
    public function actionSignUp()
    {
        $model = new SignUpForm();

        // if it is ajax validation request
        if(isset($_POST['ajax']) && $_POST['ajax']==='signUp-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        // collect user input data
        if(isset($_POST['SignUpForm']))
        {
            $model->attributes=$_POST['SignUpForm'];
var_dump($model);
            $signInForm = new SignInForm();
            $signInForm->username = $model->username;
            $signInForm->password = $model->password;

            // create company and new user as creator & admin
            if($model->validation() && $model->register())
            {
                //auto login in
                if($signInForm->login())
                {
                    $this->redirect(Yii::app()->getBaseUrl().'/');
                }
                else
                {
                    $this->redirect(Yii::app()->getBaseUrl()."/signIn");
                }
            }
        }

        // display the signUp form
        $this->render('signUp',array('model'=>$model));
    }

    /**
     * Displays the sign_in page
     */
    public function actionSignIn()
    {
        $model=new SignInForm();

        // if it is ajax validation request
        if(isset($_POST['ajax']) && $_POST['ajax']==='SignIn-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        // collect user input data
        if(isset($_POST['SignInForm']))
        {
            $model->attributes=$_POST['SignInForm'];
            // validate user input and redirect to the previous page if valid
            if($model->validate() && $model->login())
            {
                $this->redirect(Yii::app()->user->returnUrl);
                Yii::app()->session['signinAttempt'] = null;
                Yii::app()->params['signInDisplayVerificationCode'] = false;
            }
            else
            {
                if(!isset(Yii::app()->session['signinAttempt']))
                    Yii::app()->session['signinAttempt'] = 1;
                else
                    Yii::app()->session['signinAttempt'] = Yii::app()->session['signinAttempt'] + 1;
                if(Yii::app()->session['signinAttempt']>=3)
                    Yii::app()->params['signInDisplayVerificationCode'] = true;
            }
        }
        // display the signIn form
        $this->render('signIn',array('model'=>$model));
    }

    //to show view of forgot password
    public function actionForgotPwd()
    {
        $model=new ForgotPasswordForm;
        // if it is ajax validation request
        if(isset($_POST['ajax']) && $_POST['ajax']==='forgotPwd-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
        // collect user input data
        if(isset($_POST['ForgotPasswordForm']))
        {
            $model->attributes=$_POST['ForgotPasswordForm'];
            // validate user input and redirect to the previous page if valid
            if($model->validation()){
                $this->render('getEmail');
                echo "<div style='text-align:center'>" .
                     CHtml::link("codeLink",array('site/upPwd','code'=>User::model()->encrypt($model->email))) .
                    "</div>";

                exit();
                // $this->redirect(array("site/upPwd",'code'=>User::model()->encrypt($model->email),'email'=>$model->email));
            }
            else
            {
                if(Yii::app()->language =='zh_cn')
                {
                    $bread = '无效路径';
                    $title = '忘记密码错误';
                    $content = '邮件地址无效或不存在';
                    $url = array('name'=>'请再试一遍','ur'=>'forgotPwd');
                    $this->render("result",array('bread'=>$bread,'title'=>$title,'content'=>$content,'url'=>$url));
                }
                else
                {
                    $bread = 'Invalid Action';
                    $title = 'Forgot Password Error';
                    $content = 'Email address is invalid or not exist';
                    $url = array('name'=>'please try again','ur'=>'forgotPwd');
                    $this->render("result",array('bread'=>$bread,'title'=>$title,'content'=>$content,'url'=>$url));
                }

                exit();
            }

        }
        $this->render('forgotPwd',array('model'=>$model));
    }

    public function actionUpPwd($code)
    {
        $email=UpdatePwdForm::validateCode($code);
        if($email)
        {
            $model=new UpdatePwdForm;
            // if it is ajax validation request
            if(isset($_POST['ajax']) && $_POST['ajax']==='upPwd-form')
            {
                echo CActiveForm::validate($model);
                Yii::app()->end();
            }
            $signInForm = new SignInForm();
            // collect user input data
            if(isset($_POST['UpdatePwdForm']))
            {
                $model->attributes=$_POST['UpdatePwdForm'];
                $model->changePwd(UpdatePwdForm::validateCode($code),$model->password);
                if($model->rememberMe)
                {
                    $signInForm->username = $model->getName($code);
                    $signInForm->password = $model->password;
                    $signInForm->login();
                    $this->redirect('index');
                    exit();
                }
                else
                {
                    $bread = 'Action Success';
                    $title = 'Reset Password Success';
                    $content = 'Reset Password Success';
                    $url = array('name'=>'Sign In','ur'=>'signIn');
                    $this->render("result",array('bread'=>$bread,'title'=>$title,'content'=>$content,'url'=>$url));
                    exit();
                }
            }
            $this->render('upPwd',array('model'=>$model));
        }else{
            $bread = 'Invalid Action';
            $title = 'Invalid Action';
            $content = 'Illegal Operation';
            $url = array('name'=>'please try again','ur'=>('forgotPwd'));
            $this->render("result",array('bread'=>$bread,'title'=>$title,'content'=>$content,'url'=>$url));
        }
    }

    //display the view of forgotPwdError
    public function actionForgotPwdError()
    {
        $bread = 'Invalid Action';
        $title = 'Invalid Action';
        $content = 'Internal Error';
        $url = array('name'=>'please try again','ur'=>'/forgotPwd');
        $this->render("result",array('bread'=>$bread,'title'=>$title,'content'=>$content,'url'=>$url));
    }

    public function actionGetEmail()
    {
        $this->render('getEmail');
    }

    public function actionResult()
    {
        $this->render('result');
    }

    public function actionEmail()
    {
        $this->render('email/index');
    }

    public function actionForgotPwdEmail(){
        $this->render('email/forgotPwdEmail');
    }


    public function actionSetLanguage(){
        if($_POST['pid']!=null || $_POST['pid']!=''){
            // set cookie
            $cookie = new CHttpCookie('language',$_POST['pid']);
            $cookie->expire = time()+60*60*24*30;  //有限期30天
            Yii::app()->request->cookies['language']=$cookie;
        }
       // parent::init();
        $result = array('status'=>'success');
        echo json_encode($result);
    }

}