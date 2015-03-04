<?php
/* @var $this EbayattributeController */
/* @var $model eBayAttribute */

$this->breadcrumbs=array(
	'eBay Attributes'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List eBayAttribute', 'url'=>array('index')),
	array('label'=>'Create eBayAttribute', 'url'=>array('create')),
	array('label'=>'View eBayAttribute', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage eBayAttribute', 'url'=>array('admin')),
);
?>

<h1>Update eBayAttribute <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>