<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />

	<!-- blueprint CSS framework -->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" />
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
	<![endif]-->

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />

    <!-- start of custom CSS file -->
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/dropdownmenu/css/dropdown/dropdown.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/dropdownmenu/css/dropdown/dropdown.vertical.rtl.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/dropdownmenu/css/dropdown/themes/default/default.ultimate.css" />
    <!-- end of custom CSS file -->
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl."/css/bulletins.css";?>"/>
    <?php Yii::app()->getClientScript()->registerCoreScript('jquery');?>
    <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/common.js"></script>

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>

<div id="ajaxloading">
    <div>
        <img src="/images/load.gif" align="absmiddle" /><span>Data is loading</span>
    </div>
</div>

<div class="container" id="page">

	<div id="header" class="container">
		<div id="logo" class="left"><?php echo CHtml::encode(Yii::app()->name); ?></div>
        <div class="right"><h5 class="append-1 prepend-top" style="vertical-align: text-bottom;">
                <?php if(Yii::app()->user->isGuest): ?>
                    <?php echo CHtml::link("SignIn",array('/site/signIn'));?>
                <?php else: ?>
                    <?php echo CHtml::encode(Yii::app()->user->name); ?>&nbsp;|&nbsp;<?php echo CHtml::link("Logout",array('/site/logout'));?>
                <?php endif;?>
        </h5></div>
	</div><!-- header -->

	<div id="menu-top">
		<?php $this->widget('zii.widgets.CMenu',array(
            'activeCssClass'=>'active',
            'activateParents'=>true,
            'htmlOptions'=>array('id'=>'nav','class'=>'dropdown dropdown-horizontal'),
            'items'=>array(
				array('label'=>'Home', 'url'=>array('/site/index')),
                array('label'=>'User', 'visible'=>!Yii::app()->user->isGuest, 'url'=>array('/company')),
                array(
                    'label'=>'Marketing',
                    'itemOptions'=>array('class'=>'dir'),
                    'visible'=>!Yii::app()->user->isGuest,
                    'items'=>array(
                        array(
                            'label'=>'Advertisement',
                            'itemOptions'=>array('class'=>'dir'),
                            'url'=>array('/marketing/advertisement/home'),
                            'items'=>array(
                                array('label'=>'AD Campaign', 'url'=>array('/marketing/advertisement/adcampaign')),
                                array('label'=>'AD Group', 'url'=>array('/marketing/advertisement/adgroup')),
                                array('label'=>'ADs', 'url'=>array('/marketing/advertisement/ad')),
                            ),
                        ),
                    ),
                ),
                array(
                    'label'=>'eBay',
                    'itemOptions'=>array('class'=>'dir'),
                    'visible'=>!Yii::app()->user->isGuest,
                    'items'=>array(
                        array('label'=>'Manage API Keys', 'url'=>array('/eBay/eBayApiKey')),
                        array('label'=>'Manage eBay Listings', 'url'=>array('/eBay/eBayListing')),
                        array(
                            'label'=>'Manage Attribute',
                            'itemOptions'=>array('class'=>'dir'),
                            'items'=>array(
                                array('label'=>'Sets', 'url'=>array('/eBay/eBayAttributeSet')),
                                array('label'=>'Entity Types', 'url'=>array('/eBay/eBayEntityType')),
                                array('label'=>'Attributes', 'url'=>array('/eBay/eBayAttribute')),
                            ),
                        ),
                    ),
                ),
                array(
                    'label'=>'Ticket',
                    'visible'=>!Yii::app()->user->isGuest,
                    'url'=>array('/ticket')
                ),
                array(
                    'label'=>'Localization',
                    'visible'=>!Yii::app()->user->isGuest,
                    'url'=>array('/resourceString')
                ),
                array(
                    'label'=>'Announcement',
                    'itemOptions'=>array('class'=>'dir'),
                    'visible'=>!Yii::app()->user->isGuest,
                    'items'=>array(
                        array('label'=>'Notification', 'url'=>array('/notification')),
                        array('label'=>'Bulletin Board', 'url'=>array('/bulletin')),
                    ),
                ),
                array(
                    'label'=>'Help',
                    'itemOptions'=>array('class'=>'dir'),
                    'items'=>array(
                        array('label'=>'About', 'url'=>array('/site/page', 'view'=>'about')),
                        array('label'=>'Contact', 'url'=>array('/site/contact')),
                    ),
                ),
            ),

		)); ?>
	</div><!-- mainmenu -->
	<?php if(isset($this->breadcrumbs)):?>
		<?php $this->widget('zii.widgets.CBreadcrumbs', array(
			'links'=>$this->breadcrumbs,
		)); ?><!-- breadcrumbs -->
	<?php endif?>

    <?php if(Yii::app()->user->hasFlash('Info')):?>
        <div class="MessageBox MessageBoxInfo">
            <?php echo Yii::app()->user->getFlash('Info');?>
        </div>
    <?php endif;?>

    <?php if(Yii::app()->user->hasFlash('Error')):?>
        <div class="MessageBox MessageBoxError">
            <?php echo Yii::app()->user->getFlash('Error');?>
        </div>
    <?php endif;?>

    <?php if(Yii::app()->user->hasFlash('Success')):?>
        <div class="MessageBox MessageBoxSuccess">
            <?php echo Yii::app()->user->getFlash('Success');?>
        </div>
    <?php endif;?>

	<?php echo $content; ?>

	<div class="clear"></div>

	<div id="footer">
		Copyright &copy; <?php echo date('Y'); ?> by Nirvana Info.<br/>
		All Rights Reserved.<br/>
		<?php echo Yii::powered(); ?><br/>
        <?php $result = @CDbConnection::getStats(); echo "SQL executed: {$result[0]}, Time usage: {$result[1]}"?>
	</div><!-- footer -->

</div><!-- page -->

</body>
</html>
