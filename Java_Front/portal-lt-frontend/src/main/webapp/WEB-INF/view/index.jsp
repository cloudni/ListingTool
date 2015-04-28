<%@ page language="java" import="java.util.*" pageEncoding="UTF-8"%>
<%@ include file="/common/taglibs.jsp"%>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<%@ include file="/common/meta.jsp"%>
<title>Item Tool</title>
</head>

<body>

<%@ include file="/common/top.jsp"%>

<div class="container" id="page">
<%@ include file="/common/header.jsp"%>
    
<div id="content">
	
<style>
    #page { background-color: #e9eaed;border: none; }
</style>

<div class="container clearfix">
    <div class="borderBlock">
        <div>
            <div style="background: #f6f7f8; border-bottom: 1px solid #e9eaed; font-size: 12px;">
                <div style="position: relative; float: right;">
                    <a style="color: #3b5998; font-size: 11px; line-height: 38px; position: relative; margin-right: 10px; padding-right: 5px;" href="">See All</a>
                </div>
                <div style="height: 36px; color: #9197a3; font-weight: normal;">
                    <h1 style="color: #4e5665; font-weight: 700; padding-left: 14px; text-transform: uppercase; line-height: 38px; position: relative;">User Status</h1>
                </div>
            </div>
            <div class="clearfix" style="border-top: 1px solid transparent;">
                <div style="width: 100%; padding: 0px; margin: 0px;">
                    <div class="lfloat">
                        <div style="background-image: url(${ctxPath}/themes/facebook/images/201410080952.jpg); background-repeat: no-repeat; background-size: 1000%; background-position: -405px -77px; height: 100px; width: 100px;">&nbsp;</div>
                    </div>
                    <div class="lfloat">
                        <div style="font-size: 12px; height: 20px; vertical-align: middle; padding-top: 10px;">1.
                                                        Total 1 user created.                        </div>
                        <div style="font-size: 12px; height: 20px; vertical-align: middle; padding-top: 10px;">2.
                            <a href="${phpPath }/user/create">Create more user</a>&nbsp;Or&nbsp;
                            <a href="${phpPath }/user">Manage current users</a>                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="borderBlock">
        <div>
            <div style="background: #f6f7f8; border-bottom: 1px solid #e9eaed; font-size: 12px;">
                <div style="position: relative; float: right;">
                    <a style="color: #3b5998; font-size: 11px; line-height: 38px; position: relative; margin-right: 10px; padding-right: 5px;" href="">See All</a>
                </div>
                <div style="height: 36px; color: #9197a3; font-weight: normal;">
                    <h1 style="color: #4e5665; font-weight: 700; padding-left: 14px; text-transform: uppercase; line-height: 38px; position: relative;">Shop Status</h1>
                </div>
            </div>
            <div class="clearfix" style="border-top: 1px solid transparent;">
                <div style="width: 100%; padding: 0px; margin: 0px;">
                    <div class="lfloat">
                        <div style="background-image: url(${ctxPath}/themes/facebook/images/201410080952.jpg); background-repeat: no-repeat; background-size: 1000%; background-position: -50px -607px; height: 100px; width: 100px;">&nbsp;</div>
                    </div>
                    <div class="lfloat">
                        <div style="font-size: 12px; height: 20px; vertical-align: middle; padding-top: 10px;">1.
                                                                                    Total 3 store created and 2 authorized.                        </div>
                        <div style="font-size: 12px; height: 20px; vertical-align: middle; padding-top: 10px;">2.
                                                                                                                    eBay.com: 2 authorized,&nbsp;                                                            1 waiting authorize,&nbsp;                                                    </div>
                        <div style="font-size: 12px; height: 20px; vertical-align: middle; padding-top: 10px;">3.
                            <a href="${phpPath }/store/create">Create more store</a>&nbsp;Or&nbsp;
                            <a href="${phpPath }/store">Manage current stores</a>                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="borderBlock">
        <div>
            <div style="background: #f6f7f8; border-bottom: 1px solid #e9eaed; font-size: 12px;">
                <div style="position: relative; float: right;">
                    <a style="color: #3b5998; font-size: 11px; line-height: 38px; position: relative; margin-right: 10px; padding-right: 5px;" href="">See All</a>
                </div>
                <div style="height: 36px; color: #9197a3; font-weight: normal;">
                    <h1 style="color: #4e5665; font-weight: 700; padding-left: 14px; text-transform: uppercase; line-height: 38px; position: relative;">Listing Status</h1>
                </div>
            </div>
            <div class="clearfix" style="border-top: 1px solid transparent;">
                <div style="width: 100%; padding: 0px; margin: 0px;">
                    <div class="lfloat">
                        <div style="background-image: url(${ctxPath}/themes/facebook/images/201410080952.jpg); background-repeat: no-repeat; background-size: 1000%; background-position: -580px -607px; height: 100px; width: 100px;">&nbsp;</div>
                    </div>
                    <div class="lfloat">
                        <div style="font-size: 12px; height: 20px; vertical-align: middle; padding-top: 10px;">This function is coming soon.</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="borderBlock">
        <div>
            <div style="background: #f6f7f8; border-bottom: 1px solid #e9eaed; font-size: 12px;">
                <div style="position: relative; float: right;">
                    <a style="color: #3b5998; font-size: 11px; line-height: 38px; position: relative; margin-right: 10px; padding-right: 5px;" href="">See All</a>
                </div>
                <div style="height: 36px; color: #9197a3; font-weight: normal;">
                    <h1 style="color: #4e5665; font-weight: 700; padding-left: 14px; text-transform: uppercase; line-height: 38px; position: relative;">Notify Status</h1>
                </div>
            </div>
            <div class="clearfix" style="border-top: 1px solid transparent;">
                <div style="width: 100%; padding: 0px; margin: 0px;">
                    <div class="lfloat">
                        <div style="background-image: url(${ctxPath}/themes/facebook/images/201410080952.jpg); background-repeat: no-repeat; background-size: 1000%; background-position: -320px -77px; height: 100px; width: 100px;">&nbsp;</div>
                    </div>
                    <div class="lfloat">
                        <div style="font-size: 12px; height: 20px; vertical-align: middle; padding-top: 10px;">This function is coming soon.</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
</script>
</div><!-- content -->
<%@ include file="/common/footer.jsp"%>
</div>
</body>
</html>
