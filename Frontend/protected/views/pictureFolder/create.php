<?php
$this->breadcrumbs=array(
	'Picture Folders'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List PictureFolder', 'url'=>array('index')),
	array('label'=>'Manage PictureFolder', 'url'=>array('admin')),
);
?>

<h1>Create PictureFolder</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>