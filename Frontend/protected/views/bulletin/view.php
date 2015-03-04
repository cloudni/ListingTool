<?php
/* @var $this BulletinController */
/* @var $model Bulletin */
$this->pageTitle=Yii::app()->name . ' - '.Yii::t('models/Bulletins','View Bulletin');
?>


<div style="width: 990px;margin-top: 15px;">
    <div class="title" style="width:400px;margin: 0px auto ;">
        <div style="text-align: center;font-size: 18px;">
            <span><?php echo $model->title; ?></span>
        </div>
        <div style="word-break: break-all;margin-top: 15px;">
            <span>
                <?php echo $model->content ?>
            </span>
        </div>
    </div>
</div>
