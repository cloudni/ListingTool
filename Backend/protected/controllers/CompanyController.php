<?php

class CompanyController extends Controller
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
				'actions'=>array('index','view','modify','updateUser','editUser','rename','drop','manageClient','addUser','addDepartment'),
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

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		/*$this->render('view',array(
			'model'=>$this->loadModel($id),
		));*/
        $model=new Company;
        $result = $this->loadModel($id);
        $attributes = array();
        $attributes[] = $this->getTreeDataForCompanyRC($result);
            $this->render('create',array(
            'model'=>$model,
            'attributes'=>$attributes
        ));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionIndex2()
	{
		$model=new Company;
        $result = Company::model()->findAll();
        $attributes = array();
        if(count($result) > 0)
        {
            foreach($result as $row)
            {
                $attributes[] = $this->getTreeDataForCompanyRC($row);
            }
        }

		if(isset($_POST['Company']))
		{
			$model->attributes=$_POST['Company'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
            'attributes'=>$attributes
		));
	}
    private function getTreeDataForCompanyRC($company)
    {
        $self = array(
            'id'=>$company->id,
            'name'=>$company->name,
            'type'=>0,
            'icon'=>'../../images/1.png'
            /*'departmentId'=>$company->departments->id,
            'departmentName'=>$company->departments->name,
            'userId'=>$company->users->id,
            'userName'=>$company->users->username,*/
        );

       if(!empty($company->departments))
        {
            $self['children'] = array();
            $departments= Department::model()->findAll("company_id=:company_id and parent_id is null",array(":company_id"=>$company->id));
            foreach($departments as $child)
            {
                $self['children'][] = $this->getTreeDataForDepartmentRC($child);

            }
            if(!empty($company->users)){
                foreach($company->users as $child)
                {
                    if(empty($child->department_id)){
                        $self['children'][] = $this->getTreeDataForUserRC($child);
                    }
                }
            }
        }
        else
        {
            $self['children'] = array();
            if(!empty($company->users))
            {
                foreach($company->users as $child)
                {
                    $self['children'][] = $this->getTreeDataForUserRC($child);
                }
            }
        }

        return $self;
    }
    private function getTreeDataForUserRC($users)
    {
        $self = array(
            'id'=>$users->id,
            'name'=>$users->username."  (User)",
            'type'=>2,
        );
        return $self;
    }
    private function getTreeDataForDepartmentRC($department)
    {
        //==var_dump($department);
        $self = array(
            'id'=>$department->id,
            'name'=>$department->name."  (Department)",
            'type'=>1,
            'icon'=>'../../images/3.png'

        );
        if(!empty($department->subDepartment))
        {
            $self['children'] = array();
            foreach($department->subDepartment as $child)
            {
                $self['children'][] = $this->getTreeDataForDepartmentRC($child);

            }
            if(!empty($department->users))
            {
                foreach($department->users as $child)
                {
                    $self['children'][] = $this->getTreeDataForUserRC($child);
                }
            }
        }
        else
        {
            $self['children'] = array();
            if(!empty($department->users))
            {
                foreach($department->users as $child)
                {
                    $self['children'][] = $this->getTreeDataForUserRC($child);
                }
            }
        }


        return $self;
    }
    private function getSubDepartment($department)
    {

        if(!empty($department->subDepartment))
        {
            foreach($department->subDepartment as $child)
            {
                if(!empty($department->parentDepartment))
                {
                    $child->parent_id=$department->parentDepartment->id;
                }
                else
                {
                    $child->parent_id=null;
                }
                if(!$child->save(false))
                {
                }

            }
            if(!empty($department->users))
            {
                foreach($department->users as $child)
                {
                    if(!empty($department->parentDepartment))
                    {
                        $child->department_id=$department->parentDepartment->id;
                    }
                    else{ $child->department_id=null;}
                    if(!$child->save(false))
                    {

                    }
                }
            }
        }
        else
        {
            if(!empty($department->users))
            {
                foreach($department->users as $child)
                {
                    if(!empty($department->parentDepartment))
                    {
                        $child->department_id=$department->parentDepartment->id;
                    }
                    else{ $child->department_id=null;}

                    if(!$child->save(false))
                    {

                    }
                }
            }
        }
            if(!$department->delete())
            {

            }

    }
	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionManageClient($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Company']))
		{
			$model->attributes=$_POST['Company'];
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
	public function actionDelete()
	{
        $type = $_POST["type"];
        $id = $_POST["id"];
        if($type==0){

        }
        else if($type==1){

        }
        else if($type==2){

        }
		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}
    public function actionDrop()
    {
        $transaction= Yii::app()->db->beginTransaction();
        $message="";
        try
        {
        $treeType=$_POST["treeType"];
        $targetType=$_POST["targetType"];
        $treeId=$_POST["treeId"];
        $targetId=$_POST["targetId"];

        if($treeType==1&&$targetType==1)
        {
            $department=Department::model()->findByPk($treeId);
            $department2=Department::model()->findByPk($targetId);
            if($department->company_id==$department2->company_id)
            {
                $department->parent_id=$targetId;

                if(!$department->save(false))
                {
                    $transaction->rollback();
                    return false;
                }
                $message="success";
            }
            else{
                $message="error";
            }

        }
        else if($treeType==2&&$targetType==1)
        {
            $user=User::model()->findByPk($treeId);
            $department2=Department::model()->findByPk($targetId);
            if($user->company_id==$department2->company_id)
            {
                $user->department_id=$targetId;

                if(!$user->save(false))
                {
                    $transaction->rollback();
                    return false;
                }
                $message="success";
            }
            else{
                $message="error";
            }

        }
        else if($treeType==1&&$targetType==0)
        {
            $department=Department::model()->findByPk($treeId);
            $company=Company::model()->findByPk($targetId);
            if($department->company_id==$company->id)
            {
                $department->parent_id=null;

                if(! $department->save(false))
                {
                    $transaction->rollback();
                    return false;
                }
                $message="success";
            }
            else{
                $message="error";
            }

        }
        else if($treeType==2&&$targetType==0)
        {
            $user=User::model()->findByPk($treeId);
            $company=Company::model()->findByPk($targetId);
            if($user->company_id==$company->id)
            {
                $user->department_id=null;
                if(!$user->save(false))
                {
                    $transaction->rollback();
                    return false;
                }

                $message="success";
            }
            else{
                $message="error";
            }

        }
       else{
           $message="error";
       }
        echo json_encode($message);
        $transaction->commit();
    }
        catch(Exception $ex)
        {
            $transaction->rollback();
            $message="error";
        }
    }
    public function actionEditUser()
    {
        $transaction= Yii::app()->db->beginTransaction();
        try
        {
        $userName = $_POST["userName"];
        $id = $_POST["id"];
        $password=$_POST["password"];
        $user=User::model()->findByPk($id);
        $user->username=$userName;
        $user->email=$_POST["email"];
        $user->password=User::model()->encrypt($password);
        if(! $user->save(false))
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
    }
    public function actionAddUser()
    {
        $transaction= Yii::app()->db->beginTransaction();
        try
        {
        $userName = $_POST["userName"];
        $password=$_POST["password"];
        $user=new User();
        $user->username=$userName;
        $user->password=User::model()->encrypt($password);
        $user->company_id=$_POST["companyId"];
        $user->department_id=$_POST["departmentId"];
        $user->email=$_POST["email"];
        if(!$user->save(false))
        {
            $transaction->rollback();
            return false;
         }
            $transaction->commit();
            echo json_encode($user->id);
        }
        catch(Exception $ex)
        {
            $transaction->rollback();
            return false;
        }
    }
    public function actionAddDepartment()
    {
        $transaction= Yii::app()->db->beginTransaction();
        try
        {
        $name = $_POST["name"];
        $parentId=$_POST["parentId"];
        $departmentCompanyId=$_POST["departmentCompanyId"];
        $Department=new Department();
        $Department->name=$name;
        $Department->company_id=$departmentCompanyId;
        $Department->parent_id=$parentId;
            if(!$Department->save(false))
            {
                $transaction->rollback();
                return false;
            }
            $transaction->commit();
            echo json_encode($Department->id);
        }
        catch(Exception $ex)
        {
            $transaction->rollback();
            return false;
        }
    }
    public function actionUpdateUser()
    {
        $id = $_POST["id"];
        $type = $_POST["type"];
        $result=array();
        if($type==2)
        {
            $user=User::model()->findByPk($id);
            $result = array('userName'=>$user->username, 'email'=>$user->email,'passWord'=>$user->password,'id'=>$user->id);

        }
        if($type==1)
        {
            $department=Department::model()->findByPk($id);
            $result = array( 'companyId'=>$department->company_id,'departmentId'=>$department->id);

        }

        echo json_encode($result);
    }
    public  function actionModify()
    {
        $transaction= Yii::app()->db->beginTransaction();
        try
        {
        $type = $_POST["type"];
        $id = $_POST["id"];

        if($type==0)
        {
            $company=$this->loadModel($id);
            $departments=$company->departments;
            $users=$company->users;
            foreach($departments as $department)
            {
                if(!$department->delete())
                {
                    $transaction->rollback();
                    return false;
                }
            }
            foreach($users as $user)
            {

                if(!$user->delete())
                {
                    $transaction->rollback();
                    return false;
                }
            }
            if(!$company->delete())
            {
                $transaction->rollback();
                return false;
            }

        }
        else if($type==1){
            $department=Department::model()->findByPk($id);
            $subDepartments=$department->subDepartment;
            $users=$department->users;
            if(!empty($subDepartments))
            {
                $this->getSubDepartment($department);
            }
            if(!empty($department->users))
            {
                    foreach($department->users as $child)
                    {
                        if(!empty($department->parentDepartment))
                        {
                            $child->department_id=$department->parentDepartment->id;
                        }
                        else{ $child->department_id=null;}

                        if(!$child->save(false))
                        {
                            $transaction->rollback();
                            return false;
                        }
                    }
                }

                if(!$department->delete())
                {
                    $transaction->rollback();
                    return false;
                }
            }
        else if($type==2){
            $user=User::model()->findByPk($id);

            if(! $user->delete())
            {
                $transaction->rollback();
                return false;
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
    }
    public  function actionRename()
    {
        $transaction= Yii::app()->db->beginTransaction();
        try
        {
        $type = $_POST["type"];
        $id = $_POST["id"];
        $newName= $_POST["newName"];

        if($type==0)
        {
            $company=$this->loadModel($id);
            $company->name=$newName;
            if(!$company->save(false))
            {
                $transaction->rollback();
                return false;
            }

        }
        else if($type==1){
            $department=Department::model()->findByPk($id);
            $department->name=str_replace("(Department)","",$newName);
            if(!$department->save(false))
            {
                $transaction->rollback();
                return false;
            }

        }
        else if($type==2){
            $user=User::model()->findByPk($id);
            $user->username=str_replace("(User)","",$newName);
            if(!$user->save(false))
            {
                $transaction->rollback();
                return false;
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
    }
	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Company');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Company('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Company']))
			$model->attributes=$_GET['Company'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Company the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Company::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Company $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='company-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

}
