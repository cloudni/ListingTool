<%@ page language="java" import="java.util.*, com.lt.platform.framework.core.redis.*" pageEncoding="UTF-8"%>
<%@ include file="/common/taglibs.jsp"%>
<%@taglib prefix="spring" uri="http://www.springframework.org/tags"%>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <%@ include file="/common/meta.jsp"%>
<title>Item Tool</title>
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
                            <div class="loggedout_menubar_container">
                    <div class="clearfix loggedout_menubar container">
                        <div class="lfloat">
                            <h1 style="display: block; font-size: 2em; -webkit-margin-before: 0.67em; -webkit-margin-after: 0.67em; -webkit-margin-start: 0px; -webkit-margin-end: 0px; font-weight: bold;">
                                <a href="/" title="Go to ItemTool Home">
                                    <span style="color: whitesmoke;font-size: 1.7em;position: relative; top: 10px; font-weight: bold;">item tool</span>
                                </a>
                            </h1>
                        </div>
                        <div class="menu_login_container rfloat">
                            <form id="SignIn-form" action="${phpPath }/site/signIn" method="post" style="margin-right: 10px;">
                                <table cellspacing="0" style="display: table; border-collapse: separate; border-spacing: 0px; border-color: gray;padding-top: 12px;">
                                    <tbody style="display: table-row-group; vertical-align: middle; border-color: inherit;">
                                    <tr>
                                        <td style="background: #3a5795;"><label for="email" style="color: #fff; font-weight: normal; padding-left: 1px;"><spring:message code='login.username'/></label></td>
                                        <td style="background: #3a5795;"><label for="pass" style="color: #fff; font-weight: normal; padding-left: 1px;"><spring:message code='login.password'/></label></td>
                                    </tr>
                                    <tr>
                                        <td style="background: #3a5795;"><input type="text" class="inputtext" name="SignInForm[username]" id="SignInForm_username" value="" tabindex="1"></td>
                                        <td style="background: #3a5795;"><input type="password" class="inputtext" name="SignInForm[password]" id="SignInForm_password" tabindex="2"></td>
                                        <td style="background: #3a5795;"><label class="uiButton uiButtonConfirm" id="loginbutton" for="u_0_n" onclick="localtion.href='${ctxPath}/themes/facebook/views/index/index.jsp';"><input value="<spring:message code='login.login'/>" tabindex="4" type="button" id="u_0_n"></label></td>
                                    </tr>
                                    <tr>
                                        <td class="login_form_label_field" style="position: relative; left: -4px;"><input id="persist_box" type="checkbox" name="SignInForm[rememberMe]" id="SignInForm_rememberMe" value="1" tabindex="3" class="uiInputLabelInput uiInputLabelCheckbox"><label for="persist_box" class="uiInputLabelLabel" style="position: relative;top: -3px;"><spring:message code='login.autoLogin'/></label></td>
                                        <td class="login_form_label_field"><a href="${phpPath }/site/forgotPwd"><spring:message code='login.losePassword'/></a></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </form>
                        </div>
                    </div>
                </div>
                    </div>
    </div>
</div>

