<?php
/* @var $this ProductFolderController */
/* @var $model ProductFolder */

$this->breadcrumbs=array(
	'Product Folders'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List ProductFolder', 'url'=>array('index')),
);
?>

<h1>Create ProductFolder</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>