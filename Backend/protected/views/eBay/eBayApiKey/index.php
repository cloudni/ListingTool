<?php
/* @var $this EBayApiKeyController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'eBay API Keys',
);

$this->menu=array(
	array('label'=>'Create eBay API Key', 'url'=>array('create')),
	array('label'=>'Manage eBay API Key', 'url'=>array('admin')),
);
?>

<h1>eBay API Keys</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