<div class="container">
    
    
    
    
<div class="container clearfix">
    <div class="lfloat" style="display: inline-block; vertical-align: top; width: 565px;">
        <h2 class="boldFont indexSlogan">Help find the best visitor<br />Manage and accelerate your sale.</h2>
        <div class="indexDetail">
            <div style="text-align: center; width: 55px; margin-right: 20px;">
                <img src="${ctxPath}/themes/facebook/images/851565_602269956474188_918638970_n.png" />
            </div>
            <div>
                <span class="boldFont indexDetailSpan1" >Manage listings and photos</span>
                <span class="indexDetailSpan2">on multiple e-sites.</span>
            </div>
        </div>
        <div class="indexDetail">
            <div style="text-align: center; width: 55px; margin-right: 20px;">
                <img src="${ctxPath}/themes/facebook/images/851585_216271631855613_2121533625_n.png" />
            </div>
            <div>
                <span class="boldFont indexDetailSpan1" >Promote yourself in one stop service</span>
                <span class="indexDetailSpan2">with lower cost.</span>
            </div>
        </div>
        <div class="indexDetail">
            <div style="text-align: center; width: 55px; margin-right: 20px;">
                <img src="${ctxPath}/themes/facebook/images/851558_160351450817973_1678868765_n.png" />
            </div>
            <div>
                <span class="boldFont indexDetailSpan1" >Re-act with your visitor</span>
                <span class="indexDetailSpan2">let them know you better.</span>
            </div>
        </div>
    </div>
    <div class="lfloat" style="display: inline-block; vertical-align: top; width: 415px; line-height: 120%; ">
        <h2 class="boldFont indexSlogan" style="font-size: 36px; padding: 0px;"><spring:message code='login.register'/></h2>
        <div class="boldFont" style="font-weight: normal; margin: 5px 0 20px 0; color: #333; font-size: 19px; line-height: 126%; visibility: hidden;">It’s free and always will be.</div>
        <div>
            <noscript><div id="no_js_box"><h2>JavaScript is disabled on your browser.</h2><p>Please enable JavaScript on your browser or upgrade to a JavaScript-capable browser to register for Facebook.</p></div></noscript>
            <div style="margin: 0 auto 0 auto; padding-bottom: 30px;">
                <form id="signUp-form" action="${phpPath }/site/signUp" method="post" onsubmit="return validate();">
                    <div>
                        <div class="clearfix" style="width: 100%;">
                            <div style="margin-right: 8px; margin-bottom: 10px; ">
                                <div style="position: relative; width: 415px;">
                                    <div style="width: 415px; height: 40px; background: white; -webkit-border-radius: 5px; display: inline-block; position: relative;">
                                        <div class="placeholder" style="font-size: 20px; top: 5px; padding: 8px 10px; -webkit-box-sizing: border-box; overflow: hidden;text-overflow: ellipsis; white-space: nowrap;"><spring:message code='login.username'/></div>
                                        <input type="text" class="inputtext" tooltip="tooltipUserName" style="width: 393px; font-size: 18px; padding: 8px 10px; border-color: #bdc7d8; -webkit-border-radius: 5px; margin: 0; background-color: transparent; position: relative; border: 1px solid #bdc7d8;-webkit-user-select: text;-webkit-rtl-ordering: logical;" data-type="text" maxlength="20" name="SignUpForm[username]" id="SignUpForm_username" onkeyup="changeInputBackground(this);" onfocus="focusWarningIcon(this);" onblur="blurWarningIcon(this);" />
                                    </div>
                                    <i style="background-image:url(/themes/facebook/images/oTjqmTwIShG.png); background-size: auto;background-repeat: no-repeat;width: 21px;height: 21px;background-position: -122px -494px;display: none;position: absolute;right: 9px;top: 9px;"></i>
                                </div>
                            </div>
                        </div>
                        <div style="width: 100%;">
                            <div style="margin-right: 8px; margin-bottom: 10px; ">
                                <div style="position: relative; width: 415px;">
                                    <div style="width: 415px; height: 40px; background: white; -webkit-border-radius: 5px; display: inline-block; position: relative;">
                                        <div class="placeholder" style="font-size: 20px; top: 5px; padding: 8px 10px; -webkit-box-sizing: border-box; overflow: hidden;text-overflow: ellipsis; white-space: nowrap;"><spring:message code='login.emailAddress'/></div>
                                        <input type="text" class="inputtext" style="width: 393px; font-size: 18px; padding: 8px 10px; border-color: #bdc7d8; -webkit-border-radius: 5px; margin: 0; background-color: transparent; position: relative; border: 1px solid #bdc7d8;-webkit-user-select: text;-webkit-rtl-ordering: logical;" data-type="text" maxlength="256" name="SignUpForm[email]" id="SignUpForm_email" tooltip="tooltipEmail" onkeyup="changeInputBackground(this);" onfocus="focusWarningIcon(this);" onblur="blurWarningIcon(this);" />
                                    </div>
                                    <i style="background-image:url(/themes/facebook/images/oTjqmTwIShG.png); background-size: auto;background-repeat: no-repeat;width: 21px;height: 21px;background-position: -122px -494px;display: none;position: absolute;right: 9px;top: 9px;"></i>
                                </div>
                            </div>
                        </div>
                        <div style="width: 100%; ">
                            <div style="margin-right: 8px; margin-bottom: 10px; ">
                                <div class="lfloat" style="position: relative;">
                                    <div style="width: 194px; height: 40px; background: white; -webkit-border-radius: 5px; display: inline-block; position: relative;">
                                        <div class="placeholder" style="font-size: 20px; top: 5px; padding: 8px 10px; -webkit-box-sizing: border-box; overflow: hidden;text-overflow: ellipsis; white-space: nowrap;"><spring:message code='login.password'/></div>
                                        <input type="password" class="inputtext" style="width: 172px; font-size: 18px; padding: 8px 10px; border-color: #bdc7d8; -webkit-border-radius: 5px; margin: 0; background-color: transparent; position: relative; border: 1px solid #bdc7d8;-webkit-user-select: text;-webkit-rtl-ordering: logical;" data-type="text" maxlength="20" name="SignUpForm[password]" id="SignUpForm_password" tooltip="tooltipPassword" onkeyup="changeInputBackground(this);" onfocus="focusWarningIcon(this);" onblur="blurWarningIcon(this);" />
                                    </div>
                                    <i style="background-image:url(/themes/facebook/images/oTjqmTwIShG.png); background-size: auto;background-repeat: no-repeat;width: 21px;height: 21px;background-position: -122px -494px;display: none;position: absolute;right: 9px;top: 9px;"></i>
                                </div>
                                <div class="lfloat" style="position: relative; left: 27px;">
                                    <div style="width: 194px; height: 40px; background: white; -webkit-border-radius: 5px; display: inline-block; position: relative;">
                                        <div class="placeholder" style="font-size: 20px; top: 5px; padding: 8px 10px; -webkit-box-sizing: border-box; overflow: hidden;text-overflow: ellipsis; white-space: nowrap;"><spring:message code='login.repassword'/></div>
                                        <input type="password" class="inputtext" style="width: 172px; font-size: 18px; padding: 8px 10px; border-color: #bdc7d8; -webkit-border-radius: 5px; margin: 0; background-color: transparent; position: relative; border: 1px solid #bdc7d8;-webkit-user-select: text;-webkit-rtl-ordering: logical;" data-type="text" maxlength="20" name="SignUpForm[password_repeat]" id="SignUpForm_password_repeat" tooltip="tooltipRePassword" onkeyup="changeInputBackground(this);" onfocus="focusWarningIcon(this);" onblur="blurWarningIcon(this);" />
                                    </div>
                                    <i style="background-image:url(/themes/facebook/images/oTjqmTwIShG.png); background-size: auto;background-repeat: no-repeat;width: 21px;height: 21px;background-position: -122px -494px;display: none;position: absolute;right: 9px;top: 9px;"></i>
                                </div>
                            </div>
                        </div>
                        <div style="width: 100%; margin-top: 70px;">
                            <div style="margin-right: 8px; margin-bottom: 10px; ">
                                <div style="color: #141823; font-size: 18px; font-weight: normal;"><spring:message code='login.companyInfo'/></div>
                            </div>
                        </div>
                        <div style="width: 100%;">
                            <div style="margin-right: 8px; margin-bottom: 10px; ">
                                <div style="position: relative; width: 415px;">
                                    <div style="width: 415px; height: 40px; background: white; -webkit-border-radius: 5px; display: inline-block; position: relative;">
                                        <div class="placeholder" style="font-size: 20px; top: 5px; padding: 8px 10px; -webkit-box-sizing: border-box; overflow: hidden;text-overflow: ellipsis; white-space: nowrap;"><spring:message code='login.companyName'/></div>
                                        <input type="text" class="inputtext" style="width: 393px; font-size: 18px; padding: 8px 10px; border-color: #bdc7d8; -webkit-border-radius: 5px; margin: 0; background-color: transparent; position: relative; border: 1px solid #bdc7d8;-webkit-user-select: text;-webkit-rtl-ordering: logical;" data-type="text" maxlength="256" name="SignUpForm[name]" id="SignUpForm_name" tooltip="tooltipCompanyName" onkeyup="changeInputBackground(this);" onfocus="focusWarningIcon(this);" onblur="blurWarningIcon(this);" />
                                    </div>
                                    <i style="background-image:url(/themes/facebook/images/oTjqmTwIShG.png); background-size: auto;background-repeat: no-repeat;width: 21px;height: 21px;background-position: -122px -494px;display: none;position: absolute;right: 9px;top: 9px;"></i>
                                </div>
                            </div>
                        </div>
                        <div style="width: 100%;">
                            <div style="margin-right: 8px; margin-bottom: 10px; ">
                                <div style="position: relative; width: 415px;">
                                    <div style="width: 415px; height: 40px; background: white; -webkit-border-radius: 5px; display: inline-block; position: relative;">
                                        <div class="placeholder" style="font-size: 20px; top: 5px; padding: 8px 10px; -webkit-box-sizing: border-box; overflow: hidden;text-overflow: ellipsis; white-space: nowrap;"><spring:message code='login.teleNumber'/></div>
                                        <input type="text" class="inputtext" style="width: 393px; font-size: 18px; padding: 8px 10px; border-color: #bdc7d8; -webkit-border-radius: 5px; margin: 0; background-color: transparent; position: relative; border: 1px solid #bdc7d8;-webkit-user-select: text;-webkit-rtl-ordering: logical;" data-type="text" maxlength="256" name="SignUpForm[phone]" id="SignUpForm_phone" tooltip="tooltipPhoneNumber" onkeyup="changeInputBackground(this);" onfocus="focusWarningIcon(this);" onblur="blurWarningIcon(this);" />
                                    </div>
                                    <i style="background-image:url(/themes/facebook/images/oTjqmTwIShG.png); background-size: auto;background-repeat: no-repeat;width: 21px;height: 21px;background-position: -122px -494px;display: none;position: absolute;right: 9px;top: 9px;"></i>
                                </div>
                            </div>
                        </div>
                        <div style="width: 100%;">
                            <div style="margin-right: 8px; margin-bottom: 10px; ">
                                <div style="position: relative; width: 415px;">
                                    <div style="width: 415px; height: 40px; background: white; -webkit-border-radius: 5px; display: inline-block; position: relative;">
                                        <div class="placeholder" style="font-size: 20px; top: 5px; padding: 8px 10px; -webkit-box-sizing: border-box; overflow: hidden;text-overflow: ellipsis; white-space: nowrap;"><spring:message code='login.country'/></div>
                                        <input type="text" class="inputtext" style="width: 393px; font-size: 18px; padding: 8px 10px; border-color: #bdc7d8; -webkit-border-radius: 5px; margin: 0; background-color: transparent; position: relative; border: 1px solid #bdc7d8;-webkit-user-select: text;-webkit-rtl-ordering: logical;" data-type="text" maxlength="256" name="SignUpForm[country]" id="SignUpForm_country" tooltip="tooltipRegion" onkeyup="changeInputBackground(this);" onfocus="focusWarningIcon(this);" onblur="blurWarningIcon(this);" />
                                    </div>
                                    <i style="background-image:url(/themes/facebook/images/oTjqmTwIShG.png); background-size: auto;background-repeat: no-repeat;width: 21px;height: 21px;background-position: -122px -494px;display: none;position: absolute;right: 9px;top: 9px;"></i>
                                </div>
                            </div>
                        </div>
                        <div style="width: 100%;">
                            <div style="margin-right: 8px; margin-bottom: 10px; ">
                                <p style="color: #777; font-size: 11px; width: 316px;"><spring:message code='login.description'/></p>
                            </div>
                        </div>
                        <div class="clearfix" style="width: 100%;">
                            <button type="submit" name="websubmit" class="boldFont greenButton" style="margin-top: 10px; margin-bottom: 10px; min-width: 194px; padding: 7px 20px; -webkit-border-radius: 5px;"><spring:message code='login.register'/></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div id="tooltipUserName" class="uiContextualLayerPositioner" style="top: 135px; ">
    <div>
        <div>
            <div style="width: 300px;">
                What’s your name? You'll use this when you log in and if you ever need to reset your password. At least 6 English word, digital and underscore only!
            </div>
            <i style="top: 37%; margin-top: 12px;"></i>
        </div>
    </div>
