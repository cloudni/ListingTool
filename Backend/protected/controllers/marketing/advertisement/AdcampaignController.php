<?php

class AdcampaignController extends Controller
{
	public function actionIndex()
	{
        $dataProvider=new CActiveDataProvider(
            'ADCampaign',
            array
            (
                'sort'=>array(
                    'attributes'=>array(
                        'id', 'start_datetime', 'end_datetime', 'budget', 'status'
                    ),
                ),
                'pagination'=>array(
                    'pageSize'=>45,
                ),
            )
        );

		$this->render('index', array(
            "dataProvider"=>$dataProvider,
        ));
	}

    public function actionView($id)
    {
        $model = $this->loadModel($id);
        $this->layout='//layouts/column2';

        $this->render('view', array(
            "model"=>$model,
        ));
        $this->layout='';
    }

    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);
        $this->layout='//layouts/column2';

        $this->render('update', array(
            "model"=>$model,
        ));
        $this->layout='';
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
        $model=ADCampaign::model()->findByPk($id);
        if($model===null)
            throw new CHttpException(404,'The requested AD Campaign does not exist.');
        return $model;
    }

	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
}