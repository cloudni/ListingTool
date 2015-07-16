<?php

Yii::import('application.vendor.eBay.*');
require_once 'eBayTradingAPI.php';

class EBayAttributeSetController extends Controller
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
				'actions'=>array('index','view', 'create','update','delete', 'testGetSellerList'),
				'users'=>array('@'),
			),
			/*array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin'),
				'users'=>array('admin'),
			),*/
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
        $model = $this->loadModel($id);

        $attributes = eBayEntityAttribute::model()->findAll(
            'attribute_set_id=:attribute_set_id',
            array(
                ':attribute_set_id'=>$model->id,
            )
        );
        $attributeList = array();
        if(!empty($attributes))
        foreach($attributes as $attribute)
        {
            $attributeList[] = array(
                "id"=>(int)$attribute->id,
                'pId'=>(int)$attribute->parent_id,
                'name'=>$attribute->eBayAttribute->name,
            );
        }

		$this->render('view',array('model'=>$model,'attributeList'=>$attributeList));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new eBayAttributeSet;

        $this->layout = "";

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

        if(isset($_POST['eBayAttributeSet']))
        {
            if($this->saveeBayAttributeSet($model))
                $this->redirect(array('view','id'=>$model->id));
        }

		$this->render('create',array(
			'model'=>$model,
            'attributeList'=>array(),
            'attributeCount'=>0,
		));

        $this->layout='//layouts/column2';
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

        $this->layout = "";

        $attributes = eBayEntityAttribute::model()->findAll(
            'attribute_set_id=:attribute_set_id',
            array(':attribute_set_id'=>$model->id,)
        );
        $attributeList = array();
        if(!empty($attributes))
            foreach($attributes as $attribute)
            {
                $attributeList[] = array(
                    "id"=>(int)$attribute->id,
                    'pId'=>(int)$attribute->parent_id,
                    'attribute_id'=>(int)$attribute->eBayAttribute->id,
                    'name'=>$attribute->eBayAttribute->name." (".$attribute->eBayAttribute->getBackendTypeText().")",
                    'open'=>'true',
                );
            }

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

        if(isset($_POST['eBayAttributeSet']))
		{
            if($this->saveeBayAttributeSet($model))
                $this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
            'attributeList'=>$attributeList,
            'attributeCount'=>count($attributes),
		));

        $this->layout='//layouts/column2';
	}

    /*
     * execute create or update eBay attribute set
     * along with attributes and their relationship
     * @param eBayAttributeSet $model, the object of the eBay attribute set to create or update
     */
    protected function saveeBayAttributeSet($model)
    {
        $model->attributes=$_POST['eBayAttributeSet'];
        $attributes = json_decode($_POST['ebay_attribute_set'], true);

        try
        {
            $transaction= Yii::app()->db->beginTransaction();
            $newSet = false;
            //prepare ebay attribute group
            if($model->isNewRecord)
            {
                $eBayAttributeGroup = new eBayAttributeGroup();
                $eBayAttributeGroup->name = 'auto generate by system';
                $newSet = true;
            }
            else
            {
                $eBayAttributeGroup = eBayAttributeGroup::model()->findByPK($model->eBayAttributeGroups[0]->id);
            }

            //save ebay attribute set first
            if(!$model->save())
            {
                $transaction->rollback();
                return false;
            }

            //save default ebay attribute group
            $eBayAttributeGroup->attribute_set_id = $model->id;
            if(!$eBayAttributeGroup->save())
            {
                $transaction->rollback();
                return false;
            }

            $parentIndexRefer = array();
            //check and save every attribute
            if(!empty($attributes))
            foreach($attributes as $attribute)
            {
                if(substr($attribute['id'], 0, 4) == "new_") //insert new entity attributes
                {
                    if(!eBayAttribute::model()->findByPK($attribute['attribute_id'])) continue;

                    if(!empty($attribute['parent_id']) && $attribute['parent_id']!="0")
                    {
                        if(substr($attribute['parent_id'], 0, 4) == "new_")
                        {
                            if(!isset($parentIndexRefer[$attribute['parent_id']])) continue;
                            if(!eBayAttribute::model()->findByPK($parentIndexRefer[$attribute['parent_id']]['attribute_id'])) continue;
                            $attribute['parent_id'] = $parentIndexRefer[$attribute['parent_id']]['id'];
                        }
                        else
                        {
                            $query = "SELECT attribute_id FROM lt_ebay_entity_attribute where id=".(int)$attribute['parent_id']."; ";
                            $result = Yii::app()->db->createCommand($query)->queryAll();
                            if(count($result)<1) continue;
                            if(!eBayAttribute::model()->findByPK($result[0]['attribute_id'])) continue;
                        }
                    }
                    else
                    {
                        $attribute['parent_id'] = 0;
                    }

                    $insert = "INSERT INTO `lt_ebay_entity_attribute` (`entity_type_id`, `attribute_set_id`, `attribute_group_id`, `attribute_id`, `parent_id`, `sort_order`, `is_required`, `is_unique`, `create_time_utc`, `create_admin_id`, `update_time_utc`, `update_admin_id`)
                            VALUES(:entity_type_id, :attribute_set_id, :attribute_group_id, :attribute_id, :parent_id, :sort_order, :is_required, :is_unique, :create_time_utc, :create_admin_id, :update_time_utc, :update_admin_id); ";
                    $command = Yii::app()->db->createCommand($insert);
                    $command->bindValue(":entity_type_id", $model->entity_type_id, PDO::PARAM_INT);
                    $command->bindValue(":attribute_set_id", $model->id, PDO::PARAM_INT);
                    $command->bindValue(":attribute_group_id", $eBayAttributeGroup->id, PDO::PARAM_INT);
                    $command->bindValue(":attribute_id", $attribute['attribute_id'], PDO::PARAM_INT);
                    $command->bindValue(":parent_id", $attribute['parent_id'], PDO::PARAM_INT);
                    $command->bindValue(":sort_order", 0, PDO::PARAM_INT);
                    $command->bindValue(":is_required", 0, PDO::PARAM_INT);
                    $command->bindValue(":is_unique", 0, PDO::PARAM_INT);
                    $command->bindValue(":create_time_utc", time(), PDO::PARAM_INT);
                    $command->bindValue(":create_admin_id", Yii::app()->user->id, PDO::PARAM_INT);
                    $command->bindValue(":update_time_utc", time(), PDO::PARAM_INT);
                    $command->bindValue(":update_admin_id", Yii::app()->user->id, PDO::PARAM_INT);
                    $command->execute();

                    $parentIndexRefer[$attribute['id']] = array('id'=>Yii::app()->db->getLastInsertID(), 'attribute_id'=>$attribute['attribute_id']);
                }
                else //update current entity attributes
                {
                    if(!eBayAttribute::model()->findByPK($attribute['attribute_id'])) continue;

                    if(!empty($attribute['parent_id']) && $attribute['parent_id']!="0")
                    {
                        if(substr($attribute['parent_id'], 0, 4) == "new_")
                        {
                            if(!isset($parentIndexRefer[$attribute['parent_id']])) continue;
                            if(!eBayAttribute::model()->findByPK($parentIndexRefer[$attribute['parent_id']]['attribute_id'])) continue;
                            $attribute['parent_id'] = $parentIndexRefer[$attribute['parent_id']]['id'];
                        }
                        else
                        {
                            $query = "SELECT attribute_id FROM lt_ebay_entity_attribute where id=".(int)$attribute['parent_id']."; ";
                            $result = Yii::app()->db->createCommand($query)->queryAll();
                            if(count($result)<1) continue;
                            if(!eBayAttribute::model()->findByPK($result[0]['attribute_id'])) continue;
                        }
                    }
                    else
                    {
                        $attribute['parent_id'] = 0;
                    }

                    $update = "update `lt_ebay_entity_attribute` set
                                   `entity_type_id`=:entity_type_id,
                                   `attribute_set_id`=:attribute_set_id,
                                   `attribute_group_id`=:attribute_group_id,
                                   `attribute_id`=:attribute_id,
                                   `parent_id`=:parent_id,
                                   `sort_order`=:sort_order,
                                   `is_required`=:is_required,
                                   `is_unique`=:is_unique,
                                   `create_time_utc`=:create_time_utc,
                                   `create_admin_id`=:create_admin_id,
                                   `update_time_utc`=:update_time_utc,
                                   `update_admin_id`=:update_admin_id
                               where `id`=:id; ";
                    $command = Yii::app()->db->createCommand($update);
                    $command->bindValue(":entity_type_id", $model->entity_type_id, PDO::PARAM_INT);
                    $command->bindValue(":attribute_set_id", $model->id, PDO::PARAM_INT);
                    $command->bindValue(":attribute_group_id", $eBayAttributeGroup->id, PDO::PARAM_INT);
                    $command->bindValue(":attribute_id", $attribute['attribute_id'], PDO::PARAM_INT);
                    $command->bindValue(":parent_id", $attribute['parent_id'], PDO::PARAM_INT);
                    $command->bindValue(":sort_order", 0, PDO::PARAM_INT);
                    $command->bindValue(":is_required", 0, PDO::PARAM_INT);
                    $command->bindValue(":is_unique", 0, PDO::PARAM_INT);
                    $command->bindValue(":create_time_utc", time(), PDO::PARAM_INT);
                    $command->bindValue(":create_admin_id", Yii::app()->user->id, PDO::PARAM_INT);
                    $command->bindValue(":update_time_utc", time(), PDO::PARAM_INT);
                    $command->bindValue(":update_admin_id", Yii::app()->user->id, PDO::PARAM_INT);
                    $command->bindValue(":id", $attribute['id'], PDO::PARAM_INT);
                    $command->execute();
                }
            }

            //remove deleted attributes
            $dbEntityAttributes = $model->eBayEntityAttributes;
            foreach($dbEntityAttributes as $dbEntityAttribute)
            {
                $is_found = false;
                foreach($attributes as $attribute)
                {
                    if($dbEntityAttribute->attribute_id == $attribute["attribute_id"] && ($dbEntityAttribute->parent_id == $attribute["parent_id"] || (!$dbEntityAttribute->parent_id && !$attribute["parent_id"]))) {
                        $is_found = true;
                        break;
                    }
                }
                if(!$is_found) {
                    $dbEntityAttribute->delete();
                }
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
        $dataProvider=new CActiveDataProvider('eBayAttributeSet');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	/*public function actionAdmin()
	{
		$model=new eBayAttributeSet('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['eBayAttributeSet']))
			$model->attributes=$_GET['eBayAttributeSet'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}*/

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return eBayAttributeSet the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=eBayAttributeSet::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param eBayAttributeSet $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='e-bay-attribute-set-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
