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

    <!-- start of bulletin model css file-->
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl."/css/bulletins.css";?>"/>
    <!--start of bulletin model css file-->

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
		<div id="logo" class="left">
            <?php echo CHtml::encode(Yii::app()->name); ?>
        </div>
        <div class="right"><h5 class="append-1 prepend-top" style="vertical-align: text-bottom;">
                <?php echo CHtml:: dropDownList('Language',Helper::getLanguageEnvironmental(),array('zh_cn'=>'简体中文','en_us'=>'English'),
                    array(
                        'onchange'=>'changeLanguage(this.value)',
                    )
                );?>
                <?php if(Yii::app()->user->isGuest): ?>
                    <?php echo CHtml::link(ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'signUp_title'),array('/site/signUp'));?>&nbsp;|&nbsp;<?php echo CHtml::link(ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'signIn_title'),array('/site/signIn'));?>
                <?php else: ?>
                   <!-- --><?php
/*                         echo CHtml::imageButton(Yii::app()->baseUrl.'/images/email-icon.png',array('submit' => "notification",'style'=>'width: 18px;height: 18p' ));

                    */?>

                    <?php $image = CHtml::image(Yii::app()->baseUrl.'/images/email-icon.png');

                    echo CHtml::link($image,array('/notification')); ?>

                    <?php
                        $query = "select count(id)  from lt_notification where  company_id = ".(Yii::app()->session['user']->company_id)." and (is_new=0 or is_important=1); ";
                        $result = Yii::app()->db->createCommand($query)->queryAll();
                   /* var_dump($result[0]["count(id)"]);*/
                    ?>
                    <?php if($result[0]["count(id)"]>0): ?>
                    <?php
                        echo "(".$result[0]["count(id)"].")";
                    ?>
                    <?php endif;?>&nbsp;&nbsp;&nbsp;
                    <?php echo CHtml::encode(Yii::app()->user->name." (".Yii::app()->session['company']->name.")"); ?>&nbsp;|&nbsp;<?php echo CHtml::link(ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'signOut_title'),array('/site/logout'));?>
                    <?php endif;?>
        </div>
	</div><!-- header -->

	<div id="menu-top">
		<?php $this->widget('zii.widgets.CMenu',array(
            'activeCssClass'=>'active',
            'activateParents'=>true,
            'htmlOptions'=>array('id'=>'nav','class'=>'dropdown dropdown-horizontal'),
            'items'=>array(
				array('label'=>ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'menu_home'), 'url'=>array('/site/index')),
                /*array(
                    'label'=>ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'menu_products'),
                    'itemOptions'=>array('class'=>'dir'),
                    'visible'=>!Yii::app()->user->isGuest,
                    'items'=>array(
                        array('label'=>ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'menu_manage_folder'), 'url'=>array('/ProductFolder')),
                    ),
                ),
                array(
                    'label'=>ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'menu_picture'),
                    'itemOptions'=>array('class'=>'dir'),
                    'visible'=>!Yii::app()->user->isGuest,
                    'url'=>array('/Picture'),
                    'items'=>array(
                        array('label'=>ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'menu_manage_folder'), 'url'=>array('/PictureFolder')),
                    ),
                ),*/
                array(
                    'label'=>'eBay',
                    'itemOptions'=>array('class'=>'dir'),
                    'visible'=>!Yii::app()->user->isGuest,
                    'url'=>array('/eBay/eBay'),
                    'items'=>array(
                        array('label'=>'Manage Listing', 'url'=>array('/eBay/eBayListing')),
                        array('label'=>'Bulk Update Listing', 'url'=>array('/eBay/eBayListing/bulkUpdate')),
                    ),
                ),
                array(
                    'label'=>ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'menu_system'),
                    'itemOptions'=>array('class'=>'dir'),
                    'visible'=>!Yii::app()->user->isGuest,
                    'items'=>array(
                        array('label'=>ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'user_manage_label'), 'url'=>array('/User')),
                        array('label'=>ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'menu_manage_department'), 'url'=>array('/department')),
                        array('label'=>ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'store_manage_menu'), 'url'=>array('/Store')),
                        array('label'=>ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'menu_manage_company'), 'url'=>array('/Company')),
                    ),
                ),
                array(
                    'label'=>ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'menu_help'),
                    'itemOptions'=>array('class'=>'dir'),
                    'items'=>array(
                        array('label'=>ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'ticket_title'), 'url'=>array('/ticket'), 'visible'=>!Yii::app()->user->isGuest),
                        array('label'=>ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'notification_title'), 'url'=>array('/notification'), 'visible'=>!Yii::app()->user->isGuest),
                        array('label'=>ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'menu_help_bulletion'), 'url'=>array('/bulletin'), 'visible'=>!Yii::app()->user->isGuest),
                        array('label'=>ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'menu_help_about'), 'url'=>array('/site/page', 'view'=>'about')),
                        array('label'=>ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'contact_title'), 'url'=>array('/site/contact')),
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
<script >
    function changeLanguage(tag){
        $.ajax({
            type: "POST",
            url: '/index.php/site/setLanguage',
            data: {pid:tag},
            dataType: "JSON",
            success: function(data, status, xhr) {
                if(data.status=='success'){
                    window.location.reload(true);
                }
            },
            error: function(data, status, xhr) {
            }
        });
    }
</script>
</body>
</html>

<?php
if(isset(Yii::app()->session['user']))
{
    setcookie("user", base64_encode(Yii::app()->session['user']->username), time() + 60 * 30, "", "it.net");
    setcookie("user_key", md5(Yii::app()->session['user']->username . Yii::app()->params['sitePrivateKey']), time() + 60 * 30, "", "it.net");
}
?>