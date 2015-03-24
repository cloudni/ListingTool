<?php
/* @var $this EBayTargetAndTrackController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'E Bay Target And Tracks',
);

$this->menu=array(
	array('label'=>'Create eBayTargetAndTrack', 'url'=>array('create')),
	array('label'=>'Manage eBayTargetAndTrack', 'url'=>array('admin')),
);
?>

<h1>E Bay Target And Tracks</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
