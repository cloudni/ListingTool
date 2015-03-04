<?php

class PictureController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout= null; //'//layouts/column2';

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
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('index','view','create','update','getPage','batchPicture', 'uploadTest', 'uploadSubmit'),
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

    public function actionUploadSubmit()
    {
        $targetDir = dirname(__FILE__) . DIRECTORY_SEPARATOR . "..".DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."upload";
        $cleanupTargetDir = true; // Remove old files
        $maxFileAge = 10 * 60 * 60; // Temp file age in seconds
        if (!file_exists($targetDir))  @mkdir($targetDir);
        $targetDir .= DIRECTORY_SEPARATOR.date("Y");
        if (!file_exists($targetDir))  @mkdir($targetDir);
        $targetDir .= DIRECTORY_SEPARATOR.date("m");
        if (!file_exists($targetDir))  @mkdir($targetDir);

        // Get a file name
        if (isset($_REQUEST["name"])) {
            $fileName = $_REQUEST["name"];
        } elseif (!empty($_FILES)) {
            $fileName = $_FILES["file"]["name"];
        } else {
            $fileName = uniqid("file_");
        }

        //set file path
        $filePath = $targetDir . DIRECTORY_SEPARATOR . $fileName;

        // Chunk might be enabled
        $chunk = isset($_REQUEST["chunk"]) ? intval($_REQUEST["chunk"]) : 0;
        $chunks = isset($_REQUEST["chunks"]) ? intval($_REQUEST["chunks"]) : 0;

        // Remove old temp files
        if ($cleanupTargetDir)
        {
            if (!is_dir($targetDir) || !$dir = opendir($targetDir)) {
                die('{"jsonrpc" : "2.0", "error" : {"code": 100, "message": "Failed to open temp directory."}, "id" : "id"}');
            }

            while (($file = readdir($dir)) !== false) {
                $tmpfilePath = $targetDir . DIRECTORY_SEPARATOR . $file;

                // If temp file is current file proceed to the next
                if ($tmpfilePath == "{$filePath}.part") {
                    continue;
                }

                // Remove temp file if it is older than the max age and is not the current file
                if (preg_match('/\.part$/', $file) && (filemtime($tmpfilePath) < time() - $maxFileAge)) {
                    @unlink($tmpfilePath);
                }
            }
            closedir($dir);
        }

        // Open temp file
        if (!$out = @fopen("{$filePath}.part", $chunks ? "ab" : "wb")) {
            die('{"jsonrpc" : "2.0", "error" : {"code": 102, "message": "Failed to open output stream."}, "id" : "id"}');
        }

        if (!empty($_FILES)) {
            if ($_FILES["file"]["error"] || !is_uploaded_file($_FILES["file"]["tmp_name"])) {
                die('{"jsonrpc" : "2.0", "error" : {"code": 103, "message": "Failed to move uploaded file."}, "id" : "id"}');
            }

            // Read binary input stream and append it to temp file
            if (!$in = @fopen($_FILES["file"]["tmp_name"], "rb")) {
                die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');
            }
        } else {
            if (!$in = @fopen("php://input", "rb")) {
                die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');
            }
        }

        while ($buff = fread($in, 4096))
        {
            fwrite($out, $buff);
        }

        @fclose($out);
        @fclose($in);

        // Check if file has been uploaded
        if (!$chunks || $chunk == $chunks - 1)
        {
            // Strip the temp .part suffix off
            rename("{$filePath}.part", $filePath);
        }
        sleep(1);
        $rename = time() . substr($fileName, strlen($fileName)-4, 4);
        rename ($filePath, $targetDir . DIRECTORY_SEPARATOR . $rename);
        $img_info = getimagesize($targetDir . DIRECTORY_SEPARATOR . $rename);
        $picture = new Picture();
        $picture->company_id =Yii::app()->session['user']->company_id;
        $picture->name = $rename;
        $picture->is_delete = false;
        $picture->folder_id = $_POST['folderId'];
        $picture->type = $img_info['mime'];
        $picture->width = $img_info[0];
        $picture->height = $img_info[1];
        $picture->file_path=DIRECTORY_SEPARATOR.date("Y").DIRECTORY_SEPARATOR.date("m");
        $picture->save(false);

        // Return Success JSON-RPC response
        die('{"jsonrpc" : "2.0", "result" : null, "id" : "id"}');
    }

    public function actionUploadTest()
    {
        $this->render('uploadTest',array(
        ));
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
		$model=new Picture;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Picture']))
		{
			$model->attributes=$_POST['Picture'];
            $model->company_id = Yii::app()->session['user']->company_id;
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

		if(isset($_POST['Picture']))
		{
			$model->attributes=$_POST['Picture'];
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

       // $pictures = $this->getPageList();
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
            'pictureFolder'=>$pictureFolder
        ));
	}

    public function actionGetPage()
    {
        $folder_id = intval($_POST['folderId']);
        $currentPage = intval($_POST['currentPage']);
        $pictures = $this->getPageList($folder_id,$currentPage);
        $result = array('status'=>'success','lists'=>$pictures);
        echo json_encode($result);
    }

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Picture('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Picture']))
			$model->attributes=$_GET['Picture'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Picture the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Picture::model()->findByPk($id, "company_id=:company_id" ,array(':company_id' => Yii::app()->session['user']->company_id));
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
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

    public function getPageList($folderId=null,$currentPage=0,$pageSize=10)
    {
        $conditions = ($folderId==null||$folderId<=0)?'':' and folder_id='.$folderId;
        $sql = " select id,name,folder_id,`type`,width,height,title,file_path from lt_picture where company_id=".Yii::app()->session['user']->company_id.$conditions." order by id desc";
        $result = Yii::app()->db->createCommand($sql)->queryAll();
        $totalPage = ceil(count($result)/$pageSize);
        $startPage = $currentPage*$pageSize;
        $pages['total'] = count($result);
        $pages['pageSize'] = $pageSize;
        $pages['totalPage'] = $totalPage;

        $result=Yii::app()->db->createCommand($sql." LIMIT :offset,:limit");
        $result->bindValue(':offset', $startPage);
        $result->bindValue(':limit', $pageSize);
        $pictures=$result->queryAll();
        return array('pictures'=>$pictures,'pages'=>$pages);
    }


    public function actionBatchPicture()
    {
        $ids = $_POST['ids'];
        try
        {
            $transaction= Yii::app()->db->beginTransaction();
            if(count($ids)>0)
            {
                foreach($ids as $k => $v){
                    $this->loadModel(intval($v))->delete();
                }
                $transaction->commit();
                $result = array('status'=>'success','data'=>$ids);
            }
            else
            {
                $transaction->rollback();
                $result = array('status'=>'error','errorMsg'=>'delete failed');
            }

        }
        catch (Exception $ex)
        {
            $transaction->rollback();
            $result = array('status'=>'error','errorMsg'=>'delete failed');
        }
        echo json_encode($result);
    }

	/**
	 * Performs the AJAX validation.
	 * @param Picture $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='picture-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
