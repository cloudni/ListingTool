<?php
/**
 * Created by PhpStorm.
 * User: cloud
 * Date: 14-11-17
 * Time: 10:51am
 */
/**
 * Plupload class file.
 * @author cloud.liu
 * @version 1.0
 */
Yii::import('zii.widgets.jui.CJuiWidget');

/*$this->widget('ext.Plupload.Plupload',array(
            'form_id'=>'upload_test_form',
            'submitURL'=>'/picture/uploadsubmit',
            'max_file_count'=>20,
            'mime_types'=>array('Image_files'),
            'views'=>array('list'=>'true','thumbs'=>'true', 'active'=>'thumbs', )
));*/
class Plupload extends CJuiWidget
{
    /**
     * @var array|string
     */
    public $scriptFile=array(
        'jquery-ui-1.11.2/jquery-ui.min.js',
        'browserplus-min.js',
        'js/plupload.full.min.js',
        'js/jquery.ui.plupload/jquery.ui.plupload.js',
    );
    /**
     * @var array|string
     */
    public $cssFile=array(
        'jquery-ui-1.11.2/jquery-ui.css',
        'js/jquery.ui.plupload/css/jquery.ui.plupload.css',
    );

    public $submitURL;

    public $max_file_count=20;

    public $chunk_size='5mb';

    public $max_file_size='20mb';

    public $mime_types=array('Image_files');

    public $form_id;

    public $views;

    public $baseUrl;

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
        echo CHtml::tag('div');
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
        $js		= array();
        $views=CJavaScript::encode($this->views);
        $js[] = "
        var plupload_{$this->id} = $('#".$this->form_id."').plupload({
            runtimes : 'html5,flash,silverlight,html4',
            url : '{$this->submitURL}',

            // User can upload no more then 20 files in one go (sets multiple_queues to false)
            max_file_count: {$this->max_file_count},

            chunk_size: '{$this->chunk_size}',

            filters : {
                // Maximum file size
                max_file_size : '{$this->max_file_size}',
                // Specify what files to browse for
                mime_types: [
                    {title : \"Image files\", extensions : \"jpg,gif,png\"},
                    {title : \"Zip files\", extensions : \"zip\"}
                ]
            },

            // Rename files by clicking on their titles
            rename: false,

            // Sort files
            sortable: false,

            // Enable ability to drag'n'drop files onto the widget (currently only HTML5 supports that)
            dragdrop: true,

            // Views to activate
            views: $views,

            // Flash settings
            flash_swf_url : '../../js/Moxie.swf',

            // Silverlight settings
            silverlight_xap_url : '../../js/Moxie.xap',
            multipart_params:{
                folderId:1
            },
            init: {
                FilesAdded:function(up,files){
                    var node = getZTreeObj().getSelectedNodes()[0] ;
                    up.settings.multipart_params.folderId = (node!=null?node.id:1);
                },
                UploadComplete: function(up, files) {
                    up.splice();
                    up.refresh();
                }
            }
        });

        $('#form').submit(function(e)
        {
            // Files in queue upload them first
            if ($('#{$this->id}').plupload('getFiles').length > 0) {

                // When all files are uploaded submit form
                $('#{$this->id}').on('complete', function() {
                    $('#{$this->form_id}')[0].submit();
                });

                $('#{$this->id}').plupload('start');
            } else {
                alert(\"You must have at least one file in the queue.\");
            }
            return false; // Keep the form from submitting
	    });";
        return $js;
    }
} 