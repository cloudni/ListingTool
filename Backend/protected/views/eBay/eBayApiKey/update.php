<?php
/* @var $this EBayApiKeyController */
/* @var $model eBayApiKey */

$this->breadcrumbs=array(
	'eBay API Keys'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List eBay API Key', 'url'=>array('index')),
	array('label'=>'Create eBay API Key', 'url'=>array('create')),
	array('label'=>'View eBay API Key', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage eBay API Key', 'url'=>array('admin')),
);
?>

<h1>Update eBay API Key <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>