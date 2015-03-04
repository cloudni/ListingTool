<?php
/* @var $this BulletinController */
/* @var $model Bulletin */

$this->breadcrumbs=array(
	'Bulletins'=>array('index'),
	$model->title=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Bulletin', 'url'=>array('index')),
	array('label'=>'Create Bulletin', 'url'=>array('create')),
	array('label'=>'View Bulletin', 'url'=>array('view', 'id'=>$model->id)),
);
?>

<h1>Update Bulletin <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_update', array('model'=>$model)); ?>