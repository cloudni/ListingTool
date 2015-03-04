<?php
/* @var $this EbayattributeController */
/* @var $model eBayAttribute */

$this->breadcrumbs=array(
	'eBay Attributes'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List eBayAttribute', 'url'=>array('index')),
	array('label'=>'Manage eBayAttribute', 'url'=>array('admin')),
);
?>

<h1>Create eBayAttribute</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>