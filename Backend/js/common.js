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