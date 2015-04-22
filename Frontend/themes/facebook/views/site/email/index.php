<?php
/* @var $this SiteController */
$this->pageTitle=Yii::app()->name . ' - ' . $model->title;
?>
<div class="view">
    <div class="row">
        <h1>nirvana -- <?php echo $model->purpose;?></h1>
    </div>
    <div class="row">
        sender:<?php echo $model->sender; ?>
    </div>
    <div class="row">
        recipient:<?php echo $model->recipient; ?>
    </div>
    <div class="row">
        date:<?php echo $model->date; ?>
    </div>
</div>
<div class="view">
    <?php $this->renderPartial("email/" . $model->content,array(
        'model'=>$model,
    )); ?>
</div>
<div class="view">
    company desc.
</div>