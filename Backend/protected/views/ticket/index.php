<?php
/* @var $this TicketController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Tickets',
);

/*$this->menu=array(
	array('label'=>'Create Ticket', 'url'=>array('create')),
	array('label'=>'Manage Ticket', 'url'=>array('admin')),
);*/
?>

<h1>Tickets</h1>
<table>
    <thead>
    <th>ID</th>
    <th>Title</th>
    <th>Content</th>
    <th>Type</th>
    <th>New</th>
    <th>Create User</th>
    <th>RepliesCount</th>
    </thead>
    <tbody>
    <?php $this->widget('zii.widgets.CListView', array(
        'dataProvider'=>$dataProvider,
        'itemView'=>'_view',
    )); ?>
    </tbody>
</table>

<?php /*$this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); */?>
