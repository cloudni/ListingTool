<?php
$this->breadcrumbs=array(
	'Picture Folders'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List PictureFolder', 'url'=>array('index')),
	array('label'=>'Create PictureFolder', 'url'=>array('create')),
	array('label'=>'View PictureFolder', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage PictureFolder', 'url'=>array('admin')),
);
?>

<h1>Update PictureFolder <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>