</div>
<div id="tooltipEmail"  class="uiContextualLayerPositioner" style="top: 220px; ">
    <div>
        <div>
            <div style="width: 200px;">
                Please enter your email address.
            </div>
            <i style="top: 0%; margin-top: 12px;"></i>
        </div>
    </div>
</div>
<div id="tooltipPassword"  class="uiContextualLayerPositioner" style="top: 270px; ">
    <div>
        <div>
            <div style="width: 300px;">
                Enter a combination of at least six numbers, letters and punctuation marks (like ! and &).
            </div>
            <i style="top: 0%; margin-top: 12px;"></i>
        </div>
    </div>
</div>
<div id="tooltipRePassword"  class="uiContextualLayerPositioner" style="top: 330px; right: 458px;">
    <div>
        <div>
            <div style="width: 200px;">
                Please re-enter your password.
            </div>
            <i style="background-position: -121px -481px; height: 11px; top: -11px; width: 22px; left: 30%; margin-left: 12px;"></i>
        </div>
    </div>
</div>
<div id="tooltipCompanyName"  class="uiContextualLayerPositioner" style="top: 352px; ">
    <div>
        <div>
            <div style="width: 220px;">
                Please enter your company's name.
            </div>
            <i style="top: 0%; margin-top: 12px;"></i>
        </div>
    </div>
