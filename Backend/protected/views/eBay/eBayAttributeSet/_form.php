<?php
/* @var $this EbayattributesetController */
/* @var $model eBayAttributeSet */
/* @var $form CActiveForm */
?>

<style>
    .treeList{
        width: 90%;
        height: 480px;
        border: 1px solid rgb(163, 163, 163);
    }

    hr{
        top: 6px;
        position: relative;
        width: 90%;
        background-color: gray;
    }
</style>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'e-bay-attribute-set-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
    'htmlOptions'=>array(
        'onsubmit'=>' return processForm();',
    ),
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

    <div class="container">
        <div class="row left span-3">
            <?php echo $form->labelEx($model,'name', array('style'=>'padding-top: 5px;')); ?>
        </div>
        <div class="row left">
            <?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255)); ?>
            <?php echo $form->error($model,'name'); ?>
        </div>
        <div class="row buttons prepend-1 left">
            <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
        </div>
    </div>

	<div class="container">
        <div class="row left span-3">
            <?php echo $form->labelEx($model,'entity_type_id', array('style'=>'padding-top: 5px;')); ?>
        </div>
        <div class="row left span-5">
            <?php echo $form->dropDownList($model,'entity_type_id', CHtml::listData(eBayEntityType::model()->findAll(),'id','name'), array('style'=>'width: 170px;')); ?>
            <?php echo $form->error($model,'entity_type_id'); ?>
        </div>
        <div class="row left span-3">
            <?php echo $form->labelEx($model,'is_active', array('style'=>'padding-top: 5px;')); ?>
        </div>
        <div class="row left">
            <?php echo $form->dropDownList($model,'is_active', $model->getIsActiveOptions()); ?>
            <?php echo $form->error($model,'is_active'); ?>
        </div>
	</div>

    <div class="container" style="width: 100%">
        <div class="left" style="width: 430px;">
            <div class="row">
                <?php echo CHtml::label("Available eBay Attributes: ", false, array('style'=>'')); ?>
            </div>
            <div class="row">
                <?php
                    $result = eBayAttribute::model()->findAll(array('order'=>'code asc'));
                    foreach($result as $attribute)
                    {
                        $attributes[] = array(
                            'id'=>$attribute->id,
                            'name'=>sprintf("%s (%s, %s)",$attribute->name, $attribute->getBackendTypeText(), $attribute->getFrontendInputText()),
                        );
                    }
                    echo CHtml::dropDownList('available_ebay_attribute', 0, CHtml::listData($attributes,'id','name'), array('style'=>'width: 90%; height: 300px;', 'multiple'=>'multiple'));
                ?>
            </div>
            <div class="row"><hr /></div>
            <div class="row">
                <?php echo CHtml::label("Add New eBay Attribute: ", false, array('style'=>'')); ?>
            </div>
            <div class="row">
                <?php $this->renderPartial('_attributeForm', array('form'=>$form, 'model'=>new eBayAttribute())); ?>
            </div>
        </div>
        <div class="left" style="width: 40px; padding: 80px 25px 0px 15px;">
            <?php echo CHtml::button("=>", array('id'=>'select_ebay_attribute', 'style'=>'margin-left: -11px;', 'disabled'=>'disabled')); ?>
        </div>
        <div class="left" style="width: 410px;">
            <div class="row">
                <?php echo CHtml::label("Selected eBay Attributes: ", false, array('style'=>'')); ?>
            </div>
            <div class="row" style="width: 100%; height: 670px;">
                <?php
                    /*$query = "SELECT eea.id, eea.attribute_id, ea.name, eea.parent_id
                        FROM lt_ebay_entity_attribute eea
                        left join lt_ebay_attribute ea on ea.id = eea.attribute_id
                        where eea.attribute_set_id = ".($model->isNewRecord ? 0 : $model->id)." order by eea.parent_id asc; ";
                    $result = Yii::app()->db->createCommand($query)->queryAll();*/

                    $this->widget('ext.zTree.zTree',array(
                        'data'=>array(
                            'key'=>array('name'=>'name'),
                            'simpleData'=>array(
                                'enable'=>true,//Set zTree's node to accept the simple data format, when zTree is initialized or when ajax get / or when use addNodes method.
                                'idKey'=>'id',//The node data's attribute to save node data's unique identifier. It is valid when [setting.data.simpleData.enable = true]
                                'pIdKey'=>'pId',
                                'attribute_id'=>'attribute_id',
                            ),
                        ),
                        'view'=>array(
                            'expandSpeed'=>"",
                            'showLine'=>true,
                            'selectedMulti'=>false,
                            'showIcon'=>false,
                            'autoCancelSelected'=>true,
                        ),
                        'edit'=>array(
                            'enable'=>true,
                            'showRemoveBtn'=>true,
                            'showRenameBtn'=>false,
                            'removeTitle'=>'del',
                        ),
                        'htmlOptions'=>array('id'=>'attribute_has','name'=>'attribute_has','class'=>'treeList', 'style'=>'overflow-y: scroll; overflow-x: auto; height: 100%; width: 100%;'),
                        'input'=>$attributeList,
                    ));
                    echo CHtml::textField('ebay_attribute_set', null, array('hidden'=>'hidden', 'style'=>'visibility: hidden;'));
                ?>
            </div>
        </div>
    </div>

<?php $this->endWidget(); ?>

</div><!-- form -->

<script>

    var treeNodeIndex = <?php echo (int)$attributeCount;?>;

    function getZTreeObj()
    {
        return $.fn.zTree.getZTreeObj("attribute_has");
    }

    $(function(){
        $("#available_ebay_attribute").change(function(){
            if($("#available_ebay_attribute").val())
                $("#select_ebay_attribute").removeAttr("disabled");
        });

        $("#select_ebay_attribute").click(function(){
            if(!$("#available_ebay_attribute").val()) return false;
            var zTree = getZTreeObj();
            var selectedNodes = zTree.getSelectedNodes();
            var newNode = {attribute_id: parseInt($("#available_ebay_attribute").val()), id:'new_'+treeNodeIndex/*parseInt($("#available_ebay_attribute").val())*/, name:$("#available_ebay_attribute option:selected").text(), pId:selectedNodes.length <= 0 ? 0 : selectedNodes[0].id};
            zTree.addNodes(selectedNodes.length <= 0 ? null : selectedNodes[0], newNode);
            treeNodeIndex++;
        });
    });

    function processForm()
    {
        $("input[type=submit]").attr("disabled", 'disabled');
        var errorMsg = '';
        $("#attribute_error_msg").html(errorMsg);
        if($("#eBayAttributeSet_name").val().length<=0)
        {
            alert("eBay Attribute Set Name can not be empty!");
            $("#eBayAttributeSet_name").focus();
            $("input[type=submit]").removeAttr("disabled");
            return false;
        }

        var zTree = getZTreeObj();
        var nodes = zTree.transformToArray(zTree.getNodes());
        var attributes = new Array();
        for(var i=0;i<nodes.length;i++)
        {
            attributes.push({id:nodes[i].id, parent_id:nodes[i].pId, attribute_id: nodes[i].attribute_id});
        }
        $("#ebay_attribute_set").val(JSON.stringify(attributes));
        return true;
    }

</script>