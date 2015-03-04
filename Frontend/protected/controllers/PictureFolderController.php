<?php

class PictureFolderController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout=null;//'//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
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
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('index','view','create','update','delete','updateName','removeTreeNode','remoteCreate','dropFolder'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
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
		$model=new PictureFolder;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['PictureFolder']))
		{
			$model->attributes=$_POST['PictureFolder'];
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

		if(isset($_POST['PictureFolder']))
		{
			$model->attributes=$_POST['PictureFolder'];
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
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$this->loadModel($id)->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

    private function getTreeDataForSubRC($parent)
    {
        $self = array(
            'id'=>$parent->id,
            'name'=>$parent->name,
            'pId'=>$parent->parent_id,
        );
        if(!empty($parent->subPictureFolders))
        {
            $self['children'] = array();
            foreach($parent->subPictureFolders as $childValue)
            {
                $self['children'][] = $this->getTreeDataForSubRC($childValue);
            }
        }
        return  $self;
    }


    /**
	 * Lists all models.
	 */
    public function actionIndex()
    {
        $PictureResult  = PictureFolder::model()->findAll(
            'parent_id=:parent_id and company_id=:company_id',
            array(
                ':parent_id'=>0,
                ':company_id'=>Yii::app()->session['user']->company_id,
            )
        );
        $pictureFolder = array();
        if(count($PictureResult) > 0){
            foreach($PictureResult as $row)
            {
                $pictureFolder[] = $this->getTreeDataForSubRC($row);
            }

        }
        $this->render('index',array(
            'pictureFolder'=>$pictureFolder,
        ));
    }

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new PictureFolder('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['PictureFolder']))
			$model->attributes=$_GET['PictureFolder'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
        $model=PictureFolder::model()->findByPk($id, "company_id=:company_id" ,array(':company_id' => Yii::app()->session['user']->company_id));
        if($model===null)
            throw new CHttpException(404,'The requested page does not exist.');
        return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='picture-folder-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

    protected function savePictureFolder($model)
    {
        $transaction= Yii::app()->db->beginTransaction();
        try
        {
            if(!$model->save())
            {
                $transaction->rollback();
                return false;
            }

            $transaction->commit();
            return true;
        }
        catch(Exception $ex)
        {
            $transaction->rollback();
            return false;
        }
        return true;
    }

    /**
     * update folder
     */
    public function actionUpdateName()
    {
        try{
            $id = intval($_POST['id']);
            $name=(string)$_POST['name'];
            $parentId = intval($_POST['pid']);

            $model=$this->loadModel($id);
            $model->name = $name;
            $model->parent_id = $parentId;
            if($this->savePictureFolder($model))
            {
                $result = array('status'=>'success','successMsg'=>'update name success');
            }
        }
        catch (Exception $ex)
        {
            $result = array('status'=>'error','errorMsg'=>'can not update name');
        }

        echo json_encode($result);
    }


    public function actionRemoveTreeNode()
    {
        try{
            $id = intval($_POST['id']);
            $transaction= Yii::app()->db->beginTransaction();
            $parentFolder = $this->loadModel($id);
            $subFolder = array();
            $subFolder[] = $this->getTreeDataForSubRC($parentFolder);

            if((!empty($subFolder[0]['children'])))
            {
                foreach($subFolder[0]['children'] as $folder)
                {
                    $saveFolder = $this->loadModel($folder['id']);
                    $saveFolder->parent_id = $parentFolder->parent_id ;
                    $saveFolder->save();

                }
            }

            if(!($parentFolder->delete()))
            {
                $transaction->rollback();
                $result = array('status'=>'error','errorMsg'=>'delete picture folder failed');
            }

            $transaction->commit();
            $result = array('status'=>'success','successMsg'=>'delete picture folder success');
        }
        catch (Exception $ex)
        {
            $transaction->rollback();
            $result = array('status'=>'error','errorMsg'=>'delete picture folder failed');
        }
        echo json_encode($result);
    }

    public function actionRemoteCreate()
    {
        $model = new PictureFolder();
        $model->name=(string)$_POST['name'];
        $model->parent_id = intval($_POST['pid']);
        $model->company_id = intval(Yii::app()->session['user']->company_id);
        $data = $this->savePictureFolder($model);
        if($data)
        {
            $result = array('status'=>'success','successMsg'=>'create success','id'=>$model->id);
        }
        else
        {
            $result = array('status'=>'error', 'errorMsg'=>'can not save new picture folder');
        }
        echo json_encode($result);
    }

    public function actionDropFolder()
    {
        try{
            $id = intval($_POST['id']);
            $tid = intval($_POST['tid']);
            $model=$this->loadModel($id);
            if($tid==0){
                $model->parent_id = 0;
            }
            else
            {
                $targetModel=$this->loadModel($tid);
                $model->parent_id = $targetModel->id;
            }
            if($this->savePictureFolder($model))
            {
                $result = array('status'=>'success','successMsg'=>'move folder successfully');
            }
        }
        catch (Exception $ex)
        {
            $result = array('status'=>'error','errorMsg'=>'move folder failed');
        }

        echo json_encode($result);
    }
}
