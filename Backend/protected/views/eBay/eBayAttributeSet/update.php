<?php
/* @var $this EbayattributesetController */
/* @var $model eBayAttributeSet */
?>

<div style="width: 100%">
    <div id="content">

    <?php
    $this->breadcrumbs=array(
        'eBay Attribute Sets'=>array('index'),
        $model->name=>array('view','id'=>$model->id),
        'Update',
    );

    $this->menu=array(
        array('label'=>'List eBayAttributeSet', 'url'=>array('index')),
        array('label'=>'Create eBayAttributeSet', 'url'=>array('create')),
        array('label'=>'View eBayAttributeSet', 'url'=>array('view', 'id'=>$model->id)),
        array('label'=>'Delete eBayAttributeSet', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
    );
    ?>

    <h1>Update eBayAttributeSet <?php echo $model->id; ?></h1>

    <?php $this->renderPartial('_form', array('model'=>$model, 'attributeList'=>$attributeList, 'attributeCount'=>$attributeCount)); ?>

    </div>
</div>