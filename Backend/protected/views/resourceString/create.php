<?php
/* @var $this ResourceStringController */
/* @var $model ResourceString */

$this->breadcrumbs=array(
	'Resource Strings'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List ResourceString', 'url'=>array('index')),
	array('label'=>'Manage ResourceString', 'url'=>array('admin')),
);
?>

<h1>Create ResourceString</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>