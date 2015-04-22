<?php
/* @var $this CompanyController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Companies',
);

$this->menu=array(

);
?>

<h1>Companies</h1>

<div class="grid-view">
    <table class="items" width="100%">
        <tr>
            <th>Id</th>
            <th>name</th>
            <th>phone</th>
            <th>country</th>
        </tr>
        <?php $this->widget('zii.widgets.CListView', array(
            'dataProvider'=>$dataProvider,
            'itemView'=>'_view',
        )); ?>
    </table>
</div>
