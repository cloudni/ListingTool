<?php
/* @var $this EBayApiKeyController */
/* @var $model eBayApiKey */

$this->breadcrumbs=array(
	'eBay API Keys'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List eBay API Key', 'url'=>array('index')),
	array('label'=>'Manage eBay API Key', 'url'=>array('admin')),
);
?>

<h1>Create eBay API Key</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>