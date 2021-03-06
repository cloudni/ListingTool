<?php

Yii::import('application.vendor.eBay.*');
Yii::import('application.vendor.Wish.*');
require_once 'reference.php';
require_once 'eBayTradingAPI.php';
require_once 'WishClient.php';

class StoreController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view', 'getToken', 'eBayThirdPartyAuthSuccess', 'eBayThirdPartyAuthFail'),
				'users'=>array('@'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('@'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

    public function actionEBayThirdPartyAuthSuccess($id)
    {
        $model = $this->loadModel($id);
        if(empty($model))
        {
            Yii::app()->user->setFlash('Error', 'Cannot find your store, please try authorize again later!');
            $this->redirect($this->createUrl("store/index",array()));
        }

        $result = eBayTradingAPI::FetchToken($model);
        if(!$result || empty($result))
        {
            Yii::app()->user->setFlash('Error', 'Failed to get token from eBay, please try authorize again later!');
            $this->redirect($this->createUrl("store/index",array()));
        }

        $transaction = null;
        try
        {
            $transaction= Yii::app()->db->beginTransaction();
            $model->ebay_token = $result['eBayAuthToken'];
            $model->HardExpirationTime = strtotime((string)$result['HardExpirationTime']);
            $model->is_active = Store::ACTIVE_YES;
            $model->save(false);

            $scheduleJob = ScheduleJob::model()->find("params=:params and action=:action", array(":params"=>(string)$model->id, ":action"=>ScheduleJob::ACTION_EBAYGETMYEBAYSELLING));
            if(empty($scheduleJob)) $scheduleJob = new ScheduleJob();
            $scheduleJob->platform = Store::PLATFORM_EBAY;
            $scheduleJob->action = ScheduleJob::ACTION_EBAYGETMYEBAYSELLING;
            $scheduleJob->params = $model->id;
            $scheduleJob->last_execute_status = ScheduleJob::LAST_EXECUTE_STATUS_SUCCESS;
            $scheduleJob->create_time_utc = time();
            $scheduleJob->is_active = ScheduleJob::ACTIVE_YES;
            $scheduleJob->crontab = sprintf("1 %s,%s * * *", ($model->id % 10), ($model->id % 10 + 12));//"1 */12 * * *";
            $scheduleJob->next_execute_time_utc = 0;
            $scheduleJob->type = ScheduleJob::TYPE_REPEAT;
            $scheduleJob->save(false);

            $transaction->commit();
            Yii::app()->user->setFlash('Success', 'Authorized succeeded! Will start to sync eBay listings.');
            $this->redirect(array('view','id'=>$model->id));
        }
        catch(Exception $ex)
        {
            if(isset($transaction)) $transaction->rollback();
            Yii::app()->user->setFlash('Error', "Exception happened, please try authorize again later!\nError Code: ".$ex->getCode().', Error Message: '.$ex->getMessage());
            $this->redirect($this->createUrl("store/index",array()));
        }
    }

    public function actionEBayThirdPartyAuthFail($id)
    {
        $model = $this->loadModel($id);
        if(empty($model))
        {
            $this->redirect($this->createUrl("store/index",array()));
        }
        Yii::app()->user->setFlash('Error', 'Fail to authorized your store, please try authorize again later!');
        $this->redirect(array('view','id'=>$model->id));
    }

    public function actionGetToken($id)
    {
        $model = $this->loadModel($id);
        switch($model->platform)
        {
            case Store::PLATFORM_EBAY:

                $sql = "select a.*
                from lt_ebay_api_key a
                left join (select ebay_api_key_id, count(ebay_api_key_id) as total from lt_store t
                where is_active = :is_active and t.platform = :platform
                group by ebay_api_key_id) as temp on temp.ebay_api_key_id = a.id
                where a.type = :type and a.id not in (1,2,3,4) and IFNULL(temp.total, 0) < :max_count
                order by a.id asc; ";
                $eBayApiKey = null;
                try
                {
                    $eBayApiKey = eBayApiKey::model()->findBySql($sql, array(
                        ':is_active'=>Store::ACTIVE_YES,
                        ':platform'=>Store::PLATFORM_EBAY,
                        ':type'=>eBayApiKey::TYPE_PROD,
                        ':max_count'=>Yii::app()->params['ebay']['maxAuthNum'],
                    ));
                }
                catch(Exception $ex)
                {
                    Yii::app()->user->setFlash('Error', 'Exception happened while getting API key<br />code: ' . $ex->getCode() . ', msg: ' . $ex->getMessage());
                }

                if(!isset($eBayApiKey))
                {
                    Yii::app()->user->setFlash('Error', 'No available API to authorize, Please contact with us!');
                }
                else
                {
                    $model->ebay_api_key_id = $eBayApiKey->id;
                    if($model->save())
                    {
                        $sessionId = eBayTradingAPI::GetSessionID($model->ebay_api_key_id);

                        $prodSignInURL = Yii::app()->params['ebay']['productSignInURL'];
                        $sandboxSignInURL = Yii::app()->params['ebay']['sandboxSignInURL'];
                        if($sessionId)
                        {
                            Yii::app()->session['store_'.$model->id.'_ebay_session_id']=$sessionId;
                            if($model->eBayApiKey->type == eBayApiKey::TYPE_SANDBOX)
                                $this->redirect(sprintf($sandboxSignInURL, $model->eBayApiKey->runame, $sessionId, "id%3D".$model->id));
                            if($model->eBayApiKey->type == eBayApiKey::TYPE_PROD)
                                $this->redirect(sprintf($prodSignInURL, $model->eBayApiKey->runame, $sessionId, "id%3D".$model->id));
                        }
                        else
                        {
                            Yii::app()->user->setFlash('Error', 'Failed to get author session from eBay, please try again later!');
                        }
                    }
                    else
                    {
                        Yii::app()->user->setFlash('Error', 'Fail to update Store with API key, please try again later!');
                    }
                }
                break;
            default:
                Yii::app()->user->setFlash('Error', 'This store is not an eBay shop, please select an eBay shop and try again!');
                break;
        }
        $this->redirect(array('view','id'=>$model->id));
    }

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Store;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Store']))
		{
			$model->attributes=$_POST['Store'];
            $model->company_id = Yii::app()->session['user']->company_id;
            $model->is_active = Store::ACTIVE_NO;

			if($model->save())
            {
                switch($model->platform)
                {
                    case Store::PLATFORM_EBAY:
                        $this->redirect(array('getToken','id'=>$model->id));
                        break;
                    case Store::PLATFORM_WISH:
                        if(isset($model->wish_token) && $model->wish_token)
                        {
                            try
                            {
                                $client = new WishClient($model->wish_token);
                                if(strtolower($client->authTest()) == 'success')
                                {
                                    $model->is_active = Store::ACTIVE_YES;

                                    $transaction = null;
                                    try
                                    {
                                        $transaction = Yii::app()->db->beginTransaction();

                                        if($model->save())
                                        {
                                            $scheduleJob = new ScheduleJob();
                                            $scheduleJob->platform = Store::PLATFORM_WISH;
                                            $scheduleJob->action = ScheduleJob::ACTION_WISHGETALLPRODUCTS;
                                            $scheduleJob->params = $model->id;
                                            $scheduleJob->last_execute_status = ScheduleJob::LAST_EXECUTE_STATUS_NO_OCCURRED;
                                            $scheduleJob->create_time_utc = time();
                                            $scheduleJob->is_active = ScheduleJob::ACTIVE_YES;
                                            $scheduleJob->crontab = sprintf("1 %s,%s * * *", ($model->id % 10), ($model->id % 10 + 12));//"1 */12 * * *";
                                            $scheduleJob->next_execute_time_utc = 0;
                                            $scheduleJob->last_execute_time_utc = 0;
                                            $scheduleJob->last_finish_time_utc = 0;
                                            $scheduleJob->type = ScheduleJob::TYPE_REPEAT;
                                            $scheduleJob->save(false);
                                        }

                                        $transaction->commit();
                                    } catch(Exception $ex)
                                    {
                                        if(isset($transaction)) $transaction->rollback();
                                        //todo pop up error message
                                    }
                                }
                            }
                            catch(Exception $ex)
                            {
                                //todo
                            }
                        }
                        break;
                    default:
                        break;
                }
                Yii::app()->user->setFlash('Success', "Store {$model->name} created successfully!");
                $this->redirect(array('view','id'=>$model->id));
            }
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);
        $oldModel = $this->loadModel($id);
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Store']))
		{
			$model->attributes=$_POST['Store'];
            if($model->platform == Store::PLATFORM_WISH && isset($model->wish_token) && $model->wish_token && $model->wish_token != $oldModel->wish_token)
            {
                try
                {
                    $client = new WishClient($model->wish_token);
                    $scheduleJob = ScheduleJob::model()->find("platform=:platform and action=:action and params=:params", array(':platform' => Store::PLATFORM_WISH, ':action' => ScheduleJob::ACTION_WISHGETALLPRODUCTS, ':params' => $model->id,));
                    if(strtolower($client->authTest()) == 'success')
                    {
                        $model->is_active = Store::ACTIVE_YES;
                        if(isset($scheduleJob))
                        {
                            $scheduleJob->is_active = ScheduleJob::ACTIVE_YES;
                            $scheduleJob->save(false);
                        }
                        else
                        {
                            $scheduleJob = new ScheduleJob();
                            $scheduleJob->platform = Store::PLATFORM_WISH;
                            $scheduleJob->action = ScheduleJob::ACTION_WISHGETALLPRODUCTS;
                            $scheduleJob->params = $model->id;
                            $scheduleJob->last_execute_status = ScheduleJob::LAST_EXECUTE_STATUS_SUCCESS;
                            $scheduleJob->create_time_utc = time();
                            $scheduleJob->is_active = ScheduleJob::ACTIVE_YES;
                            $scheduleJob->crontab = sprintf("1 %s,%s * * *", ($model->id % 10), ($model->id % 10 + 12));//"1 */12 * * *";
                            $scheduleJob->next_execute_time_utc = 0;
                            $scheduleJob->type = ScheduleJob::TYPE_REPEAT;
                            $scheduleJob->save(false);
                        }
                    }
                    else
                    {
                        $model->is_active = Store::ACTIVE_NO;
                        if(isset($scheduleJob))
                        {
                            $scheduleJob->is_active = ScheduleJob::ACTIVE_NO;
                            $scheduleJob->save(false);
                        }
                    }
                }
                catch(Exception $ex)
                {
                    //todo
                }
            }
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider(
            'Store',
            array
            (
                'criteria' => array
                (
                    'condition' => 'company_id=:company_id',
                    'params' => array(
                        ':company_id' => Yii::app()->session['user']->company_id),
                ),
            )
        );
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Store('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Store']))
			$model->attributes=$_GET['Store'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Store the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Store::model()->findByPk($id, "company_id=:company_id" ,array(':company_id' => Yii::app()->session['user']->company_id));
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Store $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='store-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
