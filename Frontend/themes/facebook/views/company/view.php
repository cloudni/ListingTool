<?php
/* @var $this CompanyController */
/* @var $model Company */

$this->pageTitle=Yii::app()->name . ' - '.ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'company_view_menu');
$this->breadcrumbs=array(
    ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'company_title')=>array('index'),
	$model->name,
);

$this->menu=array(
	/*array('label'=>'List Company', 'url'=>array('index')),
	array('label'=>'Create Company', 'url'=>array('create')),*/
	array('label'=>ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'company_update_menu'), 'url'=>array('update'/*, 'id'=>$model->id*/)),
	/*array('label'=>'Delete Company', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Company', 'url'=>array('admin')),*/
    array('label'=>"Finance", 'url'=>'http://local.java.it.net/portal-lt-frontend/company/transaction/list.shtml'),
);
?>

<style>
	table.detail-view th, table.detail-view td
	{
		font-size: 12px;
	}
</style>

<div style="clear: both; width: 100%; position: relative; top: -5px;">
	<div class="borderBlock">
		<div>
			<div style="background: #f6f7f8; border-bottom: 1px solid #e9eaed; font-size: 12px;">
				<div style="height: 36px; color: #9197a3; font-weight: normal;">
					<h1 style="color: #4e5665; font-weight: 700; padding-left: 14px; line-height: 38px; position: relative;"><?php echo $model->name; ?></h1>
				</div>
			</div>
			<div style="display: block;">
				<?php $this->widget('zii.widgets.CDetailView', array(
					'data'=>$model,
					'attributes'=>array(
						//'id',
						'name',
						'phone',
						'country',
					),
				)); ?>
			</div>
		</div>
	</div>
</div>


