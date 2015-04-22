<?php
/**
 * Created by PhpStorm.
 * User: GavinLe
 * Date: 11/18/14
 * Time: 9:56 AM
 */
?>
<div class="form">
    <?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'upload_test_form',
    'enableAjaxValidation'=>false,
)); ?>
<div>
    <?php $this->widget('ext.Plupload.Plupload',array(
        'form_id'=>'upload_test_form',
        'submitURL'=>Yii::app()->createAbsoluteUrl('Picture/uploadSubmit'),
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