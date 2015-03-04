<?php
/**
 * zTree class file.
 * @author cloud.liu
 * @version 1.0
 */
Yii::import('zii.widgets.jui.CJuiWidget');
/*$this->widget('ext.zTree.zTree',array(
    'async'=>array(
        'autoParam'=>array(),//Required automatically submit the parameters about the properties of the parent node, when the asynchronous load. It is valid when [setting.async.enable = true]
        'contentType'=>"application/json",//When Ajax sending data to the server, use this content-type. It is valid when [setting.async.enable = true]
        'dataFilter'=>'',//Function used to pre-process for the return data of Ajax. It is valid when [setting.async.enable = true]
        'dataType'=>'text',//The data type of Ajax. It is valid when [setting.async.enable = true]
        'enable'=>'false',//Set zTree asynchronous loading mode is turned on or off.
        'otherParam'=>array(),//The static parameters of the Ajax request. (key - value) It is valid when [setting.async.enable = true]
        'type'=>'post',//Http request mode in ajax. It is valid when [setting.async.enable = true]
        'url'=>'',//The URL to which the ajax request is sent. It is valid when [setting.async.enable = true]
    ),
    'callback'=>array(
        'beforeAsync'=>null,//Used to capture the event before zTree execute ajax, zTree based on return value to determine whether to execute ajax.
        'beforeCheck'=>null,//Used to capture the event before check or uncheck node, zTree based on return value to determine whether to change check state.
        'beforeClick'=>null,//Used to capture the event before click node, zTree based on return value to determine whether to trigger the 'onClick' callback.
        'beforeCollapse'=>null,//Used to capture the event before collapse node, zTree based on return value to determine whether to collapse node.
        'beforeDblClick'=>null,//Used to capture the dblclick event before the 'onDblClick' callback, zTree based on return value to determine whether to trigger the 'onDblClick' callback.
        'beforeDrag'=>null,//Used to capture the event before drag node, zTree based on return value to determine whether to start to drag node.
        'beforeDragOpen'=>null,//Used to capture the event when drag node to collapsed parent node, zTree based on return value to determine whether to auto expand parent node.
        'beforeDrop'=>null,//Used to capture the event before drag-drop node, zTree based on return value to determine whether to allow drag-drop node.
        'beforeEditName'=>null,//Used to capture the event before click edit button, zTree based on return value to determine whether to allow to edit the name.
        'beforeExpand'=>null,//Used to capture the event before expand node, zTree based on return value to determine whether to expand node.
        'beforeMouseDown'=>null,//Used to capture the mousedown event before the 'onMouseDown' callback, zTree based on return value to determine whether to trigger the 'onMouseDown' callback.
        'beforeMouseUp'=>null,//Used to capture the mouseup event before the 'onMouseUp' callback, zTree based on return value to determine whether to trigger the 'onMouseUp' callback.
        'beforeRemove'=>null,//Used to capture the event before remove node, zTree based on return value to determine whether to allow to remove node.
        'beforeRename'=>null,//Used to capture the event before rename(when input DOM blur or press Enter Key), zTree based on return value to determine whether to allow to rename node.
        'beforeRightClick'=>null,//Used to capture the right click event before the 'onRightClick' callback, zTree based on return value to determine whether to trigger the 'onRightClick' callback.
        'onAsyncError'=>null,//Used to capture the error event when execute ajax.
        'onAsyncSuccess'=>null,//Used to capture the complete success event when execute ajax.
        'onCheck'=>null,//Used to capture the check or uncheck event when check or uncheck the checkbox and radio.
        'onClick'=>null,//Used to capture the click event when click node.
        'onCollapse'=>null,//Used to capture the event when collapse node.
        'onDblClick'=>null,//Used to capture the dblclick event when double click node.
        'onDrag'=>null,//Used to capture the drag event when drag node.
        'onDragMove'=>null,//Used to capture the drag-move event when drag & drop node.
        'onDrop'=>null,//Used to capture the drop event when drag-drop node.
        'onExpand'=>null,//Used to capture the event when expand node.
        'onMouseDown'=>null,//Used to capture the event when mouse down.
        'onMouseUp'=>null,//Used to capture the event when mouse up.
        'onNodeCreated'=>null,//Used to capture the event when node's DOM is created.
        'onRemove'=>null,//Used to capture the event when remove node.
        'onRename'=>null,//Used to capture the event when remove node.
        'onRightClick'=>null,//Used to capture the event when mouse right click node.
    ),
    'check'=>array(
        'autoCheckTrigger'=>false,//When node is automatically checked or unchecked, this parameter used to set to trigger 'beforeCheck / onCheck' callback. It is valid when [setting.check.enable = true & setting.check.chkStyle = "checkbox"]
        'chkboxType'=>array('Y'=>'ps', 'N'=>'ps'),//When one node is checked or unchecked, control its parent node and its child node auto checked or unchecked. It is valid when [setting.check.enable = true & setting.check.chkStyle = "checkbox"]
        'chkStyle'=>'checkbox',//Use the checkbox or radio. It is valid when [setting.check.enable = true]
        'enable'=>false,//Set to use checkbox or radio in zTree
        'nocheckInherit'=>false,//When the parent node's 'nocheck' attribute is true, set the child nodes automatically inherit the 'nocheck' attribute. It is valid when [setting.check.enable = true]
        'chkDisabledInherit'=>false,//When the parent node's 'chkDisabled' attribute is true, set the child nodes automatically inherit the 'chkDisabled' attribute. It is valid when [setting.check.enable = true]
        'radioType'=>'level',//The group about radio. It is valid when [setting.check.enable = true & setting.check.chkStyle = "radio"]
    ),
    'data'=>array(
        'keep'=>array(
            'leaf'=>false,//The leaf node's lock, the leaf node will lock the 'isParent' attribute to false.
            'parent'=>false,//The parent node's lock, the parent node will lock 'isParent' attribute to true.
        ),
        'key'=>array(
            'checked'=>'checked',//The node data's attribute to save the checked state.
            'children'=>'children',//The node data's attribute to save the child nodes.
            'name'=>'name',//The node data's attribute to save the node name.
            'title'=>'',//The node data's attribute to save the 'title' attribute of node DOM. It is valid when [setting.view.showTitle = true]
            'url'=>'',//The node data's attribute to save the node link's url.
        ),
        'simpleDate'=>array(
            'enable'=>false,//Set zTree's node to accept the simple data format, when zTree is initialized or when ajax get / or when use addNodes method.
            'idKey'=>'id',//The node data's attribute to save node data's unique identifier. It is valid when [setting.data.simpleData.enable = true]
            'pIdKey'=>'pId',//The node data's attribute to save its parent node data's unique identifier. It is valid when [setting.data.simpleData.enable = true]
            'rootPId'=>null,//Set the default value of root's 'pIdKey' specified attribute values​​. It is valid when [setting.data.simpleData.enable = true]
        ),
    ),
    'edit'=>array(
        'drag'=>array(
            'autoExpandTrigger'=>false,//When drag node cause the parent node is automatically expanded, set whether to allow to trigger the 'onExpand' callback. It is valid when [setting.edit.enable = true]
            'isCopy'=>true,//When drag-drop node, set whether to allow to copy node. It is valid when [setting.edit.enable = true]
            'isMove'=>true,//When drag-drop node, set whether to allow to move node. It is valid when [setting.edit.enable = true]
            'prev'=>true,//When drag one node to the target node, set whether to allow the node to be the target node's previous sibling. It is valid when [setting.edit.enable = true]
            'next'=>true,//When drag one node to the target node, set whether to allow the node to be the target node's next sibling. It is valid when [setting.edit.enable = true]
            'inner'=>true,//When drag one node to the target node, set whether to allow the node to be the target node's child. It is valid when [setting.edit.enable = true]
            'borderMax'=>10,//When drag a node to root, the zTree's inner border width. (Unit: px) It is valid when [setting.edit.enable = true]
            'borderMin'=>-5,//When drag a node to root, the zTree's outer border width. (Unit: px) It is valid when [setting.edit.enable = true]
            'minMoveSize'=>5,//The minimum offset which used to determine the drag operator start. (Unit: px) It is valid when [setting.edit.enable = true]
            'maxShowNodeNum'=>5,//When dragging more than one sibling node, the floating layer shows the maximum number of nodes. zTree using '...' instead of redundant nodes. It is valid when [setting.edit.enable = true]
            'autoOpenTime'=>500,//Drag to the parent node, the parent node auto expand time interval. (Unit: ms) It is valid when [setting.edit.enable = true]
        ),
        'editNameSelectAll'=>false,//When edit node's name, the text in input is selected or unselected. It is valid when [setting.edit.enable = true]
        'enable'=>false,//Set zTree is in edit mode
        'removeTitle'=>'remove',//the title of the remove button DOM. It is valid when [setting.edit.enable = true & setting.edit.showRemoveBtn = true]
        'renameTitle'=>'rename',//the title of the rename button DOM. It is valid when [setting.edit.enable = true & setting.edit.showRenameBtn = true]
        'showRemoveBtn'=>true,//Set to show or hide the remove button. It is valid when [setting.edit.enable = true]
        'showRenameBtn'=>true,//Set to show or hide the rename button. It is valid when [setting.edit.enable = true]
    ),
    'view'=>array(
        'addDiyDom'=>null,//This function used to display the custom control on the node.
        'addHoverDom'=>null,//Used to display custom control when mouse move over the node. (e.g. the rename and remove button)
        'autoCancelSelected'=>true,//When click the selected node while pressing the Ctrl-key or Cmd-key, allow to cancel selected the node.
        'dblClickExpand'=>true,//When double-click the parent node, 'dblClickExpand' is used to decide whether to expand the parent node.
        'expandSpeed'=>'fast',//The animation speed of expand or collapse node. As same as 'speed' parameter in jQuery
        'fontCss'=>array(),//Personalized text style, only applies to <A> object in the node DOM
        'nameIsHTML'=>false,//Set to use HTML in 'name' attribute.
        'removeHoverDom'=>null,//Used to hide custom control when mouse move out the node. (e.g. the rename and remove button)
        'selectedMulti'=>true,//Set whether to allow select multiple nodes.
        'showIcon'=>true,//Set to show or hide node icon.
        'showLine'=>true,//Set to show or hide line.
        'showTitle'=>true,//Set to show or hide the 'title' attribute of node DOM.
        'txtSelectedEnable'=>false,//Set to allow or don't allow to select the text which in zTree's DOM.
    ),
    'backgroundTagName'=>'div',
    'htmlOptions'=>array(),
    'input'=>array(//input data to show up.
        array(
            'id'=>1,
            'parent_id'=>0,
            'name'=>'目录1',
            'children'=>array(
                array(
                    'id'=>2,
                    'parent_id'=>1,
                    'name'=>'目录2',
                    'children'=>array(
                        array('id'=>5, 'parent_id'=>2, 'name'=>'目录5'),
                    ),
                ),
                array(
                    'id'=>3,
                    'parent_id'=>1,
                    'name'=>'目录3',
                    'children'=>array(
                        array('id'=>6, 'parent_id'=>3, 'name'=>'目录6')
                    ),
                ),
                array('id'=>4, 'parent_id'=>1, 'name'=>'目录4'),
            ),
        ),
    ),
    'model'=>'',//model of data type, if model is set, input will be ignore
    'criteria'=>null,//criteria params for query model
));*/