</div>
<div id="tooltipPhoneNumber"  class="uiContextualLayerPositioner" style="top: 402px; ">
    <div>
        <div>
            <div style="width: 300px;">
                Please enter your mobile or phone number. We will use this number to contact you.
            </div>
            <i style="top: 0%; margin-top: 12px;"></i>
        </div>
    </div>
</div>
<div id="tooltipRegion"  class="uiContextualLayerPositioner" style="top: 452px; ">
    <div>
        <div>
            <div style="width: 260px;">
                Please enter your located country or region.
            </div>
            <i style="top: 0%; margin-top: 12px;"></i>
        </div>
    </div>
</div>

<script>
    function validate()
    {
        var error = false;
        if($("#SignUpForm_username").val().length < 6 || $("#SignUpForm_username").val().length > 20)
        {
            blurWarningIcon($("#SignUpForm_username")[0], true);
            error = true;
        }

        if($("#SignUpForm_email").val().length <= 0)
        {
            blurWarningIcon($("#SignUpForm_email")[0], true);
            error = true;
        }

        if($("#SignUpForm_password").val().length < 6 || $("#SignUpForm_password").val().length > 20)
        {
            blurWarningIcon($("#SignUpForm_password")[0], true);
            error = true;
        }

        if($("#SignUpForm_password").val() != $("#SignUpForm_password_repeat").val())
        {
            blurWarningIcon($("#SignUpForm_password_repeat")[0], true);
            error = true;
        }

        if($("#SignUpForm_name").val().length <= 0 )
        {
            blurWarningIcon($("#SignUpForm_name")[0], true);
            error = true;
        }

        if($("#SignUpForm_phone").val().length <= 0 )
        {
            blurWarningIcon($("#SignUpForm_phone")[0], true);
            error = true;
        }

        if($("#SignUpForm_country").val().length <= 0 )
        {
            blurWarningIcon($("#SignUpForm_country")[0], true);
            error = true;
        }

        if(error) return false; else return true;
    }

    function focusWarningIcon(obj)
    {
        changeInputBackground(obj);
        if($(obj.parentNode.parentNode.childNodes[3]).css('display') != 'none')
        {
            $("#"+$(obj).attr('tooltip')).css('display', 'block');
        }
        $(obj).css('border-color', '#bdc7d8');
        $(obj.parentNode.parentNode.childNodes[3]).css('display', 'none');
    }

    function blurWarningIcon(obj, err)
    {
        $("div[id^='tooltip']").css('display', 'none');
        if($(obj).val().length <= 0 || err == true)
        {
            $(obj).css('border-color', '#8b0300');
            $(obj.parentNode.parentNode.childNodes[3]).css('display', '');
        }
        else
        {
            $(obj).css('border-color', '#bdc7d8');
            $(obj.parentNode.parentNode.childNodes[3]).css('display', 'none');
        }
    }

    function changeInputBackground(obj)
    {
        if($(obj).val().length > 0)
            $(obj).css('background-color', '#fff');
        else
            $(obj).css('background-color', 'transparent');
    }
</script>

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
        Copyright &copy; 2015 by Nirvana Info.<br/>
        All Rights Reserved.<br/>
        Powered by <a href="http://www.yiiframework.com/" rel="external">Yii Framework</a>.<br/>
        SQL executed: 20, Time usage: 0.0032017230987549    </div><!-- footer -->

</div><!-- page -->
<script >
    function changeLanguage(tag){
        $.ajax({
            type: "POST",
            url: '${phpPath }/site/setLanguage',
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

