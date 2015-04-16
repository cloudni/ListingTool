<?php

class ADController extends Controller
{
	public function actionIndex()
	{
		$this->render('index');
	}

    public function actionGetDynamicGroupList()
    {
        try
        {
            $adCampaignId = $_POST['campaign_id'];
            $adGroups = ADGroup::model()->findALL("campaign_id=:campaign_id and company_id=:company_id", array(":campaign_id"=>$adCampaignId, ":company_id"=>Yii::app()->session['user']->company_id));
            $adGroupList = "<option value=''>Choose a group...</option>";
            foreach($adGroups as $adGroup)
                $adGroupList .= "<option value='{$adGroup->id}'>{$adGroup->name}</option>";
            echo json_encode($adGroupList);
            exit();
        }
        catch(Exception $ex)
        {
            $result = array('status'=>'error', 'msg'=>"Exception, Code: ".$ex->getCode().", Msg: ".$ex->getMessage());
            echo json_encode($result);
        }
    }

    public function actionCreate($adcampaignid=null, $adgroupid=null, $lead=null)
    {
        $model = new ADAdvertise();

        if(isset($_POST['adgroup']))
        {
            exit();
        }

        if(!isset($adcampaignid) || !isset($adgroupid))
        {
            $this->render('chooseCampaignAndGroup');
            exit();
        }

        $this->render('create', array(
            'adCampaignId'=>$adcampaignid,
            'adGroupId'=>$adgroupid,
            'model'=>$model,
            'lead'=>$lead,
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
        $model=ADAdvertise::model()->findByPk($id, "company_id=:company_id" ,array(':company_id' => Yii::app()->session['user']->company_id));
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
            'postOnly + delete, getDynamicGroupList', // we only allow deletion via POST request
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
                'actions'=>array('index', 'create', 'view', 'update', 'getDynamicGroupList'),
                'users'=>array('@'),
            ),
            array('deny',  // deny all users
                'users'=>array('*'),
            ),
        );
    }
}