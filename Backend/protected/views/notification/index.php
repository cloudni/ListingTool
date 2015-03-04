<?php
/* @var $this NotificationController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Notifications',
);

$this->menu=array(
	array('label'=>'Create Notification', 'url'=>array('create')),
	array('label'=>'Manage Notification', 'url'=>array('admin')),
);
?>

<h1>Notifications</h1>

<?php /*$this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); */?>
<div class="grid-view">
    <table class="items" width="100%">
        <tr>
            <th>Id</th>
            <th>Title</th>
            <th>Content</th>
            <th>Company</th>
            <th>CreateAdmin</th>
            <th>CreateTime</th>
            <th>Action</th>
        </tr>
        <?php $this->widget('zii.widgets.CListView', array(
            'dataProvider'=>$dataProvider,
            'itemView'=>'_view',
        )); ?>
    </table>
</div>
