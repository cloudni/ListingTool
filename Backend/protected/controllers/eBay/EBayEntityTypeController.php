<?php

class EBayEntityTypeController extends Controller
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
				'actions'=>array('index','view', 'test'),
				'users'=>array('@'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	public function actionTest()
	{
		$listing_id = '221545344981';
		$store_id = 91;
		$company_id = 4;
		if(!$store_id) return array('status'=>'fail', 'msg'=>'store id is invalid.');

		if(!$company_id) return array('status'=>'fail', 'msg'=>'company id is invalid.');

		$list = eBayListing::model()->find("ebay_listing_id=:ebay_listing_id and store_id=:store_id and company_id=:company_id", array(":ebay_listing_id"=>$listing_id, ":store_id"=>$store_id, ":company_id"=>$company_id));

		if(empty($list))
		{
			$list = new eBayListing();
			$list->store_id = $store_id;
			$list->ebay_listing_id = (string)$listing_id;
			$list->company_id = $company_id;
		}
		if(eBayTradingAPI::GetItem($list))
			return array('status'=>'success', 'msg'=>"$listing_id has been updated.");
		else
			return array('status'=>'fail', 'msg'=>"fail to update $listing_id.");
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
		$model=new eBayEntityType;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['eBayEntityType']))
		{
			$model->attributes=$_POST['eBayEntityType'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
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

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['eBayEntityType']))
		{
			$model->attributes=$_POST['eBayEntityType'];
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
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('eBayEntityType');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new eBayEntityType('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['eBayEntityType']))
			$model->attributes=$_GET['eBayEntityType'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return eBayEntityType the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=eBayEntityType::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param eBayEntityType $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='e-bay-entity-type-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
