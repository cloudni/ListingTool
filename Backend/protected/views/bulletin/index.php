<?php
/* @var $this BulletinController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Bulletins',
);

$this->menu=array(
	array('label'=>'Create Bulletin', 'url'=>array('create')),
);
?>

<div class="bulletin-list">
    <div class="panel-title">Bulletins</div>
    <table class="panel-table">
        <thead>
        <th>ID</th>
        <th>Title</th>
        <th>Content</th>
        <th>Top</th>
        <th>Viewable</th>
        <th>Create time</th>
        </thead>
        <tbody>
        <?php $this->widget('zii.widgets.CListView', array(
            'dataProvider'=>$dataProvider,
            'itemView'=>'_view',
        )); ?>
        </tbody>
    </table>
</div>

