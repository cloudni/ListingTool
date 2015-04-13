<?php

class CampaignController extends Controller
{
    public $layout='';

	public function actionIndex()
	{
        $this->layout='//layouts/column2';

        $campaigns = AdCampaign::model()->findAll("company_id=:company_id" ,array(':company_id' => Yii::app()->session['user']->company_id));
        $rawData = array();
        foreach($campaigns as $campaign)
        {
            $rawData[] = array(
                'name'=>$campaign->name,
                'id'=>$campaign->id,
                'budget'=>$campaign->budget,
                'status'=>$campaign->status,
            );
        }
        $dataProvider=new CArrayDataProvider($rawData, array(
            'id'=>'id',
            'sort'=>array(
                'attributes'=>array(
                    //'el.id', 'soldquantity'
                ),
            ),
            'pagination'=>array(
                'pageSize'=>10,
            ),
        ));
		$this->render('index',array(
            'dataProvider'=>$dataProvider,
        ));
	}

    public function actionCreate()
    {
        $model = new AdCampaign();

        if(isset($_POST['campaign']))
        {
            $model->name = (string)$_POST['campaign']['name'];
            $model->budget = (float)$_POST['campaign']['budget'];
            $model->company_id = Yii::app()->session['user']->company_id;
            $model->status = AdCampaign::Status_Eligible;
            $model->is_delete = AdCampaign::Delete_No;
            $criteria['language'] = !isset($_POST['language_option_all_value']) && isset($_POST['language_option_value']) && !empty($_POST['language_option_value']) ? implode(',', $_POST['language_option_value']) : '';
            $locations = array();
            foreach($_POST as $key => $value)
            {
                if(substr($key, 0, 37) === 'exclude_ship_location_worldwide_list_') foreach($value as $local) $locations[] = $local;
            }
            $criteria['location'] = implode(',', $locations);
            $criteria['timezone'] = $_POST['schedule_timezone'];
            $model->start_datetime = strtotime($_POST['startdate']);
            $model->end_datetime = $_POST['enddate_select'] == 'select_end_date' && isset($_POST['enddate']) ? strtotime($_POST['enddate']) : null;
            if(isset($_POST['schedule_option_value_day']) && !empty($_POST['schedule_option_value_day']))
            {
                $criteria['schedule'] = array();
                for($i=0;$i<count($_POST['schedule_option_value_day']);$i++)
                {
                    if(!isset($_POST['schedule_option_value_day'][$i]) || !isset($_POST['schedule_option_value_from_hour'][$i]) || !isset($_POST['schedule_option_value_from_minute'][$i]) || !isset($_POST['schedule_option_value_to_hour'][$i]) || !isset($_POST['schedule_option_value_to_minute'][$i])) continue;
                    $criteria['schedule'][] = array(
                        'day'=>$_POST['schedule_option_value_day'][$i],
                        'from_hour'=>$_POST['schedule_option_value_from_hour'][$i],
                        'from_minute'=>$_POST['schedule_option_value_from_minute'][$i],
                        'to_hour'=>$_POST['schedule_option_value_to_hour'][$i],
                        'to_minute'=>$_POST['schedule_option_value_to_minute'][$i],
                    );
                }
            }
            $model->criteria = json_encode($criteria);
            if($model->save())
                $this->redirect($this->createAbsoluteUrl("marketing/advertisement/campaign/view", array('id'=>$model->id)));
        }

        $this->render('create', array(
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

    public function actionUpdate($id)
    {
        $model=$this->loadModel($id);

        if(isset($_POST['campaign']))
        {
            $model->budget = (float)$_POST['campaign']['budget'];
            $model->company_id = Yii::app()->session['user']->company_id;
            $model->status = AdCampaign::Status_Eligible;
            $model->is_delete = AdCampaign::Delete_No;
            $criteria['language'] = !isset($_POST['language_option_all_value']) && isset($_POST['language_option_value']) && !empty($_POST['language_option_value']) ? implode(',', $_POST['language_option_value']) : '';
            $locations = array();
            foreach($_POST as $key => $value)
            {
                if(substr($key, 0, 37) === 'exclude_ship_location_worldwide_list_') foreach($value as $local) $locations[] = $local;
            }
            $criteria['location'] = implode(',', $locations);
            $criteria['timezone'] = $_POST['schedule_timezone'];
            $model->start_datetime = strtotime($_POST['startdate']);
            $model->end_datetime = $_POST['enddate_select'] == 'select_end_date' && isset($_POST['enddate']) ? strtotime($_POST['enddate']) : null;
            if(isset($_POST['schedule_option_value_day']) && !empty($_POST['schedule_option_value_day']))
            {
                $criteria['schedule'] = array();
                for($i=0;$i<count($_POST['schedule_option_value_day']);$i++)
                {
                    if(!isset($_POST['schedule_option_value_day'][$i]) || !isset($_POST['schedule_option_value_from_hour'][$i]) || !isset($_POST['schedule_option_value_from_minute'][$i]) || !isset($_POST['schedule_option_value_to_hour'][$i]) || !isset($_POST['schedule_option_value_to_minute'][$i])) continue;
                    $criteria['schedule'][] = array(
                        'day'=>$_POST['schedule_option_value_day'][$i],
                        'from_hour'=>$_POST['schedule_option_value_from_hour'][$i],
                        'from_minute'=>$_POST['schedule_option_value_from_minute'][$i],
                        'to_hour'=>$_POST['schedule_option_value_to_hour'][$i],
                        'to_minute'=>$_POST['schedule_option_value_to_minute'][$i],
                    );
                }
            }
            $model->criteria = json_encode($criteria);
            if($model->save())
                $this->redirect($this->createAbsoluteUrl("marketing/advertisement/campaign/view", array('id'=>$model->id)));
        }

        $this->render('update',array(
            'model'=>$model,
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
        $model=AdCampaign::model()->findByPk($id, "company_id=:company_id" ,array(':company_id' => Yii::app()->session['user']->company_id));
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
                'actions'=>array('index', 'create', 'view', 'update'),
                'users'=>array('@'),
            ),
            array('deny',  // deny all users
                'users'=>array('*'),
            ),
        );
    }
}