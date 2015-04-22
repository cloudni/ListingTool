/**
 * Created by cloud on 2015/2/3.
 */

function ShowHelp(img, title, desc)
{
    img = document.getElementById(img);
    div = document.createElement('div');
    div.id = 'help';

    div.style.display = 'inline';
    div.style.position = 'absolute';
    div.style.width = '350';

    div.style.backgroundColor = '#FEFCD5';
    div.style.border = 'solid 1px #E7E3BE';
    div.style.padding = '10px';
    div.style.zIndex = '900';
    div.innerHTML = '<span class=helpTip><strong>' + title + '<\/strong><\/span><br /><div style="padding-left:10; padding-right:5" class=helpTip>' + desc + '<\/div>';

    //img.parentNode.appendChild(div);
    var parent = img.parentNode;
    if(img.nextSibling)
        parent.insertBefore(div, img.nextSibling);
    else
        parent.appendChild(div)
}

function HideHelp(img)
{
    img = document.getElementById(img);
    div = document.getElementById('help');
    if (div) {
        img.parentNode.removeChild(div);
    }
}

function WhatBrowser()
{
    var str=navigator.userAgent;
    var BrowserS=['MSIE 9.0','MSIE 8.0','MSIE 7.0','MSIE6.0',
        'Firefox','Opera','Chrome', '.NET CLR'];
    for(var i=0;i<BrowserS.length;i++)
    {
        if(str.indexOf(BrowserS[i])>=0)
        {
            if(BrowserS[i]=='.NET CLR')return 'IE';
            return BrowserS[i].replace('MSIE','IE');
        }
    }
}

function setstyle(themeName) {
    var browser = '';
    if (navigator.userAgent.indexOf("MSIE") > 0) {
        browser = 'IE';
    }
    else if (navigator.userAgent.indexOf("Firefox") > 0) {
        browser = 'Firefox';
    }
    else if (navigator.userAgent.indexOf("Chrome") > 0) {
        browser = 'Chrome';
    }
    else if (navigator.userAgent.indexOf("Safari") > 0) {
        browser = 'Safari';
    }
    else if (navigator.userAgent.indexOf("Camino") > 0) {
        browser = 'Camino';
    }
    else if (navigator.userAgent.indexOf("Gecko") > 0) {
        browser = 'Gecko';
    }

    if(browser.length>0)
    {
        var head = document.getElementsByTagName('head')[0];
        var link = document.createElement('link');
        link.href = '/themes/'+themeName+'/css/'+browser+'.css';
        link.rel = 'stylesheet';
        link.type = 'text/css';
        head.appendChild(link);
    }
}