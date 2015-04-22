<?php
/* @var $this ResourceStringController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Resource Strings',
);

$this->menu=array(
	array('label'=>'Create ResourceString', 'url'=>array('create')),
	array('label'=>'Manage ResourceString', 'url'=>array('admin')),
);
?>

<h1>Resource Strings</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
