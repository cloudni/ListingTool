<%@ page language="java" import="java.util.*" pageEncoding="UTF-8"%>
<div id="ajaxloading">
    <div>
        <img src="${ctxPath}/images/load.gif" align="absmiddle" /><span>Data is loading</span>
    </div>
</div>

<div id="pagelet_bluebar">
    <div id="blueBarDOMInspector" style="height: auto;">
        <div id="blueBarNAXAnchor" class="_4f7n _xxp">
                            <div class="loggedin_menubar_container">
                    <div class="clearfix loggedin_menubar container">
                        <div class="clearfix lfloat">
                            <h1 style="font-weight: bold; position: relative; top: 5px; margin-left: -12px;">
                                <a href="/" title="Go to ItemTool Home" style="display: block;">
                                    <img src="${ctxPath}/themes/facebook/images/30x30_logo.jpg" />
                                </a>
                            </h1>
                        </div>
                        <div class="clearfix lfloat">
                            <label style="color: #fff; font-size: 1.7em; font-weight: bold; position: relative; top: 22px; margin-left: -7px;">${user.userName==null?"nitest":user.userName } - ${user.companyName }</label>
                        </div>
                        <div class="rfloat">
                            <ul class="clearfix" style="position: relative;height: 22px;margin: 10px 0 10px 5px;display: block;list-style-type: none;color: whitesmoke;top: 20px;">
                                <li class="lfloat">
                                    <a href="${phpPath }/notification"><img src="${ctxPath}/images/email-icon.png" alt=""/></a>                                                                                                        </li>
                                <li class="lfloat"><a style="color: whitesmoke;" href="${ctxPath}/logout.shtml">${session.signOut_title }</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                    </div>
    </div>
</div>