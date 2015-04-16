<?php

class ADGroupController extends Controller
{
    public $layout='';

	public function actionIndex($campaignId=null)
	{
        $this->layout='//layouts/column2';
		$this->render('index');
	}

    public function actionCreate($campaignid=null, $lead=false)
    {
        $model = new ADGroup();

        if(isset($_POST['adgroup']))
        {
            $model->company_id = Yii::app()->session['user']->company_id;
            $model->name = $_POST['adgroup']['name'];
            $model->default_bid = $_POST['adgroup']['default_bid'];
            $model->campaign_id = $campaignid;
            $model->status = ADGroup::Status_Enabled;
            $model->is_delete = ADGroup::Delete_No;
            $criteria = array(
                'keywords'=>str_replace("\n", ADGroup::Criteria_Separator,$_POST['keywords']),
                'placements'=>str_replace("\n", ADGroup::Criteria_Separator,$_POST['placements']),
            );
            $model->criteria = json_encode($criteria);
            if($model->save())
            {
                $this->redirect($this->createAbsoluteUrl("marketing/advertisement/adad/create", array('adcampaignid'=>$model->id, 'adgroupid'=>$model->id, 'lead' => $lead,)));
            }
        }

        if(!isset($campaignid))
        {
            $this->render('chooseCampaign');
            exit();
        }

        $this->render('create', array(
            'model'=>$model,
            'lead'=>$lead,
        ));
    }

    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);

        if(isset($_POST['adgroup']))
        {
            $model->default_bid = $_POST['adgroup']['default_bid'];
            $criteria = array(
                'keywords'=>str_replace("\n", ADGroup::Criteria_Separator,$_POST['keywords']),
                'placements'=>str_replace("\n", ADGroup::Criteria_Separator,$_POST['placements']),
            );
            $model->criteria = json_encode($criteria);
            if($model->save())
            {
                $this->redirect($this->createAbsoluteUrl("marketing/advertisement/adgroup/view", array('id'=>$model->id)));
            }
        }

        $this->render('update', array(
            'model'=>$model,
        ));
    }

    public function actionView($id)
    {
        $this->layout='//layouts/column2';
        $this->render('view',array(
            'model'=>$this->loadModel($id),
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Department the loaded model
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model=ADGroup::model()->findByPk($id, "company_id=:company_id" ,array(':company_id' => Yii::app()->session['user']->company_id));
        if($model===null)
            throw new CHttpException(404,'The requested page does not exist.');
        return $model;
    }

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
                'actions'=>array('index', 'create', 'update', 'view'),
                'users'=>array('@'),
            ),
            array('deny',  // deny all users
                'users'=>array('*'),
            ),
        );
    }
}