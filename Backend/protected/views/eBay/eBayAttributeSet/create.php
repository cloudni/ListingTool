<?php
/* @var $this EbayattributesetController */
/* @var $model eBayAttributeSet */
?>

<div style="width: 100%">
    <div id="content">

    <?php
    $this->breadcrumbs=array(
        'eBay Attribute Sets'=>array('index'),
        'Create',
    );

    $this->menu=array(
        array('label'=>'List eBayAttributeSet', 'url'=>array('index')),
        //array('label'=>'Manage eBayAttributeSet', 'url'=>array('admin')),
    );
    ?>

    <h1>Create eBayAttributeSet</h1>

    <?php $this->renderPartial('_form', array('model'=>$model, 'attributeList'=>$attributeList, 'attributeCount'=>$attributeCount)); ?>

    </div>
</div>