class zTree extends CJuiWidget
{
	/**
	 * @var array|string
	 */
	public $scriptFile=array('jquery.ztree.all-3.5.min.js');
	/**
	 * @var array|string
	 */
	public $cssFile=array('zTreeStyle.css');

    public $async=array();

    public $callback=array();

    public $check= array();

    public $data=array();

    public $edit=array();

    public $view=array();

    public $backgroundTagName='div';

    public $htmlOptions=array();

    public $input=array();

    public $model;

    public $baseUrl;

    public $criteria;

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

        if(isset($this->htmlOptions['class'])) $this->htmlOptions['class']	.= ' ztree'; else $this->htmlOptions['class'] = ' ztree';
	
		/*if (!isset($this->options['data']))
		{
			$this->options['data']	= array();
		}
	
		if (!isset($this->options['data']['simpleData']))
		{
			$this->options['data']['simpleData']	= array();
		}
	
		if ($this->isSimpleData)
		{
			
			$this->options['data']['simpleData']['enable']	= true;
		}
		
		if ($this->treeNodeKey !== null)
		{
			$this->options['data']['simpleData']['idKey']		= $this->treeNodeKey;
		}
		
		if ($this->treeNodeParentKey !== null)
		{
			$this->options['data']['simpleData']['pIdKey']		= $this->treeNodeParentKey;
		}
		
		if ($this->width !== null)
		{
			$this->backgroundHtmlOptions['style'] .= " width:{$this->width}px;";
		}
		if ($this->height !== null)
		{
			$this->backgroundHtmlOptions['style'] .= " height:{$this->height}px;";
		}
		if ($this->backgroundId['id'] === null)
		{
			$this->backgroundId	= isset($this->backgroundHtmlOptions['id']) ? $this->backgroundHtmlOptions['id'] :  $this->id.'background';
		}
		$this->backgroundHtmlOptions['id']	= $this->backgroundId;*/
	}
	
	public function run()
	{
		if (!empty($this->backgroundTagName))
		{
			echo CHtml::openTag($this->backgroundTagName, $this->htmlOptions);
		}

		echo CHtml::tag('ul');
		if (!empty($this->backgroundTagName))
		{
			echo CHtml::closeTag($this->backgroundTagName);
		}

		$cs = Yii::app()->getClientScript();
		$cs->registerCoreScript('jquery');
		Yii::app()->getClientScript()->registerScript(__CLASS__.'#'.$this->id, implode("\n", $this->getRegisterScripts()));
	}
	
	/**
	 * ע��JS�б�
	 * 
	 */
	protected function getRegisterScripts()
	{
		$js		= array();
		$input	= $this->getData();
        $async=CJavaScript::encode($this->async);
        $callback=$this->encodeJSFunction($this->callback);
        $data=CJavaScript::encode($this->data);
        $edit=CJavaScript::encode($this->edit);
        $view=CJavaScript::encode($this->view);
        $js[] = "
        zTree_{$this->id} = $.fn.zTree.init(
            $('#{$this->id}'),
            {
                'async':{$async},
                'callback':{$callback},
                'data':{$data},
                'edit':{$edit},
                'view':{$view}
            },
            {$input}
        );";
		return $js;
	}
	
	protected function getData()
	{
		if ($this->model !== null)
		{
			$model = is_object($this->model) ? $this->model : new $this->model;
			if ($model instanceof CModel)
			{
                if(isset($this->criteria) && !empty($this->criteria))
				    $data = $model->findAll($this->criteria);
                else
                    $data = $model->findAll();
			}
		}
		else 
		{
			$data = $this->input;
		}
		
		if(is_array($data))
		{
			$arr	= array();
			foreach ($data as $key => $value)
			{
				if ($value instanceof CModel)
				{
					$value			= $value->getAttributes();
				}
				$value['name']	= $value[$this->data['key']['name']];
				$arr[]	= $value;
			}
			$data	= $arr;
			$data	= CJavaScript::encode($data);
		}
		
		return $data;
	}

    protected function encodeJSFunction($params)
    {
        $str = "";
        foreach($params as $key => $row)
        {
            $str .= ($str ? ", " : "" )."'$key':$row";
        }
        $str = "{".$str."}";
        return $str;
    }
}