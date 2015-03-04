<?php
/* @var $this ResourceStringController */
/* @var $model ResourceString */

$this->breadcrumbs=array(
	'Resource Strings'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List ResourceString', 'url'=>array('index')),
	array('label'=>'Create ResourceString', 'url'=>array('create')),
	array('label'=>'View ResourceString', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage ResourceString', 'url'=>array('admin')),
);
?>

<h1>Update ResourceString <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>