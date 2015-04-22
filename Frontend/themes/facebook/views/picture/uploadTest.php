<?php
/**
 * Created by PhpStorm.
 * User: cloud
 * Date: 14-11-17
 * Time: 10:04am
 */

$this->breadcrumbs=array(
    'Pictures'=>array('index'),
    'Upload Test',
);
?>

<div class="form">
    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'upload_test_form',
        'enableAjaxValidation'=>false,
    )); ?>
    <div>
        <?php $this->widget('ext.Plupload.Plupload',array(
            'form_id'=>'upload_test_form',
            'submitURL'=>'/picture/uploadsubmit',
            'max_file_count'=>20,
            'mime_types'=>array('Image_files'),
            'views'=>array('list'=>'true','thumbs'=>'true', 'active'=>'thumbs', )
        ));?>
    </div>
    <hr /><br/>
    <div>
        <input type="submit" value="Submit">
    </div>
    <?php $this->endWidget(); ?>
</div>

