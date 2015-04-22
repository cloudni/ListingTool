<?php
/* @var $this EbayentitytypeController */
/* @var $model eBayEntityType */

$this->breadcrumbs=array(
	'eBay Entity Types'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List eBayEntityType', 'url'=>array('index')),
	array('label'=>'Manage eBayEntityType', 'url'=>array('admin')),
);
?>

<h1>Create eBayEntityType</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>