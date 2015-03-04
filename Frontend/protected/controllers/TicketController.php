<?php

class TicketController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
    private $_model = null ;

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
				'actions'=>array('index','view','create','update'),
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
        $ticket=$this->loadModel($id,true);
        $reply=$this->createReply($ticket);
        self::setIsNewField($ticket->id,0); // set is_new true
        $this->render('view',array(
            'model'=>$ticket,
            'reply'=>$reply,
        ));
	}

    /**
     * reply ticket
     * @param $parentTicket
     * @return Ticket
     */
    protected function createReply($parentTicket)
    {
        $reply=new Ticket();
        if(isset($_POST['Ticket']))
        {
            $reply->attributes=$_POST['Ticket'];
            $reply->is_user = 0;
            if($parentTicket->addTicket($reply))
            {
                // update parent ticket is_new
                $updateTicket =  Ticket::model()->findbyPk($parentTicket->id);
                if($updateTicket->is_new==0)
                {
                    $updateTicket->is_new = 1;
                    $updateTicket->save();
                }
                Yii::app()->user->setFlash('replySubmitted',"Your reply has been added." );
                $this->refresh();
            }
        }
        return $reply;
    }


    protected function findReply($pid)
    {
        $sql = ' select lt.`id` as id,lt.`content` as content ,lt.`type` as type,lt.`is_repliable` as is_repliable,lt.`is_viewable` as is_viewable,lt.`create_time_utc` as create_time_utc,
                 case lt.`is_user` when 0 then lu.username else la.username end  as username
                 from lt_ticket lt
                 left join lt_admin la on la.id = lt.create_user_id
                 left join lt_user lu on lu.id = lt.create_user_id
                 where lt.parent_id =:parentId and lt.is_repliable =1 and lt.is_viewable = 1 order by lt.id asc ';
        $command = Yii::app()->db->createCommand($sql);
        $command->bindValue(":parentId", $pid, PDO::PARAM_INT);
        return $command->queryAll();
    }

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Ticket;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Ticket']))
		{
            $_POST['Ticket']['is_user'] =0;
			$model->attributes=$_POST['Ticket'];
            $model->is_new=1;
			if(!$model->save())
            {
                Yii::app()->user->setFlash('Error', "Fail to create new ticket!<br />Please try again.");
                $this->redirect('create');
            }

            $error = "";
            $targetDir = dirname(__FILE__) . DIRECTORY_SEPARATOR . "..".DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."upload";
            if (!file_exists($targetDir))  @mkdir($targetDir);
            $targetDir .= DIRECTORY_SEPARATOR.date("Y");
            if (!file_exists($targetDir))  @mkdir($targetDir);
            $targetDir .= DIRECTORY_SEPARATOR.date("m");
            if (!file_exists($targetDir))  @mkdir($targetDir);

            for($i=0;$i<count($_FILES['attach']['name']);$i++)
            {
                if(!$_FILES['attach']['error'][$i])
                {
                    $suffix = explode('.', $_FILES["attach"]["name"][$i]);
                    if(count($suffix)<=1) $suffix = ""; else $suffix = '.'.$suffix[count($suffix)-1];
                    $filename = time();
                    $index = 1;
                    while(file_exists($targetDir . DIRECTORY_SEPARATOR . $filename . $suffix))
                    {
                        $filename = $filename . "_" .$index;
                        $index++;
                    }
                    $filename .= $suffix;
                    move_uploaded_file($_FILES["attach"]["tmp_name"][$i], $targetDir . DIRECTORY_SEPARATOR . $filename);

                    $ticketAttach = new TicketAttachment();
                    $ticketAttach->company_id = Yii::app()->session['user']->company_id;
                    $ticketAttach->name = $filename;
                    $ticketAttach->is_delete = TicketAttachment::IS_DELETE_NO;
                    $ticketAttach->path = DIRECTORY_SEPARATOR."upload".DIRECTORY_SEPARATOR.date("Y").DIRECTORY_SEPARATOR.date("m");
                    $ticketAttach->size = $_FILES["attach"]["size"][$i];
                    $ticketAttach->ticket_id = $model->id;
                    $ticketAttach->type = $_FILES["attach"]["type"][$i];
                    $ticketAttach->view_url = $ticketAttach->path . DIRECTORY_SEPARATOR . $ticketAttach->name;
                    if(!$ticketAttach->save()) $error .= "Invalid file " . $_FILES["attach"]["name"][$i] . "<br />";
                }
                else
                {
                    if($_FILES["attach"]["name"][$i]) $error .= "Invalid file " . $_FILES["attach"]["name"][$i] . "<br />";
                }
            }
            if($error) Yii::app()->user->setFlash('Error', $error);
            Yii::app()->user->setFlash('Success', "Ticket submit successfully!");
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

		if(isset($_POST['Ticket']))
		{
			$model->attributes=$_POST['Ticket'];
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
        $dataProvider=new CActiveDataProvider('Ticket'
            ,array(
            'criteria' => array(
                'condition'=>'is_viewable = 1 and parent_id=0',
                'order'=>'id desc',
            ),));
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Ticket('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Ticket']))
			$model->attributes=$_GET['Ticket'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Ticket the loaded model
	 * @throws CHttpException
	 */
    public function loadModel($id,$withReply=false)
    {

        if($id==null){
            $id = $_GET['id'];
        }

        if($this->_model===null)
        {
            if($withReply)
            {
                $this->_model=Ticket::model()->findbyPk($id);
                $this->_model->replies = self::findReply($id);
            }
            else
            {
                $this->_model=Ticket::model()->findbyPk($id);
            }
            if($this->_model===null) throw new CHttpException(404,'The requested page does not exist.');
        }
        return $this->_model;
    }

    protected  function setIsNewField($id,$value=0)
    {
        $userId = Yii::app()->user->id;
        $ticket = Ticket::model()->findbyPk($id);

        // get last reply
        $sql = 'select lt.`id` as id,lt.`content` as content ,lt.`type` as type,lt.`is_repliable` as is_repliable,lt.`is_viewable` as is_viewable
                from lt_ticket lt
                left join lt_admin la on la.id = lt.create_user_id
                left join lt_user lu on lu.id = lt.create_user_id
                where lt.parent_id =:parentId
                and (case lt.`is_user` when 0 then lu.id else la.id end ) not in (:userId)
                and lt.id = (select max(id) from lt_ticket)';

        $command = Yii::app()->db->createCommand($sql);
        $command->bindValue(":parentId", $ticket->id, PDO::PARAM_INT);
        $command->bindValue(":userId", $userId, PDO::PARAM_INT);
        $lastTicket = $command->queryAll();
        if($lastTicket)
        {
            $ticket->is_new=$value;
            $ticket->save();
            $lticket = Ticket::model()->findbyPk($lastTicket[0]['id']);
            $lticket->is_new =$value;
            $lticket->save();
        }
    }

	/**
	 * Performs the AJAX validation.
	 * @param Ticket $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='ticket-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
