<?php
/* @var $this EBayListingController */
/* @var $model eBayListing */

$this->breadcrumbs=array(
	'eBay Listings'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List eBayListing', 'url'=>array('index')),
	array('label'=>'Manage eBayListing', 'url'=>array('admin')),
);
?>

<h1>Create eBayListing</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>