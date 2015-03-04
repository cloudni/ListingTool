<?php
/* @var $this EbayentitytypeController */
/* @var $model eBayEntityType */

$this->breadcrumbs=array(
	'eBay Entity Types'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List eBayEntityType', 'url'=>array('index')),
	array('label'=>'Create eBayEntityType', 'url'=>array('create')),
	array('label'=>'View eBayEntityType', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage eBayEntityType', 'url'=>array('admin')),
);
?>

<h1>Update eBayEntityType <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>