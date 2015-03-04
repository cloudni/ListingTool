<?php
/* @var $this NotificationController */
/* @var $model Notification */

$this->breadcrumbs=array(
	'Notifications'=>array('index'),
	$model->title,
);

$this->menu=array(
	array('label'=>'List Notification', 'url'=>array('index')),
	array('label'=>'Create Notification', 'url'=>array('create')),
	array('label'=>'Update Notification', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Notification', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Notification', 'url'=>array('admin')),
);
?>

<!--<h1>View Notification #<?php /*echo $model->id; */?></h1>-->
<?php /*$this->widget('zii.widgets.CDetailView', array(
    'data'=>$model,

)); */?>
<!--<div class="grid-view">
    <table class="items" width="50%">
        <tr style="width: 300px">
            <th>Id</th>
            <th>Title</th>
            <th>Content</th>
            <th>Company</th>
            <th>CreateAdmin</th>
            <th>CreateTime</th>
            <th>Action</th>
        </tr>
        <tr style="width: 300px">
            <td style="width: 150px"><?php /*echo($model->content) */?></td>
            <td></td>
        </tr>

    </table>
</div>-->
<div style="width: 990px;margin-top: 15px;">
    <div class="title" style="width:400px;margin: 0px auto ;">
        <div style="text-align: center;font-size: 18px;">
            <span><?php echo $model->title; ?></span>
        </div>
        <div style="word-break:break-all">

                <?php echo $model->content ?>
        </div>
    </div>
</div>


