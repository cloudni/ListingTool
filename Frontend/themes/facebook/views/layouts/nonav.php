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

    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/main.css" />

    <script type="text/javascript">
        window.onload = function () {setstyle('facebook');}
    </script>

    <title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>

<div id="ajaxloading">
    <div>
        <img src="/images/load.gif" align="absmiddle" /><span>Data is loading</span>
    </div>
</div>

<div id="pagelet_bluebar">
    <div id="blueBarDOMInspector" style="height: auto;">
        <div id="blueBarNAXAnchor" class="_4f7n _xxp">
            <?php if(Yii::app()->user->isGuest): ?>
                <div class="loggedout_menubar_container">
                    <div class="clearfix loggedout_menubar container">
                        <div class="lfloat">
                            <h1 style="display: block; font-size: 2em; -webkit-margin-before: 0.67em; -webkit-margin-after: 0.67em; -webkit-margin-start: 0px; -webkit-margin-end: 0px; font-weight: bold;">
                                <a href="/" title="Go to ItemTool Home">
                                    <span style="color: whitesmoke;font-size: 3.7em;position: relative; top: 10px; font-weight: bold;">item tool</span>
                                </a>
                            </h1>
                        </div>
                        <div class="menu_login_container rfloat">
                            <form id="SignIn-form" action="<?php echo Yii::app()->createAbsoluteUrl("site/signIn");?>" method="post" style="margin-right: 10px;">
                                <table cellspacing="0" style="display: table; border-collapse: separate; border-spacing: 0px; border-color: gray;padding-top: 12px;">
                                    <tbody style="display: table-row-group; vertical-align: middle; border-color: inherit;">
                                    <tr>
                                        <td style="background: #3a5795;"><label for="email" style="color: #fff; font-weight: normal; padding-left: 1px;"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'user_name');?></label></td>
                                        <td style="background: #3a5795;"><label for="pass" style="color: #fff; font-weight: normal; padding-left: 1px;"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'password');?></label></td>
                                    </tr>
                                    <tr>
                                        <td style="background: #3a5795;"><input type="text" class="inputtext" name="SignInForm[username]" id="SignInForm_username" value="" tabindex="1"></td>
                                        <td style="background: #3a5795;"><input type="password" class="inputtext" name="SignInForm[password]" id="SignInForm_password" tabindex="2"></td>
                                        <td style="background: #3a5795;"><label class="uiButton uiButtonConfirm" id="loginbutton" for="u_0_n"><input value="<?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'log_in');?>" tabindex="4" type="submit" id="u_0_n"></label></td>
                                    </tr>
                                    <tr>
                                        <td class="login_form_label_field" style="position: relative; left: -4px;"><input id="persist_box" type="checkbox" name="SignInForm[rememberMe]" id="SignInForm_rememberMe" value="1" tabindex="3" class="uiInputLabelInput uiInputLabelCheckbox"><label for="persist_box" class="uiInputLabelLabel" style="position: relative;top: -3px;"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'keep_me_logged_in');?></label></td>
                                        <td class="login_form_label_field"><a href="<?php echo Yii::app()->createAbsoluteUrl("site/forgotPwd");?>"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'forget_your_password');?></a></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </form>
                        </div>
                    </div>
                </div>
            <?php else:?>
                <div class="loggedin_menubar_container">
                    <div class="clearfix loggedin_menubar container">
                        <div class="clearfix lfloat">
                            <h1 style="display: block; -webkit-margin-before: 0.67em; -webkit-margin-after: 0.67em; -webkit-margin-start: 0px; -webkit-margin-end: 0px; font-weight: bold;">
                                <a href="/" title="Go to ItemTool Home" style="display: block;">
                                    <img src="/themes/facebook/images/30x30_logo.jpg" class="loggedin_logo" />
                                </a>
                            </h1>
                        </div>
                        <div class="clearfix lfloat">
                            <label style="color: #fff; font-weight: bold; padding-left: 6px; position: relative; top: 18px; font-size: 1.7em;"><?php echo CHtml::encode(Yii::app()->user->name." - ".Yii::app()->session['company']->name); ?></label>
                        </div>
                        <div class="rfloat">
                            <ul class="clearfix" style="height: 22px; margin: 10px 0 10px 5px;display: block;list-style-type: none; color: whitesmoke; position: relative; top: 8px;">
                                <li class="lfloat" style="padding-right: 6px; position: relative; top: 8px;">
                                    <?php $image = CHtml::image(Yii::app()->baseUrl.'/images/email-icon.png'); echo CHtml::link($image,array('/notification')); ?>
                                    <?php
                                    $query = "select count(id)  from lt_notification where  company_id = ".(Yii::app()->session['user']->company_id)." and (is_new=0 or is_important=1); ";
                                    $result = Yii::app()->db->createCommand($query)->queryAll();
                                    ?>
                                    <?php if($result[0]["count(id)"]>0) echo "(".$result[0]["count(id)"].")"; ?>
                                </li>
                                <li class="lfloat" style="padding-right: 6px;"><?php echo CHtml:: dropDownList('Language',Helper::getLanguageEnvironmental(),array('zh_cn'=>'简体中文','en_us'=>'English'),array('onchange'=>'changeLanguage(this.value)',));?></li>
                                <li class="lfloat" style=" position: relative; top: 8px;"><?php echo CHtml::link(ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'signOut_title'),array('/site/logout'), array('style'=>'color: whitesmoke;'));?></li>
                            </ul>
                        </div>
                    </div>
                </div>
            <?php endif;?>
        </div>
    </div>
</div>

<div class="container">
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
    <hr style="background-color: #87A9F2;" />
    <div id="pageFooter" >
        <ul class="clearfix" style="list-style: none; margin: 0px; padding: 0px; display: block;clear: both;">
            <li class="lfloat">
                <a title="English (US)" onclick="changeLanguage('en_us');">English (US)</a>
            </li>
            <li class="lfloat" style="padding-left: 10px;">
                <a title="Simplified Chinese (China)" onclick="changeLanguage('zh_cn');">中文(简体)</a>
            </li>
        </ul><br/>
        Copyright &copy; <?php echo date('Y'); ?> by Nirvana Info.<br/>
        All Rights Reserved.<br/>
        <?php $result = @CDbConnection::getStats(); echo "SQL executed: {$result[0]}, Time usage: {$result[1]}"?>
        <div style="padding-top: 15px;">
        </div>
    </div><!-- footer -->

</div><!-- page -->
<script >
    function changeLanguage(tag){
        $.ajax({
            type: "POST",
            url: '<?php echo $this->createAbsoluteUrl('site/setLanguage');?>',
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
