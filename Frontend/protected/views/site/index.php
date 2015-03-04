<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;
Yii::app()->clientScript->registerCoreScript('jquery');
?>

<?php if(Yii::app()->user->isGuest || empty($bulletins)): ?>
    <h1>Welcome to <i><?php echo CHtml::encode(Yii::app()->name); ?></i></h1>

    <p>Congratulations! You have successfully created your Yii application.</p>

    <p>You may change the content of this page by modifying the following two files:</p>
    <ul>
        <li>View file: <code><?php echo __FILE__; ?></code></li>
        <li>Layout file: <code><?php echo $this->getLayoutFile('main'); ?></code></li>
    </ul>
    <p>For more details on how to further develop this application, please read
        the <a href="http://www.yiiframework.com/doc/">documentation</a>.
        Feel free to ask in the <a href="http://www.yiiframework.com/forum/">forum</a>,
        should you have any questions.</p>
<?php else: ?>

    <div  >
        <div class="bulletin-panel" >
            <div class="relative">
                <div class="panel-title"><span><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'label_bulletin'); ?></span></div>
                <div class="panel-more"><span><?php echo CHtml::link(ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'label_more'),array('/bulletin/index'));?></span></div>
            </div>
            <div class="panel-content">
                <ul>
                    <?php foreach($bulletins as $bulletin): ?>
                        <?php if($bulletin!=null): ?>
                            <?php if($bulletin['is_top']==Bulletin::STATUS_TRUE):?>
                                <li class="prominent">
                                    <?php echo CHtml::link($bulletin['title'],array('/bulletin/view','id'=>$bulletin['id']));?>
                                </li>
                            <?php else: ?>
                                <li >
                                    <?php echo CHtml::link($bulletin['title'],array('/bulletin/view','id'=>$bulletin['id']));?>
                                </li>
                            <?php endif; ?>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
<?php endif;?>
