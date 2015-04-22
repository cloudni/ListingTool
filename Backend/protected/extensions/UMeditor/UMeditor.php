<?php
/**
 * Created by PhpStorm.
 * User: cloud
 * Date: 2015/2/3
 * Time: 14:26
 */

Yii::import('zii.widgets.jui.CJuiWidget');

class UMeditor extends CJuiWidget
{
    public $scriptFile=array(
        'umeditor.js',
        'umeditor.config.js',
    );

    public $cssFile=array('themes/default/css/umeditor.css');

    public $htmlOptions=array();

    public $baseUrl;

    protected $backgroundTagName='div';

    //custom properties

    protected $UMEDITOR_HOME_URL;

    public $imageUrl;

    public $imagePath;

    public $imageFieldName;

    public $toolbar = array("source | undo redo | bold italic underline strikethrough | superscript subscript | forecolor backcolor | removeformat | insertorderedlist insertunorderedlist | selectall cleardoc paragraph | fontfamily fontsize | justifyleft justifycenter justifyright justifyjustify | link unlink | emotion image | horizontal print preview fullscreen", "formula");

    public $lang = "zh-cn";

    public $langPath = "lang";

    public $autourldetectinie = false;

    public $theme = '';

    public $themePath = "themes";

    public $charset = "utf-8";

    public $isShow = true;

    public $initialContent = "";

    public $initialFrameWidth = 500;

    public $initialFrameHeight = 500;

    public $autoClearinitialContent = false;

    public $textarea;

    public $focus = false;

    public $autoClearEmptyNode = false;

    public $fullscreen = false;

    public $readonly = false;

    public $zIndex = 1;

    public $autoSyncData = true;

    protected $emotionLocalization = false;

    public $allHtmlEnabled = true;

    public $fontfamily = array(array("name"=>"songti", "val"=>"SimSun"));

    public $fontsize = array(10, 11, 12, 14, 16, 18, 20, 24, 36);

    public $paragraph = array('p'=>'', 'h1'=>'', 'h2'=>'', 'h3'=>'', 'h4'=>'', 'h5'=>'', 'h6'=>'');

    public $maxUndoCount = 20;

    public $maxInputCount = 1;

    public $imageScaleEnabled = false;

    public $dropFileEnabled = false;

    public $pasteImageEnabled = false;

    public $autoHeightEnabled = true;

    public $autoFloatEnabled = true;

    public $topOffset = 30;

    public $filterRules = array();

    public function init()
    {
        $path=dirname(__FILE__).DIRECTORY_SEPARATOR.'assets';
        $this->baseUrl=Yii::app()->getAssetManager()->publish($path);
        $this->themeUrl	= $this->scriptUrl	= $this->baseUrl;
        parent::init();

        if(!empty($this->htmlOptions['id']))
            $this->id=$this->htmlOptions['id'];
        else
            $this->htmlOptions['id']=$this->id;
    }

    public function run()
    {
        if (!empty($this->backgroundTagName))
        {
            echo CHtml::openTag($this->backgroundTagName, $this->htmlOptions);
        }

        if (!empty($this->backgroundTagName))
        {
            echo CHtml::closeTag($this->backgroundTagName);
        }

        $cs = Yii::app()->getClientScript();
        $cs->registerCoreScript('jquery');

        Yii::app()->getClientScript()->registerScript(__CLASS__.'#'.$this->id, implode("\n", $this->getRegisterScripts()));
    }

    protected function getRegisterScripts()
    {
        $js = array();
        $js[] = "var umeditor = UM.getEditor('{$this->id}', {
            initialFrameWidth: ".CJavaScript::encode($this->initialFrameWidth).",
            initialFrameHeight: ".CJavaScript::encode($this->initialFrameHeight).",
            toolbar: ".CJavaScript::encode($this->toolbar).",
            lang: ".CJavaScript::encode($this->lang).",
            autourldetectinie: ".CJavaScript::encode($this->autourldetectinie).",
            initialContent: ".CJavaScript::encode($this->initialContent).",
            focus: ".CJavaScript::encode($this->focus).",
            autoClearEmptyNode: ".CJavaScript::encode($this->autoClearEmptyNode).",
            fullscreen: ".CJavaScript::encode($this->fullscreen).",
            readonly: ".CJavaScript::encode($this->readonly).",
            zIndex: ".CJavaScript::encode($this->zIndex).",
            autoSyncData: ".CJavaScript::encode($this->autoSyncData).",
            emotionLocalization: ".CJavaScript::encode($this->emotionLocalization).",
            allHtmlEnabled: ".CJavaScript::encode($this->allHtmlEnabled).",
            fontfamily: ".CJavaScript::encode($this->fontfamily).",
            fontsize: ".CJavaScript::encode($this->fontsize).",
            paragraph: ".CJavaScript::encode($this->paragraph).",
            maxUndoCount: ".CJavaScript::encode($this->maxUndoCount).",
            maxInputCount: ".CJavaScript::encode($this->maxInputCount).",
            imageScaleEnabled: ".CJavaScript::encode($this->imageScaleEnabled).",
            dropFileEnabled: ".CJavaScript::encode($this->dropFileEnabled).",
            pasteImageEnabled: ".CJavaScript::encode($this->pasteImageEnabled).",
            autoHeightEnabled: ".CJavaScript::encode($this->autoHeightEnabled).",
            autoFloatEnabled: ".CJavaScript::encode($this->autoFloatEnabled).",
            topOffset: ".CJavaScript::encode($this->topOffset).",
            filterRules: ".CJavaScript::encode($this->filterRules).",
        });";
        return $js;
    }
}