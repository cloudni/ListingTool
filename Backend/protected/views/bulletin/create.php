<?php
/* @var $this BulletinController */
/* @var $model Bulletin */

$this->breadcrumbs=array(
	'Bulletins'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Bulletin', 'url'=>array('index')),
);
?>

<h1>Create Bulletin</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>