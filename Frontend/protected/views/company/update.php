<?php
/* @var $this CompanyController */
/* @var $model Company */

$this->pageTitle=Yii::app()->name . ' - '.ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'company_update_menu');
$this->breadcrumbs=array(
    ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'company_title')=>array('index'),
	$model->name=>array('view','id'=>$model->id),
    ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'btn_update'),
);

$this->menu=array(
	/*array('label'=>'List Company', 'url'=>array('index')),
	array('label'=>'Create Company', 'url'=>array('create')),*/
	array('label'=>ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'company_view_menu'), 'url'=>array('view'/*, 'id'=>$model->id*/)),
	//array('label'=>'Manage Company', 'url'=>array('admin')),
);
?>

<h1><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'company_update_menu') ;?><?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>