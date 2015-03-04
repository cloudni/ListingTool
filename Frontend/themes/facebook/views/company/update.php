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

<div style="clear: both; width: 100%; position: relative; top: -5px;">
	<div class="borderBlock">
		<div>
			<div style="background: #f6f7f8; border-bottom: 1px solid #e9eaed; font-size: 12px;">
				<div style="height: 36px; color: #9197a3; font-weight: normal;">
					<h1 style="color: #4e5665; font-weight: 700; padding-left: 14px; line-height: 38px; position: relative;"><?php echo $model->name; ?></h1>
				</div>
			</div>
			<div style="display: block; padding: 0px 10px 0px 10px;">
				<?php $this->renderPartial('_form', array('model'=>$model)); ?>
			</div>
		</div>
	</div>
</div>
