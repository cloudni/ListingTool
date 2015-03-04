<?php
/* @var $this EBayListingController */
/* @var $model eBayListing */

$this->breadcrumbs=array(
	'eBay Listings'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List eBayListing', 'url'=>array('index')),
	array('label'=>'View eBayListing', 'url'=>array('view', 'id'=>$model->id)),
);
?>

<h1>Update eBayListing <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>